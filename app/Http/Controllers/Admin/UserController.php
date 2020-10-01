<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::get();
        return view('admin.users.index',$data);
    }

    public function create()
    {
			$data['roles'] = Role::get();
      return view('admin.users.create',$data);
    }

    public function store(Request $request)
    {
			if($request->status){
				$status =1;
			} else {
				$status = 0;
			}

			$validatedData = $request->validate([
        'role_id' => 'required',
        'name' => 'required|max:255',
        'username' => 'required',
				'phone' => 'required',
				'image' => 'required',
        'email' => 'required|unique:users',
        'password' => 'required|confirmed',
			]);
			if($request->hasFile('image')){
				$image = $request->file('image');
				$image_name = 'user'.'-'.rand().'-'.time().'.'.$image->getClientOriginalExtension(); // generate new name
				// $image_name = $image->getClientOriginalName(); // get the original name of image
				$uploadpath = public_path('uploads/user/');
				if(!is_dir(	$uploadpath)){
					mkdir($uploadpath,0777,true);
				}
				$image->move($uploadpath,$image_name);
			} else {
				$image_name = null;
			}
			$data = [
				'role_id' =>  $request->role_id,
				'name' =>  $request->name,
				'username' =>  $request->username,
				'phone' =>  $request->phone,
				'email' =>  $request->email,
				'image' =>  $image_name,
				'about' =>  $request->about,
				'password' =>  bcrypt($request->password), //Hash::make($request->password)
				'status' =>   $status,
      ];
			$user = User::create($data);
			return redirect()->route('admin.users.index')->with('success','New User Create Successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
			$data['user'] = User::findOrFail($id);
			$data['roles'] = Role::get();
			// $data['tag'] = Tag::where('id',$id)->first();
      return view('admin.users.edit',$data);
    }

    public function update(Request $request, $id)
    {
			if($request->status){
				$status =1;
			} else {
				$status = 0;
			}
			$user=User::findOrFail($id);
			$old_image = $user->image;
			$validatedData = $request->validate([
        'role_id' => 'required',
        'name' => 'required|max:255',
        'username' => 'required',
				'phone' => 'required',
        'email' => 'required',
  		]);
			if($request->hasFile('image')){
				if($old_image){
					$old_path = public_path('uploads/user'.$old_image);
					if(file_exists($old_path)){
						unlink($old_path);
					}
				}
				$image = $request->file('image');
				$image_name = 'user'.'-'.rand().'-'.time().'.'.$image->getClientOriginalExtension(); // generate new name
				// $image_name = $image->getClientOriginalName(); // get the original name of image
				$uploadpath = public_path('uploads/user/');
				if(!is_dir(	$uploadpath)){
					mkdir($uploadpath,0777,true);
				}
				$image->move($uploadpath,$image_name);
			} else {
				$image_name = $old_image;
			}
			if($request->password){
				$data = [
					'role_id' =>  $request->role_id,
					'name' =>  $request->name,
					'username' =>  $request->username,
					'phone' =>  $request->phone,
					'email' =>  $request->email,
					'image' =>  $image_name,
					'about' =>  $request->about,
					'password' =>  bcrypt($request->password), //Hash::make($request->password)
					'status' =>   $status,
				];
				$user->update($data);
			} else {
				$user->update([
					'role_id' =>  $request->role_id,
					'name' =>  $request->name,
					'username' =>  $request->username,
					'phone' =>  $request->phone,
					'email' =>  $request->email,
					'image' =>  $image_name,
					'about' =>  $request->about,
					'status' =>   $status,
				]);
			}
			return redirect()->route('admin.users.index')->with('success','New User Updated Successfully!');
		}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $old_image = $user->image;
        $old_path = public_path('uploads/user/'.$old_image);
        if($old_path){
					if(file_exists($old_path)){
						unlink($old_path);
					}
				}
				$user->delete();
        return redirect()->route('admin.users.index')->with('success','User Deleted Successfully!');
    }

}
