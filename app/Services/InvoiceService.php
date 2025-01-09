<?php

namespace App\Services;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceService
{
    public static function generateInvoiceNumber()
    {
        $latestInvoice  = Invoice::latest()->first();
        $currentYear    = Carbon::now()->year;
        $nextNumber     = 1;
    
        // Check if there is a latest invoice and it is from the current year
        if ($latestInvoice) {
            $numberParts = explode('/', $latestInvoice->number);
            $invoiceYear = $numberParts[1];  // The year part of the invoice number
            $invoiceNumber = $numberParts[2]; // The number part of the invoice
    
            // If the latest invoice is from the current year, increment the number
            if ($invoiceYear == $currentYear) {
                $nextNumber = intval($invoiceNumber) + 1;
            }
        }

        return 'INV/' . $currentYear . '/' . sprintf('%04d', $nextNumber);
    }
}
