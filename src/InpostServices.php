<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Abstracts\Enum;

class InpostServices extends Enum
{
    const COURIER_STANDARD = 'inpost_courier_standard'; //Przesyłka kurierska standardowa
    const COURIER_EXPRESS_1000 = 'inpost_courier_express_1000'; //Przesyłka kurierska z doręczeniem do 10:00
    const COURIER_EXPRESS_1200 = 'inpost_courier_express_1200'; //Przesyłka kurierska z doręczeniem do 12:00
    const COURIER_EXPRESS_1700 = 'inpost_courier_express_1700'; //Przesyłka kurierska z doręczeniem do 12:00
    const COURIER_PALETTE = 'inpost_courier_palette'; //Przesyłka kurierska Paleta Standard
    const COURIER_LOCAL_STANDARD = 'inpost_courier_local_standard'; //Przesyłka kurierska Lokalna Standardowa	
    const COURIER_LOCAL_EXPRESS = 'inpost_courier_local_express'; //Przesyłka kurierska Lokalna Expresowa
    const COURIER_LOCAL_SUPER_EXPRESS = 'inpost_courier_local_super_express'; //Przesyłka kurierska Lokalna Super Expresowa
    const LOCKER_STANDARD = 'inpost_locker_standard'; //Przesyłka paczkomatowa - standardowa
}
