<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the Company</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(90deg, #f97316, #fb923c);
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
            color: #333;
            line-height: 1.6;
        }
        .content h2 {
            margin-top: 0;
            color: #f97316;
        }
        .credentials {
            margin: 20px 0;
            border: 1px solid #f1f1f1;
            border-radius: 8px;
            overflow: hidden;
        }
        .credentials table {
            width: 100%;
            border-collapse: collapse;
        }
        .credentials td {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f1f1;
        }
        .credentials tr:last-child td {
            border-bottom: none;
        }
        .credentials td.label {
            font-weight: bold;
            background-color: #fef3f0;
            color: #f97316;
            width: 30%;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #999;
        }
        @media only screen and (max-width: 600px) {
            .email-container { margin: 20px 10px; }
            .content { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            Welcome to the Company!
        </div>

        <div class="content">
            <h2>Hello {{ $employee->name }},</h2>
            <p>Your employee account has been created successfully. Please find your login credentials below:</p>

            <div class="credentials">
                <table>
                    <tr>
                        <td class="label">Email</td>
                        <td>{{ $employee->email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Password</td>
                        <td>{{ $planPassword }}</td>
                    </tr>
                    <tr>
                        <td class="label">Phone</td>
                        <td>{{ $employee->phone }}</td>
                    </tr>
                </table>
            </div>

             <div style="text-align:center; margin:30px 0;">
                                <a href="{{ url('https://growthmanagement.fillipsoftware.com/') }}"
                                    style="
                               background:#6366f1;
                               color:#ffffff;
                               text-decoration:none;
                               padding:14px 30px;
                               border-radius:30px;
                               font-size:15px;
                               display:inline-block;">
                                Click to Login
                                </a>
                            </div>

            <p>Please login as soon as possible and change your password for security reasons.</p>

            <p>We are excited to have you on board! 🚀</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Fillip Technologies. All rights reserved.
        </div>
    </div>
</body>
</html>
