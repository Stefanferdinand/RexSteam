<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use HasFactory;
    use Authenticatable;

    public function insertUser($username, $fullname, $roleId, $password){
        $user = new User();
        $user->username = $username;
        $user->fullname = $fullname;
        $user->roleId = $roleId;
        $user->password = $password;
        $user->level = 0;
        $user->profilePicture = asset('/images/default-profile-icon.png');
        $user->timestamps = date('Y-m-d H:i:s');
        $user->save();
    }

    public function findById($id){
        return $this->where("id", "=", $id)->get()->first();
    }

    public function findByUsername($username){
        return $this->where("username", "=", $username)->get()->first();
    }

    public function updateLevel($id, $level){
        $user = $this->findById($id);
        $user->level = $user->level + $level;
        $user->save();
    }

    public function updatePassword($id, $newPassword){
        $user = $this->findById($id);
        $user->password = $newPassword;
        $user->save();
    }

    public function updateProfilePicture($id, $newProfilePicture){
        $user = $this->findById($id);
        $user->profilePicture = $newProfilePicture;
        $user->save();
    }

    public function updateFullName($id, $newFullname){
        $user = $this->findById($id);
        $user->fullname = $newFullname;
        $user->save();
    }

}
