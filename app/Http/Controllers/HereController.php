<?php

namespace App\Http\Controllers;

use Curl\Curl;
use View, Request, Response;

/**
 * 打卡控制器
 *
 * @author popfeng <popfeng@yeah.net> 2016-04-19
 */
class HereController extends Controller
{ 

    /**
     * 首页
     *
     * @return Response
     */
    public function map()
    {
        // render page
        return View::make('here.map');
    }

    /**
     * 打卡记录
     *
     * @return Response
     */
    public function index()
    {
        // render page
        return View::make('here.index');
    }

    /**
     * 新增打卡
     *
     * @return Response
     */
    public function create()
    {
        // render page
        return Response::view('here.create');
    }

    /**
     * Query Autocomplete Requests
     *
     * @param Request $request
     * @return Response
     * @see https://developers.google.com/places/web-service/query
     */
    public function geo(Request $request)
    {
        $api = 'https://maps.googleapis.com/maps/api/place/autocomplete/json';
        $key = 'AIzaSyA6pLYI91AnL4IJH_GDgh_VZXpmK6hwA_k';

        $curl = new Curl();
        $curl->setTimeout(10);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
        $curl->get($api, [
            'types'    => 'geocode',
            //'language' => 'zh',
            'key'      => $key,
            'input'    => $request::get('input')
        ]);
        if ($curl->error) {
            return Response::json([
                'status' => $curl->errorCode . ': ' . $curl->errorMessage
            ]);
        } else {
            return Response::json($curl->response);
        }
    }
}
