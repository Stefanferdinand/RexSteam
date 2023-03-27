<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    
    public function searchIfAlreadyExist($userId, $friendId){
        if($this->where("userId", "=", $userId)->where("friendId", "=", $friendId)->get()->first() == null){
            return false;
        }
        return true;
    }

    public function getAllFriends($userId){
        $friends = $this->where("userId", "=", $userId)->orWhere("friendId", "=", $userId)->get();
        $filter = $friends->filter(function($item){
            return $item->pending == false;
        }); 
        return $filter;
    }

    public function getPendingFriend($userId){
        return $this->where("userId", "=", $userId)->where("pending", "=", true)->get();
    }

    public function getIncomingFriend($userId){
        return $this->where("friendId", "=", $userId)->where("pending", "=", true)->get();
    }

    public function addFriend($userId, $friendId){
        $friend = new Friend();
        $friend->userId = $userId;
        $friend->friendId = $friendId;
        $friend->pending = true;
        $friend->save();
    }

    public function cancelFriend($userId, $friendId){
        $this->where("userId", "=", $userId)->where("friendId", "=", $friendId)->delete();
    }

    public function rejectFriend($userId, $friendId){
        $this->where("userId", "=", $userId)->where("friendId", "=", $friendId)->delete();
    }

    public function acceptFriend($userId, $friendId){
        $friend = $this->where("userId", "=", $userId)->where("friendId", "=", $friendId)->get()->first();
        $friend->pending = false;
        $friend->save();
    }

}
