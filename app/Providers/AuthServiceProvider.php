<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Project;
use App\Models\User;
use App\Models\UsersProjects;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage-task', function ($user, $task) {
            $user_role = $user->projects->find($task->project_id)->pivot->role_id;
            
            if ($user_role === User::ROLE_ADMIN || $user_role === User::ROLE_MANAGER) {
                return $user->projects->contains('id', $task->project_id);
            } 
            
            if ($user_role === User::ROLE_EXECUTOR) {
                return $user->assigned_tasks->contains('id', $task->id);
            }
            
            return false;
        });
        
        Gate::define('create-task', function ($user, $project_id) {
            $user_role = $user->projects->find($project_id)->pivot->role_id;
        
            if ($user_role === User::ROLE_ADMIN || $user_role === User::ROLE_MANAGER) {
                return $user->projects->contains('id', $project_id);
            } 
            return false;
        });

        Gate::define('is-member', function ($user, $project) {
            return $project->users->contains('id', $user->id);
        });
        
        Gate::define('manage-project', function ($user, $id) {
            $project = Project::find($id);
            return $project && $user->id === $project->owner_id;
        });
    }
}
