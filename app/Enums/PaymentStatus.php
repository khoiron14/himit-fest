<?php

namespace App\Enums;

enum PaymentStatus: string {
    case Pending = 'pending';
    case Accept = 'accept';
    case Reject = 'reject';
}