<?php

namespace App\Http\Controllers;

use App\Repository\BookRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(private readonly BookRepository $bookRepository)
    {

    }
    public function get_books(){
        $allBooks = $this->bookRepository->getBooks();

        return response()->json([
            'message'=>'ok',
            'data'=> $allBooks
        ]);
    }

    public function get_loaned_books(){
        $loanedBooks = $this->bookRepository->getLoanedBooks();

        return response()->json([
            'message'=>'ok',
            'data'=> $loanedBooks
        ],200);
    }

    public function save_book(Request $request){
        $saveBook = $this->bookRepository->createBook($request);
        return response()->json([
            'message'=>'Libro Guardado',
            'data'=> $saveBook
        ]);
    }

    public function update_book(int $id,Request $request){
        $updated = $this->bookRepository->updateBook($id,$request);
        return response()->json([
            'message'=>'Libro Actualizado',
            'data'=> $updated
        ],201);
    }

    public function disable_book(int $id){
         $delete = $this->bookRepository->disableBook($id);

         return response()->json([
            'message'=>'Libro Deshabilitado',
            'data'=> $delete
         ]);
    }

    public function allow_book(int $id){
        $allow = $this->bookRepository->allowBook($id);

        return response()->json([
           'message'=>'Libro Habilitado',
           'data'=> $allow
        ]);
   }

    public function loan_book(int $id,Request $request){

        $loanBook = $this->bookRepository->loanBook($id,$request);
        if(!$loanBook) return response()->json(['message'=>'Libro se encuentra prestado o no esta disponible'],404);
        return response()->json([
            'message'=>'Libro Prestado Correctamente',
            'data'=> $loanBook
         ],200);
    }

    public function return_book(int $id,Request $request){
        $returnBook = $this->bookRepository->returnBook($id,$request);

        if(!$returnBook) return response()->json(['message'=>'Libro ya se encuentra devuelto o no disponible'],404);

        return response()->json([
            'message'=>'Libro Devuelto Correctamente',
            'data'=> $returnBook
         ],200);
    }
}
