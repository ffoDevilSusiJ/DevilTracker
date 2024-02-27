<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'description',
        'owner_id'
    ];
    protected $table = 'project';
    protected $plural = false;
    protected $keyType = 'string';
    public function users()
    {
        return $this->belongsToMany(User::class, 'projects_users');
    }
    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
