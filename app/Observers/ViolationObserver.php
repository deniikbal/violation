<?php

namespace App\Observers;

use App\Models\Violation;
use Illuminate\Support\Facades\Auth;

class ViolationObserver
{
    /**
     * Handle the Violation "created" event.
     */
    public function created(Violation $violation): void
    {
        $violation->user_id = Auth::id();
        $violation->save();
    }

    /**
     * Handle the Violation "updated" event.
     */
    public function updated(Violation $violation): void
    {
        //
    }

    /**
     * Handle the Violation "deleted" event.
     */
    public function deleted(Violation $violation): void
    {
        //
    }

    /**
     * Handle the Violation "restored" event.
     */
    public function restored(Violation $violation): void
    {
        //
    }

    /**
     * Handle the Violation "force deleted" event.
     */
    public function forceDeleted(Violation $violation): void
    {
        //
    }
}
