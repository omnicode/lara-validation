<?php
namespace LaraValidation\Rules;

use LaraValidation\Contracts\RuleInterface;

class MultiExistsIfRule extends DbRule implements RuleInterface
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
        return self::getForExistsIf($attribute, $value, $parameters, $validator, 'multiExistsIf', true);
    }

}
