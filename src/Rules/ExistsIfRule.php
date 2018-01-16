<?php
namespace LaraValidation\Rules;

use Illuminate\Support\Facades\DB;
use LaraValidation\Contracts\RuleInterface;
use LaraValidation\Traits\DBParametersGetter;

class ExistsIfRule extends DbRule implements RuleInterface
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
        return self::getForExistsIf($attribute, $value, $parameters, $validator, 'exists');
    }

}
