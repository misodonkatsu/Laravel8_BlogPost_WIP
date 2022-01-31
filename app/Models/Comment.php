<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // blog_post_id
    public function blogPost()
    {
        return $this->belongsTo('App\Models\blogPost');
    }
}
