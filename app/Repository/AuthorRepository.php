<?php

namespace App\Repository;

use App\Services\AuthorServices;

class AuthorRepository{

    public function __construct(private readonly AuthorServices $authorServices)
    {

    }

    public function allAuthors(){
        $author = $this->authorServices->getAuthors();
        return $author;
    }
}
