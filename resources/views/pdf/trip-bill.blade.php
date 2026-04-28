<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trip Settlement Ledger - T-{{ $trip->trip_number }}</title>
    <style>
        @page { margin: 30px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #334155; line-height: 1.4; margin: 0; }
        
        /* Header Section */
        .header-container { margin-bottom: 30px; border-bottom: 2px solid #1e293b; padding-bottom: 15px; }
        .company-name { font-size: 24px; font-weight: 900; color: #1e293b; margin: 0; text-transform: uppercase; letter-spacing: -1px; }
        .document-type { font-size: 12px; font-weight: bold; color: #64748b; text-transform: uppercase; margin-top: 5px; }
        
        /* Grid Info Table */
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px 0; vertical-align: top; }
        .info-label { font-size: 9px; font-weight: bold; color: #94a3b8; text-transform: uppercase; display: block; }
        .info-value { font-size: 12px; font-weight: bold; color: #1e293b; text-tzransform: uppercase; }

        /* Dashboard Style Summary */
        .summary-box { width: 100%; background-color: #1e293b; margin-bottom: 25px; border-radius: 8px; overflow: hidden; }
        .summary-box td { padding: 15px 10px; text-align: center; border: 1px solid #334155; }
        .summary-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 5px; }
        .summary-value { font-size: 16px; font-weight: bold; color: #ffffff; }
        .val-green { color: #4ade80 !important; }
        .val-red { color: #f87171 !important; }

        /* Data Tables */
        .section-title { font-size: 10px; font-weight: 900; color: #ffffff; background-color: #334155; padding: 6px 10px; text-transform: uppercase; margin-bottom: 0; border-radius: 4px 4px 0 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th { background-color: #f8fafc; color: #64748b; font-size: 9px; font-weight: bold; text-transform: uppercase; padding: 8px 10px; border: 1px solid #e2e8f0; text-align: left; }
        .data-table td { padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 10px; color: #334155; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        

        /* Footer Styling */
        .footer { position: fixed; bottom: 0; width: 100%; border-top: 1px solid #e2e8f0; padding-top: 8px; padding-bottom: 5px; }
        .footer-table { width: 100%; }
        .footer-text { font-size: 8px; color: #94a3b8; }
        .branding-text { font-size: 9px; color: #64748b; text-align: right; }
        .branding-text strong { color: #0f172a; }
        /* Two Column Layout Helper */
        .row { width: 100%; }
        .col { width: 48%; display: inline-block; vertical-align: top; }
        .col-spacer { width: 3%; display: inline-block; }
    </style>
</head>
<body>

    @php
        $sDE = $driverExp->sum('amount');
        $sOE = $ownerExp->sum('amount');
        $sDR = $driverRec->sum('amount');
        $sOR = $ownerRec->sum('amount');
        $driverHisab = $sDR - $sDE;
        $totalRev = $sDR + $sOR;
        $totalExp = $sDE + $sOE;
        $netProfit = $totalRev - $totalExp;
    @endphp

    <div class="header-container">
        <table style="width: 100%;">
            <tr>
                <td>
                    <h1 class="company-name">TRIP SETTLEMENT</h1>
                    <div class="document-type">Trip Ledger & Profit Analysis</div>
                </td>
                <td style="text-align: right;">
                    <div class="info-label">Report Date</div>
                    <div class="info-value">{{ date('d M, Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-table">
        <tr>
            <td width="25%">
                <span class="info-label">Trip ID</span>
                <span class="info-value">T-{{ $trip->trip_number }}</span>
            </td>
            <td width="25%">
                <span class="info-label">Truck Number</span>
                <span class="info-value">{{ $trip->vehicle->truck_number ?? 'N/A' }}</span>
            </td>
            <td width="25%">
                <span class="info-label">Driver Name</span>
                <span class="info-value">{{ $trip->driver->name ?? 'N/A' }}</span>
            </td>
            <td width="25%">
                <span class="info-label">Route</span>
                <span class="info-value">{{ $trip->from_location }} to {{ $trip->to_location }}</span>
            </td>
        </tr>
    </table>

    <table class="summary-box">
        <tr>
            <td>
                <span class="summary-label">Total Recovery</span>
                <span class="summary-value val-green">₹ {{ number_format($totalRev) }}</span>
            </td>
            <td>
                <span class="summary-label">Total Expenses</span>
                <span class="summary-value val-red">₹ {{ number_format($totalExp) }}</span>
            </td>
            <td>
                <span class="summary-label">Net Profit</span>
                <span class="summary-value">₹ {{ number_format($netProfit) }}</span>
            </td>
            <td>
                <span class="summary-label">Driver Balance</span>
                <span class="summary-value {{ $driverHisab >= 0 ? 'val-green' : 'val-red' }}">
                    ₹ {{ number_format($driverHisab) }}
                </span>
            </td>
        </tr>
    </table>

    <div class="row">
        <div class="col">
            <div class="section-title">Driver Expenses (Wallet)</div>
            <table class="data-table">
                <thead>
                    <tr><th>Description</th><th class="text-right">Amount</th></tr>
                </thead>
                <tbody>
                    @foreach($driverExp as $ex)
                    <tr>
                        <td>{{ $ex->category->name ?? 'Expense' }}</td>
                        <td class="text-right">₹ {{ number_format($ex->amount) }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-bold">
                        <td class="text-right">Total:</td>
                        <td class="text-right">₹ {{ number_format($sDE) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-spacer"></div>
        <div class="col">
            <div class="section-title">Owner Expenses (Bank)</div>
            <table class="data-table">
                <thead>
                    <tr><th>Description</th><th class="text-right">Amount</th></tr>
                </thead>
                <tbody>
                    @foreach($ownerExp as $ex)
                    <tr>
                        <td>{{ $ex->category->name ?? 'Owner Exp' }}</td>
                        <td class="text-right">₹ {{ number_format($ex->amount) }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-bold">
                        <td class="text-right">Total:</td>
                        <td class="text-right">₹ {{ number_format($sOE) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="section-title" style="background-color: #059669;">Driver Recovery (Cash)</div>
            <table class="data-table">
                <thead>
                    <tr><th>Description</th><th class="text-right">Amount</th></tr>
                </thead>
                <tbody>
                    @foreach($driverRec as $rc)
                    <tr>
                        <td>{{ $rc->remarks ?: 'Trip Recovery' }}</td>
                        <td class="text-right">₹ {{ number_format($rc->amount) }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-bold">
                        <td class="text-right">Total:</td>
                        <td class="text-right">₹ {{ number_format($sDR) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-spacer"></div>
        <div class="col">
            <div class="section-title" style="background-color: #059669;">Owner Recovery (Bank)</div>
            <table class="data-table">
                <thead>
                    <tr><th>Description</th><th class="text-right">Amount</th></tr>
                </thead>
                <tbody>
                    @foreach($ownerRec as $rc)
                    <tr>
                        <td>{{ $rc->remarks ?: 'Bank Deposit' }}</td>
                        <td class="text-right">₹ {{ number_format($rc->amount) }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-bold">
                        <td class="text-right">Total:</td>
                        <td class="text-right">₹ {{ number_format($sOR) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section-title" style="background-color: #2a2b6e;">Party Billing & Material Details</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Party Name</th>
                <th>Material</th>
                <th>Weight</th>
                <th class="text-right">Freight</th>
                <th class="text-right">Received</th>
                <th class="text-right">Dues</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billings as $bill)
            <tr>
                <td class="font-bold">{{ strtoupper($bill->party_name) }}</td>
                <td>{{ $bill->material_description }}</td>
                <td>{{ $bill->weight_tons }} MT</td>
                <td class="text-right font-bold">₹ {{ number_format($bill->freight_amount) }}</td>
                <td class="text-right">₹ {{ number_format($bill->received_amount) }}</td>
                <td class="text-right font-bold" style="color: #e11d48;">₹ {{ number_format($bill->freight_amount - $bill->received_amount) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td class="gen-date">
                    Generated on: {{ date('d M Y, h:i A') }} | Trip ID: T-{{ $trip->trip_number }}
                </td>
                <td class="branding">
                    Designed & Developed by <strong>JMD TRUCK MANAGEMENT</strong>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>