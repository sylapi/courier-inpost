<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Exception;
use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Inpost\Responses\Parcel as ParcelResponse;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Inpost\Helpers\ResponseErrorHelper;
use Sylapi\Courier\Contracts\CourierPostShipment as CourierPostShipmentContract;
use Sylapi\Courier\Responses\Parcel as ResponseParcel;

class CourierPostShipment implements CourierPostShipmentContract
{
    const API_PATH = '/v1/organizations/:organization_id/dispatch_orders';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function postShipment(Booking $booking): ResponseParcel
    {
        $response = new ParcelResponse();

        try {
            $request = [
                'shipments' => [$booking->getShipmentId()],
            ];
            /**
             * @var \Sylapi\Courier\Inpost\Entities\Booking $booking
             */
            $request = array_merge($request, $booking->getDispatchPointAddress());

            $stream = $this->session
                ->client()
                ->post(
                    $this->getPath($this->session->organizationId()),
                    [
                        'json' => $request,
                    ]
                );

            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Json data is incorrect');
            }

            $shipment = $result->shipments[0] ?? null;
            
            $response->setResponse($result);
            $response->setShipmentId((string) $booking->getShipmentId());
            $response->setTrackingId($shipment->tracking_number ?? null);

        } catch (ClientException $e) {
            throw new TransportException(ResponseErrorHelper::message($e));
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        return $response;
    }

    private function getPath(string $value)
    {
        return str_replace(':organization_id', $value, self::API_PATH);
    }
}
