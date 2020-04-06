<?php

namespace Sylapi\Courier\Inpost;

abstract class Connect
{
    const API_LIVE = 'https://api-shipx-pl.easypack24.net';
    const API_SANDBOX = 'https://sandbox-api-shipx-pl.easypack24.net';

    protected $api_uri;
    protected $session;
    protected $token;
    protected $parameters;
    protected $error;
    protected $response;
    protected $code = '';
    protected $test = false;

    public $organization_id;

    public function __construct() {
        $this->api_uri = self::API_LIVE;
    }

    protected function setLogin($organization_id) {
        return $this->organization_id = $organization_id;
    }

    protected function setToken($token) {
        return $this->token = $token;
    }

    public function getApiUri() {
        return $this->api_uri;
    }

    public function sandbox() {
        return $this->api_uri = self::API_SANDBOX;
    }

    public function isSuccess() {
        return (empty($this->error)) ? true : false;
    }

    public function getError() {
        return $this->error;
    }

    protected function setError($value) {
        if (!empty($value)) {
            return $this->error[] = $value;
        }
    }

    protected function setCode($value) {
        return $this->code = $value;
    }

    public function getCode() {
        return $this->code;
    }

    protected function setResponse($value) {
        return $this->response = $value;
    }

    public function getResponse() {
        return $this->response;
    }

    public function setSession($session) {
        $this->session = $session;
    }

    public function setUri($uri) {
        $this->test = true;
        $this->api_uri = $uri;
    }

    public function call($uri, array $params = [], $request='GET', $file=false) {

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->token,
        ];

        if ($this->test == true) {
            $result = file_get_contents($this->api_uri);
        }
        else {
            $curl = curl_init($this->api_uri . $uri);
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

    public function debug() {

        return [
            'success' => $this->isSuccess(),
            'code' => $this->getCode(),
            'error' => $this->getError(),
            'response' => $this->getResponse(),
        ];
    }
}