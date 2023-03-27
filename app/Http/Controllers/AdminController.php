<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function manageGame(){
        return view('admin.manageGame', ['gameGenres'=>GameController::getAllGenre(), 'games'=>GameController::getAllGamesPaginated()]);
    }
    public function showInsertForm(){
        return view('admin.insertGame', ['gameGenres'=>GameController::getAllGenre()]);
    }

    public function insertGame(Request $request){
        
        $gameName = $request->gameName;
        $gameSummary = $request->gameSummary;
        $gameDescription = $request->gameDescription;
        $gameGenre = $request->gameGenre;
        $gameDeveloper = $request->gameDeveloper;
        $gamePublisher = $request->gamePublisher;
        $gamePrice = $request->gamePrice;
        $gameCover = $request->file('gameCover');
        $gameTrailer = $request->file('gameTrailer');
        $adultOnly = $request->input('adultOnly');
        

        $request->validate([
            'gameName' =>'required|string|unique:games,gameName',
            'gameSummary' =>'required|string|max:500',
            'gameDescription' =>'required|string|max:2000',
            'gameGenre' =>'required',
            'gameDeveloper'=>'required|string',
            'gamePublisher'=>'required|string',
            'gamePrice' => 'required|numeric|min:1|max:1000000',
            'gameCover'=>'required|mimes:jpg|max:100',
            'gameTrailer'=>'required|mimes:webm|max:100000'
        ]);
        
        // store to server (symbolic link)
        $gameCover->store('/public/covers');
        $gameTrailer->store('/public/trailers');

        // create url path
        $gameCover = asset('storage/covers/'.$gameCover->hashName());
        $gameTrailer = asset('storage/trailers/' .$gameTrailer->hashName());

        if($adultOnly == 'on'){
            $adultOnly = true;
        }
        else{
            $adultOnly = false;
        }

        $genreModel = new Genre();
        $gameGenreId = $genreModel->getIdByGenre($gameGenre); 
        
        // store to db
        $gameModel = new Game();
        $gameModel->insertGame($gameName, $gameSummary, $gameDescription, $gameGenreId, $gameDeveloper, $gamePublisher, $gamePrice, $gameCover, $gameTrailer, $adultOnly);
        
        return redirect('/admin')->with('status', "Success Create Game");
    }

    public function showDeleteConfirmation($id){
        return view('admin.manageGame', ['gameGenres'=>GameController::getAllGenre(), 'games'=>GameController::getAllGamesPaginated(), 'gameId'=>$id]);      
    }

    public function deleteGame($id){
        $gameModel = new Game();
        $game = $gameModel->findById($id);

        $this->deleteCoverPathFromDB($game);
        $this->deleteTrailerPathFromDB($game);

        // delete data from DB
        $gameModel->deleteGameById($id);
        return redirect('/admin');
    }

    public function deleteCoverPathFromDB($game){
        foreach(explode('/', $game->gameCover) as $item){
            if(str_ends_with($item, '.jpg')){
                File::delete(public_path("storage/covers/".$item));
            }
        }
    }

    public function deleteTrailerPathFromDB($game){
        foreach(explode('/', $game->gameTrailer) as $item){
            if(str_ends_with($item, '.webm')){
                File::delete(public_path("storage/trailers/".$item));
            }
        }
    }

    public function showUpdateForm(){
        return view('admin.updateGame', ['gameGenres'=>GameController::getAllGenre()]);
    }

    public function updateGame(Request $request, $id){

        // old data
        $gameModel = new Game();
        $game = $gameModel->findById($id);

        // new data
        $newGameSummary = $request->gameSummary;
        $newGameDescription = $request->gameDescription;
        $newGameGenre = $request->gameGenre;
        $newGamePrice = $request->gamePrice;

        $newGameCover = $request->file('gameCover');
        $newGameTrailer = $request->file('gameTrailer');

        $request->validate([
            'gameSummary' =>'required|string|max:500',
            'gameDescription' =>'required|string|max:2000',
            'gameGenre' =>'required',
            'gamePrice' => 'required|numeric|min:1|max:1000000',
            'gameCover'=>'mimes:jpg|max:100',
            'gameTrailer'=>'mimes:webm|max:100000'
        ]);

        // logic to update paths
        if($newGameCover == null){
            $newGameCover = $game->gameCover;
        } 
        else if($newGameCover != null){
            if($newGameCover != null){
                $this->deleteCoverPathFromDB($game);
                $newGameCover->store('/public/covers');
                $newGameCover = asset('storage/covers/'.$newGameCover->hashName());
            }
        }

        if($newGameTrailer == null){
            $newGameTrailer = $game->gameTrailer;
        }
        else if($newGameTrailer != null){
            $this->deleteTrailerPathFromDB($game);
            $newGameTrailer->store('/public/trailers');
            $newGameTrailer = asset('storage/trailers/' .$newGameTrailer->hashName());
        }

        $genreModel = new Genre();
        $gameGenreId = $genreModel->getIdByGenre($newGameGenre); 
        
        // store to db
        $gameModel = new Game();
        $gameModel->updateGame($id, $newGameSummary, $newGameDescription, $gameGenreId, $newGamePrice, $newGameCover, $newGameTrailer);
        
        return redirect('/admin')->with('status', "Success Update Game");
    
    }

    public function searchGame(Request $request){
        
        $genreModel = new Genre();
        $genres = new Collection();
        $q = $request->gameSearch;

        if($q == null && $request->genres == null) return back();

        if($request->genres != null){
            foreach($request->genres as $key=>$value){
                $genres->push($genreModel->getIdByGenre($key));
            }
        }

        $gameModel = new Game();
        $games = $gameModel->GetGamesByAdvanceQuery($q, $genres);
        $games->appends(["q"=>$q, "genres"=>$genres]);
        $games = GameController::convertGameGenre($games); // change genre id to genre name
        
        return view('admin.searchGame', ['gameGenres'=>GameController::getAllGenre(), "games"=>$games]);
    }

}
