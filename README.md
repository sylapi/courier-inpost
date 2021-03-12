# Courier-inpost

![StyleCI](https://github.styleci.io/repos/251561035/shield?style=flat&style=flat) ![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen.svg?style=flat) [![Build](https://github.com/sylapi/courier-inpost/actions/workflows/build.yaml/badge.svg?event=push)](https://github.com/sylapi/courier-inpost/actions/workflows/build.yaml) [![codecov.io](https://codecov.io/github/sylapi/courier-inpost/coverage.svg)](https://codecov.io/github/sylapi/courier-inpost/)

## Methody

### Init

```php
    $courier = CourierFactory::create('Inpost', [
        'token'     => 'mytoken',
        'organization_id'  => 'myorganizationid',
        'sandbox'   => true,
        'labelType' => 'normal', //normal lub A6
        // 'dispatch_point_id' => '1234567890', // lub Adres (dispatch_point)
        'dispatch_point' => [
            'street' => 'Street',
            'building_number' => '2',
            'city' => 'City',
            'post_code' => '11-222',
            'country_code' => 'PL',
            'service' => InpostServices::COURIER_STANDARD,
            // lub paczkomat
            // 'service' => InpostServices::LOCKER_STANDARD,
            // 'target_point' => 'KRA010'
        ]
    ]);
```

### CreateShipment

```php
    /**
     * Init Courier
     */
    $sender = $courier->makeSender();
    $sender->setFullName('Nazwa Firmy/Nadawca')
        ->setStreet('Ulica')
        ->setHouseNumber('2a')
        ->setApartmentNumber('1')
        ->setCity('Miasto')
        ->setZipCode('66-100')
        ->setCountry('Poland')
        ->setCountryCode('PL')
        ->setContactPerson('Jan Kowalski')
        ->setEmail('login@email.com')
        ->setPhone('48500600700');

    $receiver = $courier->makeReceiver();
    $receiver->setFirstName('Jan')
        ->setSurname('Nowak')
        ->setStreet('Ulica')
        ->setHouseNumber('15')
        ->setApartmentNumber('1896')
        ->setCity('Miasto')
        ->setZipCode('70-200')
        ->setCountry('Poland')
        ->setCountryCode('PL')
        ->setContactPerson('Jan Kowalski')
        ->setEmail('login@email.com')
        ->setPhone('48500600700');

    $parcel = $courier->makeParcel();
    $parcel->setWeight(2)
        ->setLength(8)
        ->setWidth(36)
        ->setHeight(64);

    $shipment = $courier->makeShipment();
    $shipment->setSender($sender)
        ->setReceiver($receiver)
        ->setParcel($parcel)
        ->setContent('Zawartość przesyłki');

    try {
        $response = $courier->createShipment($shipment);
        if ($response->hasErrors()) {
            var_dump($response->getFirstError()->getMessage());
        } else {
            var_dump($response->shipmentId); // Zewnetrzny idetyfikator zamowienia
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
```

### PostShipment

```php
    /**
     * Init Courier
     */
    $booking = $courier->makeBooking();
    $booking->setShipmentId('123456');
    try {
        $response = $courier->postShipment($booking);
        if($response->hasErrors()) {
            var_dump($response->getFirstError()->getMessage());
        } else {
            var_dump($response->shipmentId); // Zewnetrzny idetyfikator zamowienia
            var_dump($response->trackingId); // Zewnetrzny idetyfikator sledzenia przesylki
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
```

### GetStatus

```php
    /**
     * Init Courier
     */
    try {
        $response = $courier->getStatus('123456');
        if($response->hasErrors()) {
            var_dump($response->getFirstError()->getMessage());
        } else {
            var_dump((string) $response);
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
```


### GetLabel

```php
    /**
     * Init Courier
     */
    try {
        $response = $courier->getLabel('123456');
        if($response->hasErrors()) {
            var_dump($response->getFirstError()->getMessage());
        } else {
            var_dump((string) $response);
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
```

## Komendy

| KOMENDA | OPIS |
| ------ | ------ |
| composer tests | Testy |
| composer phpstan |  PHPStan |
| composer coverage | PHPUnit Coverage |
| composer coverage-html | PHPUnit Coverage HTML (DIR: ./coverage/) |
