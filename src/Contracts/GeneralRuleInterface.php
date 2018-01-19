<?php
namespace LaraValidation\Contracts;

interface GeneralRuleInterface
{
    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function required($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function requiredIf($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function requiredUnless($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function requiredWith($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function requiredWithAll($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function requiredWithout($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function requiredWithoutAll($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function present($name, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function filled($name, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function accepted($name, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function nullable($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $size
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function size($name, $size, $message = '', $when = null);

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
     * @param $min
     * @param $max
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function between($name, $min, $max, $message = '', $when = null);

    /**
     * @param $name
     * @param $value
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function different($name, $value, $message = '', $when = null);

    /**
     * @return mixed
     */
    public function last();

    /**
     * @return mixed
     */
    public function bail();

    /**
     * @param $name
     * @param $rule
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function add($name, $rule, $message = '', $when = null);

    /**
     * @param $name
     * @param null $ruleName
     * @return mixed
     */
    public function remove($name, $ruleName = null);

}
