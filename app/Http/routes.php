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
Route::get('/', 'ProgramController@index');

// 打卡页
Route::resource('heres', 'HereController');
Route::get('here', 'HereController@map');
Route::get('here/placeAutocomplete', 'HereController@placeAutocomplete');
Route::get('here/placeDetails', 'HereController@placeDetails');

// 节目页
Route::get('program/apptoday', 'ProgramController@apptoday');
Route::get('program/{date}', 'ProgramController@detail');
Route::get('program/{date}/pv', 'ProgramController@getPvCounts');

// 音乐页
Route::get('music/{id}', 'MusicController@titlePage');
Route::get('music/artist/{id}', 'MusicController@artistPage');

// 关于页
Route::get('about', 'AboutController@index');

// 多说评论
Route::get('duoshuo/login', 'DuoshuoController@login');
Route::get('duoshuo/logout', 'DuoshuoController@logout');
Route::post('duoshuo/comment', 'DuoshuoController@comment');

// 后台
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
