<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Exception;
use Sylapi\Courier\Enums\StatusType;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Inpost\Helpers\ResponseErrorHelper;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Inpost\Responses\Status as StatusResponse;
use Sylapi\Courier\Contracts\CourierGetStatuses as CourierGetStatusesContract;

class CourierGetStatuses implements CourierGetStatusesContract
{
    private $session;

    const API_PATH_TRACKING = '/v1/tracking/:tracking_number';
    const API_PATH = '/v1/organizations/:organization_id/shipments/?tracking_number=:shipment_id';

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getStatus(string $shipmentId): ResponseContract
    {
        try {
            return $this->getStatusByShipmentId($shipmentId);
        } catch (ClientException $e) {
            throw new TransportException(ResponseErrorHelper::message($e));
        } catch (Exception $e) {
           throw new TransportException($e->getMessage(), $e->getCode());
        }
    }

    private function getPathByShipmentId(array $values)
    {
        return str_replace(array_keys($values), array_values($values), self::API_PATH);
    }

    private function getPathByTrackingId(string $value)
    {
        return str_replace(':tracking_number', $value, self::API_PATH_TRACKING);
    }

    private function getStatusByShipmentId(string $shipmentId): StatusResponse
    {
        $stream = $this->session
            ->client()
            ->get($this->getPathByShipmentId([
                ':shipment_id'     => $shipmentId,
                ':organization_id' => $this->session->organizationId(),
            ]));

        $result = json_decode($stream->getBody()->getContents());

        $statusName = (isset($result->items[0]->status))
            ? new StatusTransformer((string) $result->items[0]->status)
            : StatusType::APP_RESPONSE_ERROR;


        return new StatusResponse((string) new StatusTransformer((string) $statusName));
    }

    private function getStatusByTrackingId(string $shipmentId): StatusResponse
    {
        $stream = $this->session
        ->client()
        ->get($this->getPathByTrackingId($shipmentId));

        $result = json_decode($stream->getBody()->getContents());

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Json data is incorrect');
        }

        return new StatusResponse((string) new StatusTransformer((string) $result->status));
    }
}
