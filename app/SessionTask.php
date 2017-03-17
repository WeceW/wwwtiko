<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionTask extends Model
{
    protected $fillable = ['start_time', 'end_time', 'session_id', 'task_id'];

    public $timestamps = false;
    public $incrementing = false;

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function taskAttempt()
    {
        return $this->hasMany(TaskAttempt::class);
    }
}
