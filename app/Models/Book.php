<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isbn',
        'availability',
        'location_id',
        'author_id',
    ];

    public function loans(){
        return $this->hasMany(Loan::class,'book_id');
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function loanDecrece(){
        $this->availability--;
        $this->save();
    }

    public function returnedBook(){
        $this->availability++;
        $this->save();
    }

}
