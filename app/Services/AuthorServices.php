<?php

namespace App\Services;

use App\Models\Author;

class AuthorServices{

    public function getAuthors(){

        try {
            //code...
            $authors = Author::all();

            return $authors;
        } catch (\Throwable $th) {
            //throw $th;

            return $th->getMessage();
        }
    }
}
