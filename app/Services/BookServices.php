<?php

namespace App\Services;



use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookServices {

    public function getBooks(){
        try {
            $books = Book::with(['location' => function ($query) {
                $query->select('id', 'name');
            }, 'author' => function ($query) {
                $query->select('id', 'author');
            }])->get();
            return $books;
        } catch (\Throwable $th) {
            return $th->getMessage();
            //throw $th;
        }
    }

    public function getLoanedBooks(){
        try {
            $loanedBooks = Loan::with(['book'=>function($query){
                $query->select('id','name');
            },
            'user'=>function($query){
                $query->select('id','name');
            }
        ])
        ->get();

        return $loanedBooks;
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
    public function createBook(Request $request){

        try {
            $book = Book::create([
                'name'=>$request['name'],
                'isbn'=>$request['isbn'],
                'availability'=> $request['availability'],
                'location_id'=>$request['location_id'],
                'author_id'=>$request['author_id']
            ]);

            return $book;
        } catch (\Throwable $th) {

            return $th->getMessage();
            //throw $th;
        }
    }

    public function updateBook(int $id,Request $request){

        try {
            $book = Book::where('id',$id)->update([
                'name'=>$request['name'],
                'isbn'=>$request['isbn'],
                'availability'=> $request['availability'],
                'location_id'=>$request['location_id'],
                'author_id'=>$request['author_id']
            ]);

            return $book;
        } catch (\Throwable $th) {

            return $th->getMessage();
            //throw $th;
        }
    }

    public function disableBook(int $id){
        try {
            $book = Book::where('id',$id)->update([
                'status' => 0
            ]);
           
            return $book;

        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }

    }

    public function allowBook(int $id){
        try {
            $book = Book::where('id',$id)->update([
                'status' => 1
            ]);
           
            return $book;

        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }

    }

    public function loanBook(int $id,Request $request){
        try {
            $loanBook = Loan::create([
                'user_id' => $request['user_id'],
                'book_id' => $id,
                'status' =>  1,
                'loan_at' => Carbon::now(),
                'returned_at' => null
            ]);

            return $loanBook;

        } catch (\Throwable $th) {

            return $th->getMessage();
            //throw $th;
        }
    }

    public function returnBook(int $id, Request $request){
        try {
            $loanBook = Loan::where(['user_id' => $request['user_id'],'book_id'=> $id,'status'=> 1])->update([
                'status' =>  0,
                'returned_at' => Carbon::now()
            ]);

            return $loanBook;

        } catch (\Throwable $th) {

            return $th->getMessage();
            //throw $th;
        }
    }
}
