<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

/**
 * 用户模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-04-27
 */
class User extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ds_id', 'name', 'url', 'avatar_url', 'meta', 'state'];

    /**
     * 状态常量
     *
     * @var int
     */
    const STATE_ENABLE  = 1;
    const STATE_DISABLE = 0;

    /**
     * session key
     *
     * @var string
     */
    const SESSION_KEY = 'user';

    /**
     * 是否登录
     *
     * @return bool
     */
    public static function isLogin()
    {
        return ! empty(Session::get(self::SESSION_KEY));
    }

    /**
     * 保存数据
     *
     * @param array $data
     * @return void
     */
    public static function login(array $data)
    {
        $user = static::where('ds_id', $data['user_id'])->first() ? : new static;
        $user->ds_id      = $data['user_id'];
        $user->name       = $data['name'];
        $user->url        = $data['url'];
        $user->avatar_url = $data['avatar_url'];
        $user->meta       = json_encode($data, JSON_UNESCAPED_UNICODE);
        $user->state      = self::STATE_ENABLE;
        $user->save();

        Session::put(self::SESSION_KEY, $data);
    }

    /**
     * 销毁数据
     *
     * @return void
     */
    public static function logout()
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * 获取当前用户信息
     *
     * @param int $userId
     * @return \App\User
     */
    public static function getInfo($userId = null)
    {
        if ($userId) {
            return static::find($userId);
        } else {
            $dsInfo = Session::get(self::SESSION_KEY);
            if ( ! empty($dsInfo)) {
                return static::where('ds_id', $dsInfo['user_id'])->first();
            } else return null;
        }
    }
}
