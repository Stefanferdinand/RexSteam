<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            ['genreName'=>'Action'],
            ['genreName'=>'Adventure'],
            ['genreName'=>'RPG'],
            ['genreName'=>'Horror'],
            ['genreName'=>'Sandbox'],
            ['genreName'=>'FPS'],
            ['genreName'=>'MOBA']
        ]);
    }
}
