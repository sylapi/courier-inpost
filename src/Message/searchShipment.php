<?php

namespace Sylapi\Courier\Inpost\Message;

class searchShipment
{
    private $data;
    private $response;

    public function prepareData($data = [])
    {
        $this->data = $data;

        return $this;
    }

    public function send($connect)
    {
        $uri = '/v1/organizations/'.$connect->organization_id.'/shipments';

        if (!empty($this->data['tracking_number'])) {
            $uri .= '?tracking_number='.$this->data['tracking_number'];
        } else {
            if (!empty($this->data['custom_id'])) {
                $uri .= '?id='.$this->data['custom_id'];
            }
        }

        $this->response = $connect->call($uri, [], 'GET');
    }

    public function getResponse()
    {
        if (empty($this->response['error']) && isset($this->response)) {
            return $this->response;
        }

        return null;
    }

    public function isSuccess()
    {
        if (!($this->response['error'])) {
            return true;
        }

        return false;
    }

    public function getError()
    {
        return (!empty($this->response['error'])) ? $this->response['error'].': '.$this->response['message'] : null;
    }

    public function getCode()
    {
        return (!empty($this->response['status'])) ? $this->response['status'] : 0;
    }
}
