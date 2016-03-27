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

// 首页
Route::get('/', 'ProgramsController@index');

// 节目页
Route::get('programs/apptoday', 'ProgramsController@apptoday');
Route::get('programs/{date}', 'ProgramsController@detail');
Route::get('programs/{date}/pv', 'ProgramsController@getPvCounts');

// 关于页
Route::get('about', 'AboutController@index');

// 多说评论
Route::post('duoshuo/callback', 'DuoshuoController@callback');

// 后台管理
Route::group(['prefix' => 'admin','namespace' => 'Admin',
    'middleware' => ['web']], function () {
    // 协同列表
    Route::resource('contributions', 'ContributionsController');
    // 通知消息
    Route::resource('notifications', 'NotificationsController');

    // 认证
    Route::get('/', function () {
        if (Auth::guest()) {
            return Redirect::to('/admin/auth/login');
        } else {
            return Redirect::to('/admin/contributions');
        }
    });
    Route::controllers([
        'auth'     => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
    ]);
});
