<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Mail\InviteLinkController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function showForm() {
        return view("main.add-project")->with(['user'=>Auth::user()]);
    }
    public function store(Request $request) {
        
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255']
        ]);

        $id = Str::random(20); 

        $project = Project::create([
            'id' => $id,
            'owner_id' => Auth::user()->id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

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
                $inviteController->sendConfirmationLink($inviteRequest); // Вызываем метод sendConfirmationLink из другого контроллера
            }
            $i++;
        }
        return redirect("/project/".$id);
    }
}
