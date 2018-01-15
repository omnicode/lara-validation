<?php
namespace LaraValidation\Contracts;

interface FileRuleInterface
{
    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function file($name, $message = '', $when = null);

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function mimes($name, $data, $message = '', $when = null);

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function image($name, $message = '', $when = null);

}
