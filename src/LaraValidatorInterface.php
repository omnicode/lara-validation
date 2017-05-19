<?php
namespace LaraValidation;

interface LaraValidatorInterface
{
    /**
     * @param array $attributes
     * @param array $options
     * @return mixed
     */
    public function isValid(array $attributes, $options = []);

    /**
     * return error messages from last validation
     * @return mixed
     */
    public function getErrors();
}