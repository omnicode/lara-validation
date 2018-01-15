<?php
namespace LaraValidation\Contracts;

interface DBRuleInterface
{
    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function exists($name, $params = [], $message = '', $when = null);

    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function multiExists($name, $params = [], $message = '', $when = null);

    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function unique($name, $params = [], $message = '', $when = null);

    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function multiExistsIf($name, $params = [], $message = '', $when = null);

    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return mixed
     */
    public function existsIf($name, $params = [], $message = '', $when = null);

}
