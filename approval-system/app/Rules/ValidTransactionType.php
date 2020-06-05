<?php

declare(strict_types=1);

namespace App\Rules;

use App\Dictionaries\TransactionTypeDictionary;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidTransactionType implements Rule
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $tableName;

    public function __construct(array $data, string $tableName)
    {
        $this->data = $data;
        $this->tableName = $tableName;
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
        if (TransactionTypeDictionary::TRANSACTION_INSERT === $value) {
            return true;
        }

        return array_key_exists('id', $this->data) && $this->isRecordFound();
    }

    private function isRecordFound(): bool
    {
        return (bool) DB::table($this->tableName)->find($this->data['id']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The transaction type is invalid according to the provided data.';
    }
}
