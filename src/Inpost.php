<?php
namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Inpost\Message\createShipment;
use Sylapi\Courier\Inpost\Message\deleteShipment;
use Sylapi\Courier\Inpost\Message\getLabel;
use Sylapi\Courier\Inpost\Message\shipmentsCalculate;
use Sylapi\Courier\Inpost\Message\getParcel;

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

        $inpost = new shipmentsCalculate();
        $inpost->prepareData($this->parameters);
        $inpost->send($this);

        if ($inpost->isSuccess()) {
            $response = true;
        }
        else {
            $response = false;
        }

        $this->setResponse($response);
        $this->setError($inpost->getError());
    }

    public function GetLabel() {

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

    public function CreatePackage() {

        $inpost = new createShipment();
        $inpost->prepareData($this->parameters);
        $inpost->send($this);

        $response = $inpost->getResponse();

        if ($inpost->isSuccess()) {
            $response['custom_id'] = $response['custom_id'];
        }

        $this->setResponse($response);
        $this->setError($inpost->getError());
    }

    public function CheckPrice() {

        $inpost = new shipmentsCalculate();
        $inpost->prepareData($this->parameters);
        $inpost->send($this);

        $response = $inpost->getResponse();

        if ($inpost->isSuccess()) {
            $response['price'] = $response['calculated_charge_amount'];
        }

        $this->setResponse($response);
        $this->setError($inpost->getError());
    }

    public function DeletePackage() {

        $inpost = new deleteShipment();
        $inpost->prepareData($this->parameters);
        $inpost->send($this);

        $response = $inpost->getResponse();

        $this->setResponse($response);
        $this->setError($inpost->getError());
    }

    public function getParcel() {

        $inpost = new getParcel();
        $inpost->send($this);

        $response = $inpost->getResponse();

        $this->setResponse($response);
        $this->setError($inpost->getError());
    }
}