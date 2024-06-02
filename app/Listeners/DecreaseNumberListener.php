<?php

namespace App\Listeners;
use App\Models\User;
use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DecreaseNumberListener implements ShouldQueue
{
    /**
     * Create the event listener.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 
     * Handle the event.
     */
    public function handle(DecreaseNumberEvent $event)
    {
        // Fetch the record from the database
        $record = Project::first();

        if ($record) {
            // Decrease the number (for example, subtract 1)
            $record->end_date -= 1;
            $record->save();
        }
    }
}
