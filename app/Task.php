<?php

namespace App;

use App\User;
use App\Status;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function history()
    {
        return $this->hasMany(TaskHistory::class, 'task_id', 'id');
    }
}
