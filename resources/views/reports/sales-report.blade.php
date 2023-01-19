<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('Sales report') }}</title>
    <style>
        h1 {
            color: #206bc4;
            font-size: 24px;
        }

        h2 {
            font-size: 18px;
        }
        .report-box {
            max-width: 800px;
            margin: auto;
            padding: 10px 30px 30px;
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .report-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .report-box table td {
            padding: 3px;
            vertical-align: top;
        }

        .report-box table tr td:nth-child(2) {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }

        .footer span {
            color: red;
            font-size: 12px;
        }

        .border-top td {
            border-top: 1px solid rgba(98, 105, 118, .16) !important;
        }

        .bg-primary {
            background-color: #307fdd;
            color: #fff;
        }

        .heading th {
            background: rgba(32, 107, 196, .1) !important;
            color: #206bc4 !important;
        }

        .bg-primary th, .heading th {
            text-align: left !important;
            padding: 5px 10px;
        }
        .subtotal {
            text-align: right;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
<div class="report-box">
    <h1>{{ $user->business->name ?? $user->name ?? 'Sling' }}</h1>
    <h2>{{ __('Sales report :from — :to',[
        'from' =>  $reportParameters->dateFrom->format('d.m.Y'),
        'to' => $reportParameters->dateTo->format('d.m.Y')
    ]) }}</h2>
    @if(count($report))
        @foreach($report as $invoices)
            <table cellpadding="0" cellspacing="0">
                @foreach($invoices as $invoice)
                    @if($loop->first)
                        <tr class="heading">
                            <th colspan="2">{{ $invoice->client_name }}</th>
                        </tr>
                    @endif
                    <tr>
                        <td>{{ $invoice->payment_date->format('d.m.Y') }}
                            @if($user->currency->id == $invoice->currency_id)
                                ({{ $invoice->invoice_number }})
                            @else
                                ({{ $invoice->invoice_number }}, {{ $invoice->product_price }} {{ $invoice->currency }} x {{ $invoice->exchange_rate }})
                            @endif
                        </td>
                        <td>
                            {{ $invoice->amount }} {{ $user->currency->code }}
                        </td>
                    </tr>
                    @if($loop->last)
                        <tr class="border-top">
                            <td colspan="2">
                                <div class="subtotal"><strong>{{ $invoices->sum('amount') }} {{ $user->currency->code }}</strong></div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
            @if($loop->last)
                <table cellpadding="0" cellspacing="0">
                    <tr class="bg-primary">
                        <th>{{ __('Total') }}</th>
                        <td>
                            <strong>{{ number_format($total, 2) }} {{ $user->currency->code }}</strong>
                        </td>
                    </tr>
                </table>
            @endif
        @endforeach
        <div class="footer">
            <span>* {{ __('Subtotals are displayed to 6 decimal places') }}</span>
        </div>
    @else
        {{ __('There is no data for the selected period.') }}
    @endif
</div>
</body>
</html>
