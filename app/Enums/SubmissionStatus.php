<?php

namespace App\Enums;

enum SubmissionStatus: string {
    case Pending = 'pending';
    case Pass = 'lolos';
    case Failed = 'tidak lolos';
}