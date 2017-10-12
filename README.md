# Lara Validation

Lara Validation is a convenient wrapper for laravel validation (it is influenced by Cakephp 3 validations)

It has the following advantages
- More Logical way for defining rules
- Allows to move validation rules away from controller, service or from other layers
- Makes rules re-usable through different service layers, controllers etc.
- Allows to define multiple validation scenarios with shared rules
- Easier to write custom validation messages
- Better way of defining custom validation methods

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


## <a id="quick-start"></a>Examples

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


