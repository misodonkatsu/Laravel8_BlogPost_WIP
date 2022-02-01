<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;
    
    public function profile()
    {
        return $this->hasOne(Profile::class); // Laravel 8
        // return $this->hasOne('App\Profile'); Laravel 5.8
    }
}
