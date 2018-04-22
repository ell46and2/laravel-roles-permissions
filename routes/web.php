<?php

use Illuminate\Http\Response;

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

Route::get('/', function () {
    
    $user = request()->user();

    // dump($user->can('delete users'));
    
    $user->withdrawPermissionTo('delete posts');

    return Response('hi', 200);
});

Route::group(['middleware' => ['role:admin,delete users']], function() {
	Route::get('/admin', function() {
		return 'Admin panel';
	});
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
