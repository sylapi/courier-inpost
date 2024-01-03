<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Exception;
use Sylapi\Courier\Inpost\Responses\Label as LabelResponse;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Inpost\Helpers\ResponseErrorHelper;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Contracts\CourierGetLabels as CourierGetLabelsContract;
use Sylapi\Courier\Contracts\LabelType as LabelTypeContract;

class CourierGetLabels implements CourierGetLabelsContract
{
    const API_PATH = '/v1/shipments/:shipment_id/label';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getLabel(string $shipmentId, LabelTypeContract $labelType): ResponseContract
    {
        try {
            $stream = $this->session
                ->client()
                ->get(
                    $this->getPath($shipmentId),
                    [
                        'query' => [
                            'type' => $labelType->getLabelType(),
                        ],
                    ]
                );

            $result = $stream->getBody()->getContents();

            return new LabelResponse((string) $result);
        } catch (ClientException $e) {
            throw new TransportException(ResponseErrorHelper::message($e));
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }
    }

    private function getPath(string $value)
    {
        return str_replace(':shipment_id', $value, self::API_PATH);
    }
}
