<?php
namespace LaraValidation\Rules;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class UniqRule implements RuleInterface
{

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public static function get($attribute, $value, $parameters, $validator)
    {
        if (!isset($value)) {
            return true;
        }

        $data = $validator->getData();
        if (empty($parameters[0])) {
            throw new \InvalidArgumentException('Second parameter is required for unique validation');
        }

        $param1 = $parameters[0];
        unset($parameters[0]);

        if (class_exists($param1)) {
            $model = App::make($param1);
            $primaryKey = $model->getKeyName();
            $query = $model->newQuery();
        } else {
            $primaryKey = 'id';
            $table = $param1;
            $query = DB::table($table);
        }

        // set main uniqueness condition
        $query->where($attribute, '=', $value);

        // if primary key exists - set to NOT be equal (for updating case)
        if (!empty($data[$primaryKey])) {
            $query->where($primaryKey, '!=', $data[$primaryKey]);
        }

        // check conditional columns
        if (!empty($parameters)) {
            foreach ($parameters as $column) {
                if (isset($data[$column])) {
                    $query->where($column, '=', $data[$column]);
                }
            }
        }

        $count = $query->count();
        return ($count == 0) ? true : false;
    }

}
