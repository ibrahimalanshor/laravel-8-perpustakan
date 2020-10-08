<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'return', 'status'];

    public function books()
    {
    	return $this->belongsToMany(Book::class)->withPivot('qty');
    }

    public function member()
    {
    	return $this->belongsTo(Member::class);
    }
}
