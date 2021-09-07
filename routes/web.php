<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


/*
GET/posts, mapped to the index() method,
GET /posts/create, mapped to the create() method,
POST /posts, mapped to the store() method,
GET /posts/{post_id}, mapped to the show() method,
GET /posts/{post_id}/edit, mapped to the edit() method,
PUT/PATCH /posts/{post_id}, mapped to the update() method,
DELETE /posts/{post_id}, mapped to the destroy() method.
*/

