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
        }
        return view("main.workspace")->with(['user' => $user, 'projects' => $projects]);
    }
    public function showProject($id, $view)
    {
        $user = Auth::user();
        $project = $user->projects->find($id);
        //Инициализация пользователей внутри проектов
        $projects = $user->projects;
        foreach ($projects as $key => $project) {
            $project->users;
        }
        foreach ($project->tasks as $key => $task) {
            $task->executor;
            $task->creator;
        }
        if ($project) {
            $project->owner;
            $project->tasks;
            return view("main.workspace")->with(['user' => $user, 'projects' => $projects, 'project' => $project, 'view'=>$view]);
        } else {
            return response([], 404);
        }
    }
    public function showMissingView(): Response
    {
        return response([], 404);
    }
}
