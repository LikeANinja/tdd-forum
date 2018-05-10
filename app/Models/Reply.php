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
    protected $appends = ['favoritesCount','isFavorited'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
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
