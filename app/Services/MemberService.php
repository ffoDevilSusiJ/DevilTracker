<?php


namespace App\Services;

use App\Contracts\Mail\MailConfirm;
use App\Models\Invite;
use App\Models\Project;
use App\Models\User;
use App\Models\UsersProjects;
use App\Services\Mail\InviteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MemberService
{
    protected $inviteService;

    public function __construct(InviteService $inviteService)
    {
        $this->inviteService = $inviteService;
    }

    public function create(array $data)
    {
        if(!Gate::allows('manage-project', $data["project_id"])) {
            return redirect("/")->with('error', 'У вас нет прав на добаление участников в проект');
        }

        $project = Project::find($data["project_id"]);

        $this->inviteService->eachInvite($data, $project);

        return redirect("/")->with('success', 'Пользователям отправлены приглашения');
    }

    public function update(array $data)
    {
        if(!Gate::allows('manage-project', $data["project_id"])) {
            return redirect("/project/{$data["project_id"]}/info")->with('error', 'У вас нет прав на изменение ролей участников проекта');
        }

        $member = UsersProjects::where(["user_id"=>$data["id"], "project_id" => $data['project_id']]);

        $member->update(["role_id" => $data["role_id"]]);

        return redirect("/project/{$data["project_id"]}/info")->with('success', 'Роль пользователя успешна изменена');
    }
    public function delete(array $data)
    {
        if(!Gate::allows('manage-project', $data["project_id"])) {
            return response()->json('У вас нет прав на удаление участников из проекта', 403);
        }

        $member = UsersProjects::where(["user_id"=>$data["id"], "project_id" => $data['project_id']]);

        $member->delete();

        return response()->json('Пользователь исключен из проекта', 200);
    }

    private function eachInvite($data, $project) {
        foreach ($data['members'] as $email) {
            $member = User::where('email', $email)->first();
            if ($member) {
                $data = [
                    'user' => $member,
                    'project' => $project,
                    'role_id' => array_shift($data['roles'])
                ];
                $this->inviteService->send($data);
            }
        }
    }
}