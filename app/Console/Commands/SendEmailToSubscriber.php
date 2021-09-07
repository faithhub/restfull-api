<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Mail\Subscriber;
use App\Models\Subscriber as ModelsSubscriber;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailToSubscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriber:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A new post uploaded';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $websites = Website::with('post')->get();
        foreach ($websites as $website) {
           $subscribers = ModelsSubscriber::where('website_id', $website->id)->get('email');
           foreach ($website->post as $post) {
              $data = [
                 'website_name' => $website->name,
                 'title' => $post->title,
                 'description' => $post->description
              ];
              Mail::to($subscribers)->send(new Subscriber($data));
           }
        }  
        $this->info('The posts are sent successfully!');
    }
}
