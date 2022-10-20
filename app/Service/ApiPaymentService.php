<?php
declare(strict_types=1);

namespace App\Service;

class ApiPaymentService
{

    /**
     * @return int
     */
    public function payment(int $price): int
    {
        return rand(0, 1);
    }

}
