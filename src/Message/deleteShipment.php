<?php

namespace Sylapi\Courier\Inpost\Message;

/**
 * Class deleteShipment.
 */
class deleteShipment
{
    /**
     * @var
     */
    private $data;
    /**
     * @var
     */
    private $response;

    /**
     * @param array $data
     *
     * @return $this
     */
    public function prepareData($data = [])
    {
        $this->data = $data;

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

        $uri = '/v1/shipments/'.$this->data['custom_id'];
        $this->response = $connect->call($uri, $this->data, 'DELETE');
    }

    /**
     * @return null
     */
    public function getResponse()
    {
        if (!isset($this->response['error']) && isset($this->response)) {
            return $this->response;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        if (empty($this->response['error'])) {
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
