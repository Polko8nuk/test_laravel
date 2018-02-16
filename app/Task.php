<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function status()
    {
        return $this->belongsTo('App\Statu','status_id');
    }

    public function times()
    {
        return $this->hasMany('App\Time','tasks_id');
    }
}
