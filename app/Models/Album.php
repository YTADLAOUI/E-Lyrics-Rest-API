<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'release_date'
    ];
    public function song()
    {
        return $this->hasMany(song::class, 'album_ID');
    }
}
