<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webmozart\Assert\Assert;

class Task extends Model
{
    use SoftDeletes;

    /**
     * task is done
     */
    public const DONE = 1;

    /**
     * task in progress
     */
    public const ACTIVE = 0;

    protected  $fillable = ['title', 'body', 'user_id', 'project_id', 'done', 'date', 'every'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function order() {
        return $this->hasOne(Order::class);
    }

}
