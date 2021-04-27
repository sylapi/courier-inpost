<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Contracts\CourierPostShipment;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Entities\Response;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Helpers\ResponseHelper;

class InpostCourierPostShipment implements CourierPostShipment
{
    const API_PATH = '/v1/organizations/:organization_id/dispatch_orders';

    private $session;

    public function __construct(InpostSession $session)
    {
        $this->session = $session;
    }

    public function postShipment(Booking $booking): ResponseContract
    {
        $response = new Response();

        try {
            $request = [
                'shipments' => [$booking->getShipmentId()],
            ];
            $request = array_merge($request, $this->session->parameters()->getDispatchPoint());

            $stream = $this->session
                ->client()
                ->post(
                    $this->getPath($this->session->parameters()->organization_id),
                    [
                        'json' => $request,
                    ]
                );

            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Json data is incorrect');
            }

            $response->shipmentId = $booking->getShipmentId();
            $shipment = $result->shipments[0] ?? null;
            $response->trackingId = $shipment->tracking_number ?? null;
        } catch (ClientException $e) {
            $excaption = new TransportException(InpostResponseErrorHelper::message($e));
            ResponseHelper::pushErrorsToResponse($response, [$excaption]);

            return $response;
        } catch (Exception $e) {
            $excaption = new TransportException($e->getMessage(), $e->getCode());
            ResponseHelper::pushErrorsToResponse($response, [$excaption]);
        }

        return $response;
    }

    private function getPath(string $value)
    {
        return str_replace(':organization_id', $value, self::API_PATH);
    }
}
