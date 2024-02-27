<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'executor_id' => 'required|integer',
            'priority_id' => 'required|integer',
            'project_id' => 'required|string|max:255',
        ]);
        $executor = User::find($validatedData['executor_id']);
        $project = Project::find($validatedData['project_id']);
        $userIds = $project->users->pluck('id')->toArray();
        
        if (in_array($executor->id, $userIds)) {
            $taskData = [
                'title' => $validatedData['title'],
                'description' => $validatedData['title'],
                'creator_id' => Auth::user()->id,
                'executor_id' => $validatedData['executor_id'],
                'priority_id' => $validatedData['priority_id'],
                'project_id' => $validatedData['project_id'],
                'group_id' => 0
            ];
            if (!empty($validatedData['deadline_date'])) {
                $taskData['deadline_date'] = $validatedData['deadline_date'];
            }
            $task = Task::create($taskData);
            return redirect("/project/" . $validatedData['project_id'] . "/board");
        }
        return response()->json(["error" => "Исполнитель не числиться участником проекта"]);
    }
    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'executor_id' => 'required|integer',
            'priority_id' => 'required|integer',
            'project_id' => 'required|string|max:255',
        ]);
        $executor = User::find($validatedData['executor_id']);
        $project = Project::find($validatedData['project_id']);
        $userIds = $project->users->pluck('id')->toArray();
        
        if (in_array($executor->id, $userIds)) {
            $taskData = [
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'creator_id' => Auth::user()->id,
                'executor_id' => $validatedData['executor_id'],
                'priority_id' => $validatedData['priority_id'],
                'project_id' => $validatedData['project_id'],
                'group_id' => 0
            ];
            if (!empty($validatedData['deadline_date'])) {
                $taskData['deadline_date'] = $validatedData['deadline_date'];
            }
            $task = Task::create($taskData);
            return redirect("/project/" . $validatedData['project_id']);
        }
        return response()->json(["error" => "Исполнитель не числиться участником проекта"]);
    }
    public function status(Request $request, $id)
    {
        $validatedData = $request->validate([
            'group_id' => 'required|integer',
        ]);
        $user = auth()->user();
        foreach ($user->projects as $key => $project) {
            $userTaskIds = $project->tasks->pluck('id')->toArray();
            if (in_array($id, $userTaskIds)) {
                $task = Task::find($id);
                $task->update(['group_id' => $validatedData['group_id']]);
                return response()->json(["success" => "Статус задачи успешно обновлен"]);
            }
        }
        return response()->json(["error" => "У вас нет доступа к этой задаче"]);


    }
}
