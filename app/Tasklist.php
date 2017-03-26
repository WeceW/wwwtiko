<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasklist extends Model
{
    protected $fillable = ['name', 'description'];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks() 
    {
        return $this->belongsToMany(Task::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($body)
    {
        $this->comments()->create(['body' => $body]);
    }

}
