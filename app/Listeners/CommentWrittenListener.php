<?php
// app/Listeners/CommentWrittenListener.php

namespace App\Listeners;

use App\Events\CommentWritten;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentWrittenListener implements ShouldQueue
{
    public function handle(CommentWritten $event)
    {
        // Implement logic to unlock comment-related achievements and badges

        // Dispatch events for unlocked achievements and badges
        event(new AchievementUnlocked('Achievement Name', $event->comment->user));
        event(new BadgeUnlocked('Badge Name', $event->comment->user));
    }
}
