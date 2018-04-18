<?php


namespace App\Traits;

trait Favorable
{
	public function favorites()
    {
        return $this->morphMany(\App\Models\Favorite::class, 'favorited');
    }

    public function favorite($userId)
    {
        $attributes = ['user_id' => $userId];
        if (! $this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
