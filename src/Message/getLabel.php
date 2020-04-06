<?php
namespace Sylapi\Courier\Inpost\Message;

use Sylapi\Courier\Inpost\Message\searchShipment;

class getLabel
{
    private $data;
    private $format = ['pdf', 'zpl', 'epl'];

    public function prepareData($data=[]) {

        $this->data = [
            'tracking_id' => $data['tracking_id'],
            'custom_id' => $data['custom_id'],
            'type' => (!empty($data['format'])) ? $data['format'] : 'A6',
            'format' => (!empty($data['type'])) ? $data['type'] : $this->format[0],
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

        $uri = '/v1/shipments/' . $this->data['custom_id'] . '/label?type='.$this->data['type'].'&format='.$this->data['format'];
        $this->response = $connect->call($uri, [], 'GET', true);


        $check_response = json_decode($this->response, true);
        if (!empty($check_response)) {
            $this->response = $check_response;
        }
    }

    public function getResponse() {
        if ($this->isSuccess() == true) {
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