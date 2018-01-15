<?php
namespace LaraValidation\Contracts;

interface CoreValidatorInterface
{
    /**
     * get pure rule name frome rule string
     *
     * @param string $rule
     * @return string
     */
    public function getRuleName($rule = '');

    /**
     * returns the rules in Laravel format
     *
     * @return array
     */
    public function rules();

    /**
     * return list of messages
     *
     * @return array
     */
    public function messages();

    /**
     * @param $input
     * @return mixed
     */
    public function validate($input);

}