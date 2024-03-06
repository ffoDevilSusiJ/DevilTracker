<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task';
    protected $plural = false;
    protected $fillable = [
        'title',
        'description',
        'creator_id',
        'updated_at',
        'completed_at',
        'executor_id',
        'priority_id',
        'deadline_date',
        'project_id',
        'group_id',
        'time_spent'
    ];

    public function executor() {
        return $this->belongsTo(User::class);
    }
    public function group() {
        return $this->belongsTo(TaskGroup::class);
    }
    public function creator() {
        return $this->belongsTo(User::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
}
