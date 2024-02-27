<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'token';
    protected $fillable = [
        'token',
        'user_id',
        'project_id',
        'role_id',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
}
