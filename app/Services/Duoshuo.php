<?php

namespace App\Services;

use Illuminate\Support\ServiceProvider;

/**
 * 多说服務
 *
 * @author popfeng <popfeng@yeah.net> 2016-01-28
 */
class Duoshuo
{
    private $api       = 'http://api.duoshuo.com/';
    private $apiFormat = 'json';
    private $userAgent = 'DuoshuoPhpSdk/0.3.0';
    private $timeout   = 60;
    private $shortName;
    private $secret;
    private $accessToken;
    private $refreshToken;

    /**
     * __construct
     *
     * @param string $shortName
     * @param string $secret
     * @param string $remoteAuth
     * @param string $accessToken
     * @return void
     */
    public function __construct(
        $shortName = null,
        $secret = null,
        $remoteAuth = null,
        $accessToken = null
    ){
        $this->shortName   = $shortName;
        $this->secret      = $secret;
        $this->remoteAuth  = $remoteAuth;
        $this->accessToken = $accessToken;
    }

    /**
     * 获取日志
     *
     * @param int $sinceId
     * @param int $limit
     * @param string $order
     * @return array
     */
    public function getLogList($sinceId, $limit, $order = 'asc')
    {
        return $this->request('GET', 'log/list', [
            'since_id' => $sinceId,
            'limit'    => $limit,
            'order'    => $order
        ]);
    }

    /**
     * 创建or回复评论
     *
     * @param string $message
     * @param string $threadId
     * @param string $parentId
     * @param string $authorName
     * @param string $authorEmail
     * @param string $authorUrl
     * @return bool
     */
    public function createPost(
        $message,
        $threadId,
        $parentId = null,
        $authorName,
        $authorEmail,
        $authorUrl = null
    ) {
        $response = $this->request('POST', 'posts/create', [
            'message'      => $message,
            'thread_id'    => $threadId,
            'parent_id'    => $parentId,
            'author_name'  => $authorName,
            'author_email' => $authorEmail,
            'author_url'   => $authorUrl,
        ]);
        return $response['code'] === 0;
    }

    /**
     * 检查签名
     *
     * @param array $params
     * @return bool
     */
    public function checkSignature($params)
    {
        if (empty($params['signature'])) {
            return false;
        }

        $signature = $params['signature'];
        unset($params['signature']);

        ksort($params);
        $expectSignature = base64_encode($this->hmacsha1(
            http_build_query($params, null, '&'),
            $this->secret
        ));
        return $signature === $expectSignature;
    }

    /**
     * getRemoteAuth
     *
     * @param array $userData
     * @return string
     */
    public function getRemoteAuth($userData)
    {
        $time = time();
        $message = base64_encode(json_encode($userData));
        return $message . ' ' . self::hmacsha1($message . ' ' . $time, $this->secret) . ' ' . $time;
    }

    /**
     * getAccessToken
     *
     * @param string  $type
     * @param string $keys
     * @return string|array
     */
    public function getAccessToken($type, $keys)
    {
        $params = [
            'client_id'     =>  $this->shortName,
            'client_secret' => $this->secret,
        ];
        
        switch($type){
            case 'token':
                $params['grant_type']    = 'refresh_token';
                $params['refresh_token'] = $keys['refresh_token'];
                break;
            case 'code':
                $params['grant_type']   = 'authorization_code';
                $params['code']         = $keys['code'];
                $params['redirect_uri'] = $keys['redirect_uri'];
                break;
            case 'password':
                $params['grant_type'] = 'password';
                $params['username']   = $keys['username'];
                $params['password']   = $keys['password'];
                break;
            default:
                return 'wrong auth type';
        }
        $accessTokenUrl = 'http://api.duoshuo.com/oauth2/access_token';
        $response = $this->http($accessTokenUrl, $params, 'POST');

        if (is_array($response) and empty($response['error'])) {
            $this->accessToken = $response['access_token'];
            if (isset($response['refresh_token'])) {
                $this->refreshToken = $response['refresh_token'];
            }
        } else {
            return $response['error'];
        }
    }

    /**
     * 请求接口
     *
     * @param string $method
     * @param string $path
     * @param array $params
     * @return array
     */
    public function request($method, $path, $params = [])
    {
        $params['short_name']  = $this->shortName;
        $params['secret']      = $this->secret;
        $params['remote_auth'] = $this->remoteAuth;

        if ($this->accessToken) {
            $params['access_token'] = $this->accessToken;
        }

        $url = $this->api . $path . '.' . $this->apiFormat;

        return $this->http($url, $params, $method);
    }

    /**
     * http
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @return string
     */
    private function http($url, $params, $method = 'POST')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);

        switch ($method) {
            case 'GET':
                $url .= '?' . http_build_query($params, null, '&');
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);

        $json = json_decode($response, true);
        return $json === null ? $response : $json;
    }

    /**
     * Calculate HMAC-SHA1 according to RFC2104
     *
     * @param string $data
     * @param string $key
     * @return string
     * @see from: http://www.php.net/manual/en/function.sha1.php#39492
     * @see http://www.ietf.org/rfc/rfc2104.txt
     */
    private function hmacsha1($data, $key)
    {
        if (function_exists('hash_hmac')) {
            return hash_hmac('sha1', $data, $key, true);
        }

        $blocksize = 64;
        $hashfunc = 'sha1';
        if (strlen($key) > $blocksize) {
            $key = pack('H*', $hashfunc($key));
        }
        $key = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        $hmac = pack(
            'H*', $hashfunc(
                ($key ^ $opad) . pack(
                    'H*', $hashfunc(
                        ($key ^ $ipad) . $data
                    )
                )
            )
        );
        return bin2hex($hmac);
    }
}
