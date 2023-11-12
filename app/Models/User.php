<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    public function achievements()
    {
        $lessonsWatchedCount = $this->watched()->wherePivot('watched', true)->count();
        $commentsWrittenCount = $this->comments()->count();

        $achievements = [];

        // Lessons watched achievements
        $lessonAchievements = [1, 5, 10, 25, 50];
        foreach ($lessonAchievements as $achievement) {
            if ($lessonsWatchedCount >= $achievement) {
                $achievements[] = "$achievement Lessons Watched";
            }
        }

        // Comments written achievements
        $commentAchievements = [1, 3, 5, 10, 20];
        foreach ($commentAchievements as $achievement) {
            if ($commentsWrittenCount >= $achievement) {
                $achievements[] = "$achievement Comments Written";
            }
        }

        return $achievements;
    }
}

