<?php
namespace Sylapi\Courier\Inpost\Message;

class getParcel
{
    private $data;
    private $uri = 'http://api.paczkomaty.pl/?do=listmachines_xml';

    public function prepareData($data=[]) {

        $this->data = $data;
        return $this;
    }

    public function send($connect) {

        $curl = curl_init($this->uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        if (!empty($result)) {
            $xml = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);

            foreach($xml->machine as $machine) {

                $this->data['machines'][] = [
                    'name' => (String)$machine->name,
                    'city' => (String)$machine->town,
                    'street' => (String)$machine->street.' '.$machine->buildingnumber,
                    'postcode' => (String)$machine->postcode,
                ];
            }
        }

        $this->response = $this->data['machines'];
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