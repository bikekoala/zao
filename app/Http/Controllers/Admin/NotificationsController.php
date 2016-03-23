<?php

namespace App\Http\Controllers\Admin;

use App\Notification;
use View, Validator, Request, Redirect;

/**
 * 通知消息控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-03-22
 */
class NotificationsController extends Controller
{
    protected $module = 'notifications';

    /**
     * 列表页
     *
     * @return Response
     */
    public function index()
    {
        $list = Notification::orderBy('id', 'desc')->paginate(100);
        return View::make('admin/notifications/index', ['list' => $list]);
    }

    /**
     * 新增消息
     *
     * @return void
     */
    public function create()
    {
        return View::make('admin/notifications/edit');
    }

    /**
     * 编辑消息
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        return View::make('admin/notifications/edit')
            ->with('notification', Notification::find($id));
    }

    /**
     * 更新消息
     *
     * @return void
     */
    public function store()
    {
        // get params & validate
        $id          = Request::get('id');
        $message     = Request::get('message');
        $durationAt  = Request::get('duration_at');
        $state       = Request::get('state');
        $redirectUrl = Request::get('_redirect_url');

        $rules = [
            'message'     => 'required|max:500',
            'duration_at' => 'required|date',
            'state'       => 'required|in:0,1'
        ];
        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to($redirectUrl)->with('error', '保存失败~');
        }

        // save
        $data = [
            'message'     => $message,
            'duration_at' => $durationAt,
            'state'       => $state
        ];
        if ($id) {
            Notification::where('id', $id)->update($data);
        } else {
            Notification::create($data);
        }

        // redirect
        return Redirect::to($redirectUrl)->with('success', '保存成功~');
    }
}
