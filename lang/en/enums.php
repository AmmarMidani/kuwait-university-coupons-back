<?php

use App\Enums\GenderLookupType;
use App\Enums\GenderType;

return [
    GenderType::class => [
        GenderType::Male => 'Male',
        GenderType::Female => 'Female',
    ],

    GenderLookupType::class => [
        GenderLookupType::Male => 'Male',
        GenderLookupType::Female => 'Female',
        GenderLookupType::Both => 'Both (Male, Female)',
    ],
];
