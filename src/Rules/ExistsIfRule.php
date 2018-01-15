<?php
namespace LaraValidation\Rules;

use Illuminate\Support\Facades\DB;
use LaraValidation\Contracts\RuleInterface;
use LaraValidation\Traits\DBParameterGetter;

class ExistsIfRule implements RuleInterface
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

        if (empty($parameters[0])) {
            throw new \InvalidArgumentException('Second parameter is required for existsIf validation');
        }

        list($table, $column, $connection, $conditions) = static::getParameters ($attribute, $parameters);
        $conditions[$column] = $value;
        $query = DB::connection($connection)->table($table)->select($column)->where($conditions);

        return $query->count();
    }

}
