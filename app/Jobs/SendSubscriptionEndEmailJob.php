<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSubscriptionEndEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $customer;
    private $expired_date;

    public function __construct($customer, $expired_date)
    {
        $this->customer = $customer;
        $this->expired_date = $expired_date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::send('emails.sub_ended', $this->customer->toArray(), function ($message) {
            $message->from('redis@app.com', 'Redis App');
            $message->to( $this->customer->email , $this->customer->name);
            $message->subject('You subscription has expired T^T');
        });
    }
}
