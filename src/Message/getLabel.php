<?php
namespace Sylapi\Courier\Inpost\Message;

use Sylapi\Courier\Inpost\Message\searchShipment;

class getLabel
{
    private $data;
    private $types = ['pdf', 'zpl', 'epl'];

    public function prepareData($data=[]) {

        $this->data = [
            'tracking_id' => $data['tracking_id'],
            'custom_id' => $data['custom_id'],
            'type' => (!empty($this->data['type'])) ? $this->data['type'] : $this->types[0],
            'format' => (!empty($this->data['format'])) ? $this->data['format'] : 'A6',
        ];

        return $this;
    }

    public function send($connect) {

        if (empty($this->data['custom_id']) && !empty($this->data['tracking_id'])) {

            $searchShipment = new searchShipment();
            $searchShipment->prepareData(['tracking_number' => $this->data['tracking_id']]);
            $searchShipment->send($connect);

            if ($searchShipment->isSuccess()) {

                $response = $searchShipment->getResponse();
                if (count($response['items']) == 1) {

                    $this->data['custom_id'] = $response['items'][0]['id'];
                }
            }
        }

        pr($this->data);

        echo $uri = '/v1/shipments/' . $this->data['custom_id'] . '/label?type='.$this->data['type'];
        echo $this->response = $connect->call($uri, [], 'GET', true);
    }

    public function getResponse() {
        if (empty($this->response['error']) && isset($this->response)) {
            return $this->response;
        }
        return null;
    }

    public function isSuccess() {
        if (!isset($this->response['error'])) {
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