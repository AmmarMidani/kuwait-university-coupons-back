<?php

use App\Enums\GenderLookupType;
use App\Enums\GenderType;

return [
    GenderType::class => [
        GenderType::Male => 'ذكر',
        GenderType::Female => 'أنثى',
    ],

    GenderLookupType::class => [
        GenderLookupType::Male => 'ذكور فقط',
        GenderLookupType::Female => 'إناث فقط',
        GenderLookupType::Both => 'الجنسين (ذكور وإناث)',
    ],
];
