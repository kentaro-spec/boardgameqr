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

// Route::get('/', function () {
//     return view('welcome');
// });

// 一覧ページ
Route::get('/', 'PostController@index');
//質問ページ
Route::get('/qr','PostController@qr')->name('qr');
Route::post('/','PostController@insert_qr');
//質問詳細ページ
Route::get('/qr/{id}','PostController@show_qr')->name('show');
Route::post('/qr/{id}','PostController@answer_qr');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
