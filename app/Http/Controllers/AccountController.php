<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function transfeer(Request $request)
    {
        $receiver = $request->to;
        $amount = $request->amount;
        $sender = Auth::user();

        if ($sender->balance < $amount) {
            return response()->json([
                "Error" => " the amount is bigger than your balance"],
                400);
        }


        $receiver = User::find($receiver);
        $receiver->balance += $amount;
        $receiver->save();

        $sender->balance -= $amount;
        $sender->save();

        $trans = Transaction::create([
            "sender_id" => $sender->id,
            "recever_id" => $receiver->id,
            "amount" => $amount
        ]);


        return response()->json([
            "transaction_id" => $trans->id,
            "current_balance" => $sender->balance
        ], 200);

    }

}

