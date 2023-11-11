<?php
// app/Events/AchievementUnlocked.php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AchievementUnlocked
{
    use Dispatchable, SerializesModels;

    public $achievementName;
    public $user;

    public function __construct($achievementName, User $user)
    {
        $this->achievementName = $achievementName;
        $this->user = $user;
    }
}
