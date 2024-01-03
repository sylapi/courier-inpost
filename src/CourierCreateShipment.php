<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Exception;
use Sylapi\Courier\Contracts\Shipment;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Inpost\Helpers\ResponseErrorHelper;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Contracts\CourierCreateShipment as CourierCreateShipmentContract;
use Sylapi\Courier\Inpost\Responses\Shipment as ShipmentResponse;

class CourierCreateShipment implements CourierCreateShipmentContract
{
    private $session;

    const API_PATH = '/v1/organizations/:organization_id/shipments';

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getShipmentId(string $trackingId): ResponseContract
    {
        $response = new ShipmentResponse();
        $response->setTrackingId($trackingId);

        try {
            $stream = $this->session
            ->client()
            ->request(
                'GET',
                $this->getPath($this->session->getOrganizationId()),
                [
                    'form_params' => [
                        'tracking_number' => $trackingId,
                    ],
                ]
            );

            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Json data response is incorrect');
            }

            if (!(
                isset($result->items)
                    && is_array($result->items)
                    && count($result->items) === 1
                    && isset($result->items[0]->id)
                    && isset($result->items[0]->tracking_number)
                    && (string) $result->items[0]->tracking_number === (string) $trackingId
            )
            ) {
                throw new Exception('Shipment (tracking_id: '.$trackingId.') does not exist.');
            }

            $response->setResponse($result);
            $response->setShipmentId($result->items[0]->id);
        } catch (ClientException $e) {
            throw new TransportException(ResponseErrorHelper::message($e));

            return $response;
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        return $response;
    }

    public function getTrackingId(string $shipmentId): ResponseContract
    {
        $response = new ShipmentResponse();

        $response->setShipmentId($shipmentId);

        try {
            $stream = $this->session
            ->client()
            ->request(
                'GET',
                $this->getPath($this->session->getOrganizationId()),
                [
                    'form_params' => [
                        'id' => $shipmentId,
                    ],
                ]
            );

            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Json data response is incorrect');
            }

            if (!(
                isset($result->items)
                    && is_array($result->items)
                    && count($result->items) === 1
                    && isset($result->items[0]->tracking_number)
                    && isset($result->items[0]->id)
                    && (string) $result->items[0]->id === (string) $shipmentId
            )

            ) {
                throw new Exception('Shipment (id: '.$shipmentId.') does not exist.');
            }
            $response->setResponse($result);
            $response->setTrackingId($result->items[0]->tracking_number);
        } catch (ClientException $e) {
            throw new TransportException(ResponseErrorHelper::message($e));
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        return $response;
    }

    public function createShipment(Shipment $shipment): ResponseContract
    {
        $response = new ShipmentResponse();
        try {
            $request = $this->getShipment($shipment);
            $stream = $this->session
                ->client()
                ->request(
                    'POST',
                    $this->getPath($this->session->getOrganizationId()),
                    ['json' => $request]
                );

            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Json data response is incorrect');
            }
            $response->setShipmentId($result->id);
        } catch (ClientException $e) {
            throw new TransportException(ResponseErrorHelper::message($e));
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
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
                'address'       => [
                    'street'            => $shipment->getReceiver()->getStreet(),
                    'building_number'   => $shipment->getReceiver()->getHouseNumber().' '.$shipment->getReceiver()->getApartmentNumber(),
                    'city'              => $shipment->getReceiver()->getCity(),
                    'post_code'         => $shipment->getReceiver()->getZipCode(),
                    'country_code'      => $shipment->getReceiver()->getCountryCode(),
                ],
            ],
            'sender' => [
                'company_name'  => $shipment->getSender()->getFullName(),
                'email'         => $shipment->getSender()->getEmail(),
                'phone'         => $shipment->getSender()->getPhone(),
                'address'       => [
                    'street'            => $shipment->getSender()->getStreet(),
                    'building_number'   => $shipment->getSender()->getHouseNumber().' '.$shipment->getSender()->getApartmentNumber(),
                    'city'              => $shipment->getSender()->getCity(),
                    'post_code'         => $shipment->getSender()->getZipCode(),
                    'country_code'      => $shipment->getSender()->getCountryCode(),
                ],
            ],
            'parcels' => [
                [
                    'dimensions' => [
                        'length' => $shipment->getParcel()->getLength(),
                        'width'  => $shipment->getParcel()->getWidth(),
                        'height' => $shipment->getParcel()->getHeight(),
                    ],
                    'weight' => [
                        'amount' => $shipment->getParcel()->getWeight(),
                    ],
                ],
            ],
            'reference' => $shipment->getContent(),
            // 'service'   => $this->session->parameters()->getService(), //TODO: add service
        ];

        //TODO: add service
        /*
        if ($this->session->parameters()->hasProperty('target_point')) {
            $data['custom_attributes']['target_point'] = $this->session->parameters()->target_point;
        }

        if ($this->session->parameters()->hasProperty('cod') && is_array($this->session->parameters()->cod)) {
            $data['cod'] = $this->session->parameters()->cod;
        }

        if ($this->session->parameters()->hasProperty('insurance') && is_array($this->session->parameters()->insurance)) {
            $data['insurance'] = $this->session->parameters()->insurance;
        }
        */

        return $data;
    }

    private function getPath(string $value)
    {
        return str_replace(':organization_id', $value, self::API_PATH);
    }
}
