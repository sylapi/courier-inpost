<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Exception;
use Sylapi\Courier\Entities\Status;
use Sylapi\Courier\Enums\StatusType;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Helpers\ResponseHelper;
use Sylapi\Courier\Contracts\CourierGetStatuses;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Inpost\InpostResponseErrorHelper;
use Sylapi\Courier\Contracts\Status as StatusContract;

class InpostCourierGetStatuses implements CourierGetStatuses
{
    private $session;

    const API_PATH_TRACKING = '/v1/tracking/:tracking_number';
    const API_PATH = '/v1/organizations/:organization_id/shipments/?tracking_number=:shipment_id';

    public function __construct(InpostSession $session)
    {
        $this->session = $session;
    }

    public function getStatus(string $shipmentId): StatusContract
    {
        try {
            return $this->getStatusByShipmentId($shipmentId);
        } catch (ClientException $e) {
            $excaption = new TransportException(InpostResponseErrorHelper::message($e));
            $status = new Status(StatusType::APP_RESPONSE_ERROR);
            ResponseHelper::pushErrorsToResponse($status, [$excaption]);
            return $status;                        
        } catch (Exception $e) {
            $excaption = new TransportException($e->getMessage(), $e->getCode());
            $status = new Status(StatusType::APP_RESPONSE_ERROR);
            ResponseHelper::pushErrorsToResponse($status, [$excaption]);

            return $status;
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

    private function getStatusByShipmentId(string $shipmentId): Status
    {
        $stream = $this->session
            ->client()
            ->get($this->getPathByShipmentId([
                ':shipment_id'     => $shipmentId,
                ':organization_id' => $this->session->parameters()->organization_id,
            ]));

        $result = json_decode($stream->getBody()->getContents());

        $statusName = (isset($result->items[0]->status))
            ? new InpostStatusTransformer((string) $result->items[0]->status)
            : StatusType::APP_RESPONSE_ERROR;

        return new Status((string) $statusName);
    }

    private function getStatusByTrackingId(string $shipmentId): Status
    {
        $stream = $this->session
        ->client()
        ->get($this->getPathByTrackingId($shipmentId));

        $result = json_decode($stream->getBody()->getContents());

        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Json data is incorrect');
        }

        return new Status((string) new InpostStatusTransformer((string) $result->status));
    }
}
