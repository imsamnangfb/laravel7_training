<?php

use Illuminate\Support\Facades\Route;

Route::get('/','FrontController@index')->name('homepage');

Route::post('/favorite/{post}/add','FavoriteController@save')->name('favorite.save');
Route::post('subscriber','SubscriberController@store')->name('subscriber.store');
Route::post('comment/{post}','CommentController@store')->name('comment.store');

Route::get('/post/{id}/detail','FrontController@postDetail')->name('post.detail');
Route::get('/post/byCategory/{slug}','FrontController@postByCategory')->name('post.by.postByCategory');
Route::get('/post/byTag/{slug}','FrontController@postByTag')->name('post.by.postByTag');
Route::get('/allpost','FrontController@allPost')->name('allPost');

Route::group(['prefix' => 'admin','namespace'=>'Admin','as' =>'admin.','middleware'=>['web','auth','isAdmin']], function () {
	Route::get('/dashboard','DashboardController@index')->name('dashboard');
	Route::resource('/tags', 'TagController');
	Route::get('/tags/{id}/showDelete','TagController@showDelete')->name('tags.show.delete');
	Route::get('/categories','CategoryController@CategoryList')->name('categories.list');
	Route::get('/categories/create','CategoryController@CreateCategory')->name('categories.create');
	Route::post('/categories/save','CategoryController@SaveCategory')->name('categories.save');
	Route::get('/categories/{id}/edit','CategoryController@EditCategory')->name('categories.edit');
	Route::put('/categories/{id}/update/','CategoryController@UpdateCategory')->name('categories.update');
	Route::delete('/categories/{id}/delete','CategoryController@DeleteCategory')->name('categories.delete');

	Route::get('/posts/pending','PostController@pendingPost')->name('posts.pending');
    Route::put('/posts/{id}/approve','PostController@approval')->name('posts.approve');
    Route::get('/posts/gallery','PostController@postGallery')->name('posts.gallery');
    Route::post('posts/dropzone/upload','PostController@dropzoneStore')->name('upload.dropzone.store');
    Route::post('posts/dropzone/delete', 'PostController@dropzonedelete')->name('upload.dropzone.delete');
    Route::get('posts/gallery_list', 'PostController@listGallery')->name('posts.gallery.list');
    Route::delete('posts/gallery/destroy/{id}', 'PostController@deleteImage')->name('posts.gallery.destroy');
	Route::resource('/posts', 'PostController');
	Route::resource('/roles', 'RoleController');
	Route::resource('/users', 'UserController');

    Route::get('/subscriber','SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}','SubscriberController@destroy')->name('subscriber.destroy');
	Route::group(['prefix' => 'laravel-filemanager'], function () {
		\UniSharp\LaravelFilemanager\Lfm::routes();
	});

});

Route::group(['prefix' => 'author','namespace'=>'Author','as'=>'author.','middleware'=>['auth','isAuthor']], function () {
  Route::get('/dashboard','DashboardController@index')->name('dashboard');
  Route::get('/posts/pending','PostController@pendingPost')->name('posts.pending');
  Route::get('/posts/gallery','PostController@postGallery')->name('posts.gallery');
    Route::post('posts/dropzone/upload','PostController@dropzoneStore')->name('upload.dropzone.store');
    Route::post('posts/dropzone/delete', 'PostController@dropzonedelete')->name('upload.dropzone.delete');
    Route::get('posts/gallery_list', 'PostController@listGallery')->name('posts.gallery.list');
    Route::delete('posts/gallery/destroy/{id}', 'PostController@deleteImage')->name('posts.gallery.destroy');
  Route::resource('/posts', 'PostController');
  Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
  });
});
// Route::group(['prefix' => 'laravel-filemanager','middleware'=>'auth'], function () {
// 	\UniSharp\LaravelFilemanager\Lfm::routes();
// });
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

View::composer('layouts.front.footer',function ($view){
    $categories = App\Models\Category::all();
    $view->with('categories',$categories);
    // $categories = App\Tag::all();
    // $view->with('categories',$categories);
});
