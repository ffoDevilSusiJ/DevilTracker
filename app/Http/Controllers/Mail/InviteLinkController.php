<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\InviteMail;
use App\Models\Invite;
use App\Models\User;
use App\Models\UsersProjects;
use App\Services\Mail\InviteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteLinkController extends Controller
{
    protected $inviteService;
    public function __construct(InviteService $inviteService) {
        $this->inviteService = $inviteService;
    }
    public function confirm($token)
    {
        return $this->inviteService->confirm($token);
    }
}
