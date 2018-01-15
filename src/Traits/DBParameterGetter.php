<?php
namespace LaraValidation\Traits;

trait DBParameterGetter
{
    /**
     * @param $attribute
     * @param $parameters
     * @return array
     */
    protected static function getParameters($attribute, $parameters) {
        $connection = config('database.default');
        $modelName = array_shift($parameters);
        $table = class_exists($modelName) ? app($modelName)->getTable() : $modelName;
        $param = array_shift($parameters);

        if (str_contains($param, '=>')) {
            $column = $attribute;
            array_unshift($parameters, $param);
        } else {
            $column = $param;
            $param = array_shift($parameters);

            if (str_contains($param, '=>')) {
                array_unshift($parameters, $param);
            } else {
                $connection = $param;
            }
        }

        $conditions = [];
        foreach ($parameters as $parameter) {
            $condition = explode('=>', $parameter);
            $conditions[array_shift($condition)] = array_shift($condition);
        }

        return [$table, $column, $connection, $conditions];
    }
}