<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Regular pages
Route::get('/','HomeController@index');
Route::get('/home','HomeController@index');
Route::get('/about', function () {
    return view('about');
});

Route::get('/contact','ContactController@index');
Route::post('/contact','ContactController@submit');

Route::get('/terms', function () {
    return view('privacy');
});
Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/blog','BlogController@index');
Route::get('/blog/{slug}','BlogController@show');
Route::post('/search', 'SearchController@index');
Route::get('/search', function () {
    return view('search');
});

Auth::routes();

Route::get('fbredirect', 'Auth\LoginController@fbRedirect');
Route::get('fbcallback', 'Auth\LoginController@fbCallback');

Route::get('/dashboard', 'DashboardController@show')->name('dashboard');

// Friend request stuff
Route::post('/friendrequest','FriendController@sendRequest');
Route::post('/acceptrequest','FriendController@acceptRequest');
Route::post('/deleterequest','FriendController@deleteRequest');
Route::post('/reviewcheck','ReviewsController@check');
Route::post('/reviewsave','ReviewsController@save');

// Users views
Route::get('/user/',function() {
    return redirect('home');
});
Route::get('/users/',function() {
    return redirect('home');
});
//Route::get('/users/','UserController@index');
Route::get('/user/{id}','UserController@show');

Route::get('/book/{id}','BookController@show');

// Authors views
Route::get('/author/',function() {
    return redirect('authors');
});
Route::get('/authors/','AuthorController@index');
Route::get('/author/{id}','AuthorController@show');

// Notifications
Route::post('/notifications/markread','NotificationController@markRead');

Route::get('/add-book', 'BookController@externalAdd');

// Resources
Route::post('bookshelf/update/', 'BookshelfController@updateBookshelf');
Route::resource('bookshelf', 'BookshelfController');
Route::resource('category', 'CategoryController');

// Admin
Route::get('/admin/','AdminController@index');

Route::get('/admin/posts/','AdminController@posts');

Route::get('/admin/posts/new','AdminController@createPostForm');
Route::post('/admin/posts/new','AdminController@createPost');

Route::get('/admin/posts/{id}','AdminController@singlePost');
Route::post('/admin/posts/{id}','AdminController@updatePost');
Route::get('/admin/users','AdminController@userList');