<?php

namespace App\Jobs;

use App\Mail\Subscriber;
use App\Models\Subscriber as ModelsSubscriber;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBulkQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    public $timeout = 1800; // 30 minute
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
    /**
     * Execute the job.
     *
     * @return void
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
    }
}
