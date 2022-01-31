<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function profile()
    {
        return $this->hasOne(Profile::class); // Laravel 8
        // return $this->hasOne('App\Profile'); Laravel 5.8
    }
}
