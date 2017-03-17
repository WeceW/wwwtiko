<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SessionTask;

class TaskAttempt extends Model
{
    protected $fillable = ['count', 
                           'start_time', 
                           'end_time', 
                           'result',
                           'answer',
                           'session_id',
                           'task_id'];

    public $timestamps = false;
    public $incrementing = false;

    public function sessionTask()
    {
        return $this->belongsTo(SessionTask::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

}
