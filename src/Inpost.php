<?php
namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Inpost\Message\createShipment;
use Sylapi\Courier\Inpost\Message\getLabel;
use Sylapi\Courier\Inpost\Message\shipmentsCalculate;

class Inpost extends Connect
{
    protected $session;

    public function initialize($parameters) {

        $this->parameters = $parameters;

        if (!empty($parameters['accessData'])) {

            $this->setLogin($parameters['accessData']['login']);
            $this->setToken($parameters['accessData']['token']);
        }
        else {
            $this->setError('Access Data is empty');
        }
    }

    public function ValidateData() {

        $shipment = new shipmentsCalculate();
        $shipment->prepareData($this->parameters);
        $shipment->send($this);

        if ($shipment->isSuccess()) {
            $response = true;
        }
        else {
            $response = false;
        }

        $this->setResponse($response);
        $this->setError($shipment->getError());
    }

    public function GetLabel() {

        if (empty($this->parameters['custom_id'])) {

            $getLabel = new getLabel();
            $getLabel->prepareData($this->parameters);
            $getLabel->send($this);

            $this->setResponse($getLabel->getResponse());
            $this->setError($getLabel->getError());

            if ($getLabel->isSuccess()) {

                $data = $this->getResponse();

                $this->setResponse($data);
            }
        }
    }

    public function CreatePackage() {

        $shipment = new createShipment();
        $shipment->prepareData($this->parameters);
        $shipment->send($this);

        $response = $shipment->getResponse();

        if ($shipment->isSuccess()) {
            $response['custom_id'] = $response['custom_id'];
        }

        $this->setResponse($response);
        $this->setError($shipment->getError());
    }

    public function CheckPrice() {

        $shipment = new shipmentsCalculate();
        $shipment->prepareData($this->parameters);
        $shipment->send($this);

        $response = $shipment->getResponse();

        if ($shipment->isSuccess()) {
            $response['price'] = $response['calculated_charge_amount'];
        }

        $this->setResponse($response);
        $this->setError($shipment->getError());
    }


}