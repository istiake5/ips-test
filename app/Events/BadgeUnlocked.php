<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BadgeUnlocked
{
    use Dispatchable, SerializesModels;

    public $badgeName;
    public $user;

    public function __construct($badgeName, User $user)
    {
        $this->badgeName = $badgeName;
        $this->user = $user;
    }
}
