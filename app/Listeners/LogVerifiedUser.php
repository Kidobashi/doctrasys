<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class LogVerifiedUser
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

    public function log(User $user)
    {
        // Log the verified user
        Log::info('User ' . $user->name . ' (' . $user->email . ') has been verified.');
    }

     /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        // Log the verified user
        $logger = new LogVerifiedUser();
        $logger->log($event->user);
        Alert::success('message', 'User Verified');
    }
}
