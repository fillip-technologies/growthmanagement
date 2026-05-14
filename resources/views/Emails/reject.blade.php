<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leave Approved Email</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f7fb;
            font-family: Arial, Helvetica, sans-serif;
        }

        .email-container {
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .email-header {
            background: linear-gradient(135deg, #0f172a, #0284c7);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .email-body {
            padding: 30px;
            color: #334155;
            line-height: 1.7;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 15px;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 12px;
            border: 1px solid #e2e8f0;
        }

        .details-table td:first-child {
            font-weight: bold;
            width: 35%;
            background: #f8fafc;
        }

        .status-approved {
            display: inline-block;
            padding: 6px 14px;
            background: #dcfce7;
            color: #166534;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        @media(max-width:600px) {
            .email-body {
                padding: 20px;
            }

            .details-table td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            .details-table td:first-child {
                border-bottom: none;
            }
        }
    </style>
</head>
@php
    use Carbon\Carbon;
    $fromDate = Carbon::parse($data->from_date);
    $toDate = Carbon::parse($data->to_date);
    $totalDays = $fromDate->diffInDays($toDate) + 1;
@endphp

<body>

    <div class="email-container">

        <div class="email-header">
            <h1>Leave Request Approved</h1>
        </div>

        <div class="email-body">

            <p>Dear <strong id="employeeName">{{ $data->employee->name }}</strong>,</p>

            <p>
                We are pleased to inform you that your leave request has been
                approved successfully.
            </p>

            <!-- Employee Details -->
            <div class="section-title">
                Employee Details
            </div>

            <table class="details-table">
                <tr>
                    <td>Employee ID</td>
                    <td id="employeeId">{{ $data->employee->id }}</td>
                </tr>
                <tr>
                    <td>Employee Name</td>
                    <td id="employeeName2">{{ $data->employee->name }}</td>
                </tr>

                <tr>
                    <td>Designation</td>
                    <td id="department">{{ $data->employee->designation }}</td>
                </tr>
            </table>

            <div class="section-title">
                Leave Details
            </div>

            <table class="details-table">

                <tr>
                    <td>From Date</td>
                    <td>
                        {{ $fromDate->format('d M Y') }}
                        ({{ $fromDate->format('l') }})
                    </td>
                </tr>

                <tr>
                    <td>To Date</td>
                    <td>
                        {{ $toDate->format('d M Y') }}
                        ({{ $toDate->format('l') }})
                    </td>
                </tr>

                <tr>
                    <td>Total Days</td>
                    <td>
                        {{ $totalDays }}
                        {{ $totalDays > 1 ? 'Days' : 'Day' }}
                    </td>
                </tr>

                <tr>
                    <td>Applied On</td>
                    <td>
                        {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y h:i A') }}
                    </td>
                </tr>

                <tr>
                    <td>Reason</td>
                    <td>
                        {{ $data->reason }}
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <span class="status-approved">
                            Rejected
                        </span>
                    </td>
                </tr>

            </table>

            <p style="margin-top:25px;">
                Please ensure that all pending tasks are properly handed over
                before your leave period begins.
            </p>

            <p>
                We wish you a pleasant and restful leave.
            </p>

            <p>
                Regards,<br>
                <strong>Fillip Technologies</strong><br>
                HR Department
            </p>

        </div>

        <div class="footer">
            © {{ date('y') }} Fillip Technologies All Rights Reserved.
        </div>

    </div>


</body>

</html>
