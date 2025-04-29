<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class GenderType extends Enum implements LocalizedEnum
{
    const Male = 1;
    const Female = 2;
}
