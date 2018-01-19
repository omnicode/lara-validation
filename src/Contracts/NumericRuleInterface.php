<?php
namespace LaraValidation\Contracts;

interface NumericRuleInterface
{
    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function numeric($name, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function integer($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $value
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function digits($name, $value, $message = '', $when = null);

    /**
     * @param $name
     * @param $min
     * @param $max
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function digitsBetween($name, $min, $max, $message = '', $when = null);

}
