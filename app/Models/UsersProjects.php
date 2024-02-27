<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UsersProjects extends Model
{
    use HasFactory;
    protected $table = "projects_users";
    public $timestamps = false;
    public $incrementing = false;   
    protected $primaryKey = ['user_id', 'project_id'];
    protected $fillable = [
        'user_id',
        'project_id',   
        'role_id', // Дополнительное поле
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}