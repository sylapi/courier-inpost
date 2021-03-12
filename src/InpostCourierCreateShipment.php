<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Exception;
use Sylapi\Courier\Entities\Response;
use Sylapi\Courier\Contracts\Shipment;
use Sylapi\Courier\Inpost\InpostSession;
use Sylapi\Courier\Helpers\ResponseHelper;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\CourierCreateShipment;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class InpostCourierCreateShipment implements CourierCreateShipment
{
    private $session;

    const API_PATH = '/v1/organizations/:organization_id/shipments';

    public function __construct(InpostSession $session)
    {
        $this->session = $session;
    }

    public function createShipment(Shipment $shipment): ResponseContract
    {
        $response = new Response();

        try {
            $request = $this->getShipment($shipment);        
            $stream = $this->session
                ->client()
                ->request(
                    'POST',
                    $this->getPath($this->session->parameters()->organization_id ?? null), 
                    [ 'json' => $request ]
                );
            
            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Json data is incorrect');
            }
            $response->shipmentId = $result->id;
            $response->trackingId = null;
        } catch (Exception $e) {
            $excaption = new TransportException($e->getMessage(), $e->getCode());
            ResponseHelper::pushErrorsToResponse($response, [$excaption]);
        }
        return $response;
    }

    private function getShipment(Shipment $shipment): array
    {
        $data = [
            'receiver' => [
                'company_name'  => $shipment->getReceiver()->getFullName(),
                'first_name'    => $shipment->getReceiver()->getFirstName(),
                'last_name'     => $shipment->getReceiver()->getSurname(), 
                'email'         => $shipment->getReceiver()->getEmail(),
                'phone'         => $shipment->getReceiver()->getPhone(),
                'address' => [
                    'street'            => $shipment->getReceiver()->getStreet(),
                    'building_number'   => $shipment->getReceiver()->getHouseNumber().' '.$shipment->getReceiver()->getApartmentNumber(),
                    'city'              => $shipment->getReceiver()->getCity(),
                    'post_code'         => $shipment->getReceiver()->getZipCode(),
                    'country_code'      => $shipment->getReceiver()->getCountryCode(),                
                ]
            ],
            'sender' => [
                'company_name'  => $shipment->getSender()->getFullName(),
                'email'         => $shipment->getSender()->getEmail(),
                'phone'         => $shipment->getSender()->getPhone(),
                'address' => [
                    'street'            => $shipment->getSender()->getStreet(),
                    'building_number'   => $shipment->getSender()->getHouseNumber().' '.$shipment->getSender()->getApartmentNumber(),
                    'city'              => $shipment->getSender()->getCity(),
                    'post_code'         => $shipment->getSender()->getZipCode(),
                    'country_code'      => $shipment->getSender()->getCountryCode(),                
                ]
            ],
            'parcels' => [
                [
                    'dimensions' => [
                        'length' => $shipment->getParcel()->getLength(),
                        'width' => $shipment->getParcel()->getWidth(),
                        'height' => $shipment->getParcel()->getHeight(),
                    ],
                    'weight' => [
                        'amount' => $shipment->getParcel()->getWeight(),
                    ],
                ]
            ],
            'reference' => $shipment->getContent(),
            'service' => $this->session->parameters()->getService(),
        ];

        if($this->session->parameters()->hasProperty('target_point')) {
            $data['custom_attributes']['target_point'] = $this->session->parameters()->target_point;
        }

        return $data;
    }

    private function getPath(string $value)
    {
        return str_replace(':organization_id', $value, self::API_PATH);
    }
}
