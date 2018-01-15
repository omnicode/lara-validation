<?php
namespace LaraValidation\Contracts;

interface StringRuleInterface
{
    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function email($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $string
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function startsWith($name, $string, $message = '', $when = null);

    /**
     * @param $name
     * @param $string
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function endsWith($name, $string, $message = '', $when = null);

    /**
     * @param $name
     * @param $string
     * @param string $message
     * @param null $when
     * @return mixed4
     */
    public function is($name, $string, $message = '', $when = null);

    /**
     * @param $name
     * @param $regex
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function regex($name, $regex, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function confirmed($name, $message = '', $when = null);

}
