# Lara Validation

Lara Validation is a powerful wrapper for laravel validations (it is influenced by Cakephp 3 validations)

It has the following advantages
- More Logical way for defining rules
- Allows to move validation rules away from controller, service or from other layers to a separate Validation layer
- Makes rules re-usable through different service layers, controllers etc.
- Allows to define multiple validation scenarios with shared rules
- Easier to write custom validation messages
- Better way of defining custom validation methods
- Convenient features for defining conditional validation rules
- Easily integrated with FormRequests

## Contents

1. <a href="#installation">Installation</a>
2. <a href="#quick-start">Quick start</a>
3. <a href="#features">Features</a>
	* <a href="#basic-example">Basic Example</a>
	* <a href="#custom-message">Custom Validation Message</a>
	* <a href="#conditional-validation-create-update">Conditional Validation during Create and Update</a>
	* <a href="#conditional-validation-callable">Conditional Validation with Callable method</a>
	* <a href="#add-laravel-rule">Adding Existing Laravel Rules</a>
	* <a href="#add-multiple-validations">Adding Multiple Validations</a>
	* <a href="#share-rules">Share Rules between Different policies</a>
4. <a href="#how-to">Methods</a>
    * <a href="#rule-required">required</a>
    * <a href="#rule-minlength">minLength</a>
    * <a href="#rule-maxlength">maxLength</a>
    * <a href="#rule-email">email</a>
    * <a href="#rule-numeric">numeric</a>
    * <a href="#rule-unique">unique</a>
    * <a href="#rule-add">add</a>
    * <a href="#rule-remove">remove</a>
4. <a href="#custom-rules">Custom Rules</a>
5. <a href="#form-requetss">Using with Form Requests</a>
5. <a href="#license">License</a>
 

## <a id="installation"></a>Installation

At `composer.json` of your Laravel installation, add the following require line:

``` json
{
    "require": {
        "omnicode/lara-validation": "~0.0"
    }
}
```

Run `composer update` to add the package to your Laravel app.


## <a id="quick-start"></a>Quick start

Define simple validator

```
<?php
namespace App\Validators;

use LaraValidation\LaraValidator;

class PostValidator extends LaraValidator
{
    /**
     * @return \LaraValidation\CoreValidator
     */
    public function validationDefault()
    {
        $this->validator
            ->required('title')
            ->required('content', 'Message can not be empty')
            ->maxLength('content', 5000);

        return $this->validator;
    }

}
```

Use it inside your controller or service layer


```
// .. - your namespace

use App\Validators\PostValidator;

// ... controller, service or other class

protected $postValidator;

public function __construct(PostValidator $postValidator)
{
	$this->postValidator = $postValidator;
}

public function someMethod()
{
	// $data -> the data, that should be validated - as an array
	//        can be taken from request by $request->all()
	//        or can be a custom-created as below

	$data = [
	  'title' => 'some title',
	  'content' => 'Some content for post'
	];
	
	if ($this->postValidator->isValid($data)) {
		// validated
	} else {
		// not validated
	}
	
}

```


## <a id="Features"></a>Features
LaraValidadtion has some pre-defined methods, each method has the parameter for providing the field name, possible paramters based on each rule, as well as an optional `$when` parameter which might a callable function, or a string as `create` or `update`. Any laravel  validation rules that do not have wrappers can be easily added by `add` method, which allows also to add custom validation methods as a callable function.


### <a id="basic-example"></a>Basic Example

To make the field to be required we can simply write
```
public function validationDefault()
{
	$this->validator->required('first_name');
	
	return $this->validator;
}
```

### <a id="custom-message"></a>Custom Validation Message

```
$this->validator->required('first_name', 'First Name can not be empty');

// For Laravel 5.4 and above you can use
$this->validator->required('first_name', __('First Name can not be empty'));
```

### <a id="conditional-validation-create-update"></a>Conditional Validation during Create and Update

To make the rule to be applied only when the record is being created or only when it is being updated
```
// the first_name will be required only when creating a record
$this->validator->required('first_name', 'First Name can not be empty', 'create');

// the first_name will be required only when updating the record
$this->validator->required('first_name', 'First Name can not be empty', 'update');
```

### <a id="conditional-validation-callable"></a>Conditional Validation with Callable method

Use callable method for conditional validation

```
// the rule will be applied only if the callable method returns true
$this->validator->required('first_name', 'First Name can not be empty', function($input) {
	$array = $input->toArray();	// or you can use getAttributes()
	return empty($array['is_company']) ? true : false;
});
```

`$input` is and object of [Illuminate\Support\Fluent](https://laravel.com/api/5.3/Illuminate/Support/Fluent.html) that contains the data to be validated.

### <a id="add-laravel-rule"></a>Adding Existing Laravel Rules

If the rule does not have a wrapper, but it exists in Laravel, it can be easily added by

```
$this->validator->add('date_of_birth', 'date')
```
 
### <a id="share-rules"></a>Sharing Rules

It might be cases, that it is required to apply different rules during create or update, meanwhile sharing part of the rules:

```
// this validation will require first_name, last_name and email
public function validationDefault()
{
	$this->validator
		->required('first_name')
		->required('last_name')
		->required('email');
	
	return $this->validator;
}

// this validation would require only first_name and last_name
public function validationEdit()
{
	// applies the rules from validationDefault
	$this->validationDefault();
	
	// remove existing rule
	$this->validator
		->remove('email');
	
	return $this->validator;
}

// this validation would require first_name, last_name, email and gender
public function validationOther()
{
	// applies the rules from validationDefault
	$this->validationDefault();
	
	// add new rule
	$this->validator
		->required('gender');
	
	return $this->validator;
}
```

To validate the data by `validationDefault`

```
use App\Validators\UserValidator;

// ... controller, service or other class

protected $userValidator;

public function __construct(UserValidator $userValidator)
{
	$this->userValidator = $userValidator;
}

public function someMethod()
{
	
	// $data - data to be validated

	// to validate by `validationDefault` rules use
	$this->userValidator->isValid($data);
	// which is the same as
	$this->userValidator->isValid($data, ['rule' => 'default']);

	// to validate by `validationEdit` rules use
	$this->userValidator->isValid($data, ['rule' => 'edit']);

	// to validate by `validationOther` rules use
	$this->userValidator->isValid($data, ['rule' => 'other']);
	
}
```















