<?php

namespace App\Observers;

use App\Models\UserAction;
use Illuminate\Support\Facades\Auth;

class UserActionObserver
{
    public function saved($model): void
    {
        if ($model->wasRecentlyCreated) {
            // Data was just created
            $action = 'created';
        } else {
            // Data was updated
            $action = 'updated';
        }
        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => $action,
                'action_model' => $model->getTable(),
                'action_id'    => $model->id
            ]);
        }
    }

    public function deleting($model): void
    {
        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => 'deleted',
                'action_model' => $model->getTable(),
                'action_id'    => $model->id
            ]);
        }
    }
}
