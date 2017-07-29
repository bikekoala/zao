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

// 签到页
Route::resource('heres', 'HereController');
Route::post('here/login', 'HereController@login');
Route::get('here/logout', 'HereController@logout');
Route::get('here', 'HereController@map');
Route::get('here/mapData', 'HereController@mapData');
Route::get('here/placeAutocomplete', 'HereController@placeAutocomplete');

// 节目页
Route::get('program/apptoday', 'ProgramController@apptoday');
Route::get('program/{date}', 'ProgramController@detail');
Route::get('program/{date}/pv', 'ProgramController@getPvCounts');

// 音乐页
Route::get('music', 'MusicController@index');
Route::get('music/{id}', 'MusicController@titlePage');
Route::get('music/artist/{id}', 'MusicController@artistPage');

// 关于页
Route::get('about', 'AboutController@index');
Route::get('about/donation', 'AboutController@donationList');
Route::get('about/contribution', 'AboutController@contributionList');

// 多说评论
Route::get('duoshuo/login', 'DuoshuoController@login');
Route::get('duoshuo/logout', 'DuoshuoController@logout');
Route::post('duoshuo/comment', 'DuoshuoController@comment');

// 后台
Route::group(['prefix' => 'admin','namespace' => 'Admin',
    'middleware' => ['web']], function () {
    // 通知消息
    Route::resource('notifications', 'NotificationsController');

    // 认证
    Route::get('/', function () {
        if (Auth::guest()) {
            return Redirect::to('/admin/auth/login');
        } else {
            return Redirect::to('/admin/notifications');
        }
    });
    Route::controllers([
        'auth'     => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
    ]);
});
