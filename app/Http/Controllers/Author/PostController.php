<?php

namespace App\Http\Controllers\Author;

use App\User;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewAuthorPost;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{

	public function index()
	{
		// $data['posts'] = Post::where('status',1)
		// 										->where('is_approved',1)
		// 										->get();
		$data['posts']= Post::where('user_id',Auth::id())
												->active()
												->approve()
												->get();
		return view('author.posts.index',$data);
	}

	public function pendingPost()
	{
		// $data['posts'] = Post::where('status',1)
		// 										->where('is_approved',0)
		// 										->get();
		$data['posts'] = Post::active()
													->pending()
													->get();
		return view('author.posts.pending',$data);
	}

	public function create()
	{
		$data['categories'] = Category::get();
		$data['tags'] = Tag::get();
		return view('author.posts.create',$data);
	}

	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'title' => 'required|unique:posts|max:255',
			'body' => 'required',
			'image' => 'required',
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
			'is_approved' =>0
		];
		$post = Post::create($data);
		$post->categories()->attach($request->category);
        $post->tags()->attach($request->tag);
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

		$users = User::where('role_id',1)->get();
		Notification::send($users, new NewAuthorPost($post));
		return redirect(route('author.posts.index'))->with('success','Post has been created Successful');
	}

	public function show($id)
	{

	}

	public function edit($id)
	{
			$data['post'] =Post::findOrFail($id);
			$data['categories'] = Category::get();
			$data['tags'] = Tag::get();
			return view('author.posts.edit',$data);
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
				'is_approved' =>0
			];
			$post->update($data);
			$post->categories()->sync($request->category);
			$post->tags()->sync($request->tag);
			return redirect(route('author.posts.index'))->with('success','Post has been updated Successful');
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
		return redirect(route('author.posts.index'))->with('success','Post was deleted Successfully!');
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
