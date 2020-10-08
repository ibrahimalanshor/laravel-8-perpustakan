<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'writer', 'year', 'category_id'];

    public function stocks()
    {
    	return $this->hasMany(Stock::class);
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->belongsToMany(Loan::class);
    }
}
