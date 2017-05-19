<?php
namespace LaraValidation;

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

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function required($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $length
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function minLength($name, $length, $message = '', $when = null);

    /**
     * @param $name
     * @param $length
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function maxLength($name, $length, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function email($name, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function numeric($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $rule
     * @param string $message
     * @param null $when
     * @return $this
     */
    public function add($name, $rule, $message = '', $when = null);

    /**
     * remove and existing rule
     *
     * @param $name
     * @param $ruleName
     * @return bool
     */
    public function remove($name, $ruleName = null);

}