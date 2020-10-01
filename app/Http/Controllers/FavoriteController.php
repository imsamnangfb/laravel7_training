<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function save($post)
    {
      $user = Auth::user();
        $is_favorite = $user->favorite_posts()->where('post_id',$post)->count();
        if($is_favorite==0){
					$user->favorite_posts()->attach($post);
					Toastr::success('You have add this post to favorite', 'Add to Favorite');
					return redirect()->back();
        } else {
					$user->favorite_posts()->detach($post);
					Toastr::warning('Your favorite post have been remove', 'Add to Favorite');
					return redirect()->back();
        }
    }
}
