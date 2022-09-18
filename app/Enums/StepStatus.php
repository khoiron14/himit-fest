<?php

namespace App\Enums;

enum StepStatus: string {
    case Step1 = 'step_1';
    case Step2 = 'step_2';
    case Step3 = 'step_3';
    case End = 'end';
}