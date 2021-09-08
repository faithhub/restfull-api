<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Mail\Subscriber;
use App\Models\CheckPost;
use App\Models\Post;
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
        $post = Post::with('website')->get();
        for ($i = 0; $i < $post->count(); $i++) {
            $sub = ModelsSubscriber::where('website_id', $post[$i]->website_id)->get();
            for ($j = 0; $j < $sub->count(); $j++) {
                $check = CheckPost::where(['website_id' => $post[$i]->website_id,  'post_id' => $post[$i]->id, 'subscriber_id' => $sub[$j]->id])->get();
                if ($check->count() == 0) {
                    $data = [
                        'website_name' => $post[$i]->website->name,
                        'website_link' => $post[$i]->website->url,
                        'subscriber_name' => $sub[$j]->name,
                        'title' => $post[$i]->title,
                        'description' => $post[$i]->description
                    ];
                    Mail::to($sub[$j]->email)->send(new Subscriber($data));
                    $save = new CheckPost([
                        'website_id' => $post[$i]->website_id,  'post_id' => $post[$i]->id, 'subscriber_id' => $sub[$j]->id
                    ]);
                    $save->save();
                }
            }
        }  
        $this->info('The posts are sent successfully!');
    }
}
