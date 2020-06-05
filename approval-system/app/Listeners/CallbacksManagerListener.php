<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Callback;
use App\Events\DataApprovedEvent;

class CallbacksManagerListener
{
    /**
     * Handle the event.
     *
     * @param  DataApprovedEvent  $event
     * @return void
     */
    public function handle(DataApprovedEvent $event)
    {
        $callback = $event->getData()->callback;

        if ($callback instanceof Callback) {
            $callbackExecution = [$callback->class_path, $callback->function_name];

            try {
                $callbackExecution($callback->arguments ? json_decode($callback->arguments) : null);
            } catch (\Exception $exception) {
                dd($exception->getMessage());
            }
        }
    }
}
