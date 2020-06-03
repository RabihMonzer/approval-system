<?php

namespace App\Dictionaries;

class TransactionTypeDictionary
{
    const TRANSACTION_INSERT = 'Insert';
    const TRANSACTION_UPDATE = 'Update';
    const TRANSACTION_DELETE = 'Delete';

    public static function getValidTransactionTypes(): array
    {
        return [
            self::TRANSACTION_INSERT,
            self::TRANSACTION_UPDATE,
            self::TRANSACTION_DELETE,
        ];
    }
}
