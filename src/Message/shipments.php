<?php

namespace Sylapi\Courier\Inpost\Message;

/**
 * Class shipments
 * @package Sylapi\Courier\Inpost\Message
 */
class shipments
{
    /**
     * @var
     */
    private $data;

    /**
     * @param array $data
     * @return $this
     */
    public function prepareData($data = [])
    {
        $shippment = [
            'id'       => 'SHIPMENT1',
            'receiver' => [
                'email'      => $data['receiver']['email'],
                'phone'      => $data['receiver']['phone'],
                'first_name' => $data['receiver']['name'],
                'last_name'  => '',
                'address'    => [
                    'line1'        => $data['receiver']['street'],
                    'line2'        => '',
                    'city'         => $data['receiver']['city'],
                    'post_code'    => $data['receiver']['postcode'],
                    'country_code' => $data['receiver']['country'],
                ],
            ],
            'parcels' => [
                'dimensions' => [
                    'length' => $data['options']['depth'],
                    'width'  => $data['options']['width'],
                    'height' => $data['options']['height'],
                    'unit'   => 'cm',
                ],
                'weight' => [
                    'amount' => $data['options']['weight'],
                    'unit'   => 'kg',
                ],
            ],
            'reference' => $data['options']['references'],
            'comments'  => $data['options']['note'],
            'insurance' => [
                'amount'   => $data['options']['amount'],
                'currency' => (!empty($data['options']['currency'])) ? $data['options']['currency'] : 'PLN',
            ],
            'service'         => 'inpost_locker_standard',
            'is_non_standard' => (isset($data['options']['custom']['is_non_standard'])) ? $data['options']['custom']['is_non_standard'] : true,
        ];

        if ($data['options']['cod'] == true) {
            $shippment['cod'] = [
                'amount'   => $data['options']['amount'],
                'currency' => (!empty($data['options']['currency'])) ? $data['options']['currency'] : 'PLN',
            ];
        }

        if (!empty($data['options']['custom']['service'])) {
            $shippment['service'] = $data['options']['custom']['service'];
        }

        if (!empty($data['options']['custom']['external_customer_id'])) {
            $shippment['external_customer_id'] = $data['options']['custom']['external_customer_id'];
        }

        if (!empty($data['options']['custom']['target_point'])) {
            $shippment['custom_attributes']['target_point'] = $data['options']['custom']['target_point'];
        }

        $this->data['shipments'][] = $shippment;

        return $this;
    }

    /**
     * @param int $organization_id
     * @return string
     */
    public function getUri($organization_id = 1)
    {
        return '/v1/organizations/'.$organization_id.'/shipments/calculate';
    }
}
