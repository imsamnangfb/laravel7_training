<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
	public function CategoryList()
	{
        $data['categories'] = Category::get();
		return view('admin.categories.index',$data);
	}

	public function CreateCategory()
	{
		return view('admin.categories.create');
	}

	public function SaveCategory(Request $request)
	{
		if($request->status){
			$status = 1;
		} else {
			$status =0;
		}
		if($request->hasFile('image')){
      $image = $request->file('image');
			$ext = $image->getClientOriginalExtension();
			$image_name = Str::slug($request->name).'-'.rand().'-'.time().'.'.$ext;
			// $image_name = $image->getClientOriginalName(); //get the original filename
			$destination= public_path('uploads/category/');
			if(!is_dir($destination)) {
				mkdir(($destination),0777,true);
			}
			$image->move($destination,$image_name);
		} else {
			$image_name = null;
		}
		$data = [
			'name' => $request->name,
			'slug' => Str::slug($request->name),
			'status' => $status,
			'image' => $image_name
		];
		$category = Category::create($data);
		return redirect()->route('admin.categories.list')->with('success','Category has been created Successful');
  }

  public function EditCategory($id)
	{
		$data['category'] = Category::where('id',$id)->first();
		return view('admin.categories.edit',$data);
  }

  public function UpdateCategory(Request $request, $id)
	{
		$category = Category::findOrFail($id);
		$old_image = $category->image;
		if($request->status){
			$status = 1;
		} else {
			$status =0;
		}
		if($request->hasFile('image')){
      if($category->image!=null){
        $old_image_path =public_path('uploads/category/'.$old_image);
				unlink($old_image_path);
			}
			// \File::delete($old_image_path);
      $image = $request->file('image');
			$ext = $image->getClientOriginalExtension();
			$image_name = Str::slug($request->name).'-'.rand().'-'.time().'.'.$ext;
			// $image_name = $image->getClientOriginalName(); //get the original filename
			$destination= public_path('uploads/category/');
			if(!is_dir($destination)) {
				mkdir(($destination),0777,true);
			}
			$image->move($destination,$image_name);
		} else {
			$image_name = $old_image;
		}
		$data = [
			'name' => $request->name,
			'slug' => Str::slug($request->name),
			'status' => $status,
			'image' => $image_name
		];
		$category->update($data);
		return redirect()->route('admin.categories.list')->with('success','Category has been Updated Successful');
  }

  public function DeleteCategory($id)
	{
		$category = Category::where('id',$id)->first();
		$old_image = $category->image;
		$old_image_path =public_path('uploads/category/'.$old_image);
		if(file_exists($old_image_path)){
			unlink($old_image_path); //delete from uploads
		}
		$category->delete(); //delete from database
		return redirect()->back();
	}

}
