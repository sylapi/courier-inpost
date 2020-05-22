<?php

namespace Sylapi\Courier\Inpost\Message;

class dispatchOrders
{
    private $data;
    private $response;

    public function prepareData($data = [])
    {
        $this->data = [
            'shipments' => [
                $data['custom_id'],
            ],
            'address' => [
                'street'          => $data['sender']['street'],
                'building_number' => $data['sender']['building_number'],
                'city'            => $data['sender']['city'],
                'post_code'       => $data['sender']['postcode'],
                'country_code'    => $data['sender']['country'],
            ],
        ];

        if (!empty($data['custom']['dispatch_point_id'])) {
            $this->data['dispatch_point_id'] = $data['custom']['dispatch_point_id'];
            unset($this->data['address']);
        }

        return $this;
    }

    public function send($connect)
    {
        $uri = '/v1/organizations/'.$connect->organization_id.'/dispatch_orders';
        $this->response = $connect->call($uri, $this->data, 'POST');
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
        if (!isset($this->response['error'])) {
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
