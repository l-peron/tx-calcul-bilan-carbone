<?php

namespace App\Enums;

enum QuestionType: string
{
    case SAISIE= 'saisie';
    case UNIQUE= 'unique';
    case MULTIPLE= 'multiple';
}
