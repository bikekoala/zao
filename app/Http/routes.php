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
// 节目页
Route::get('programs/{date}', 'ProgramsController@detail');
// 关于页
Route::get('about', function () {
    return View::make('about')->with('title', '关于');
});
