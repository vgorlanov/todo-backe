<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected  $fillable = ['title', 'body', 'user_id', 'project_id', 'done', 'date', 'every'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
