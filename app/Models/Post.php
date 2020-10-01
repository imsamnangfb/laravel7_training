<?php

namespace App\Models;

use App\User;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
		protected $fillable = [
			'user_id','title','slug','body','status','image','view_count','is_approved',
    ];
    protected $primaryKey = 'id';

    public function categories()
    {
      return $this->belongsToMany(Category::class,'category_posts');
    }

    public function tags()
    {
      return $this->belongsToMany(Tag::class,'post_tags');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
    
    public function scopeApprove($query)
    {
        return $query->where('is_approved', 1);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeDisActive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeDescendingPost($query)
    {
        return $query->orderBy('created_at','desc');
    }
    public function scopeAscendingPost($query)
    {
        return $query->orderBy('created_at','asc');
    }

    public function favorite_to_users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
