<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('Invoice') }}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        h1 {
            color: #206bc4;
            font-size: 24px;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <h1>{{ $invoice->user->business->name ?? 'Sling' }}</h1>
                        </td>
                        <td>
                            Invoice #: {{ $invoice->invoice_number }}<br>
                            Created: {{ $invoice->invoice_date->format('F j, Y') }}
                            @if($invoice->is_paid && $invoice->payment_date)
                                <br>
                                Paid: {{ $invoice->payment_date->format('F j, Y') }}
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            <strong>{{ $invoice->user->name }}</strong><br>
                            {{ $invoice->user->address->street1 }}{{ $invoice->user->address->street2 ? ', ' . $invoice->user->address->street2 : '' }}
                            <br>
                            {{ $invoice->user->address->city }}{{ $invoice->user->address->state ? ', ' . $invoice->user->address->state : '' }}
                            <br>
                            {{ $invoice->user->address->country }}{{ $invoice->user->address->zip ? ', ' . $invoice->user->address->zip : '' }}
                            <br><br>
                            {{ $invoice->user->email }}<br>
                            {{ $invoice->user->phone }}<br><br>
                            <strong>Money transfer to the account below:</strong><br>
                            {{ $invoice->paymentMethod->name }}<br>
                            @foreach($invoice->paymentMethod->attributes as $attribute_key => $attribute_value)
                                {{ $attribute_key }}: {{ $attribute_value }}<br>
                            @endforeach
                        </td>
                        <td>
                            @if($invoice->client->company)
                                <strong>{{ $invoice->client->company }}</strong><br>
                            @endif
                            <strong>{{ $invoice->client->name }}</strong><br>
                            {{ $invoice->client->address->street1 }}{{ $invoice->client->address->street2 ? ', ' . $invoice->client->address->street2 : '' }}
                            <br>
                            {{ $invoice->client->address->city }}{{ $invoice->client->address->state ? ', ' . $invoice->client->address->state : '' }}
                            <br>
                            {{ $invoice->client->address->country }}{{ $invoice->client->address->zip ? ', ' . $invoice->client->address->zip : '' }}
                            <br><br>
                            {{ $invoice->client->email }}<br>
                            {{ $invoice->client->phone }}<br><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>
                Item
            </td>

            <td>
                Price
            </td>
        </tr>

        <tr class="item">
            <td>
                {{ $invoice->product_name }}
            </td>

            <td>
                {{ number_format($invoice->product_price, 2) }} {{ $invoice->currency->code }}
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0">
        <tr class="total">
            <td style="min-width: 30%"></td>

            <td>
                Total: {{ number_format($invoice->product_price, 2) }} {{ $invoice->currency->code }}
                ({{ number_format($invoice->product_price, 2) }} {{ $invoice->currency->name }})
            </td>
        </tr>
    </table>
</div>
</body>
</html>
