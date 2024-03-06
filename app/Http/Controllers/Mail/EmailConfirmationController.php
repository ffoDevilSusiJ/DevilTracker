<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmationMail;
use App\Mail\InviteMail;
use App\Models\Invite;
use App\Models\User;
use App\Models\UsersProjects;
use App\Services\Mail\ConfirmationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailConfirmationController extends Controller
{
    protected $confirmationService;
    public function __construct(ConfirmationService $confirmationService) {
        $this->confirmationService = $confirmationService;
    }
    public function confirm($token)
    {
        return $this->confirmationService->confirm($token);
    }
}
