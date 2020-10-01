<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';
		protected $fillable = [
			'post_id','gallery_image'
    ];
    protected $primaryKey = 'id';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
