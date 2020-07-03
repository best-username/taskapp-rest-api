<?php

namespace App\Listeners;

use Auth;
use App\Logs;
use App\User;
use App\Events\TaskUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WriteToTaskLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskUpdated  $event
     * @return void
     */
    public function handle(TaskUpdated $event)
    {
        $log = new Logs();
        $log->time = NOW()->toDateTimeString();
        $log->text = 'Task was ' . $event->changes . 'd by ' . Auth::user()->id;
        $log->save();
    }
}
