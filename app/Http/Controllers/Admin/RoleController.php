<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
			$data['roles'] = Role::get();
			return view('admin.roles.index',$data);
    }

    public function create()
    {
      return view('admin.roles.create');
    }

    public function store(Request $request)
    {
			if($request->status){
				$status =1;
			} else {
				$status = 0;
			}
			$data = [
				'name' =>  $request->name,
				'slug' =>  Str::slug($request->name),
				'status' =>   $status,
      ];
				$role = Role::create($data);
			return redirect()->route('roles.index')->with('success','New Role Create Successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
			$data['role'] = Role::findOrFail($id);
			// $data['tag'] = Tag::where('id',$id)->first();
      return view('admin.roles.edit',$data);
    }

    public function update(Request $request, $id)
    {
			if($request->status){
					$status =1;
			} else {
					$status = 0;
			}
			$data = [
				'name' =>  $request->name,
				'slug' =>  Str::slug($request->name),
				'status' =>   $status,
			];
			$tag = Role::findOrFail($id)->update($data);
			// $data['tag'] = Tag::where('id',$id)->update($data);
			return redirect()->route('roles.index')->with('success','Role Updated Successfully!');
		}

    public function destroy($id)
    {
        $role = Role::findOrFail($id)->delete();
        return redirect()->route('roles.index')->with('success','Role Deleted Successfully!');
    }

}
