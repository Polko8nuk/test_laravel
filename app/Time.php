<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $table = 'times_new';
    public $timestamps = false;

    public function tasks()
    {
        return $this->belongsTo('App\Task', 'tasks_id');
    }
}
