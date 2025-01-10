<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .text-center {
            text-align: center;
        }
        .pt-3 {
            padding-top: 1rem;
        }
        .py-3 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .my-3 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .mb-0 {
            margin-bottom: 0 !important;
        }
        .fst-italic {
            font-style: italic;
        }
        .border-top-bottom {
            border-top: 1px dashed black;
            border-bottom: 1px dashed black;
        }
        .text-muted {
            color: #777;
        }
        h3 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Invoice Title -->
    <div class="text-center py-3 border-top-bottom">
        <h3 class="mb-0">INVOICE</h3>
    </div>

    <!-- Invoice Information -->
    <div class="my-3">
        <p class="mb-0">Invoice Number: {{ $invoice->number }}</p>
        <p class="mb-0">Invoice Date: {{ $invoice->date->format('Y-m-d') }}</p>
        <p class="mb-0">Due Date: {{ $invoice->due_date->format('Y-m-d') }}</p>
        <p class="mb-0">Status: {{ $invoice->status == 0 ? 'Unpaid' : 'Paid' }}</p>
        <br>
        <p class="mb-0">
            Description: <br>
            {!! $invoice->description ?? '-' !!}
        </p>
        <br>
        <p class="mb-0">Invoice Amount: RM{{ number_format($invoice->amount, 2) }}</p>
    </div>

    <!-- Terms & Conditions -->
    <div class="py-3 border-top-bottom">
        <p class="mb-0">Term & Conditions:</p>
        <p>
            - Please make payment within the due date. <br>
            - Payments are to be made in RM currency.
        </p>
    </div>

    <!-- Footer Note -->
    <div class="text-center pt-3">
        <small class="text-muted fst-italic">*** This is a computer-generated copy. No signature is required ***</small>
    </div>
</div>

</body>
</html>