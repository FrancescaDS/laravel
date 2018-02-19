<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.testemail')



            //la parte qui sotto era per test da rotta
            //->with(['username'=>'Francescax'])
            //->to('francesca.dallaserra@gmail.com')
            //si possono passare tutti i parametri che si vogliono
            //come cc, from o text ecc

            ;
    }
}
