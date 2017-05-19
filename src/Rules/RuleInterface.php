<?php
namespace LaraValidation\Rules;

interface RuleInterface
{
    public static function get($attribute, $value, $parameters, $validator);
}
