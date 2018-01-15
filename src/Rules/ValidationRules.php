<?php
namespace LaraValidation\Rules;

use Illuminate\Support\Facades\Validator;

class ValidationRules
{

    /**
     * @return bool
     */
    public static function execute()
    {
        /**
         * Custom Rule for unique validation
         */
        Validator::extend('uniq', 'LaraValidation\Rules\UniqRule@get');
        Validator::extend('multiExists', 'LaraValidation\Rules\MultiExistsRule@get');
        Validator::extend('existsIf', 'LaraValidation\Rules\ExistsIfRule@get');
        Validator::extend('multiExistsIf', 'LaraValidation\Rules\multiExistsIfRule@get');

        // other rules should be added here

        return true;
    }

}
