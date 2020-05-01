<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function transfeer(Request $request){

        $receiver = $request->to;
        
        $amount = $request->amount;
        
        $sender = Auth::user();
        
        
        if($sender->balance < $amount){
        
        return response()->json(400,[
        "Error"=>" the amount is bigger than your balance"]);
        
        }
        
        
        
        $receiver = User::find($receiver);
        $receiver->balance += $amount;
        $receiver->save();
        
        
        
        $sender->balance -= $amount;
        $sender->save();
        
        $trans = Transaction::create([
        "sender" => $sender->id,
        "receiver" => $receiver->id,
        "amount" => $amount
        ]);
        
        
        
        return response()->json(200,[
        
        "transaction_id" => $trans->id,
        "current_balance" => $sender->balance
        
        ]);
        
        }

    }

