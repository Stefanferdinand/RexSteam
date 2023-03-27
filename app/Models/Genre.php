<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public function getAll(){
        return $this->all();
    }

    public function getIdByGenre($gameGenre){
        return $this->where("genrename", "=", $gameGenre)->get()->first()->id;        
    }

    public function findById($genreId){
        return $this->where("id", "=", $genreId)->get()->first();
    }

}
