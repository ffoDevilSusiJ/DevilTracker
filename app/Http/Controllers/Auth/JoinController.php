<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Mail\ConfirmationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class JoinController extends Controller
{


    protected $confirmationService;
    public function __construct(ConfirmationService $confirmationService) {
        $this->confirmationService = $confirmationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("auth.join");
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'confirmed', Password::defaults()]
        ]);
        
        $this->confirmationService->send($validatedData);
 
        return view('auth.stab');
    }

}
