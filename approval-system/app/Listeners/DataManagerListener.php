<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Data;
use App\Dictionaries\TransactionTypeDictionary;
use App\Events\DataApprovedEvent;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataManagerListener
{
    /**
     * Handle the event.
     *
     * @param  DataApprovedEvent  $event
     * @return void
     */
    public function handle(DataApprovedEvent $event)
    {
        try {
            $this->executeTransaction($event->getData());
        } catch(QueryException $e){
            dd($e->getMessage());
        }
    }

    private function executeTransaction(Data $data)
    {
        $decodedData = json_decode($data->data, true);

        switch ($data->transaction_type) {
            case TransactionTypeDictionary::TRANSACTION_INSERT:
                DB::table($data->table_name)->insert($decodedData);
                break;
            case TransactionTypeDictionary::TRANSACTION_DELETE:
                DB::table($data->table_name)->delete($decodedData['id']);
                break;
            case TransactionTypeDictionary::TRANSACTION_UPDATE:
                $recordId = $decodedData['id'];
                unset($decodedData['id']);
                DB::table($data->table_name)->where('id', $recordId)->update($decodedData);
                break;
            default:
                Log::error('Invalid Transaction Type');
        }
    }
}
