<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class ValidColumnNamesRule implements Rule
{
    /**
     * @var string
     */
    private $table_name;

    public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $columnName => $columnValue) {
            if (!Schema::hasColumn($this->table_name, $columnName))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Make sure the column names are valid and exist.';
    }
}
