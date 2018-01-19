<?php
namespace LaraValidation;

use Illuminate\Support\Facades\Validator;
use LaraValidation\Contracts\ArrayRuleInterface;
use LaraValidation\Contracts\CoreValidatorInterface;
use LaraValidation\Contracts\DateRuleInterface;
use LaraValidation\Contracts\DBRuleInterface;
use LaraValidation\Contracts\FileRuleInterface;
use LaraValidation\Contracts\GeneralRuleInterface;
use LaraValidation\Contracts\NumericRuleInterface;
use LaraValidation\Contracts\StringRuleInterface;
use LaraValidation\Rules\ValidationRules;

class CoreValidator extends Validator implements CoreValidatorInterface, GeneralRuleInterface, NumericRuleInterface,
    StringRuleInterface, ArrayRuleInterface, FileRuleInterface, DBRuleInterface, DateRuleInterface
{
    /**
     * list of defined rules
     * @var array
     */
    protected $_rules = [];

    /**
     * @var null
     */
    protected $_lastField = null;

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

    /**
     * CoreValidator constructor.
     */
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

    /********************
     *   General rules  *
     *******************/

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
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function requiredIf($name, $data, $message = '', $when = null)
    {
        return $this->fixMultiRuleStructure($name, 'required_if', $data, $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function requiredUnless($name, $data, $message = '', $when = null)
    {
        return $this->fixMultiRuleStructure($name, 'required_unless', $data, $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function requiredWith($name, $data, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'required_with', $data, $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function requiredWithAll($name, $data, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'required_with_all', $data, $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function requiredWithout($name, $data, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'required_without', $data, $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function requiredWithoutAll($name, $data, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'required_without_all', $data, $message, $when);
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function present($name, $message = '', $when = null)
    {
        return  $this->add($name, 'present', $message, $when);
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function filled($name, $message = '', $when = null)
    {
        return  $this->add($name, 'filled', $message, $when);
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function accepted($name, $message = '', $when = null)
    {
        return  $this->add($name, 'accepted', $message, $when);
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function nullable($name, $message = '', $when = null)
    {
        return  $this->add($name, 'nullable', $message, $when);
    }

    /**
     * @param $name
     * @param $size
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function size($name, $size, $message = '', $when = null)
    {
        return  $this->fixRuleStructure($name, 'size', $size, $message, $when);
    }

    /**
     * @param $name
     * @param $length
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function minLength($name, $length, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'min', $length, $message, $when);
    }

    /**
     * @param $name
     * @param $length
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function maxLength($name, $length, $message = '', $when = null)
    {
        $length = $this->getTextLength($length);
        return $this->fixRuleStructure($name, 'max', $length, $message, $when);
    }

    /**
     * @param $name
     * @param $min
     * @param $max
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function between($name, $min, $max, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'between', [$min, $max], $message, $when);
    }

    /**
     * @param $name
     * @param $value
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function different($name, $value, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'different', $value, $message, $when);
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
        return $this->add($this->_lastField, 'bail');
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
        $this->_lastField = $name;
        return $this;
    }

    /**
     * remove an existing rule
     *
     * @param $name
     * @param $ruleName - if not provided all rules of the given field will be removed
     * @return $this
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


    /********************
     *   Numeric rules  *
     *******************/

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function numeric($name, $message = '', $when = null)
    {
        return $this->add($name, 'numeric', $message, $when);
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function integer($name, $message = '', $when = null)
    {
        return $this->add($name, 'integer', $message, $when);
    }

    /**
     * @param $name
     * @param $value
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function digits($name, $value, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'digits', $value, $message, $when);
    }

    /**
     * @param $name
     * @param $min
     * @param $max
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function digitsBetween($name, $min, $max, $message = '', $when = null)
    {
        return $this->numeric($name,$message, $when)->between($name, $min, $max, $message, $when);
    }


    /********************
     *   String rules   *
     *******************/

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function email($name, $message = '', $when = null)
    {
        return  $this->add($name, 'email', $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function startsWith($name, $data, $message = '', $when = null)
    {
        return $this->addStringMethodRule($name, 'starts_with', $data, $message = '', $when = null);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function endsWith($name, $data, $message = '', $when = null)
    {
        return $this->addStringMethodRule($name, 'ends_with', $data, $message = '', $when = null);
    }

    /**
     * @param $name
     * @param $pattern
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function is($name, $pattern, $message = '', $when = null)
    {
        if (empty($message)) {
            $message = sprintf('The %s must be is pattern of %s ' , $name, $pattern);
        }

        return $this->add($name, [
            'rule' => function ($attribute, $value, $parameters, $validator) use ($pattern) {
                if (empty($value)) {
                    return true;
                }

                return str_is($pattern, $value);
            }], $message, $when);
    }

    /**
     * @param $name
     * @param $regex
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function regex($name, $regex, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'regex' , $regex, $message, $when);
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function confirmed($name, $message = '', $when = null)
    {
        return $this->add($name, 'confirmed', $message, $when);
    }

    /********************
     *   Array rules    *
     *******************/

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function isArray($name, $message = '', $when = null)
    {
        return $this->add($name, 'array', $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function in($name, $data, $message = '', $when = null)
    {
        if (is_array($data)) {
            $data = implode(',', $data);
        }
        return $this->add($name, 'in:' . $data, $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function notIn($name, $data, $message = '', $when = null)
    {
        if (is_array($data)) {
            $data = implode(',', $data);
        }
        return $this->add($name, 'note_in:' . $data, $message, $when);
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function isCheckbox($name, $message = '', $when = null)
    {
        return $this->in($name, [0, 1], $message, $when);
    }

    /**
     * @param $name
     * @param $class
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function inClassConstant($name, $class, $message = '', $when = null)
    {
        $refl = new \ReflectionClass($class);
        $data = $refl->getConstants();
        return $this->in($name, $data, $message, $when);
    }

    /********************
     *   Date rules     *
     *******************/

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function date($name, $message = '', $when = null)
    {
        return $this->add($name, 'date', $message, $when);
    }

    /**
     * @param $name
     * @param $format
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function dateFormat($name, $format, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'date_format', $format, $message, $when);
    }

    /**
     * @param $name
     * @param $date
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function before($name, $date, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'before', $date, $message, $when);
    }

    /**
     * @param $name
     * @param $date
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function after($name, $date, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'after' . $date, $message, $when);
    }

    /**
     * @param $name
     * @param $date
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function afterOrEqual($name, $date, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'after_or_equal', $date, $message, $when);
    }

    /********************
     *   File rules     *
     *******************/

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function file($name, $message = '', $when = null)
    {
        return $this->add($name, 'file', $message, $when);
    }

    /**
     * @param $name
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function mimes($name, $data, $message = '', $when = null)
    {
        return $this->fixRuleStructure($name, 'mimes' ,$data, $message, $when);
    }

    /**
     * @param $name
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    public function image($name, $message = '', $when = null)
    {
        return $this->add($name, 'image', $message, $when);
    }

    /********************
     *     DB rules     *
     *******************/
    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return CoreValidator
     *
     * all time table or model full name
     *
     * $params = 'table'
     * $params = ['table', 'column']
     * $params = ['table', 'column', 'connection']
     *
     * if 'name' ends with '_id' auto 'column' => id
     */
    public function exists($name, $params = [], $message = '', $when = null)
    {
        if (empty($message)) {
            $message = 'Invalid argument is supplied';
        }
        return $this->fixRuleStructure($name, 'exists_db',  $params, $message, $when);
    }

    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return CoreValidator
     *
     * all time table or model full name
     *
     * $params = 'table'
     * $params = ['table']
     * $params = ['table', 'column']
     * $params = ['table', 'column', 'connection']
     */
    public function multiExists($name, $params = [], $message = '', $when = null)
    {
        if (empty($message)) {
            $message = 'Invalid argument is supplied';
        }
        return $this->fixRuleStructure($name, 'multi_exists', $params, $message, $when);
    }

    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return CoreValidator
     *
     * all time table or model full name
     *
     * $params = ['table', ['column' => value]]
     * $params = ['table', 'column', ['column1' => value1]]
     * $params = ['table', 'column', 'connection', ['column1' => value1]]
     *
     * $params = ['table', ['column1' => 'value1', 'column2' => 'value2']]
     * $params = ['table', 'column', ['column1' => 'value1', 'column2' => 'value2']]
     * $params = ['table', 'column', 'connection', ['column1' => 'value1', 'column2' => 'value2']]
     *
     * $params = ['table', ['column1' => 'value1'], ['column2' => 'value2']]
     * $params = ['table', 'column', ['column1' => 'value1'], ['column2' => 'value2']]
     * $params = ['table', 'column', 'connection', ['column1' => 'value1'], ['column2' => 'value2']]
     *
     */
    public function existsIf($name, $params = [], $message = '', $when = null)
    {
        if (empty($message)) {
            $message = 'Invalid argument is supplied';
        }
        return $this->fixDbIfRuleStructure($name, 'exists_if', $params, $message, $when);
    }

    /**
     * @param $name
     * @param array $params
     * @param string $message
     * @param null $when
     * @return CoreValidator
     *
     * parameters see exist if
     */
    public function multiExistsIf($name, $params = [], $message = '', $when = null)
    {
        if (empty($message)) {
            $message = 'Invalid argument is supplied';
        }
        return $this->fixDbIfRuleStructure($name, 'multi_exists_if', $params, $message, $when);
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
        return $this->fixRuleStructure($name, 'uniq', $params, $message, $when);
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
    protected function checkWhen($name, $when = null)
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


    /**
     * @param $name
     * @param $rule
     * @param $data
     * @param string $message
     * @param null $when
     * @return $this|CoreValidator
     *
     * $data = 'field,value1,value2,value3'
     * $data = [field, value1,value2,value3]
     * $data = [
     *     field1 => value1
     *     field2 => [value1, value2]
     * ]
     */
    protected function fixMultiRuleStructure($name, $rule, $data, $message = '', $when = null)
    {
        if (is_string($data) || is_numeric(head(array_keys($data)))) {
            return  $this->fixRuleStructure($name, $rule, $data, $message, $when);
        }

        foreach ($data as $filed => $values) {
            $this->makeArray($values);
            array_unshift($values, $filed);
            $this->fixRuleStructure($name, $rule, $values, $message, $when);
        }

        return  $this;
    }

    /**
     * @param $name
     * @param $rule
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     *
     * $data = 'field1,field2,field3'
     * $data = [field1, field2, field3]
     */
    protected function fixRuleStructure($name, $rule, $data, $message = '', $when = null)
    {
        $this->makeArray($data);
        $rule = sprintf('%s:%s', $rule, implode(',', $data));
        return $this->add($name, $rule, $message, $when);
    }

    /**
     * @param $name
     * @param $rule
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    protected function fixDbIfRuleStructure($name, $rule, $data, $message = '', $when = null)
    {
        $this->makeArray($data);
        $rule .= ':';

        foreach ($data as $datum) {
            if (is_array($datum)) {
                foreach ($datum as $key => $value) {
                    if (is_null($value)) {
                        $value = 'null';
                    }
                    $rule .= $key . '=>' . $value . ',';
                }
            } else {

                $rule .= $datum . ',';
            }
        }

        $rule = rtrim($rule, ',');
        return $this->add($name, $rule, $message, $when);
    }

    /**
     * @param $name
     * @param $method
     * @param $data
     * @param string $message
     * @param null $when
     * @return CoreValidator
     */
    protected function addStringMethodRule($name, $method, $data , $message = '', $when = null) {
        $this->makeArray($data);

        if (empty($message)) {
            $message = sprintf('The %s must be %s ' , $name, str_replace('_', ' ', $method));
            $message .= count($data) == 1 ? '' : 'one of ';
            $message .= implode(', ', $data);
        }

        return $this->add($name, [
            'rule' => function ($attribute, $value, $parameters, $validator) use ($method, $data) {
                if (empty($value)) {
                    return true;
                }

                return $method($value, $data);
            }], $message, $when);
    }

    /**
     * @param $array
     */
    protected function makeArray(&$array)
    {
        if (!is_array($array)) {
            $array = [$array];
        }
    }
}
