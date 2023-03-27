<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function makeNewTransaction($userId, $purchaseDate, $totalPrice){
        $transaction = new Transaction();
        $transaction->userId = $userId;
        $transaction->purchaseDate = $purchaseDate;
        $transaction->totalPrice = $totalPrice;
        $transaction->save();
        return $transaction;
    }

    public function getAllTransaction($userId){
        return $this->where("userId", "=", $userId)->get();
    }

}
