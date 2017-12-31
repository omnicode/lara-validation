<?php
namespace LaraValidation;

use Illuminate\Support\Facades\Validator;
use LaraValidation\Rules\ValidationRules;

class CoreValidator extends Validator implements CoreValidatorInterface
{
    /**
     * list of defined rules
     * @var array
     */
    protected $_rules = [];

    /**
     * list of conditional rules
     * @var array
     */
    protected $_sometimes = [];

    /**
     * list of messages for declared rules
     * @var array
     */
    protected $_messages = [];


    public function __construct()
    {
        ValidationRules::execute();
    }

    /**
     * get pure rule name frome rule string
     *
     * @param string $rule
     * @return string
     */
    public function getRuleName($rule = '')
    {
        if (stristr($rule, ":")) {
            return explode(":", $rule)[0];
        }

        return $rule;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function validate($input)
    {
        $rules = $this->rules();
        $messages = $this->messages();
        $v = self::make($input, $rules, $messages);

        if (!empty($this->_sometimes)) {
            foreach ($this->_sometimes as $col => $data) {
                reset($data);
                $key = key($data);
                $v->sometimes($col, $key, $data[$key]);
            }
        }

        return $v;
    }

    /**
     * returns the rules in Laravel format
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->_rules as $name => $ruleList) {
            $rules[$name] = implode("|", $ruleList);
        }

        return $rules;
    }

    /**
     * returns the rules in array format
     *
     * @return array
     */
    protected function _rules()
    {
        return $this->_rules;
    }

    /**
     * return list of messages
     *
     * @return array
     */
    public function messages()
    {
        return $this->_messages;
    }


    /**
     * @param $name
     * @param null $message
     * @return $this
     */
    public function requiredIfIsset($name, $message = null)
    {
        $this->required($name, $message, 'isset');
        return $this;
    }
    

    /**
     * @param array|string $name
     * @param string $message
     * @param null $when
     * @return $this
     */
    public function required($name, $message = '', $when = null)
    {
        if (is_string($name)) {
            $name = [
                $name
            ];
        }

        // prevent duplicate validation rules
        $name = array_unique($name);

        // when array is provided
        // [ 'name', 'title', 'first_name' => 'First Name is Required', 'last_name', 'gender' => 'Gender is Required' ]
        foreach ($name as $n => $m) {
            // if $n is int, means no custom message is provided - so use the default one
            // and the message is actually the name
            if (is_int($n)) {
                $n = $m;
                $m = $message;
            }

            $this->add($n, 'required', $m, $when);
        }

        return $this;
    }

    /**
     * @param $name
     * @param $length
     * @param string $message
     * @param null $when
     * @return $this
     */
    public function minLength($name, $length, $message = '', $when = null)
    {
        $this->add($name, 'min:' . $length, $message);
        return $this;
    }

    /**
     * @param $name
     * @param $length
     * @param string $message
     * @param null $when
     * @return $this
     * @throws \Exception
     */
    public function maxLength($name, $length, $message = '', $when = null)
    {
        $length = $this->getTextLength($length);
        $this->add($name, 'max:' . $length, $message, $when);
        return $this;
    }

    /**
     * @param $name
     * @param string $message
     * @param $when
     * @return $this
     */
    public function email($name, $message = '', $when = null)
    {
        $this->add($name, 'email', $message, $when);
        return $this;
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return $this
     */
    public function numeric($name, $message = '', $when = null)
    {
        $this->add($name, 'numeric', $message, $when);
        return $this;
    }

    /**
     * @param $name
     * @param $params
     * @param $message
     * @param null $when
     * @return $this
     */
    public function unique($name, $params = [], $message = '', $when = null)
    {
        if (is_string($params)) {
            $params = [
                $params
            ];
        }

        $this->add($name, 'uniq:'.implode(',', $params), $message, $when);
        return $this;
    }

    /**
     * alias for bail
     *
     * @return CoreValidator
     */
    public function last()
    {
        return $this->bail();
    }

    /**
     * if the previous rule fails, does not validate other rules of this attr
     *
     * @return $this
     */
    public function bail()
    {
        $attrs = array_keys($this->_rules());
        $name = end($attrs);

        $this->add($name, 'bail');
        return $this;
    }

    /**
     * @param $name
     * @param $rule
     * @param string $message
     * @param null $when
     * @return $this
     */
    public function add($name, $rule, $message = '', $when = null)
    {
        if (!isset($this->_rules[$name])) {
            $this->_rules[$name] = [];
        }

        // for custom rules
        if (is_array($rule)) {
            $rule = $this->addCustomRule($name, $rule);
        }

        $when = $this->checkWhen($name, $when);

        if (is_callable($when)) {
            $this->_sometimes[$name][$rule] = $when;
        } elseif (in_array($when, ['create', 'update'])) {
            $this->_sometimes[$name][$rule] = function ($input) use ($when) {
                if ($when == 'create') {
                    return empty($input['id']);
                }

                return !empty($input['id']);
            };
        } else {
            $this->_rules[$name][] = $rule;
        }

        $ruleName = $this->getRuleName($rule);
        $messageRule = $name . '.' . $ruleName;
        if (!empty($message)) {
            $this->_messages[$messageRule] = $message;
        }

        return $this;
    }

    /**
     * remove an existing rule
     *
     * @param $name
     * @param $ruleName - if not provided all rules of the given field will be removed
     * @return bool
     */
    public function remove($name, $ruleName = null)
    {
        if (!isset($this->_rules[$name]) && !isset($this->_sometimes[$name])) {
            return $this;
        }

        // reset all rules for this field
        if ($ruleName === null) {
            unset($this->_rules[$name]);
            unset($this->_sometimes[$name]);
            return $this;
        }

        // for rules
        if (!empty($this->_rules[$name])) {
            $rules = $this->_rules[$name];
            foreach ($rules as &$thisRule) {
                if ($ruleName == $this->getRuleName($thisRule)) {
                    $thisRule = null;
                }
            }
            unset($thisRule);

            $this->_rules[$name] = array_filter($rules);
            $this->_rules = array_filter($this->_rules);
        }

        if (!empty($this->_sometimes[$name])) {
            // for conditional rules
            $conditionalRules = $this->_sometimes[$name];

            foreach ($conditionalRules as $k => &$condRule) {
                if ($k == $ruleName) {
                    $condRule = null;
                }
            }
            unset($condRule);
            $this->_sometimes[$name] = array_filter($conditionalRules);
            $this->_sometimes = array_filter($this->_sometimes);
        }
        
        return $this;
    }


    /**
     * TINYTEXT	256 bytes
     * TEXT	65,535 bytes	~64kb
     * MEDIUMTEXT	 16,777,215 bytes	~16MB
     * LONGTEXT	4,294,967,295 bytes	~4GB
     *
     * @param $length
     * @return mixed
     * @throws \Exception
     */
    private function getTextLength($length)
    {
        if (is_numeric($length)) {
            return $length;
        }

        // @TODO - this is for MYSQL only
        $types = [
            'tinytext' => 256,
            'text' => 65535,
            'mediumtext' => 16777215,
            'longtext' => 4294967295
        ];
        if (isset($types[$length])) {
            return $types[$length];
        }

        throw new \Exception('Invalid length attribute');
    }


    /**
     * @param $name
     * @param array $data
     * @return string
     */
    private function addCustomRule($name, $data = [])
    {
        if (!empty($data['name'])) {
            $validationName = $data['name'];
        } else {
            $validationName = md5($name.microtime(true));
        }

        if (!empty($data['implicit'])) {
            self::extendImplicit($validationName, $data['rule']);
        } else {
            self::extend($validationName, $data['rule']);
        }

        return $validationName;
    }


    /**
     * Checks $when's string values
     *
     * @param $name
     * @param null $when
     * @return \Closure|null
     */
    private function checkWhen($name, $when = null)
    {
        // if "isset" is provided - validate only if the given value is set
        if ($when === 'isset') {
            return function($input) use ($name) {
                return array_key_exists($name, $input->toArray());
            };
        }

        // if "notempty" is provided - validate only if the given value is not empty
        if ($when === 'notempty') {
            return function($input) use ($name) {
                $arr = $input->toArray();
                return !empty($arr[$name]);
            };
        }

        return $when;
    }


}
