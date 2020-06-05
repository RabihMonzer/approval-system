<?php

declare(strict_types=1);

namespace App;

use App\Dictionaries\DataStatusDictionary;
use App\Http\Requests\CreateDataRequest;
use App\Observers\DataObserver;
use Illuminate\Database\Eloquent\Model;
use Psy\Util\Json;

class Data extends Model
{
    protected $guarded = [];

    public function createdBy()
    {
        $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        $this->belongsTo(User::class);
    }

    public function callback()
    {
        return $this->hasOne(Callback::class, 'data_id');
    }

    protected static function boot()
    {
        parent::boot();
        Data::observe(DataObserver::class);
    }

    public function approve()
    {
        $this->status = DataStatusDictionary::APPROVED;
    }

    public function reject()
    {
        $this->status = DataStatusDictionary::REJECTED;
    }

    public static function createData(CreateDataRequest $request): Data
    {
        return Data::create([
            'data' => Json::encode($request->get('data')),
            'table_name' => $request->get('table_name'),
            'transaction_type' => $request->get('transaction_type'),
            'dispatch_transaction_completed_event' => $request->get('dispatch_transaction_completed_event') ?? false,
        ]);
    }

    public function shouldDispatchTransactionCompletedEvent(): bool
    {
        return (bool) $this->dispatch_transaction_completed_event;
    }

    public static function testing()
    {
        dd('Passed');
    }
}
