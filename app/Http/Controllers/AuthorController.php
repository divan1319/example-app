<?php

namespace App\Http\Controllers;

use App\Repository\AuthorRepository;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //
    public function __construct(private readonly AuthorRepository $authorRepository)
    {

    }

    public function all_authors()
    {
        $authors = $this->authorRepository->allAuthors();

        return response()->json([
            'data'=>$authors
        ]);
    }
}
