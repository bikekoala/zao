<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// Route::group(['middleware' => ['web']], function () {});

// 首页
Route::get('/', 'ProgramsController@index');
// 详情页
Route::get('/programs/{date}.html', 'ProgramsController@detail');
