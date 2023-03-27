<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    public function insertDetails($transactionId, $gameId){
        $transactionDetail = new TransactionDetail();
        $transactionDetail->transactionId = $transactionId;
        $transactionDetail->gameId = $gameId;
        $transactionDetail->save();
    }

    public function getAllDetails($transactionId){
        return $this->where("transactionId", "=", $transactionId)->get();
    }

}
