<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';
    protected $fillable = ['rating', 'store_id'];

    public function stores(){
        return $this->belongsTo(Store::class,'store_id');
    }
}
