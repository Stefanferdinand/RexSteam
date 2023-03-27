<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Game extends Model
{
    use HasFactory;

    public function insertGame($gameName, $gameSummary, $gameDescription, $genreId, $gameDeveloper, $gamePublisher, $gamePrice, $gameCover, $gameTrailer, $adultOnly){
        $game = new Game();
        $game->gameName = $gameName;
        $game->gameSummary = $gameSummary;
        $game->gameDescription = $gameDescription;
        $game->genreId = $genreId;
        $game->gameDeveloper = $gameDeveloper;
        $game->gamePublisher = $gamePublisher;
        $game->gamePrice = $gamePrice;
        $game->gameCover = $gameCover;
        $game->gameTrailer = $gameTrailer;
        $game->adultOnly = $adultOnly;
        $game->save();
    }

    public function updateGame($id, $newGameSummary, $newGameDescription, $newGenreId, $newGamePrice, $newGameCover, $newGameTrailer){
        $game = $this->findById($id);
        $game->gameSummary = $newGameSummary;
        $game->gameDescription = $newGameDescription;
        $game->genreId = $newGenreId;
        $game->gamePrice = $newGamePrice;
        $game->gameCover = $newGameCover;
        $game->gameTrailer = $newGameTrailer;
        $game->save();
    }

    public function getAllGames(){
        return $this->all();
    }

    public function getEightRandomGames(){
        if($this->getAllGames()->count() < 8){
            return $this->all();
        }
        return $this->inRandomOrder()->limit(8)->get();
    }

    public function getAllGamesPaginated(){
        $games = $this->simplePaginate(8);
        return $games;
    }

    public function deleteGameById($id){
        $this->where('id', '=', $id)->delete();
    }

    public function findById($id){
        return $this->where("id", "=", $id)->get()->first();
    }

    public function getGamesByQuery($q){
        return $this->where("gameName", "like", "%" .$q. "%")->simplePaginate(8);
    }

    public function GetGamesByAdvanceQuery($q, ...$genres){

        if($q == null){
            return $this->whereIn("genreId", $genres)->simplePaginate(8);
        }
        else if(count($genres[0]) == 0){
            return $this->where("gameName", "like", "%" .$q. "%")->simplePaginate(8);
        }

        return $this->whereIn("genreId", $genres)
                    ->where("gameName", "like", "%" .$q. "%")      
                    ->simplePaginate(8);
    }

}
