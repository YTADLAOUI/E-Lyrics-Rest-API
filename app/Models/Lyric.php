<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'contetnt'
    ];
    public function song(){
        return $this->hasOne(Song::class);
    }
}
