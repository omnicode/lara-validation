<?php
namespace LaraValidation\Rules;

use Illuminate\Support\Facades\Validator;

class ValidationRules
{
    /**
     * @return bool
     */
    public static function process()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = self::execute();
        }

        return $inst;
    }

    /**
     * @return bool
     */
    protected static function execute()
    {
        /**
         * Custom Rule for unique validation
         */
        Validator::extend('uniq', 'LaraValidation\Rules\UniqRule@get');

        // other rules should be added here

        return true;
    }

}