<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = ['start_time', 'end_time', 'user_id', 'tasklist_id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasklist()
    {
        return $this->belongsTo(Tasklist::class);
    }

    public function sessionTask()
    {
        return $this->hasMany(SessionTask::class);
    }


}
