<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inspection Report - {{ $inspection->customer->customer_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
        }

        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #4F46E5;
            overflow: hidden;
        }

        .header-content {
            float: left;
            text-align: left;
            max-width: 350px;
        }

        .header-row {
            display: table;
            width: 100%;
        }

        .logo-cell {
            display: table-cell;
            vertical-align: middle;
            width: 90px;
            padding-right: 12px;
        }

        .company-info-cell {
            display: table-cell;
            vertical-align: middle;
        }

        .logo {
            max-width: 80px;
            max-height: 80px;
            margin-left: 10px;
        }

        .company-info {
            text-align: left;
        }

        .company-name {
            font-size: 12px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 2px;
        }

        .company-details {
            font-size: 8px;
            color: #666;
            line-height: 1.3;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            color: #1F2937;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            background-color: #F3F4F6;
            padding: 8px 10px;
            margin-bottom: 10px;
            color: #1F2937;
            border-left: 4px solid #4F46E5;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            width: 35%;
            font-weight: bold;
            padding: 5px 10px;
            background-color: #F9FAFB;
            border-bottom: 1px solid #E5E7EB;
        }

        .info-value {
            display: table-cell;
            padding: 5px 10px;
            border-bottom: 1px solid #E5E7EB;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
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

        .text-content {
            padding: 10px;
            background-color: #F9FAFB;
            border-left: 3px solid #4F46E5;
            margin-top: 5px;
            white-space: pre-line;
        }

        .files-list {
            margin-top: 10px;
        }

        .file-item {
            padding: 8px 10px;
            background-color: #F9FAFB;
            margin-bottom: 5px;
            border-left: 3px solid #4F46E5;
        }

        .file-name {
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }

        .file-meta {
            font-size: 9px;
            color: #6B7280;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            font-size: 9px;
            color: #6B7280;
        }
    </style>
</head>
<body>
    <!-- Header with Logo and Company Info -->
    <div class="header">
        <div class="header-content">
            <div class="header-row">
                @if($organization->logo)
                <div class="logo-cell">
                    <img src="{{ public_path('storage/' . $organization->logo) }}" alt="{{ $organization->name }}" class="logo">
                </div>
                @endif
                <div class="company-info-cell">
                    <div class="company-info">
                        <div class="company-name">{{ $organization->name }}</div>
                        <div class="company-details">
                            @if($organization->address)
                                {{ $organization->address }}<br>
                            @endif
                            @if($organization->phone)
                                Phone: {{ $organization->phone }}
                                @if($organization->email)
                                    |
                                @endif
                            @endif
                            @if($organization->email)
                                Email: {{ $organization->email }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <!-- Report Title -->
    <div class="report-title">INSPECTION REPORT</div>

    <!-- Inspection Information -->
    <div class="section">
        <div class="section-title">Inspection Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Inspection Type:</div>
                <div class="info-value">{{ $inspection->inspection_type }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Inspection Date:</div>
                <div class="info-value">
                    {{ $inspection->inspection_date->format('F d, Y') }}
                    @if($inspection->inspection_time)
                        at {{ date('g:i A', strtotime($inspection->inspection_time)) }}
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Inspector:</div>
                <div class="info-value">{{ $inspection->inspector->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="badge badge-{{ $inspection->status }}">
                        {{ ucfirst(str_replace('_', ' ', $inspection->status)) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Result:</div>
                <div class="info-value">{{ $inspection->result }}</div>
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="section">
        <div class="section-title">Customer Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Customer ID:</div>
                <div class="info-value">{{ $customer->customer_id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Company Name:</div>
                <div class="info-value">{{ $customer->company_name }}</div>
            </div>
            @if($customer->address)
            <div class="info-row">
                <div class="info-label">Address:</div>
                <div class="info-value">
                    {{ $customer->address }}
                    @if($customer->city || $customer->state || $customer->postal_code)
                        <br>{{ $customer->city }}@if($customer->state), {{ $customer->state }}@endif @if($customer->postal_code){{ $customer->postal_code }}@endif
                    @endif
                </div>
            </div>
            @endif
            @if($customer->contact_person)
            <div class="info-row">
                <div class="info-label">Contact Person:</div>
                <div class="info-value">{{ $customer->contact_person }}</div>
            </div>
            @endif
            @if($customer->phone)
            <div class="info-row">
                <div class="info-label">Phone:</div>
                <div class="info-value">{{ $customer->phone }}</div>
            </div>
            @endif
            @if($customer->email)
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $customer->email }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Equipment Information -->
    <div class="section">
        <div class="section-title">Equipment Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Equipment Type:</div>
                <div class="info-value">{{ $equipment->equipment_type }}</div>
            </div>
            @if($equipment->manufacturer)
            <div class="info-row">
                <div class="info-label">Manufacturer:</div>
                <div class="info-value">{{ $equipment->manufacturer }}</div>
            </div>
            @endif
            @if($equipment->model)
            <div class="info-row">
                <div class="info-label">Model:</div>
                <div class="info-value">{{ $equipment->model }}</div>
            </div>
            @endif
            @if($equipment->serial_number)
            <div class="info-row">
                <div class="info-label">Serial Number:</div>
                <div class="info-value">{{ $equipment->serial_number }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Location:</div>
                <div class="info-value">{{ $equipment->location }}</div>
            </div>
            @if($equipment->installation_date)
            <div class="info-row">
                <div class="info-label">Installation Date:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($equipment->installation_date)->format('F d, Y') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Inspection Parameters -->
    @if($parameterValues && $parameterValues->count() > 0)
    <div class="section">
        <div class="section-title">Inspection Parameters</div>
        <div class="info-grid">
            @foreach($parameterValues as $paramValue)
            <div class="info-row">
                <div class="info-label">{{ $paramValue->parameter->label }}:</div>
                <div class="info-value">{{ $paramValue->value ?: 'N/A' }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Notes -->
    @if($inspection->notes)
    <div class="section">
        <div class="section-title">Additional Notes</div>
        <div class="text-content">{{ $inspection->notes }}</div>
    </div>
    @endif

    <!-- Attached Files -->
    @if($inspection->files->count() > 0)
    <div class="section">
        <div class="section-title">Attached Files ({{ $inspection->files->count() }})</div>
        <div class="files-list">
            @foreach($inspection->files as $file)
            <div class="file-item">
                <span class="file-name">{{ $file->file_name }}</span>
                <span class="file-meta">
                    {{ ucfirst($file->file_type) }} •
                    {{ number_format($file->file_size / 1024, 2) }} KB •
                    Uploaded {{ $file->created_at->format('M d, Y') }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This report was generated on {{ $generatedAt->format('F d, Y \a\t g:i A') }}</p>
        <p>{{ $organization->name }} - Electrical Inspection Management System</p>
    </div>
</body>
</html>
