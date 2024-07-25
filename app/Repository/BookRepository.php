<?php

namespace App\Repository;


use App\Interfaces\BookInterface;
use App\Models\Book;
use App\Models\Loan;
use App\Services\BookServices;
use Illuminate\Http\Request;

class BookRepository implements BookInterface{

    public function __construct(private readonly BookServices $bookServices)
    {}

    public function getBooks()
    {
        $books = $this->bookServices->getBooks();

        return $books;
    }

    public function getLoanedBooks(){
        $loadedBooks = $this->bookServices->getLoanedBooks();

        return $loadedBooks;
    }

    public function createBook(Request $request){
        $newBook = $this->bookServices->createBook($request);
        return $newBook;
    }
    public function updateBook(int $id, Request $request){
        $updateBook = $this->bookServices->updateBook($id,$request);
        return $updateBook;

    }
    public function disableBook(int $id){
        $disableBook = $this->bookServices->disableBook($id);
        return $disableBook;
     }

     public function allowBook(int $id){
        $allowBook = $this->bookServices->allowBook($id);

        return $allowBook;
    }

    public function loanBook(int $id,Request $request){
        $book = Book::find($id);
        $loan = Loan::where('user_id',$request['user_id'])->where('book_id',$id)->where('status',1)->exists();
        
        if($loan) return false;

        if($book->availability == 0 || $book->status == 0) return false;

        if($book){

            $book->loanDecrece();
            $loanBook = $this->bookServices->loanBook($id,$request);
            return $loanBook;

        }
        
        return false;
    }

    public function returnBook(int $id, Request $request){

        $book = Book::find($id);
        if(!$book) return false;
        
        $returnBook = $this->bookServices->returnBook($id,$request);
        if($returnBook === 1){

            $book->returnedBook();
            return $returnBook;
        }

        return false;
    }
}
