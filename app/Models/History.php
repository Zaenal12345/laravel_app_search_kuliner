<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';
    protected $fillable = ['view', 'store_id'];

    public function stores(){
        return $this->belongsTo(Store::class,'store_id');
    }
}
