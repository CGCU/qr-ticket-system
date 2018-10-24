<?php

namespace App\Jobs;

use Endroid\QrCode\QrCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTicketEmail extends Job implements ShouldQueue {
  use InteractsWithQueue, SerializesModels;

  protected $ticket;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($ticket) {
    $this->ticket = $ticket;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle() {
    $ticket = $this->ticket;
    $qrCode = (new QrCode)->setText($this->ticket->qr)->setSize(400);
    Mail::send(['emails.welcome-dinner', 'emails.welcome-dinner-text'], ['ticket' => $this->ticket, 'qr' => $qrCode],
      function (Message $m) use ($ticket) {
        $m->from('guilds@ic.ac.uk', 'CGCU Committee');
        $m->to($ticket->purchaser->email)->subject('CGCU Welcome Dinner Ticket');
      });
  }
}
