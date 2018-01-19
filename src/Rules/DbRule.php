<?php
namespace LaraValidation\Rules;

use Illuminate\Support\Facades\DB;
use LaraValidation\Contracts\RuleInterface;
use LaraValidation\Traits\DBParametersGetter;
use MyDevData\Models\Staff\Staff;

class DbRule {

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    protected static function getForExists($attribute, $value, $parameters, $validator, $message, $isMulti = false)
    {
        if (!isset($value)) {
            return true;
        }

        if (empty($parameters[0])) {
            throw new \InvalidArgumentException(sprintf('Second parameter is required for %s validation', $message));
        }

        $tableParam = array_shift($parameters);
        $columnParam = array_shift($parameters);
        $connectionParam = array_shift($parameters);

        $connection = !empty($connectionParam) ? $connectionParam : config('database.default');
        $column = ends_with($attribute, ['_id', '_ids']) ? 'id' : $attribute;

        if (!empty($columnParam)) {
            $column = $columnParam;
        }

        $query = self::getQueryBased($tableParam, $column, $connection);

        return self::fixIsMulti($isMulti, $query, $column, $value);
    }


    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @param $message
     * @param bool $isMulti
     * @return bool
     * @throws \Exception
     */
    protected static function getForExistsIf($attribute, $value, $parameters, $validator, $message, $isMulti = false)
    {
        if (!isset($value)) {
            return true;
        }

        if (empty($parameters[0])) {
            throw new \InvalidArgumentException(sprintf('Second parameter is required for %s validation', $message));
        }

        $tableParam = array_shift($parameters);
        $columnParam = array_shift($parameters);
        $connectionParam = array_shift($parameters);

        $connection = config('database.default');
        self::fixField($connection, $parameters, $connectionParam);

        $column = ends_with($attribute, ['_id', '_ids']) ? 'id' : $attribute;
        self::fixField($column, $parameters, $columnParam);
        $conditions = [];

        foreach ($parameters as $parameter) {
            $condition = explode('=>', $parameter);
            $attr = array_shift($condition);
            $val = array_shift($condition);

            if (strtolower($val) == 'null') {
                $val =NULL;
            }

            $conditions[$attr] = $val;
        }

        if (empty($conditions)) {
            throw new \Exception('The Params must be contain [attribute => value] value');
        }

        $query = self::getQueryBased($tableParam, $column, $connection);
        $query->where($conditions);
        return self::fixIsMulti($isMulti, $query, $column, $value);
    }

    /**
     * @param $field
     * @param $parameters
     * @param $param
     */
    protected static function fixField(&$field, &$parameters, $param)
    {
        if (!empty($param)) {
            if (str_contains($param, '=>')) {
                array_unshift($parameters, $param);
            } else {
                $field = $param;
            }
        }
    }

    /**
     * @param $tableParam
     * @param $column
     * @param $connection
     * @return mixed
     */
    protected static function getQueryBased($tableParam, $column, $connection)
    {
        if (class_exists($tableParam)) {
            $model = app($tableParam);
            $model->setConnection($connection);
            $query = $model->newQuery();
        } else {
            $query = DB::connection($connection)->table($tableParam)->select($column);
        }

        return $query;
    }

    /**
     * @param $isMulti
     * @param $query
     * @param $column
     * @param $value
     * @return bool
     */
    protected static function fixIsMulti($isMulti, $query, $column, $value)
    {

        if (!$isMulti) {
            return $query->where($column, $value)->count();
        }

        if (!is_array($value )) {
            $value  = [$value ];
        }

        $count = $query->whereIn($column, $value)->count();
        return ($count == count($value)) ? true : false;
    }

}
