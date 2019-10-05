<?php

namespace App\Listeners;

use App\Events\MorningEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class MakeCoffeeListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  MorningEvent  $event
     * @return void
     */
    public function handle(MorningEvent $event)
    {
        Log::info('status in MakeCoffeeListener listener: ', ['status' => $event->status]);
    }
}
