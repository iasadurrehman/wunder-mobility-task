<?php

namespace App\Services\PaymentDataService;

use App\Services\HttpBaseService;

class PaymentDataService extends HttpBaseService
{
    public function savePaymentInfo(Array $infoArray){
        return self::post('/default/wunderfleet-recruiting-backend-dev-save-payment-data',
            $infoArray);
    }
}
