<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table = 'tags';
	protected $fillable = [
		'name','slug','status'
    ];
    protected $primaryKey = 'id';

    // public $timestamps = false;
    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_tags');
    }
}
