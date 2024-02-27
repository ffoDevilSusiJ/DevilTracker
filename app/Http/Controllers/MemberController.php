<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Mail\InviteLinkController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class MemberController extends Controller
{
    public function store(Request $request, $id) {

        $members = $request->input("members");
        $roles = $request->input("roles");

        $inviteController = new InviteLinkController(); 
        $i = 0;
        foreach ($members as $key => $email) {
            $member = User::where('email', $email)->first();
            if($member) {
                $inviteRequest = new Request([
                    'user_id' => $member->id,
                    'project_id' => $id,
                    'role_id' => $roles[$i]
                ]);
                $inviteController->store($inviteRequest);
            }
            $i++;
        }
        return redirect("/project/".$id);
    }
    public function destroy(Request $request, $pro) {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255']
        ]);
    }
}
