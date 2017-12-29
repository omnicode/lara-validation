# Lara Validation - wrapper for Laravel Validation

Lara Validation is a powerful wrapper for laravel validations (it is influenced by Cakephp 3 validations)

It has the following advantages
- More Logical way for defining rules
- Allows to move validation rules away from controller, service or from other layers to a separate Validation layer
- Makes validations re-usable between different service layers, controllers etc.
- Allows to define multiple validations with shared rules
- Easier to write custom validation messages
- Better way of defining custom validation methods
- Convenient features for defining conditional validation rules
- Easily integrated with Form Requests

## Contents

1. <a href="#installation">Installation</a>
2. <a href="#quick-start">Quick start</a>
3. <a href="#features">Features</a>
	* <a href="#basic-example">Basic example</a>
	* <a href="#custom-message">Custom validation message</a>
	* <a href="#conditional-validation-create-update">Conditional validation during create and update</a>
	* <a href="#conditional-validation-isset">Conditional validation if value is set</a>
	* <a href="#conditional-validation-notempty">Conditional validation if value is not empty</a>
	* <a href="#conditional-validation-callable">Conditional validation with callable method</a>
	* <a href="#add-laravel-rule">Adding existing laravel rules</a>
	* <a href="#add-custom-rule">Adding custom rules</a>
	* <a href="#share-rules">Sharing rules between different validations</a>
	* <a href="#form-requests">Using with form requests</a>
4. <a href="#methods">Methods</a>
    * <a href="#rule-required">required</a>
    * <a href="#rule-requiredIfIsset">requiredIfIsset</a>
    * <a href="#rule-minlength">minLength</a>
    * <a href="#rule-maxlength">maxLength</a>
    * <a href="#rule-email">email</a>
    * <a href="#rule-numeric">numeric</a>
    * <a href="#rule-unique">unique</a>

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
LaraValidation has some pre-defined methods, each method has the parameter for providing the field name, possible paramters based on each rule, as well as an optional `$when` parameter which might a callable function, or a string as `create` or `update`. Any laravel  validation rules that do not have wrappers can be easily added by `add` method, which allows also to add custom validation methods as a callable function.


### <a id="basic-example"></a>Basic Example

To make the field to be required we can simply write
```
public function validationDefault()
{
	$this->validator->required('first_name');
	
	return $this->validator;
}
```

### <a id="custom-message"></a>Custom validation message

```
$this->validator->required('first_name', 'First Name can not be empty');

// For Laravel 5.4 and above you can use
$this->validator->required('first_name', __('First Name can not be empty'));
```

### <a id="conditional-validation-create-update"></a>Conditional validation during create and update

To make the rule to be applied only when the record is being created or only when it is being updated
```
// the first_name will be required only when creating a record
$this->validator->required('first_name', 'First Name can not be empty', 'create');

// the first_name will be required only when updating the record
$this->validator->required('first_name', 'First Name can not be empty', 'update');
```

### <a id="conditional-validation-isset"></a>Conditional validation if value is set

To make the rule to be applied only when the key exists in the data array to be validated
```
// the first_name will be required only if 'first_name' key exists in the validated array
$this->validator->required('first_name', 'First Name can not be empty', 'isset');
```

### <a id="conditional-validation-notempty"></a>Conditional validation if value is not empty

To make the rule to be applied only when the provided value is not empty
```
// the age will be validated to be numeric only if it is provided
$this->validator->numeric('age', 'Age should be numeric', 'notempty');
```

### <a id="conditional-validation-callable"></a>Conditional validation with callable method

Use callable method for conditional validation

```
// the rule will be applied only if the callable method returns true
$this->validator->required('first_name', 'First Name can not be empty', function($input) {
	$array = $input->toArray();	// or you can use getAttributes()
	return empty($array['is_company']) ? true : false;
});
```

