<?php

namespace App\Listeners;

use App\Events\DeleteUser;
use App\Models\UserAlert;
use App\Models\UserFavorite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DeleteUserListener
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
     * @param  DeleteUser  $event
     * @return void
     */
    public function handle(DeleteUser $event)
    {
        Log::info(sprintf("[Account Deletion] Handling account deletion request"), ['user' => $event->user]);

        $alerts = UserAlert::where('user_id','=',$event->user->id)->delete();

        $favorites = UserFavorite::where('user_id','=',$event->user->id)->delete();

        $event->user->delete();

        Log::info(sprintf("[Account Deletion] Deleted User Account. User had %d alerts and %d favorites", $alerts, $favorites), ['user' => $event->user]);

    }
}
