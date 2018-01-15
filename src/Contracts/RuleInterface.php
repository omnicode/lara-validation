<?php
namespace LaraValidation\Contracts;

interface RuleInterface
{
    public static function get($attribute, $value, $parameters, $validator);
}
