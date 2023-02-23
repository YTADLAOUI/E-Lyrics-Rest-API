<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'song_ID'
    ];

    public function song()
    {
        return $this->hasOne(song::class);
    }
}
