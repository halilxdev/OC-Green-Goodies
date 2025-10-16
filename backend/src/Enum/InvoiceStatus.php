<?php

namespace App\Enum;

enum InvoiceStatus: string
{
    case Draft = 'Draft';
    case Sent = 'Sent';
    case Done = 'Done';
}