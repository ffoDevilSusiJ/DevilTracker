<?php 

namespace App\Contracts\Mail;
use Illuminate\Mail\Mailable;


interface MailConfirm {
    public function send(array $email);
    public function confirm(string $token);
}