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
Route::get('/{tab?}', 'PostController@index')->where(['tab' => '(new|solved|unsolved)']);

//質問ページ
Route::get('/qr','PostController@qr')->name('qr');
Route::post('/','PostController@insert_qr');
//質問詳細ページ
Route::get('/qr/{id?}','PostController@show_qr')->name('show');
Route::post('/qr/{id?}','PostController@answer_qr');
//ユーザー詳細ページ
Route::get('/user/{id}','PostController@show_user')->name('show_user');

// ボードゲームページ
Route::get('/boardgame/{id}','PostController@show_boardgame')->name('boardgame');
//ボードゲーム追加ページ
Route::get('/boardgame_add','PostController@create_boardgame')->name('post_newbg');
Route::post('/boardgame_add','PostController@add_boardgame')->name('add_newbg');
//ベストアンサー
Route::get('/bestanswer','PostController@store_bestanswer')->name('bestanswer');
// 検索機能
Route::get('/search','PostController@search_bgname')->name('search');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
