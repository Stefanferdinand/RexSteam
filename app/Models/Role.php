<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public static function convertUserRole($user){
        foreach($user as $item){
            if($item->roleId == 1){
                $item->roleId = "Admin";
            }
            else{
                $item->roleId = "Member";
            }   
        }
        return $user;
    }

}
