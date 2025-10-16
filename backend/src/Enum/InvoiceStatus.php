<?php

namespace App\InvoiceStatus;

enum InvoiceStatus: string
{
    case Draft = 'Draft';
    case Sent = 'Sent';
    case Done = 'Done';
}