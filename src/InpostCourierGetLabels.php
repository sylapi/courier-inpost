<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Exception;
use Sylapi\Courier\Entities\Label;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Helpers\ResponseHelper;
use Sylapi\Courier\Contracts\CourierGetLabels;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\Label as LabelContract;
use Sylapi\Courier\Inpost\InpostResponseErrorHelper;

class InpostCourierGetLabels implements CourierGetLabels
{
    const API_PATH = '/v1/shipments/:shipment_id/label';

    private $session;

    public function __construct(InpostSession $session)
    {
        $this->session = $session;
    }

    public function getLabel(string $shipmentId): LabelContract
    {
        try {
            $stream = $this->session
                ->client()
                ->get(
                    $this->getPath($shipmentId),
                    [
                        'query' => [
                            'type' => $this->session->parameters()->getLabelType(),
                        ],
                    ]
                );

            $result = $stream->getBody()->getContents();

            return new Label((string) $result);

        } catch (ClientException $e) {
            $excaption = new TransportException(InpostResponseErrorHelper::message($e));
            $label = new Label(null);
            ResponseHelper::pushErrorsToResponse($label, [$excaption]);
            return $label;                                    
        } catch (Exception $e) {
            $excaption = new TransportException($e->getMessage(), $e->getCode());
            $label = new Label(null);
            ResponseHelper::pushErrorsToResponse($label, [$excaption]);
            return $label;
        }
    }

    private function getPath(string $value)
    {
        return str_replace(':shipment_id', $value, self::API_PATH);
    }
}
