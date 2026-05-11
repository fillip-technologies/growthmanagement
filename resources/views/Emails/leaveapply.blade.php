<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Leave Application</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:20px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:10px;">

        <h2 style="color:#2563eb; text-align:center;">
            Leave Application Request
        </h2>

        <p>Hello HR Team,</p>
        <p>
            An employee has applied for leave. Below are the leave details:
        </p>
        <table style="width:100%; border-collapse:collapse; margin-top:20px;">

            <tr>
                <td style="padding:10px; border:1px solid #ddd;"><strong>Employee Name</strong></td>
                <td style="padding:10px; border:1px solid #ddd;">
                    {{ $user->name }}
                </td>
            </tr>

            <tr>
                <td style="padding:10px; border:1px solid #ddd;"><strong>Email</strong></td>
                <td style="padding:10px; border:1px solid #ddd;">
                    {{ $user->email }}
                </td>
            </tr>

            <tr>
                <td style="padding:10px; border:1px solid #ddd;"><strong>Phone</strong></td>
                <td style="padding:10px; border:1px solid #ddd;">
                    {{ $user->phone }}
                </td>
            </tr>

            <tr>
                <td style="padding:10px; border:1px solid #ddd;"><strong>From Date</strong></td>
                <td style="padding:10px; border:1px solid #ddd;">
                    {{ $data['from_date'] }}
                </td>
            </tr>

            <tr>
                <td style="padding:10px; border:1px solid #ddd;"><strong>To Date</strong></td>
                <td style="padding:10px; border:1px solid #ddd;">
                    {{ $data['to_date'] }}
                </td>
            </tr>

            <tr>
                <td style="padding:10px; border:1px solid #ddd;"><strong>Reason</strong></td>
                <td style="padding:10px; border:1px solid #ddd;">
                    {{ $data['reason'] }}
                </td>
            </tr>

        </table>

        <p style="margin-top:30px;">
            Thank You

        </p>
         <p style="margin-top:30px;">
           {{ $user->name }}
        </p>

    </div>

</body>

</html>
