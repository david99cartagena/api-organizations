<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    public function build()
    {
        return $this->subject('Invitación a organización')
            ->view('emails.invitation', [
                'url' => "http://localhost:8000/api/invitations/{$this->invitation->token}",
                'invitation' => $this->invitation
            ]);
    }
}
