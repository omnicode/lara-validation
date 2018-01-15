<?php
namespace LaraValidation\Rules;

use Illuminate\Support\Facades\DB;
use LaraValidation\Contracts\RuleInterface;

class MultiExistsRule implements RuleInterface
{

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public static function get($attribute, $value, $parameters, $validator)
    {
        if (!isset($value)) {
            return true;
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        if (empty($parameters[0])) {
            throw new \InvalidArgumentException('Second parameter is required for unique validation');
        }

        $model = array_shift($parameters);
        $table = class_exists($model) ? app($model)->getTable() : $model;
        $column = !empty($parameters) ? array_shift($parameters) : $attribute;
        $connection= !empty($parameters) ? array_shift($parameters) : '';

        $query = DB::connection($connection)->table($table)->select($column)->whereIn($column, $value);
        $count = $query->count();
        return ($count == count($value)) ? true : false;
    }

}
