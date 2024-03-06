<?php


namespace App\Services;

use App\Contracts\Mail\MailConfirm;
use App\Models\Invite;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\Mail\InviteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TaskService
{
    protected $inviteService;

    public function __construct()
    {
    }

    public function create(array $data)
    {
        $route = "/project/" . $data['project_id'] . "/board";

        $project = Project::find($data['project_id']);

        if (!Gate::allows('is-member', $project)) {
            return redirect('/')->with(['error' => 'Вы не числитесь участником проекта']);
        }
        if (!Gate::allows('create-task', $project->id)) {
            return redirect($route)->with(['error' => 'Недостаточно прав, чтобы создать задачу в этом проекте']);
        }

        $executor = User::find($data['executor_id']);

        if (!Gate::forUser($executor)->allows('is-member', $project)) {
            return redirect($route)->with(['error' => 'Исполнитель не числиться участником проекта']);
        }

        $taskData = [
            'title' => $data['title'],
            'description' => $data['description'],
            'creator_id' => Auth::user()->id,
            'executor_id' => $data['executor_id'],
            'priority_id' => $data['priority_id'],
            'project_id' => $data['project_id'],
            'group_id' => 0
        ];
        if (!empty($data['deadline_date'])) {
            $taskData['deadline_date'] = $data['deadline_date'];
        }
        $task = Task::create($taskData);

        return redirect($route)->with(['success' => 'Задача добавлена!']);
    }
    public function changeStatus(array $data)
    {
        $task = Task::find($data['task_id']);
        unset($data['task_id']);
        $project = $task->project;
        if($task->group_id == 1) {
            $data["time_spent"] = $task->time_spent + (time() - strtotime($task->updated_at));
        }

        if (!Gate::allows('is-member', $project)) {
            return response()->json("Вы не числитесь участником проекта", 403);
        }


        if (!Gate::allows('manage-task', $task)) {
            return response()->json("У вас нет прав на перенос этой задачи", 403);
        }


        $task->update($data);
        return response()->json("Статус задачи успешно обновлен", 200);

    }
    public function update(array $data)
    {
        $route = "/project/" . $data['project_id'] . "/board";
        $task = Task::find($data['id']);

        if (!Gate::allows('manage-task', $task)) {
            return redirect($route)->with('error', 'У вас нет прав на редактирование задачи');
        }

        $project = Project::find($data['project_id']);

        if (!Gate::allows('is-member', $project)) {
            return redirect('/')->with('error', 'Вы не числитесь участником проекта');
        }

        $executor = User::find($data['executor_id']);

        if (!Gate::forUser($executor)->allows('is-member', $project)) {
            return redirect('/')->with('error', 'Исполнитель не числиться участником проекта');
        }
        unset($data['project_id']);
        $task->update($data);

        return redirect($route)->with('success', 'Задача обновлена!');
    }
    public function delete($id)
    {
        $task = Task::find($id);

        if (!Gate::allows('manage-task', $task)) {
            return response()->json("У вас нет прав на удаление этой задачи", 403);
        }

        $task->delete();

        return response()->json('Задача удалена!', 200);
    }
}