<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function showCartPage(){

        $userId = Auth::user()->id;

        $packed = $this->getCartGames($userId);

        return view('user.cart', ["id"=>$userId, "games"=>$packed[0], "totalPrice"=>$packed[1]]);
    }

    public static function getCartGames($id){
        $cartModel = new Cart();
        $cartItem = $cartModel->getAllGame($id);

        $games = new Collection();
        foreach($cartItem as $items){
            $games->push(GameController::findById($items->gameId));
        }
        $totalPrice = GameController::calculateTotalGamePrice($games);
        $games = GameController::convertGameGenre($games);

        return [$games, $totalPrice];
    }

    public function showDeleteConfirmation($id){

        return redirect('/user/cart')->with(["gameId"=>$id]);
    }

    public function deleteCartItem($id){

        $userId = Auth::user()->id;

        $cartModel = new Cart();
        $cartModel->deleteGame($id, $userId);
        
        return redirect('/user/cart/');

    }
}
