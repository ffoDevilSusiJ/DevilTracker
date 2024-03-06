<?php


namespace App\Services\Mail;

use App\Contracts\Mail\MailConfirm;
use App\Mail\ConfirmationMail;
use App\Mail\InviteMail;
use App\Models\Invite;
use App\Models\User;
use App\Models\UserConfirmation;
use App\Models\UsersProjects;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ConfirmationService implements MailConfirm
{
    public function send(array $data)
    {
        $token = Str::random(60);
        $expirationTime = now()->addDays(1);

        Mail::to($data["email"])->send(new ConfirmationMail($token, $data['username']));
        try {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
            $confirmation = UserConfirmation::create([
                'token' => $token,
                'user_id' => $user->id,
                'expires_at' => $expirationTime,
                'status' => false
            ]);

            Auth::login($user);

        } catch(\Exception $e){
            return response()->json(['message' => 'Ссылка не отправлена']);
        }
    }
    public function confirm(string $token)
    {
        $confirmation = UserConfirmation::find($token);

        if (!$confirmation) {
            return response()->json(['error' => 'Неверная ссылка подтверждения'], 403);
        }

        if ($confirmation->status) {
            return redirect("/");
        }

        if (Carbon::parse($confirmation->expires_at)->isPast()) {
            return response()->json(['error' => 'Ссылка истекла'], 403);
        }
        if ($confirmation->user()->is(Auth::user())) {
            $confirmation->user()->update(["active" => true]);
            $confirmation->update(['status' => true]);

            if (session('url.intended')) {
                return redirect(session('url.intended'))->with('success', 'Ваша учетная запись была успешно создана!');
            }
            return redirect("/");
        }

        return response()->json(['error' => 'Неверная ссылка подтверждения']);
    }
}