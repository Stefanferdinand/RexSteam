<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function home(){
        $gc = new GameController();
        $randomGames = $gc->getEightRandomGames();
        return view('home', ['randomGames'=>$randomGames]);
    }

    public function insertUser($username, $fullname, $roleId, $password){
        $userModel = new User();
        $userModel->insertUser($username, $fullname, $roleId, $password);
    }

    public function searchGame($q){
        $gc = new GameController();
        $games = $gc->getGamesByQuery($q);

        return view('search', ["games"=>$games]);
    }

    public function showProfile(){
        $user = Auth::user();
        return view('user.profile', ["user"=>$user]);
    }

    public function updateLevel($id, $level){
        $userModel = new User();
        $userModel->updateLevel($id, $level);
    }

    public function updateProfile(Request $request){

        $fullname = $request->fullname;
        $currentPassword = $request->currentPassword;
        $newPassword = $request->newPassword;
        $confirmPassword = $request->confirmPassword;
        $profilePicture = $request->file('profilePicture');

        $request->validate([
            'fullname'=>'required|string',
            'currentPassword'=>'required|string|alpha_num|min:6',
            'newPassword'=>'string|alpha_num|min:6',
            'confirmPassword'=>'string|same:newPassword',
            'profilePicture'=>'mimes:jpg,png|max:100',
        ]);

        
        $user = new User();
        $userId = Auth::user()->id;
        
        if(Hash::check($currentPassword, Auth::user()->password)){

            if($newPassword != null){

                $newPassword = Hash::make($newPassword);
                $user->updatePassword($userId, $newPassword);
    
            }   
            if($profilePicture != null){

                if(Auth::user()->profilePicture != asset('/images/default-profile-icon.png')){
                    $this->deleteProfilePicturerPathFromDB(Auth::user());
                }
    
                // store
                $profilePicture->store('/public/userProfilePicture');
                // create url path
                $profilePicture = asset('storage/userProfilePicture/' .$profilePicture->hashName());
    
                $user->updateProfilePicture($userId, $profilePicture);
    
            }
    
            $user->updateFullName($userId, $fullname);
                
            return redirect('/user/profile');
        }

        return redirect('/user/profile')->with('status', "User Password invalid!");

    }

    public function deleteProfilePicturerPathFromDB($user){
        foreach(explode('/', $user->profilePicture) as $item){
            if(str_ends_with($item, '.jpg') || str_ends_with($item, '.png')){
                File::delete(public_path("storage/userProfilePicture/".$item));
            }
        }
    }

    public function showFriend(){

        $friendModel = new Friend();
        $userId = Auth::user()->id;
        $userModel = new User();

        // pending
        $allPendingFriend = $friendModel->getPendingFriend($userId);
        $pendingFriendList = new Collection();
        
        if(count($allPendingFriend) != 0){
            foreach($allPendingFriend as $item){
                $friend = $userModel->findById($item->friendId);
                $pendingFriendList->push($friend);
            }
            $pendingFriendList = Role::convertUserRole($pendingFriendList);
        }

        // incoming
        $allIncomingFriend = $friendModel->getIncomingFriend($userId);
        $incomingFriendList = new Collection();
        
        if(count($allIncomingFriend) != 0){
            foreach($allIncomingFriend as $item){
                $friend = $userModel->findById($item->userId);
                $incomingFriendList->push($friend);
            }
            $incomingFriendList = Role::convertUserRole($incomingFriendList);
        }

        // friend
        $allFriend = Role::convertUserRole($friendModel->getAllFriends($userId));
        $friendList = new Collection();

        if(count($allFriend) != 0){
            foreach($allFriend as $item){
                if (Auth::user()->id == $item->userId){
                    $friend = $userModel->findById($item->friendId);
                }elseif (Auth::user()->id == $item->friendId){
                    $friend = $userModel->findById($item->userId);
                }
                $friendList->push($friend);
            }
            $friendList = Role::convertUserRole($friendList);
        }

        return view('user.friend', ["user"=>Auth::user(), "pendingFriend"=>$pendingFriendList, "incomingFriend"=>$incomingFriendList, "friend"=>$friendList]);
    }

    public function addFriend(Request $request){
        
        
        $user = new User();
        $username = $request->username;
        $findUser = $user->findByUsername($username);
        
        
        if($findUser == null){
            return redirect('/user/friend')->with('fail', "Username not found!");
        }
        
        $friendId = $findUser->id;
        $userId = Auth::user()->id;
        $friendModel = new Friend();
        
        if($username == Auth::user()->username){
            return redirect('/user/friend')->with('fail', "You cannot add yourself!");
        }

        if($friendModel->searchIfAlreadyExist($userId, $friendId)){
            return redirect('/user/friend')->with('fail', "You already send a request or receive incoming request or friends with ".$username);
        }

        $friendModel->addFriend($userId, $friendId);

        return redirect('/user/friend')->with('success', "Sent friend request to ".$username);

    }

    public function cancelFriend($id){
        
        $userId = Auth::user()->id;
        $friendModel = new Friend();
        
        $friendModel->cancelFriend($userId, $id);
        return redirect('/user/friend')->with('success', "Success cancel pending request");
    }

    public function rejectFriend($id){
        $userId = Auth::user()->id;
        $friendModel = new Friend();

        $friendModel->rejectFriend($id, $userId);
        return redirect('/user/friend')->with('success', "Success reject incoming request");
    }

    public function acceptFriend($id){
        $userId = Auth::user()->id;
        $friendModel = new Friend();

        $friendModel->acceptFriend($id, $userId);
        return redirect('/user/friend')->with('success', "Success accept incoming request");
    
    }

    public function showHistoryPage(){
        $user = Auth::user();
        $userId = $user->id;
        $transaction = TransactionController::getAllTransaction($userId);

        $games = array();
        $temp = new Collection();

        foreach($transaction as $item){
            $transactionDetails = TransactionController::getAllDetails($item->id);
            foreach($transactionDetails as $details){
                $temp->push(GameController::findById($details->gameId));
            }
            $games[$item->id] = $temp;
            $temp = new Collection();
        }
        
        return view('user.history', ["user"=>$user, "transaction"=>$transaction, "games"=>$games]);
    }

}   
