<?php
namespace LaraValidation;

use Illuminate\Support\Facades\Validator;
use LaraValidation\Contracts\LaraValidatorInterface;
use LaraValidation\Contracts\RuleInterface;

abstract class LaraValidator implements LaraValidatorInterface
{

    /**
     * @var CoreValidator
     */
    protected $validator;

    /**
     * list of validation messages
     *
     * @var array
     */
    protected $rules;

    /**
     * contains last operation's validation errors
     *
     * @var
     */
    protected $errors;

    /**
     * @param CoreValidator $validator
     */
    public function __construct(CoreValidator $validator)
    {
        $this->initialize();
        $this->validator = $validator;
    }

//    public function setCustomRule($rule, $ruleName = '')
//    {
//        if (!ends_with($rule, 'Rule')) {
//            //TODO not show exception
//            throw new \Exception('The Rule Must be ends with "Rule"');
//        }
//
//        $refl = new \ReflectionClass($rule);
//        if (!in_array(RuleInterface::class, $refl->getInterfaceNames())) {
//            //TODO not show exception
//            throw new \Exception(sprintf('The Rule Must be implements %s interface', RuleInterface::class));
//        }
//
//        if (empty($ruleName)) {
//            $ruleName = last(explode(DIRECTORY_SEPARATOR, $rule));
//            $ruleName = str_replace('Rule', '', $ruleName);
//            $ruleName = lcfirst($ruleName);
//        }
//
//        Validator::extend($ruleName, $rule . '@get');
//    }

    /**
     *
     */
    public function initialize()
    {

    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function isValid(array $attributes, $options = [])
    {
        if (is_string($options)) {
            $options = [
                'rule' => $options
            ];
        }

        $defaults = [
            'rule' => 'default'
        ];
        $options += $defaults;

        try {
            $validationName = 'validation' . camel_case($options['rule']);
            $validator = $this->{$validationName}();
        } catch (\Exception $e) {

        }

        $v = $validator->validate($attributes);

        if ($v->passes()) {
            $this->setErrors(null);
            return true;
        }

        $this->setErrors($v->errors());
        return false;
    }

    /**
     * return error messages from last validation
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $errors
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }
}
