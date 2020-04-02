<?php
namespace Sylapi\Courier\Inpost\Message;

class createShipment
{
    private $data;
    private $response;

    public function prepareData($data=[]) {

        $this->data = $data;
        return $this;
    }

    public function send($connect) {

        pr($this->data);

        $uri = '/v1/shipments/' . $connect->organization_id;
        $this->response = $connect->call($uri, $this->data, 'DELETE');
    }

    public function getResponse() {
        if (empty($this->response['error']) && isset($this->response)) {
            return $this->response;
        }
        return null;
    }

    public function isSuccess() {
        if (!($this->response['error'])) {
            return true;
        }
        return false;
    }

    public function getError() {
        return (!empty($this->response['error'])) ? $this->response['error'].': '.$this->response['message'] : null;
    }

    public function getCode() {
        return (!empty($this->response['status'])) ? $this->response['status'] : 0;
    }
}