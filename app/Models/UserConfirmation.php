<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConfirmation extends Model
{
    use HasFactory;
    protected $table = "user_confirmation";
    public $timestamps = false;
    protected $primaryKey = 'token';
    protected $fillable = [
        'token',
        "status",
        "expires_at",
        "user_id"
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
}
