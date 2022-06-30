<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CustomerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /*
        * Get the customer from the sql database
        */
        // $customer = Customer::where('national_id', $request->national_id)->first();

        // if ($customer) {
        //     $customer->update($request->all());
        // } else {
        //     Customer::create($request->all());
        // }

       
        /*
        *  Get the customer from redis DB ( I already added this keys with fillRedis command)
        */
        // $customerId = Redis::get('national_id_' . $request->national_id);
        // if ($customerId) {
        //     Customer::where('id', $customerId)->update($request->all());
        // } else {
        //     Customer::create($request->all());
        // }


        /*
        *  Using cache with redis driver instead of file driver 
        * .env CACHE_DRIVER = redis
        * I already added this keys with fillCache command
        */
        $customerId = Cache::get('national_id_' . $request->national_id);
        if ($customerId) {
            Customer::where('id', $customerId)->update($request->all());
        } else {
            Customer::create($request->all());
        }
    }
}
