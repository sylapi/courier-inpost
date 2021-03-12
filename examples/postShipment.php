<?php

$courier = CourierFactory::create('Inpost', [
    'token'            => 'mytoken',
    'organization_id'  => 'myorganizationid',
    'sandbox'          => true,
    'labelType'        => 'normal', //normal lub A6
    // 'dispatch_point_id' => '1234567890', // lub Adres (dispatch_point)
    'dispatch_point' => [
        'street'          => 'Street',
        'building_number' => '2',
        'city'            => 'City',
        'post_code'       => '11-222',
        'country_code'    => 'PL',
        'service'         => InpostServices::COURIER_STANDARD,
        // lub paczkomat
        // 'service' => InpostServices::LOCKER_STANDARD,
        // 'target_point' => 'KRA010'
    ],
]);

/**
 * PostShipment.
 */
$booking = $courier->makeBooking();
$booking->setShipmentId('123456');

try {
    $response = $courier->postShipment($booking);
    if ($response->hasErrors()) {
        var_dump($response->getFirstError()->getMessage());
    } else {
        var_dump($response->shipmentId); // Zewnetrzny idetyfikator zamowienia
        var_dump($response->trackingId); // Zewnetrzny idetyfikator sledzenia przesylki
    }
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
