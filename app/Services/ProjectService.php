<?php


namespace App\Services;

use App\Contracts\Mail\MailConfirm;
use App\Models\Invite;
use App\Models\Project;
use App\Models\User;
use App\Services\Mail\InviteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProjectService
{
    protected $inviteService;

    public function __construct(InviteService $inviteService)
    {
        $this->inviteService = $inviteService;
    }

    public function create(array $data)
    {
        $id = Str::random(30); 

        $project = Project::create([
            'id' => $id,
            'owner_id' => Auth::user()->id,
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        $this->inviteService->eachInvite($data, $project);

        return redirect("/project/{$id}/info");
    }

    public function update(array $data)
    {
        if(!Gate::allows('manage-project', $data['id'])) {
            return redirect("/")->with('error', 'Вы не являетесь владельцем проекта');
        }
        $project = Project::find($data['id']);

        $project->update([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        return redirect("/");
    }
    public function delete(string $id)
    {
        if(!Gate::allows('manage-project', $id)) {
            return response()->json('Вы не являетесь владельцем проекта', 403);
        }
        $project = Project::find($id);
        $project->delete();
        return response()->json("", 200);

    }

}