<?php
namespace Sylapi\Courier\Inpost\Message;

class createShipment
{
    private $data;
    private $response;

    public function prepareData($data=[]) {

        $this->data = null;

        $shippment = [
            'id' => "SHIPMENT2",
            'receiver' => [
                'email' => $data['receiver']['email'],
                'phone' => $data['receiver']['phone'],
                'first_name' => $data['receiver']['name'],
                'last_name' => '',
                'address' => [
                    'line1' => $data['receiver']['street'],
                    'line2' => '',
                    'city' => $data['receiver']['city'],
                    'post_code' => $data['receiver']['postcode'],
                    'country_code' => $data['receiver']['country'],
                ]
            ],
            'sender' => [
                'email' => $data['sender']['email'],
                'phone' => $data['sender']['phone'],
                'first_name' => $data['sender']['name'],
                'last_name' => '',
                'address' => [
                    'line1' => $data['sender']['street'],
                    'line2' => '',
                    'city' => $data['sender']['city'],
                    'post_code' => $data['sender']['postcode'],
                    'country_code' => $data['sender']['country'],
                ]
            ],
            'parcels' => [
                'dimensions' => [
                    'length' => ($data['options']['depth'] * 10),
                    'width' => ($data['options']['width'] * 10),
                    'height' => ($data['options']['height'] * 10),
                    'unit' => 'mm'
                ],
                'weight' => [
                    'amount' => $data['options']['weight'],
                    'unit' => 'kg'
                ]
            ],
            'reference' => $data['options']['references'],
            'comments' => $data['options']['note'],
            'insurance' => [
                'amount' => $data['options']['amount'],
                'currency' => (!empty($data['options']['currency'])) ? $data['options']['currency'] : 'PLN'
            ],
            'service' => (!empty($data['options']['custom']['service'])) ? $data['options']['custom']['service'] : 'inpost_locker_standard',
            'is_non_standard' => (isset($data['options']['custom']['is_non_standard'])) ? $data['options']['custom']['is_non_standard'] : true
        ];

        if ($data['options']['cod'] == true) {

            $shippment['cod'] = [
                'amount' => $data['options']['amount'],
                'currency' => (!empty($data['options']['currency'])) ? $data['options']['currency'] : 'PLN'
            ];
        }


        if (!empty($data['options']['custom']['external_customer_id'])) {
            $shippment['external_customer_id'] = $data['options']['custom']['external_customer_id'];
        }

        if (!empty($data['options']['custom']['target_point'])) {
            $shippment['custom_attributes']['target_point'] = $data['options']['custom']['target_point'];
        }


        $this->data = $shippment;

        return $this;
    }

    public function send($connect) {

        $uri = '/v1/organizations/' . $connect->organization_id . '/shipments';
        $this->response = $connect->call($uri, $this->data, 'POST');
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
        if (!empty($this->response['error'])) {
            $error = $this->response['error'].': '.$this->response['message'];

            if (!empty($this->response['details'])) {

                $details = $this->response['details'];
                while(!empty($details)) {

                    $value = null;
                    foreach($details as $key => $v) {
                        $error .= ' => ' . $key;

                        $value = $v;
                        break;
                    }

                    $details = $value;
                }
            }

            return $error;
        }

        return null;
    }

    public function getCode() {
        return (!empty($this->response['status'])) ? $this->response['status'] : 0;
    }
}