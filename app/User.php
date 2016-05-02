<?php

namespace App;

use Session;

/**
 * 用户模型
 *
 * @author popfeng <popfeng@yeah.net> 2016-04-27
 */
class User
{
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
     * @return array
     */
    public static function getCurrent()
    {
        return Session::get(self::SESSION_KEY) ?? [];
    }
}
