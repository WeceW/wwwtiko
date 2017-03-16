<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'solution', 'type', 'diagram'];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function tasklists()
    {
        return $this->belongsToMany(Tasklist::class);
    }

}
