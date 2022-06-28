<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriptionEndEmailJob;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Predis\Command\Redis\ECHO_;

class SubscriptionEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:subscriptionEnd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'I want to send an email to users that their subscription has ended';

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
        $expired_customers = Customer::where('subscription_end_at','<', now())->get();
        foreach ($expired_customers as $customer) { 
            $expired_date = Carbon::createFromFormat('Y-m-d', $customer->subscription_end_at)->toDateString();
            info("I am here in command class");
            dispatch(new SendSubscriptionEndEmailJob($customer, $expired_date));
        }

    }
}
 