<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
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
        //get the customer from db
        /*
         $customer = Customer::where('national_id',$request->national_id)->first();
         
        if($customer){
            $customer->update($request->all());
        } else {  
            Customer::create($request->all());
         }
         */

        //get the customer from redis
        $customerId = Redis::get('national_id_'. $request->national_id);
           if($customerId){
            Customer::where('id', $customerId)->update($request->all());
        } else {  
            Customer::create($request->all());
         }

    }
}
