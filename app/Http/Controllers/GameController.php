<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Game;
use App\Models\Genre;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class GameController extends Controller
{

    public static function findById($id){
        $game = new Game();
        return $game->findById($id);
    }

    // convert genre id to genre name
    public static function convertGameGenre($games){
        foreach($games as $item){
            $item->genreId = GameController::getGenreNameByGame($item->genreId);
        }
        return $games;
    }

    public static function calculateTotalGamePrice($games){
        $totalPrice = 0;
        foreach($games as $item){
            $totalPrice = $totalPrice + $item->gamePrice;
        }
        return $totalPrice;
    }    

    // get genre name by genre id
    public static function getGenreNameByGame($genreId){
        $genreModel = new Genre();
        return $genreModel->findById($genreId)->genreName;
    }

    public static function getAllGenre(){
        $genreModel = new Genre();
        return $genreModel->getAll();
    }

    // get all games and paginate them
    public static function getAllGamesPaginated(){
        $gameModel = new Game();
        $games = GameController::convertGameGenre($gameModel->getAllGamesPaginated());
        return $games;
    }

    // get 8 random games
    public static function getEightRandomGames(){
        $gameModel = new Game();
        $randomGames = GameController::convertGameGenre($gameModel->getEightRandomGames());
        return $randomGames;
    }

    public function gameDetails($id){
        $gameModel = new Game();
        $game = $gameModel->findById($id);
        $game->genreId = GameController::getGenreNameByGame($game->genreId);

        if(Auth::check()){
            $transaction = TransactionController::getAllTransaction(Auth::user()->id);

            foreach($transaction as $item){
                $transactionDetails = TransactionController::getAllDetails($item->id);
                foreach($transactionDetails as $details){
                    if($details->gameId == $id){
                        return view('game.gameDetails', ["game"=>$game, "owned"=>true]);
                    }
                }
            }
        }

        return view('game.gameDetails', ["game"=>$game, "owned"=>false]);
    }

    public function showCheckAge($id){

        if($id == -1){
            return redirect('/')->with(['status'=>"You are not old enough"]);
        }

        $gameModel = new Game();
        $game = $gameModel->findById($id);

        if($game->adultOnly){
            return view('game.adultOnly', ["game"=>$game]);
        }
        else{
            return redirect('game/'.$id);
        }

    }

    public function checkAge(Request $request, $id){
        $gameModel = new Game();
        $game = $gameModel->findById($id);
        $game->genreId = $this->getGenreNameByGame($game->genreId);

        $day = $request->day;
        $month = $request->month;
        $year = $request->year;

        $userDate = new DateTime($year."-".$month."-".$day);
        $dateNow = new DateTime(date("Y-m-d"));

        // date diff
        $yearDifference = $dateNow->diff($userDate)->y;

        if($yearDifference < 17){
            return redirect('/')->with(['status'=>"You are not old enough"]);
        }
        else{
            return redirect('game/'.$id);
        }

    }

    public function addGameToCart($id){
        $cartModel = new Cart();
        $userId = Auth::user()->id;

        if($cartModel->findGame($id, $userId)){
            return redirect('game/'.$id)->withErrors('The game is already in your cart');
        }
        
        $cartModel->insertGameToCart($id, $userId);
        return redirect('game/'.$id)->with(["status"=>"Success add game to cart"]);
    }

    public function getGamesByQuery($q){
        $gameModel = new Game();
        return GameController::convertGameGenre($gameModel->getGamesByQuery($q));
    }

}

