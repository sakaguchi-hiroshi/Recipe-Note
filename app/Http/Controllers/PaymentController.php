<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function pay(Request $request) 
    {
        $auth_user = Auth::user();
        $user_id = $auth_user->id;

        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        $charge = Charge::create(array(
                'amount' => 200,
                'currency' => 'jpy',
                'source'=> request()->stripeToken,
        ));

        if(Gate::denies('premium')) {
            $user = User::find($user_id);
            $user->permission_id = 2;
            $user->save();
        }
        return back();
    }
}
