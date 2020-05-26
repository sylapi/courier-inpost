<?php

namespace Sylapi\Courier\Inpost\Message;

/**
 * Class getLabel
 * @package Sylapi\Courier\Inpost\Message
 */
class getLabel
{
    /**
     * @var
     */
    private $data;
    /**
     * @var array
     */
    private $format = ['pdf', 'zpl', 'epl'];

    /**
     * @param array $data
     * @return $this
     */
    public function prepareData($data = [])
    {
        $this->data = [
            'tracking_id' => $data['tracking_id'],
            'custom_id'   => $data['custom_id'],
            'type'        => (!empty($data['format'])) ? $data['format'] : 'A6',
            'format'      => (!empty($data['type'])) ? $data['type'] : $this->format[0],
        ];

        return $this;
    }

    /**
     * @param $connect
     */
    public function send($connect)
    {
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

        $uri = '/v1/shipments/'.$this->data['custom_id'].'/label?type='.$this->data['type'].'&format='.$this->data['format'];
        $this->response = $connect->call($uri, [], 'GET', true);

        $check_response = json_decode($this->response, true);
        if (!empty($check_response)) {
            $this->response = $check_response;
        }
    }

    /**
     * @return |null
     */
    public function getResponse()
    {
        if ($this->isSuccess() == true) {
            return $this->response;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        if (!isset($this->response['error'])) {
            return true;
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return (!empty($this->response['error'])) ? $this->response['error'].': '.$this->response['message'] : null;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return (!empty($this->response['status'])) ? $this->response['status'] : 0;
    }
}
