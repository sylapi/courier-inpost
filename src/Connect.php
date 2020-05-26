<?php

namespace Sylapi\Courier\Inpost;

/**
 * Class Connect
 * @package Sylapi\Courier\Inpost
 */
abstract class Connect
{
    /**
     *
     */
    const API_LIVE = 'https://api-shipx-pl.easypack24.net';
    /**
     *
     */
    const API_SANDBOX = 'https://sandbox-api-shipx-pl.easypack24.net';

    /**
     * @var string
     */
    protected $api_uri;
    /**
     * @var
     */
    protected $session;
    /**
     * @var
     */
    protected $token;
    /**
     * @var
     */
    protected $parameters;
    /**
     * @var
     */
    protected $error;
    /**
     * @var
     */
    protected $response;
    /**
     * @var string
     */
    protected $code = '';
    /**
     * @var bool
     */
    protected $test = false;

    /**
     * @var
     */
    public $organization_id;

    /**
     * Connect constructor.
     */
    public function __construct()
    {
        $this->api_uri = self::API_LIVE;
    }

    /**
     * @param $organization_id
     * @return mixed
     */
    protected function setLogin($organization_id)
    {
        return $this->organization_id = $organization_id;
    }

    /**
     * @param $token
     * @return mixed
     */
    protected function setToken($token)
    {
        return $this->token = $token;
    }

    /**
     * @return string
     */
    public function getApiUri()
    {
        return $this->api_uri;
    }

    /**
     * @return string
     */
    public function sandbox()
    {
        return $this->api_uri = self::API_SANDBOX;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return (empty($this->error)) ? true : false;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function setError($value)
    {
        if (!empty($value)) {
            return $this->error[] = $value;
        }
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function setCode($value)
    {
        return $this->code = $value;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function setResponse($value)
    {
        return $this->response = $value;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * @param $uri
     */
    public function setUri($uri)
    {
        $this->test = true;
        $this->api_uri = $uri;
    }

    /**
     * @param $uri
     * @param array $params
     * @param string $request
     * @param bool $file
     * @return bool|false|mixed|string|null
     */
    public function call($uri, array $params = [], $request = 'GET', $file = false)
    {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->token,
        ];

        if ($this->test == true) {
            $result = file_get_contents($this->api_uri);
        } else {
            $curl = curl_init($this->api_uri.$uri);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            if ($request == 'POST' || $request == 'PUT') {
                $parameters = json_encode($params);

                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
            }

            $result = curl_exec($curl);
        }

        if ($file == false) {
            $result = ($result === false) ? false : json_decode($result, true);
        }

        if (empty($result)) {
            return null;
        } else {
            return $result;
        }
    }

    /**
     * @return array
     */
    public function debug()
    {
        return [
            'success'  => $this->isSuccess(),
            'code'     => $this->getCode(),
            'error'    => $this->getError(),
            'response' => $this->getResponse(),
        ];
    }
}
