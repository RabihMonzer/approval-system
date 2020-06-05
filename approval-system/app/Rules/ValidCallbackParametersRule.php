<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCallbackParametersRule implements Rule
{
    const CLASS_PATH = 'class_path';
    const FUNCTION_NAME = 'function_name';
    const ARGUMENTS = 'arguments';

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isValidClassPath($value) && $this->isValidFunctionName($value) && $this->isValidArgumentType($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The class path, class method, or arguments are invalid.';
    }

    private function isValidClassPath(array $callbackParameters): bool
    {
        return array_key_exists(self::CLASS_PATH, $callbackParameters)
            && class_exists($callbackParameters[self::CLASS_PATH]);
    }

    private function isValidFunctionName(array $callbackParameters): bool
    {
        return array_key_exists(self::FUNCTION_NAME, $callbackParameters)
            && method_exists($callbackParameters[self::CLASS_PATH], $callbackParameters[self::FUNCTION_NAME]);
    }

    /**
     * - If No arguments are sent, the callback function will be called without passing any arguments
     * - If any arguments are passed, they must be of type array
     */
    private function isValidArgumentType(array $callbackParameters): bool
    {
        return array_key_exists(self::ARGUMENTS, $callbackParameters) ?
            is_array($callbackParameters[self::ARGUMENTS])
            :
            true;
    }
}
