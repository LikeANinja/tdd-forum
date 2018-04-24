<?php

namespace App\Models;

use App\Traits\Favorable;
use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favorable, RecordActivity;

    protected $guarded = [];
    protected $with = ['owner', 'favorites'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($reply) {
            $reply->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(\App\Models\Favorite::class, 'favorited');
    }

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(\App\Models\Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
