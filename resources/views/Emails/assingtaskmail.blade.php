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

                <!-- Main Card -->
                <table width="700" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#4f46e5; padding:25px; text-align:center;">
                            <h1 style="margin:0; color:#fff; font-size:28px;">
                                🚀 New Task Assigned
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:35px; color:#374151;">

                            <!-- Greeting -->
                            <p style="font-size:16px; margin-bottom:15px;">
                                Hello
                                <strong>{{ $user->name ?? 'Team Member' }}</strong>,
                            </p>

                            <p style="font-size:15px; line-height:1.7; color:#6b7280;">
                                A new task has been assigned to you. Please check the complete task and project details
                                below.
                            </p>

                            <!-- USER DETAILS -->
                            <h2
                                style="margin-top:30px; font-size:20px; color:#111827; border-bottom:2px solid #e5e7eb; padding-bottom:8px;">
                                👤 Employee Details
                            </h2>

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="margin-top:15px; background:#f9fafb; border-radius:10px; padding:20px;">

                                <tr>
                                    <td style="padding:8px 0;">
                                        <strong>👤 Name :</strong>
                                        {{ $user->name }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:8px 0;">
                                        <strong>📧 Email :</strong>
                                        {{ $user->email }}
                                    </td>
                                </tr>

                                @if (!empty($user->phone))
                                    <tr>
                                        <td style="padding:8px 0;">
                                            <strong>📱 Phone :</strong>
                                            {{ $user->phone }}
                                        </td>
                                    </tr>
                                @endif

                            </table>

                            <!-- PROJECT DETAILS -->
                            <h2
                                style="margin-top:35px; font-size:20px; color:#111827; border-bottom:2px solid #e5e7eb; padding-bottom:8px;">
                                📁 Project Details
                            </h2>

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="margin-top:15px; background:#f9fafb; border-radius:10px; padding:20px;">

                                <tr>
                                    <td style="padding:8px 0;">
                                        <strong>📌 Project Name :</strong>
                                        {{ $task->project->first()->name ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:8px 0;">
                                        <strong>📝 Description :</strong>
                                        {{ $task->project->first()->description ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:8px 0;">
                                        <strong>📅 Start Date :</strong>
                                        {{ !empty($task->project->first()->start_date) ? \Carbon\Carbon::parse($task->project->start_date)->format('d M Y') : 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:8px 0;">
                                        <strong>⏳ End Date :</strong>
                                        {{ !empty($task->project->first()->end_date) ? \Carbon\Carbon::parse($task->project->end_date)->format('d M Y') : 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:8px 0;">
                                        <strong>⚡ Priority :</strong>
                                        {{ ucfirst($task->project->first()->priority ?? 'N/A') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:8px 0;">
                                        <strong>📊 Status :</strong>
                                        {{ ucfirst($task->project->first()->status ?? 'Pending') }}
                                    </td>
                                </tr>

                                @if (!empty($task->project->first()->modules))
                                    <tr>
                                        <td style="padding:8px 0;">
                                            <strong>🧩 Modules :</strong>

                                            <div style="margin-top:8px;">

                                                @php
                                                    $modules = is_array($task->project->modules)
                                                        ? $task->project->modules
                                                        : json_decode($task->project->modules, true);
                                                @endphp

                                                @if (is_array($modules))
                                                    <ul style="padding-left:20px; margin:0;">
                                                        @foreach ($modules as $module)
                                                            <li style="margin-bottom:5px;">
                                                                {{ $module }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{ $project->modules }}
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endif

                            </table>


                        </td>
                    </tr>
                    <tr>
                        <td
                            style="background:#f3f4f6; padding:18px; text-align:center; font-size:13px; color:#6b7280;">

                            © {{ date('Y') }} {{ config('app.name') }}.
                            All rights reserved.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
```
