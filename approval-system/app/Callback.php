<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Psy\Util\Json;

class Callback extends Model
{
    protected $guarded = [];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }

    public static function createCallback(array $callbackParameters, Data $data): Callback
    {
        return Callback::create([
            'class_path' => $callbackParameters['class_path'],
            'function_name' => $callbackParameters['function_name'],
            'arguments' => isset($callbackParameters['arguments']) ? Json::encode($callbackParameters['arguments']) : null,
            'data_id' => $data->id,
        ]);
    }
}
