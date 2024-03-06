<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    protected $taskService;
    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'executor_id' => 'required|integer',
            'priority_id' => 'required|integer',
            'deadline_date' => 'nullable|date',
            'project_id' => 'required|string|max:255',
            'description'=> 'nullable|string'
        ]);
        return $this->taskService->create($validatedData);
    }
    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description'=> 'nullable|string',
            'project_id' => 'required|string|max:255',
            'executor_id' => 'required|integer',
            'priority_id' => 'required|integer',
            'deadline_date' => 'nullable|date',
        ]);

        return $this->taskService->update($validatedData);
    }
    public function status(Request $request, $id)
    {
        $validatedData = $request->validate([
            'group_id' => 'required|integer',
            'completed_at' => 'date',
        ]);
        $validatedData["task_id"] = $id;
        return  $this->taskService->changeStatus($validatedData);


    }
    public function destroy(Request $request, $id)
    {
        return  $this->taskService->delete($id);
    }
}
