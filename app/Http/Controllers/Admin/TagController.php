<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
			// $tags = DB::table('tags')->get();
			// $tags = Tag::get();
			$data['tags'] = Tag::get();
			// return view('admin.tags.index',compact('tags','title'));
			return view('admin.tags.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			// return $request->all();
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
			// return $data;
			//using Query Builder
				// $tag = DB::table('tags')->insert($data);
				// another way to save data
				// $tag = DB::table('tags')->insert([
				// 	'name' =>  $request->name,
				// 	'slug' =>  Str::slug($request->name),
				// 	'status' =>   $status,
				// ]);
			//Using Eloquent ORM (MVC)
				$tag = Tag::create($data);
				// another way to save data
				// $tag = Tag::create([
				// 	'name' =>  $request->name,
				// 	'slug' =>  Str::slug($request->name),
				// 	'status' =>   $status,
				// ]);
				// another way to save data
				// $tag = new Tag();
				// $tag->name = $request->name;
				// $tag->slug = Str::slug($request->name);
				// $tag->status = $status;
				// $tag->save();
			return redirect()->route('admin.tags.index')->with('success','New Tag Create Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
			$data['tag'] = Tag::findOrFail($id);
			// $data['tag'] = Tag::where('id',$id)->first();
      return view('admin.tags.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
			$tag = Tag::findOrFail($id)->update($data);
			// $data['tag'] = Tag::where('id',$id)->update($data);
			return redirect()->route('admin.tags.index')->with('success','Tag Updated Successfully!');
		}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id)->delete();
        return redirect()->route('admin.tags.index')->with('success','Tag Deleted Successfully!');
    }

    public function showDelete($id)
    {
        return view('admin.tags.confirm_delete',compact('id'));
    }
}
