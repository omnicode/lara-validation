<?php
namespace LaraValidation\Rules;

use Illuminate\Support\Facades\DB;
use LaraValidation\Contracts\RuleInterface;
use LaraValidation\Traits\DBParameterGetter;

class MultiExistsIfRule implements RuleInterface
{
    use DBParameterGetter;

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public static function get($attribute, $value, $parameters, $validator)
    {
        // TODO discuss when $value is empty this method not called
        if (!isset($value)) {
            return true;
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        if (empty($parameters[0])) {
            throw new \InvalidArgumentException('Second parameter is required for existsIf validation');
        }

        list($table, $column, $connection, $conditions) = static::getParameters ($attribute, $parameters);
        $query = DB::connection($connection)->table($table)->select($column)->where($conditions)->whereIn($column, $value);

        return $query->count();
    }

}
