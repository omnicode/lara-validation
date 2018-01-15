<?php
namespace LaraValidation\Contracts;

interface ArrayRuleInterface
{
    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function isArray($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function in($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function notIn($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function isCheckbox($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $class
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function inClassConstant($name, $class, $message = '', $when = null);
}
