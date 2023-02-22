<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'contetnt',
        'song_ID'
    ];
    public function song(){
        return $this->hasMany(song::class);
    }
}
