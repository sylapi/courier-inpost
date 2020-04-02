# Sylapi/Courier-inpost

**Courier library**

## Installation

Courier to install, simply add it to your `composer.json` file:

```json
{
    "require": {
        "sylapi/courier-inpost": "~1.0"
    }
}
```


## Shipping information:
```php

$courier = new Courier('Inpost');

$courier->sandbox(true);
$courier->setLogin('10001'); // ID organizacji
$courier->setToken('abcdef-123456'); // Token

$address = [
    'name' => 'Name Lastname',
    'company' => 'Company Name',
    'street' => 'Street 123/2A',
    'postcode' => '12-123',
    'city' => 'Warszawa',
    'country' => 'PL',
    'phone' => '602602602',
    'email' => 'name@example.com'
];

$courier->setSender($address);
$courier->setReceiver($address);

$courier->setOptions([
        'weight' => 3.00,
        'width' => 30.00,
        'height' => 50.00,
        'depth' => 10.00,
        'amount' => 2390.10,
        'currency' => 'PLN',
        'cod' => true,
        'references' => 'order #4567',
        'note' => 'Note',
        'custom' => [
            'is_non_standard' => true,
            'service' => 'inpost_locker_standard',
            'external_customer_id' => 12345,
            'target_point' => ''
        ],
    ]);
```