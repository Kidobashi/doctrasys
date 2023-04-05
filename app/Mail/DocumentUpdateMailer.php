<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Documents;
use App\Models\TrackingHistory;

class DocumentUpdateMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $referenceNo;
    public $status;
    public $senderOffice;
    public $receiverOffice;
    public $date;
    public $time;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(User $user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time)
    {
        $this->user = $user;
        $this->referenceNo = $referenceNo;
        $this->status = $status;
        $this->senderOffice = $senderOffice;
        $this->receiverOffice = $receiverOffice;
        $this->date = $date;
        $this->time = $time;
    }

    public function build()
    {
        return $this->subject('Document Status Update')
                    ->to($this->user->email)
                    ->view('emails.document-update');
    }
}
