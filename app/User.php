<?php

namespace App;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role_id','name','username', 'email','phone', 'password','image','about','status'
    ];

    protected $hidden = [
      'password', 'remember_token',
    ];

    protected $casts = [
      'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
      return $this->hasMany(Post::class);
    }

    public function role()
    {
      return $this->belongsTo(Role::class);
	}

    public function favorite_posts()
    {
      return $this->belongsToMany(Post::class)->withTimeStamps();
	}

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }




}
