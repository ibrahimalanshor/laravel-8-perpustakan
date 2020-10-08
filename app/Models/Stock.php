<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'type', 'book_id'];

    public function book()
	{
	    return $this->belongsTo(Book::class);
	}
}
