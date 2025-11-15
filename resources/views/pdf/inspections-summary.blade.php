<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inspections Summary Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #4F46E5;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            color: #1F2937;
        }

        .report-meta {
            text-align: center;
            font-size: 9px;
            color: #6B7280;
            margin-bottom: 20px;
        }

        .filters-section {
            background-color: #F3F4F6;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .filters-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #1F2937;
        }

        .filter-item {
            display: inline-block;
            margin-right: 15px;
            font-size: 8px;
        }

        .filter-label {
            font-weight: bold;
        }

        .summary-stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-box {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 10px;
            background-color: #F9FAFB;
            border: 1px solid #E5E7EB;
        }

        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #4F46E5;
        }

        .stat-label {
            font-size: 8px;
            color: #6B7280;
            text-transform: uppercase;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #4F46E5;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            padding: 6px 5px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 8px;
        }

        tr:nth-child(even) {
            background-color: #F9FAFB;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 2px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-pass {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .badge-fail {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .badge-conditional {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .badge-pending {
            background-color: #E5E7EB;
            color: #374151;
        }

        .badge-completed {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .badge-scheduled {
            background-color: #E5E7EB;
            color: #374151;
        }

        .badge-in-progress {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .badge-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            font-size: 8px;
            color: #6B7280;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6B7280;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">{{ $organization->name }}</div>
        @if($organization->email)
            <div style="font-size: 9px; color: #6B7280;">{{ $organization->email }}</div>
        @endif
    </div>

    <!-- Report Title -->
    <div class="report-title">INSPECTIONS SUMMARY REPORT</div>
    <div class="report-meta">
        Generated on {{ $generatedAt->format('F d, Y \a\t g:i A') }}
    </div>

    <!-- Active Filters -->
    @if(count($filters) > 0)
    <div class="filters-section">
        <div class="filters-title">Active Filters:</div>
        @if(isset($filters['search']) && $filters['search'])
            <span class="filter-item"><span class="filter-label">Search:</span> {{ $filters['search'] }}</span>
        @endif
        @if(isset($filters['status']) && $filters['status'])
            <span class="filter-item"><span class="filter-label">Status:</span> {{ ucfirst(str_replace('_', ' ', $filters['status'])) }}</span>
        @endif
        @if(isset($filters['result']) && $filters['result'])
            <span class="filter-item"><span class="filter-label">Result:</span> {{ ucfirst($filters['result']) }}</span>
        @endif
        @if(isset($filters['customer_id']) && $filters['customer_id'])
            <span class="filter-item"><span class="filter-label">Customer Filter:</span> Applied</span>
        @endif
    </div>
    @endif

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="stat-box">
            <div class="stat-value">{{ $inspections->count() }}</div>
            <div class="stat-label">Total Inspections</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $inspections->where('result', 'pass')->count() }}</div>
            <div class="stat-label">Passed</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $inspections->where('result', 'fail')->count() }}</div>
            <div class="stat-label">Failed</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $inspections->where('status', 'completed')->count() }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </div>

    <!-- Inspections Table -->
    @if($inspections->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Type</th>
                <th style="width: 15%;">Customer</th>
                <th style="width: 13%;">Equipment</th>
                <th style="width: 12%;">Inspector</th>
                <th style="width: 10%;">Date</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Result</th>
                <th style="width: 10%;">Next</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inspections as $inspection)
            <tr>
                <td>{{ $inspection->id }}</td>
                <td>{{ $inspection->inspection_type }}</td>
                <td>{{ $inspection->customer->company_name }}</td>
                <td>{{ $inspection->equipment->equipment_type }}</td>
                <td>{{ $inspection->inspector->name }}</td>
                <td>{{ $inspection->inspection_date->format('M d, Y') }}</td>
                <td>
                    <span class="badge badge-{{ $inspection->status }}">
                        {{ ucfirst(str_replace('_', ' ', $inspection->status)) }}
                    </span>
                </td>
                <td>
                    <span class="badge badge-{{ $inspection->result }}">
                        {{ ucfirst($inspection->result) }}
                    </span>
                </td>
                <td>
                    @if($inspection->next_inspection_date)
                        {{ $inspection->next_inspection_date->format('M d, Y') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        No inspections found matching the selected criteria.
    </div>
    @endif

    <!-- Results by Status Breakdown -->
    @if($inspections->count() > 0)
    <div style="margin-top: 20px;">
        <table style="width: 48%; display: inline-table; margin-right: 4%;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">RESULTS BREAKDOWN</th>
                </tr>
                <tr>
                    <th>Result</th>
                    <th style="text-align: right;">Count</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pass</td>
                    <td style="text-align: right;">{{ $inspections->where('result', 'pass')->count() }}</td>
                </tr>
                <tr>
                    <td>Fail</td>
                    <td style="text-align: right;">{{ $inspections->where('result', 'fail')->count() }}</td>
                </tr>
                <tr>
                    <td>Conditional</td>
                    <td style="text-align: right;">{{ $inspections->where('result', 'conditional')->count() }}</td>
                </tr>
                <tr>
                    <td>Pending</td>
                    <td style="text-align: right;">{{ $inspections->where('result', 'pending')->count() }}</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 48%; display: inline-table;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">STATUS BREAKDOWN</th>
                </tr>
                <tr>
                    <th>Status</th>
                    <th style="text-align: right;">Count</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Scheduled</td>
                    <td style="text-align: right;">{{ $inspections->where('status', 'scheduled')->count() }}</td>
                </tr>
                <tr>
                    <td>In Progress</td>
                    <td style="text-align: right;">{{ $inspections->where('status', 'in_progress')->count() }}</td>
                </tr>
                <tr>
                    <td>Completed</td>
                    <td style="text-align: right;">{{ $inspections->where('status', 'completed')->count() }}</td>
                </tr>
                <tr>
                    <td>Cancelled</td>
                    <td style="text-align: right;">{{ $inspections->where('status', 'cancelled')->count() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>{{ $organization->name }} - Electrical Inspection Management System</p>
        <p>This report contains {{ $inspections->count() }} inspection{{ $inspections->count() != 1 ? 's' : '' }}</p>
    </div>
</body>
</html>
