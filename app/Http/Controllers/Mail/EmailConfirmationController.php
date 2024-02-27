<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmationMail;
use App\Mail\InviteMail;
use App\Models\Invite;
use App\Models\User;
use App\Models\UsersProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteLinkController extends Controller
{
    public function sendConfirmationLink(Request $request)
    {
        $user_id = $request->input("user_id");
        $requested_user = User::find($user_id);

        $project_id = $request->input("project_id");

        $role_id = $request->input("role_id");

        $token = Str::random(60);
        $expirationTime = now()->addDays(1);
        $user = Auth::user();


        if ($user instanceof User) {
            $project = $user->projects->find($project_id);
            if ($project->owner->is($user)) {
                Mail::to($requested_user->email)->send(new ConfirmationMail($user, $token, $project));
                $invite = Invite::create([
                    'token' => $token,
                    'user_id' => $user_id,
                    'project_id' => $project_id,
                    'role_id' => $role_id,
                    'expires_at' => $expirationTime,
                    'status' => 0
                ]);
                return response()->json(['message' => 'Ссылка приглашения отправлена на почту']);
            }
        }


    }

    public function confirmLink($token)
    {
        $invite = Invite::find($token);
        if ($invite->status == 1) {
            return response()->json(['error' => 'Вы уже присоеденились'], 403);
        }
        if (!$invite->expires_at->gt(now())) {
            return response()->json(['error' => 'Ссылка истекла'], 403);
        }

        if ($invite && $invite->user()->is(Auth::user())) {
          
            $userProject = UsersProjects::create([
                'user_id' => $invite->user_id,
                'project_id' => $invite->project_id,
                'role_id' => $invite->role_id,
            ]);

            $invite->update(['status' => 1]);

            return redirect("/project/".$invite->project->id);
        }
        return response()->json(['error' => 'Неверная ссылка подтверждения']);
    }
}
