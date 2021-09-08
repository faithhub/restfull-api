<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Subscriber extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->website_name = $data['website_name'];
        $this->website_link = $data['website_link'];
        $this->subscriber_name = $data['subscriber_name'];
        $this->title = $data['title'];
        $this->description = $data['description'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.index')
            ->with([
                'website_name' => $this->website_name,
                'website_link' => $this->website_link,
                'subscriber_name' => $this->subscriber_name,
                'title' => $this->title,
                'description' => $this->description,
            ]);
    }
}
