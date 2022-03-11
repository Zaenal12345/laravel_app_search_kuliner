<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';
    protected $fillable = [
        'store_name',
        'user_id',
        'address',
        'latitude',
        'longitude',
        'picture1',
        'picture2',
        'picture3',
        'description',
    ];   

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }
    
    public function histories(){
        return $this->hasMany(History::class);
    }
}
