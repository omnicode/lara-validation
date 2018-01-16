<?php
namespace LaraValidation\Rules;

use LaraValidation\Contracts\RuleInterface;

class ExistsDbRule extends DbRule implements RuleInterface
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
        return self::getForExists($attribute, $value, $parameters, $validator, 'exists');
    }

}
