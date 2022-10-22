<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriberEmail;
use App\Models\Post;
use App\Models\PostNotification;
use App\Models\Subscription;
use Illuminate\Console\Command;

class EmailSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:subscribers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        /*
         * Use of command to send email to the subscribers
         * (command must check all websites and send all new posts to subscribers which haven't been sent yet).
        - Use of queues to schedule sending in background.
        - No duplicate stories should get sent to subscribers.
         *
         * */

        //get all new posts
        $newPosts = Post::all();

        //loop through all posts process
        foreach ($newPosts as $post) {
            //get the subscribers for website of this post
            $subscribers = Subscription::where('website_id', $post->website_id)->get();
            
            //loop through subscribers and send email
            foreach ($subscribers as $subscriber) {
                //check if subscriber is already notified
                $subscriberNotificationEntry = PostNotification::where([
                    "post_id" => $post->id,
                    'user_id' => $subscriber->user_id
                ])->first();
                if(!$subscriberNotificationEntry) {
                    SendSubscriberEmail::dispatch([
                        "email" => $subscriber->user->email,
                        "post" => $post
                    ]);
                }

                //create post notification entry
                $notified = new PostNotification();
                $notified->user_id = $subscriber->user_id;
                $notified->post_id = $post->id;
                $notified->save();
            }
        }

        return 0;
    }
}
