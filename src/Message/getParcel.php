<?php

namespace Sylapi\Courier\Inpost\Message;

/**
 * Class getParcel.
 */
class getParcel
{
    /**
     * @var
     */
    private $data;
    /**
     * @var string
     */
    private $uri = 'http://api.paczkomaty.pl/?do=listmachines_xml';

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
        $curl = curl_init($this->uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        if (!empty($result)) {
            $xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);

            foreach ($xml->machine as $machine) {
                $this->data['machines'][] = [
                    'name'     => (string) $machine->name,
                    'city'     => (string) $machine->town,
                    'street'   => (string) $machine->street.' '.$machine->buildingnumber,
                    'postcode' => (string) $machine->postcode,
                ];
            }
        }

        $this->response = $this->data['machines'];
    }

    /**
     * @return |null
     */
    public function getResponse()
    {
        if (empty($this->response['error']) && isset($this->response)) {
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
