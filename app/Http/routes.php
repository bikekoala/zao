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

// 多说评论
Route::post('duoshuo/callback', 'DuoshuoController@callback');

// 后台管理
Route::group(['prefix' => 'admin','namespace' => 'Admin',
    'middleware' => ['web']], function () {
    // 协同列表
    Route::resource('contributions', 'ContributionsController');

    // 认证
    Route::get('/', function () {
        return Redirect::to('/admin/auth/login');
    });
    Route::controllers([
        'auth'     => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
    ]);
});
