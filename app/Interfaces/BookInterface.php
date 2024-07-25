<?php

namespace App\Interfaces;


use App\Http\Requests\CreateLoanRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;

interface BookInterface {
    public function getBooks();
    public function createBook(Request $request);
    public function updateBook(int $id,Request $request);
    public function disableBook(int $id);
    public function loanBook(int $id, Request $request);
    public function returnBook(int $id, Request $request);
    public function allowBook(int $id);
}