`$input` is and object of [Illuminate\Support\Fluent](https://laravel.com/api/5.4/Illuminate/Support/Fluent.html) that contains the data to be validated.

### <a id="add-laravel-rule"></a>Adding existing Laravel rules

If the rule does not have a wrapper, but it exists in Laravel, it can be easily added by

```
$this->validator->add('date_of_birth', 'date')
```

### <a id="add-custom-rule"></a>Adding custom rules

Using `add` method custom rules by callable methods can be defined

```
$this->validator->add('some_field', [
	'rule' => function ($attribute, $value, $parameters, $validator){
		// logic goes here
		// return true to apply the validation or false otherwise
	}
], __('Some optional validation message'));
```

for the second parameter(in the array), `implicit` option can be defined as well. More info [here](https://laravel.com/docs/5.4/validation#custom-validation-rules)


`$attribute`, `$value`, `$parameters` and `$validator` params of the method are defined [here](https://laravel.com/docs/5.4/validation#custom-validation-rules)

 
### <a id="share-rules"></a>Sharing rules between different validations

It might be cases, that it is required to apply different set of validation rules with different scenarios - meanwhile sharing part of the rules:

```
// this validation will validate first_name, last_name and email
public function validationDefault()
{
	$this->validator
		->required('first_name')
		->required('last_name')
		->required('email');
	
	return $this->validator;
}

// this validation will validate only first_name and last_name
public function validationEdit()
{
	// applies the rules from validationDefault
	$this->validationDefault();
	
	// remove existing rule
	$this->validator
		->remove('email');
	
	return $this->validator;
}

// this validation will validate first_name, last_name, email and gender
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

To validate the data

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


## <a id="methods"></a>Existing methods
Here is the list of predefined methods and wrappers

for all methods
- `$name` - field name (required)
- `$message` - the validation message (optional)
- `$when` - for conditional validation, can be a string equal to `create`, `update`, `isset`, `notempty`   or a callable method (optional)
 
### <a id="rule-required"></a>required
```
public function required($name, $message = '', $when = null)
```
`$name` can be either string as the field name or array of fields (however in case of array the same error message will be used for all provided fields)

### <a id="rule-requiredIfIsset"></a>requiredIfIsset
```
public function requiredIfIsset($name,  $when = null)
```
Alias for `required($name, $messages, 'isset')`

### <a id="rule-minlength"></a>minLength
```
public function minLength($name, $length, $message = '', $when = null)
```
`$length` mininum number of characters to be allowed

### <a id="rule-maxlength"></a>maxLength
```
public function maxLength($name, $length, $message = '', $when = null)
```
`$length` maximum number of characters to be allowed

### <a id="rule-email"></a>email
```
public function email($name, $message = '', $when = null)
```

### <a id="rule-numeric"></a>numeric
```
public function numeric($name, $message = '', $when = null)
```

### <a id="rule-unique"></a>unique
```
public function unique($name, $params = [], $message = '', $when = null)
```

`$params` can be either
- string - as a db table's exact name
```
$this->validator->unique('email', 'users', __('Email already exists. Please restore your password'));
```

- Model's class, e.g.

```
$this->validator->unique('field_name', Post::class, __('This value already exists'))
```

- array, which's first value is the Model's class and the following parameters are columns that should be considered during checking the uniqueness: suppose we need to force unique `title` field per user-basis

```
$this->validator->unique('title', [Post::class, 'user_id'], __('This title already exists'))
```

**Important Notice:** the field `user_id` should exist in the validation data


## <a id="form-requests"></a>Using with form requests

The rules defined by LaraValidation can be easily used in Form Requests, for that `rules` and `messages` methods should be used, which return the list of validation rules in native format and the list of messages respectively.

```
<?php
namespace App\Http\Requests;

use App\Validators\PostValidator;

class PostRequest
{
    /**
     * @var PostValidator
     */
    protected $postValidator;

    /**
     * @param PostValidator $postValidator
     */
    public function __construct(PostValidator $postValidator)
    {
        $this->rules = $postValidator->validationDefault()->rules();
        $this->messages = $postValidator->validationDefault()->messages();
    }

}
```
