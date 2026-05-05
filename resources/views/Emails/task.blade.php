<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Task Assigned</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 0;">

                <!-- Card -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.08); overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#6366f1; padding:25px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:24px;">
                                🚀 New Task Assigned
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#374151;">

                            <p style="font-size:16px; margin:0 0 15px;">
                                Hello <strong>{{ $user->name ?? 'Team Member' }}</strong>,
                            </p>

                            <p style="font-size:15px; line-height:1.6; margin:0 0 20px;">
                                You have been assigned a new task. Please review the details below and start working on
                                it.
                            </p>

                            <!-- Task Details -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f9fafb; border-radius:10px; padding:20px;">

                                <tr>
                                    <td style="padding:6px 0;"><strong>📌 Project Name :</strong> {{ $task->title }}</td>
                                </tr>

                                <tr>
                                    <td style="padding:6px 0;"><strong>📝 Task Name:</strong> {{ $task->task_name }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:6px 0;">
                                        <strong>⏰ Deadline:</strong>
                                        {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:6px 0;">
                                        <strong>📊 Status:</strong>
                                        <span
                                            style="
                                        display:inline-block;
                                        padding:4px 12px;
                                        background:#e0e7ff;
                                        color:#3730a3;
                                        border-radius:20px;
                                        font-size:13px;">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                </tr>

                                @if (!empty($task->description))
                                    <tr>
                                        <td style="padding:6px 0;">
                                            <strong>🧾 Description:</strong><br>
                                            <span style="color:#6b7280;">
                                                {{ $task->description }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            </table>

                            <!-- Attachments Info -->
                            @if (!empty($task->attechment))
                                <div style="margin-top:20px; background:#eef2ff; padding:15px; border-radius:8px;">
                                    <strong>📎 Attached Files:</strong>

                                    <ul style="margin:10px 0 0; padding-left:18px;">
                                        @foreach ($task->attechment as $file)
                                            <li style="margin-bottom:6px;">
                                                <a href="{{ asset($file) }}"
                                                    style="color:#4f46e5; text-decoration:none;" target="_blank">
                                                    {{ basename($file) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <p style="font-size:13px; color:#6b7280; margin-top:10px;">
                                        ⬆ These files are also attached with this email.
                                    </p>
                                </div>
                            @endif


                            <!-- Button -->
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
                                    View Task
                                </a>
                            </div>

                            <p style="font-size:14px; color:#6b7280; margin:0;">
                                If you have any questions, feel free to contact the admin.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background:#f3f4f6; padding:18px; text-align:center;
                               font-size:13px; color:#6b7280;">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
