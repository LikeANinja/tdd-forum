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

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
