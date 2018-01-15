<?php
namespace LaraValidation\Contracts;

interface DateRuleInterface
{
    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function date($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $format
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function dateFormat($name, $format, $message = '', $when = null);

    /**
     * @param $name
     * @param $date
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function before($name, $date, $message = '', $when = null);

    /**
     * @param $name
     * @param $date
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function after($name, $date, $message = '', $when = null);

    /**
     * @param $name
     * @param $date
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function afterOrEqual($name, $date, $message = '', $when = null);
}
