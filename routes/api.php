<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/users', function () {
    $users = User::all();

    return response()->json([
        "data"=>$users
    ]);
});

Route::get('/location',function(){
    $estantes = DB::table('locations')->get();

    return response()->json([
        "data"=>$estantes
    ]);
});

Route::prefix('books')->controller(BookController::class)->group(function(){
    Route::get('/','get_books');
    Route::get('/loaned','get_loaned_books');
    Route::post('/create','save_book');
    Route::put('/{id}/update','update_book');
    Route::put('/{id}/disable','disable_book');
    Route::put('/{id}/allow','allow_book');
    Route::post('/loans/{id}/create','loan_book');
    Route::put('/loans/{id}/update','return_book');
    Route::get('/total_books',function(){
        $totalBooks = Book::count();
        $totalLoanedBooks = Loan::where('status',1)->count();
        return response()->json([
            "total_libro"=>$totalBooks,
            "total_prestados"=> $totalLoanedBooks,
        ]);
    });
});

Route::prefix('authors')->controller(AuthorController::class)->group(function(){
    Route::get('/','all_authors');
});

