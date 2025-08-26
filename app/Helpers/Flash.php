<?php

namespace App\Helpers;

class Flash
{
    /**
     * Create a new class instance.
     */
    public static function success($message, $component = null)
    {
        session()->flash("success", $message);
        if ($component) {
            $component->dispatch('show-toast', $message);
        }
    }
}
