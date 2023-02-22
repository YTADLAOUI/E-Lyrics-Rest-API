<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    // public function musics()
    // {
    //     return $this->hasMany(Music::class); 
    // }
    protected $fillable = [
        'name',
        'release_date'
    ];
    public function song(){
        return $this->hasMany(song::class);
    }
}
