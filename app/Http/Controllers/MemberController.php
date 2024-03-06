<?php

namespace App\Http\Controllers;

use App\Services\MemberService;
use Illuminate\Http\Request;
use App\Http\Controllers\Mail\InviteLinkController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class MemberController extends Controller
{
    protected $memberService;
    public function __construct(MemberService $memberService) {
        $this->memberService = $memberService;
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => ['required','string'],
            'members' => ['required','array'],
            'roles' => ['required','array'],
        ]);
        
        return $this->memberService->create($validatedData);
    }
    public function edit(Request $request) {
        $validatedData = $request->validate([
            'id' => ['required', 'integer'],
            'project_id' => ['required','string'],
            'role_id' => ['required','integer'],
        ]);
        return $this->memberService->update($validatedData);
    }
    public function destroy(Request $request) {
        $validatedData = $request->validate([
            'id' => ['required', 'integer'],
            'project_id' => ['required','string'],
        ]);
        return $this->memberService->delete($validatedData);
    }
}
