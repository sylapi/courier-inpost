<?php

namespace Sylapi\Courier\Inpost\Message;

/**
 * Class getPackage.
 */
class getPackage
{
    /**
     * @var
     */
    private $data;

    /**
     * @param array $data
     *
     * @return $this
     */
    public function prepareData($data = [])
    {
        $this->data = [
            'tracking_id' => (string) $data['tracking_id'],
            'custom_id'   => $data['custom_id'],
        ];

        return $this;
    }

    /**
     * @param $connect
     */
    public function send($connect)
    {
        $uri = '/v1/organizations/'.$connect->organization_id.'/shipments';

        if (!empty($this->data['tracking_id'])) {
            $uri .= '?tracking_number='.$this->data['tracking_id'];
        } else {
            if (!empty($this->data['custom_id'])) {
                $uri .= '?id='.$this->data['custom_id'];
            }
        }

        $this->response = $connect->call($uri, [], 'GET');
    }

    /**
     * @return |null
     */
    public function getResponse()
    {
        if ($this->isSuccess() == true) {
            $package = $this->response['items'][0];
            $package['tracking_id'] = $package['tracking_number'];

            return $package;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        if (!isset($this->response['error'])) {
            if ($this->response['count'] == 1) {
                return true;
            }
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
