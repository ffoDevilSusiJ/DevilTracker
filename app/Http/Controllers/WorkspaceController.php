<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showDashboard()
    {
        $user = Auth::user();
        $projects = $user->projects;
        foreach ($projects as $key => $project) {
            $project->owner;
            $project->users;
        }
        return view("main.workspace")->with(['user' => $user, 'projects' => $projects]);
    }
    public function showProject($id, $view)
    {
        $user = Auth::user();
        $project = $user->projects->find($id);
        if ($project) {
            $projects = $user->projects;
            foreach ($projects as $key => $init_project) {
                $init_project->users;
            }
            foreach ($project->tasks as $key => $task) {
                $task->executor;
                $task->creator;
            }
            foreach ($project->users as $key => $user) {
                $user->role_id = $user->projects->find($project)->pivot->role_id;
            }
            $project->owner;
            $project->tasks;
            return view("main.workspace")->with(['user' => $user, 'projects' => $projects, 'project' => $project, 'view' => $view]);


        } else {
            return abort(404);
        }
    }
    public function showMissingView(): Response
    {
        return response([], 404);
    }
}
