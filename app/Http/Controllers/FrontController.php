<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Session;

class FrontController extends Controller
{
  protected $limit = 12;

	public function index()
	{
		$data['posts']= Post::active()
											->approve()
											->descendingpost()
									// ->get();
											->paginate($this->limit);
		$data['categories'] = Category::where('status',1)->get();
		return view('front.homepage',$data);
	}

	public function allPost()
	{
		$data['posts']= Post::active()
											->approve()
											->descendingpost()
									// ->get();
											->paginate($this->limit);
		return view('front.all_post',$data);
	}

	public function postDetail($id)
	{
        $data['post'] = Post::findOrFail($id);
        $view_count = 'post_'.$data['post']->id;
        if(!Session::has($view_count)){
            $data['post']->increment('view_count');
            Session::put($view_count,1);
        }
        $data['randomposts'] = Post::approve()->active()
                                    ->take(3)
                                    ->inRandomOrder()
                                    ->get();
		return view('front.post_detail',$data);
    }

    public function postByCategory($slug)
    {
        $data['category'] = Category::where('slug',$slug)->first();
        $data['posts'] = Post::wherehas('categories',function($query) use ($slug){
            $query->where('slug',$slug);
        })->paginate($this->limit);
        return view('front.post_by_category',$data);
    }

    public function postByTag($slug)
    {
        $data['tag'] = Tag::where('slug',$slug)->first();
        $data['posts'] = Post::wherehas('tags',function($query) use ($slug){
            $query->where('slug',$slug);
        })->paginate($this->limit);
        return view('front.post_by_tag',$data);
    }
}
