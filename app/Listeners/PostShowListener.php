<?php

namespace App\Listeners;

use App\Events\PostShow;
use App\Models\UserAction;
use App\Observers\PostObserver;
use App\Observers\UserActionObserver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class PostShowListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostShow $event): void
    {
        $model = $event->user;
        $post = $event->post;
        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => 'showing',
                'action_model' => $post->getTable(),
                'action_id'    => $post->id
            ]);
        }
    }
}
