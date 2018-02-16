<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statu extends Model
{
    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany('App\Task','status_id');
    }
}
