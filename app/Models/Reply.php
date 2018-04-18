<?php

namespace App\Models;

use App\Traits\Favorable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favorable;

    protected $guarded = [];
    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
