<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Config, View;

abstract class Controller extends BaseController
{

    /**
     * 当前模块名称
     *
     * @var string
     */
    protected $module;

    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        View::share('navs', Config::get('navigation'));
        View::share('module', $this->module);
    }
}
