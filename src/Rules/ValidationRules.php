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
        Validator::extend('exists_db', 'LaraValidation\Rules\ExistsDbRule@get');
        Validator::extend('exists_if', 'LaraValidation\Rules\ExistsIfRule@get');
        Validator::extend('multi_exists', 'LaraValidation\Rules\MultiExistsRule@get');
        Validator::extend('multi_exists_if', 'LaraValidation\Rules\multiExistsIfRule@get');

        // other rules should be added here

        return true;
    }

}
