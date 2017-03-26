<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body'];

    public function tasklist()
    {
        return $this->belongsTo(Tasklist::class);
    }
}
