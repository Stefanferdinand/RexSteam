<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{

    public static function getAllDetails($transactionId){
        $transactionDetailModel = new TransactionDetail();
        return $transactionDetailModel->getAllDetails($transactionId);
    }

    public static function getAllTransaction($userId){
        $transactionModel = new Transaction();
        return $transactionModel->getAllTransaction($userId);
    }

    public function showPaymentPage(){

        $userId = Auth::user()->id;
        $packed = MemberController::getCartGames($userId);
        $games = $packed[0];
        $totalPrice = $packed[1];

        if($games->count() < 1){
            return redirect('/user/cart/');
        }

        return view('transaction.payment', ["id"=>$userId, "totalPrice"=>$totalPrice]);
    }

    public function processPayment(Request $request){
        
        $request->validate([
            'cardName'=>'required|string|min:6',
            'cardNumber'=>'required|string|size:19',
            'month'=>'required|integer|between:1,12',
            'year'=>'required|integer|between:2021,2050',
            'cvccvv'=>'required|digits_between:3,4',
            'country'=>'required',
            'zip'=>'required|numeric'
        ]);
        
        $cardNumberSplit = explode(" ", $request->cardNumber);
        foreach($cardNumberSplit as $item){
            if(strlen($item) != 4 || !is_numeric($item)) return back()->withErrors(["errors"=>"Card number must be in 0000 0000 0000 0000 format"]);
        }

        $userId = Auth::user()->id;
        $packed = MemberController::getCartGames($userId);
        $games = $packed[0];
        $totalPrice = $packed[1];

        // make transaction
        $transactionModel = new Transaction();
        $thisDate = date('Y-m-d H:i:s');
        
        $transaction = $transactionModel->makeNewTransaction($userId, $thisDate, $totalPrice);

        $level = 0;

        // make transaction details for every game on cart and delete game on cart and add level to user
        foreach($games as $item){
            $transactionDetailModel = new TransactionDetail();
            $transactionDetailModel->insertDetails($transaction->id, $item->id);
            
            $mc = new MemberController();
            $mc->deleteCartItem($item->id);

            $level = $level + 1;
        }
        
        $uc = new UserController();
        $uc->updateLevel($userId, $level);

        // success
        return redirect('/transaction/receipt')->with(['games'=>$games, 'transaction'=>$transaction]);
    }

    public function showReceipt(){

        if(Session::get('games') == null || Session::get('transaction') == null) return redirect('/user/cart');

        $games = Session::get('games');
        $transaction = Session::get('transaction');

        return view('transaction.receipt', ["games"=>$games, "transaction"=>$transaction]);

    }

}
