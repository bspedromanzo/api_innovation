<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class notifyNewProduct extends Mailable
{
    use Queueable, SerializesModels;
    private $collaborator;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($clientValidator)
    {
        $this->collaborator = $clientValidator;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Nova produto cadastrado');
        $this->to($this->collaborator->email, $this->collaborator->name);
        return $this->view('mail.newProduct',[
            'collaborator' => $this->collaborator
        ]);
    }
}
