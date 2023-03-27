<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function insertGameToCart($gameId, $userId){
        $cart = new Cart();
        $cart->gameId = $gameId;
        $cart->userId = $userId;
        $cart->save();
    }

    public function findGame($gameId, $userId){
        return $this->where('gameId', "=", $gameId)->where('userId', "=", $userId)->get()->first();
    }

    public function getAllGame($userId){
        return $this->where('userId', "=", $userId)->get();
    }

    public function deleteGame($gameId, $userId){
        $this->where("gameId", "=", $gameId)->where("userId", "=", $userId)->delete();
    }

}
