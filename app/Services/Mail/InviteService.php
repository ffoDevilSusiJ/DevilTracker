<?php


namespace App\Services\Mail;

use App\Contracts\Mail\MailConfirm;
use App\Mail\InviteMail;
use App\Models\Invite;
use App\Models\User;
use App\Models\UsersProjects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteService implements MailConfirm
{
    public function send(array $data)
    {
        $requested_user = $data["user"];
        $project = $data["project"];
        $role_id = $data["role_id"];


        $token = Str::random(60);
        $expirationTime = now()->addDays(1);
        
        Mail::to($requested_user->email)->send(new InviteMail($token, $project));
        $invite = Invite::create([
            'token' => $token,
            'user_id' => $requested_user->id,
            'project_id' => $project->id,
            'role_id' => $role_id,
            'expires_at' => $expirationTime,
            'status' => 0
        ]);
        return response()->json(['message' => 'Ссылка приглашения отправлена на почту']);
    }
    public function confirm(string $token)
    {
        $invite = Invite::where('token', $token)->first();

        if (!$invite) {
            return response()->json(['error' => 'Неверная ссылка подтверждения'], 403);
        }
    
        if ($invite->status) {
            return response()->json(['error' => 'Вы уже присоединились'], 403);
        }
    
        if ($invite->expires_at->isPast()) {
            return response()->json(['error' => 'Ссылка истекла'], 403);
        }
    
        if ($invite->user->is(Auth::user())) {
            UsersProjects::create([
                'user_id' => $invite->user_id,
                'project_id' => $invite->project_id,
                'role_id' => $invite->role_id,
            ]);
    
            $invite->update(['status' => true]);
    
            return redirect("/project/".$invite->project->id);
        }
    
        return response()->json(['error' => 'Неверная ссылка подтверждения']);
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
                $this->send($data);
            }
        }
    }
}