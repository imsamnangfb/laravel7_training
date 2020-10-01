<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewPostNotify;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Notifications\AuthorPostApproved;
use Illuminate\Support\Facades\Notification;

ini_set('memory_limit', '3000M');
ini_set('max_execution_time', '0');

class PostController extends Controller
{
    public function index()
    {
			$data['posts'] = Post::active()
													->approve()
													->descendingpost()
													->get();
			return view('admin.posts.index',$data);
    }

    public function create()
    {
			$data['categories'] = Category::get();
			$data['tags'] = Tag::get();
      return view('admin.posts.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			$validatedData = $request->validate([
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
				'image' => 'required',
				'gallery_image' => 'required',
        'category' => 'required',
        'tag' => 'required',
    	]);
			// check status
			if($request->status){
				$status = 1;
			} else {
				$status =0;
			}
			if($request->hasFile('image')){
				$image = $request->file('image');
				$image_name = 'post'.'-'.rand().'-'.time().'.'.$image->getClientOriginalExtension(); // generate new name
				// $image_name = $image->getClientOriginalName(); // get the original name of image
				$uploadpath = public_path('uploads/post/');
				if(!is_dir(	$uploadpath)){
					mkdir($uploadpath,0777,true);
				}
				$image->move($uploadpath,$image_name);
			} else {
				$image_name = null;
			}
			$data = [
				'user_id' => Auth::id(),
				'title' => $request->title,
				'slug' => Str::slug($request->title),
				'body' => $request->body,
				'image' => $image_name,
				'status' =>$status,
				'is_approved' =>1
			];

      $post = Post::create($data);
			$post->categories()->attach($request->category);
			$post->tags()->attach($request->tag);

			$subscribers = Subscriber::all();
			foreach ($subscribers as $subscriber)
			{
				Notification::route('mail',$subscriber->email)
						->notify(new NewPostNotify($post));
			}

			if ($request->hasFile('gallery_image')) {
				foreach ($request->file('gallery_image') as $image) {
					if ($image->isValid()) {
						$image_name = uniqid() . '.' . $image->getClientOriginalExtension();
						$path = public_path('/uploads/post/galleries');
						if (!is_dir( $path)) {
							mkdir( $path, 0777, true);
						}
						$img_resize = Image::make($image->getRealPath());
						$img_resize->resize(800, 360, function ($constraint) {
								$constraint->aspectRatio();
						})->save($path . '/' . $image_name);

						Gallery::create([
							'post_id' => $post->id,
							'gallery_image' => $image_name
						]);
					}
				}
			}

			return redirect(route('admin.posts.index'))->with('success','Post has been created Successful');
    }

    public function show($id)
    {
			$data['post'] = Post::findOrFail($id);
			return view('admin.posts.show',$data);
    }

    public function edit($id)
    {
        $data['post'] =Post::findOrFail($id);
        $data['categories'] = Category::get();
        $data['tags'] = Tag::get();
        return view('admin.posts.edit',$data);
    }

    public function update(Request $request, $id)
    {
			$post =Post::findOrFail($id);
			$old_image = $post->image;
			$validatedData = $request->validate([
        'title' => 'required|max:255',
        'body' => 'required',
        'category' => 'required',
        'tag' => 'required',
    	]);
			// check status
			if($request->status){
				$status = 1;
			} else {
				$status =0;
			}
			if($request->hasFile('image')){
				$image_path = public_path('/uploads/post/'.$old_image);
				if(file_exists($image_path)){
					unlink($image_path);
				}
				$image = $request->file('image');
				$image_name = 'post'.'-'.rand().'-'.time().'.'.$image->getClientOriginalExtension(); // generate new name
				// $image_name = $image->getClientOriginalName(); // get the original name of image
				$uploadpath = public_path('uploads/post/');
				if(!is_dir(	$uploadpath)){
					mkdir($uploadpath,0777,true);
				}
				$image->move($uploadpath,$image_name);
			} else {
				$image_name = $old_image;
			}
			$data = [
				'user_id' => Auth::id(),
				'title' => $request->title,
				'slug' => Str::slug($request->title),
				'body' => $request->body,
				'image' => $image_name,
				'status' =>$status,
				'is_approved' =>1
			];
			$post->update($data);
			$post->categories()->sync($request->category);
			$post->tags()->sync($request->tag);
			return redirect(route('admin.posts.index'))->with('success','Post has been updated Successful');
    }

    public function destroy($id)
    {
      $post = Post::findOrFail($id);
      $old_image = $post->image;
      $old_image_path = public_path('/uploads/post/'.$old_image);
      if(file_exists($old_image_path)){
        unlink($old_image_path);
			}
      if($post->delete()){
        $post->categories()->detach();
				$post->tags()->detach();
				$imag_galleries = Gallery::where('post_id',$id)->get();
				if(	$imag_galleries->count()>0){
					foreach($imag_galleries as $row){
						Gallery::findOrFail($row->id)->delete();
					}
				}
      }
      return redirect(route('admin.posts.index'))->with('success','Post was deleted Successfully!');
		}

    public function pendingPost()
    {
			$data['posts'] = Post::active()
														->pending()
														->descendingpost()
														->get();
			return view('admin.posts.pending',$data);
		}

    public function approval($id)
    {
        $post = Post::findOrFail($id);
        if($post->is_approved==false){
            $post->is_approved=true;
            $post->save();
            $post->user->notify(new AuthorPostApproved($post));
						$subscribers = Subscriber::all();
						foreach ($subscribers as $subscriber)
						{
								Notification::route('mail',$subscriber->email)
										->notify(new NewPostNotify($post));
						}
        }
        return redirect(route('admin.posts.index'))->with('success','Post was approved Successfully!');
		}


    public function postGallery(Request $request)
    {
			$data['posts'] = Post::approve()
										->active()
										->DescendingPost()
										->get();
      return view('admin.posts.post_gallery',$data);
    }

    public function dropzoneStore(Request $request)
    {
      $this->validate($request, [
				'file' => 'required',
				'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      $image = $request->file('file');
      $imageName = $image->getClientOriginalName();
      $uploadpath = public_path() . '\\uploads\\post\\galleries\\';
      $image->move($uploadpath, $imageName);
      // $image_name = rand() . '.' . $file->getClientOriginalExtension();
			Gallery::create([
				'post_id' => $request->post_id,
				'gallery_image' => $imageName
			]);

      return response()->json(['success'=>$imageName]);
    }

    public function dropzonedelete(Request $request)
    {
      $filename = $request->get('filename');
      $delete_image = Gallery::where('gallery_image', $filename)->first();
      $delete_image->delete();
      $uploadpath = public_path() . '\\uploads\\post\\galleries\\';
      $path = $uploadpath . $filename;
      if (file_exists($path)) {
          unlink($path);
      }
      return $filename;
    }

    public function listGallery()
    {
			$data['galleries'] = Gallery::get();
			return view('admin.posts.list_gallery',$data);
    }

	public function deleteImage($id,Request $request)
    {
			$delete_image = Gallery::findOrFail($id);
			$filename = $delete_image->gallery_image;
      $delete_image->delete();
      $uploadpath = public_path() . '\\uploads\\post\\galleries\\';
      $path = $uploadpath . $filename;
      if (file_exists($path)) {
          unlink($path);
      }
      return redirect(route('admin.posts.gallery.list'));
    }
}
