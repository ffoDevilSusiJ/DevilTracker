<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Mail\InviteLinkController;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\InviteService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    protected $projectService;
    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }
    public function store(ProjectRequest $request) {
        $validatedData = $request->validated();
        return $this->projectService->create($validatedData);
    }
    public function destroy(Request $request, $id) {
        return $this->projectService->delete($id);
    }
    public function edit(ProjectRequest  $request) {
        $validatedData = $request->validated();
        return $this->projectService->update($validatedData);
    }
}
