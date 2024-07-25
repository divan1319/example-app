<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'loan_at',
        'returned_at'
    ];

    public $timestamps = false;


    public function book(){
        return $this->belongsTo(Book::class,'book_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
