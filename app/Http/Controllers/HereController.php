<?php

namespace App\Http\Controllers;

use Curl\Curl;

use App\{User, Here};
use View, Request, Response, Config, Validator;

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
        return View::make('here.map')->with('user', User::getInfo());
    }

    /**
     * 位置记录
     *
     * @return Response
     */
    public function index()
    {
        // get here list
        $list = Here::usered(User::getInfo()->id)->orderBy('date')->get();

        // render page
        return View::make('here.index')->with('list', $list);
    }

    /**
     * 新增位置
     *
     * @return Response
     */
    public function create()
    {
        // render page
        return View::make('here.edit');
    }

    /**
     * 编辑位置
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        // get current data
        $data = Here::usered(User::getInfo()->id)->find($id);

        // render page
        return View::make('here.edit')->with('data', $data);
    }

    /**
     * 保存位置
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // get params & validate
        if ( ! User::isLogin()) {
            return Response::json(['status' => 'Not login']);
        }

        $rules = [
            'date'     => 'required|date',
            'location' => 'required|size:27',
        ];
        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['status' => 'Invalid params']);
        }

        $id = $request::get('id');
        $date = $request::get('date');
        $placeId = $request::get('location');

        // request place details
        $result = $this->placeDetails($placeId);
        if ('OK' !== $result['status']) {
            return Response::json(['status' => $result['status']]);
        }

        // save
        $details = $result['result'];
        $data = [
            'user_id'     => User::getInfo()['id'],
            'date'        => date('Y-m-d', strtotime($date)),
            'lat'         => $details['geometry']['location']['lat'],
            'lng'         => $details['geometry']['location']['lng'],
            'country'     => $details['address_components']['country']['long_name'] ?? '',
            'province'    => $details['address_components']['administrative_area_level_1']['long_name'] ?? '',
            'location'    => $details['name'],
            'gm_url'      => $details['url'],
            'gm_place_id' => $details['place_id']
        ];
        if ($id) {
            Here::where('id', $id)->update($data);
        } else {
            Here::create($data);
        }

        // response
        return Response::json(['status' => 'OK']);
    }

    /**
     * 删除位置
     *
     * @param int $id 
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        $status = Here::find($id)->delete();

        // response
        return Response::json(['status' => $status ? 'OK' : 'ERROR']);
    }

    /**
     * Google Places API Web Service
     * Place Autocomplete
     *
     * @param Request $request
     * @return Response
     * @see https://developers.google.com/places/web-service/autocomplete
     */
    public function placeAutocomplete(Request $request)
    {
        $input = trim($request::get('input'));
        if (empty($input)) {
            return Response::json([
                'status' => 'No results found'
            ]);
        }

        $curl = new Curl();
        $curl->setTimeout(15);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
        $curl->get(Config::get('googleplaces.api_autocomplete'), [
            'key'   => Config::get('googleplaces.key'),
            'types' => 'geocode',
            'input' => $input
        ]);
        if ($curl->error) {
            return Response::json([
                'status' => $curl->errorMessage
            ]);
        } else {
            return Response::json($curl->response);
        }
    }

    /**
     * Google Places API Web Service
     * Place Details
     *
     * @param string $placeId
     * @return array
     * @see https://developers.google.com/places/web-service/details
     */
    private function placeDetails($placeId)
    {
        $curl = new Curl();
        $curl->setTimeout(15);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
        $curl->setJsonDecoder(function($string) {
            return json_decode($string, true);
        });
        $curl->get(Config::get('googleplaces.api_details'), [
            'key'      => Config::get('googleplaces.key'),
            'language' => 'zh-CN',
            'placeid'  => $placeId
        ]);
        if ($curl->error) {
            return ['status' => $curl->errorMessage];
        } else {
            $response = $curl->response;
            foreach ($response['result']['address_components'] as $i => $item) {
                $response['result']['address_components'][$item['types'][0]] = $item;
                unset($response['result']['address_components'][$i]);
            }
            return $response;
        }
    }
}
