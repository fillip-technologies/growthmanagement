<?php

namespace App\Http\Controllers;

use App\Mail\ApplyLeaveMail;
use App\Mail\ApproveMail;
use App\Models\AddTask;
use App\Models\AttendanceInfo;
use App\Models\TakeLeave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AttendanceInfoController extends Controller
{
    public function index()
    {
        $id = EmpLogin()->id ?? 0;
        $attendances = AttendanceInfo::with(['employee', 'project'])->where('employee_id', $id)->paginate(10);
        $projects = AddTask::with(['project'])->where('employee_id', $id)->get();
        $eventCount = AttendanceInfo::whereDate('date', today())
            ->where('employee_id', $id)
            ->first();
        if ($eventCount && $eventCount->event_count == 1) {
            $startTime = Carbon::parse($eventCount->start_work);
            if ($startTime->diffInHours(now()) >= 12) {
                $eventCount->update([
                    'event_count' => 0,
                ]);
                $eventCount = AttendanceInfo::whereDate('date', today())
                    ->where('employee_id', $id)
                    ->first();
            }
        }

        return view('admin.attendance.index', compact('eventCount', 'attendances', 'projects'));
    }

    public function startWork(Request $request)
    {
        $empID = trim($request->empId);

        $data = AttendanceInfo::where('employee_id', $empID)
            ->whereDate('date', today())
            ->first();

        if ($data && $data->event_count == 1) {

            return response()->json([
                'status' => true,
                'event_count' => $data->event_count,
                'message' => 'You Have Already Working.......',
            ], 200);
        }

        AttendanceInfo::updateOrCreate(
            [
                'employee_id' => $empID,
                'date' => today(),
            ],
            [
                'day' => now()->format('l'),
                'event_count' => 1,
                'start_work' => now(),
            ]
        );

        return response()->json([
            'success' => 'start',
            'message' => 'Work Started',
            'time' => now()->format('d M Y h:i A'),
        ]);
    }

    public function lunchStart(Request $request)
    {
        $data = AttendanceInfo::updateOrCreate(
            [
                'employee_id' => $request->empId,
                'date' => now()->toDateString(),
            ],
            [
                'lunch_start' => now()->format('H:i:s'),
                'lunch_count' => 1,
            ]
        );

        return response()->json([
            'success' => true,
            'fire' => 'start',
            'message' => 'Lunch Started',
            'data' => $data,
        ]);
    }

    public function lunchOut(Request $request)
    {
        $data = AttendanceInfo::updateOrCreate(
            [
                'employee_id' => $request->empId,
                'date' => now()->toDateString(),
            ],
            [
                'lunch_out' => now()->format('H:i:s'),
                'lunch_count' => 0,
            ]
        );

        return response()->json([
            'success' => true,
            'fire' => 'out',
            'message' => 'Lunch Out...',
            'data' => $data,
        ]);
    }

    public function endWork(Request $request)
    {
        $data = AttendanceInfo::whereDate('date', today())
            ->where('employee_id', $request->empId)
            ->first();

        if (! $data) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance record not found',
            ]);
        }
        $endWorkTime = Carbon::now();
        $startWorkTime = $data->start_work
            ? Carbon::parse($data->start_work)
            : null;
        $lunchStartTime = $data->lunch_start
            ? Carbon::parse($data->lunch_start)
            : null;

        $lunchOutTime = $data->lunch_out
            ? Carbon::parse($data->lunch_out)
            : null;
        $totalMinutes = $startWorkTime
            ? $startWorkTime->diffInMinutes($endWorkTime)
            : 0;

        $lunchMinutes = 0;
        if ($lunchStartTime && $lunchOutTime) {
            $lunchMinutes = $lunchStartTime->diffInMinutes($lunchOutTime);
        }

        $finalMinutes = $totalMinutes - $lunchMinutes;
        $finalHours = gmdate('H:i:s', $finalMinutes * 60);
        $data->update([
            'end_work' => $endWorkTime->format('H:i:s'),
            'lunch_count' => 0,
            'total_hours' => $finalHours,
            'event_count' => 0,
        ]);

        return response()->json([
            'success' => true,
            'fire' => 'out',
            'message' => 'Work End Successfully',
            'total_hours' => $finalHours,
            'data' => $data,
        ]);
    }

    public function TodayWorks(Request $request)
    {

        $request->validate([
            'employee_id' => 'required',
            'today_works' => 'required',
            'project_id' => 'required',
        ]);

        AttendanceInfo::updateOrCreate(
            [
                'employee_id' => $request->employee_id,
                'date' => today(),
            ],
            [
                'day' => now()->format('l'),
                'project_id' => $request->project_id,
                'today_works' => $request->today_works,
            ]
        );

        return back()->with('success', 'Today work saved successfully');
    }

    public function dailyAttendance(Request $request)
    {

        try {
            $request->validate([
                'status' => 'required',
            ]);

            AttendanceInfo::updateOrCreate(
                [
                    'employee_id' => $request->empId,
                    'date' => today(),
                ],
                [
                    'day' => now()->format('l'),
                    'status' => $request->status,
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Attendance Marked...',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Something Went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function TakeLeave(Request $request)
    {
        try {

            $request->validate([
                'employee_id' => 'required',
                'from_date' => 'required|date',
                'to_date' => 'required|date|after_or_equal:from_date',
                'reason' => 'required',
            ]);

            $leave = TakeLeave::create([
                'employee_id' => $request->employee_id,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'reason' => $request->reason,
            ]);

            $mailData = [
                'from_date' => $leave->from_date,
                'to_date' => $leave->to_date,
                'reason' => $leave->reason,
            ];

            $user = User::where('id', $request->employee_id)
                ->select('name', 'email', 'phone')
                ->first();

            Mail::to('developer4.filliptechnologies@gmail.com')->send(new ApplyLeaveMail($user, $mailData));

            return response()->json([
                'success' => true,
                'message' => 'Leave Apply Successfully with Email',
                'fire' => 'done',
                'data' => $leave,
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function leaveStatus(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'status' => 'required',
        ]);

        $data = TakeLeave::where('employee_id', $request->employee_id);

    }

    public function ViewLeave(Request $request)
    {
        try {
            $id = trim($request->id);
            $viewdata = TakeLeave::with(['employee'])->findOrFail($id);

            return response()->json([
                'message' => 'Leave data',
                'success' => true,
                'data' => $viewdata,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function statusApproved(Request $request)
    {
        try {
            $id = trim($request->id);
            $getdata = TakeLeave::with('employee')->findOrFail($id);
            if ($getdata) {
                $getdata->update([
                    'status' => 'approved',
                ]);
            }
            Mail::to($getdata->employee->email)->send(new ApproveMail($getdata));
            return response()->json([
                'message' => 'Leave Approved SuccessFul',
                'success' => true,
                'data' => $getdata,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'messahe' => 'Something Wend Wrong',
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function statusReject(Request $request)
    {
        try {
            $id = trim($request->id);
            $getdata = TakeLeave::findOrFail($id);
            if ($getdata) {
                $getdata->update([
                    'status' =>'reject',
                ]);
            }

            return response()->json([
                'message' => 'Leave Rejected SuccessFul',
                'success' => true,
                'data' => $getdata,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'messahe' => 'Something Wend Wrong',
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function statusDelete(Request $request)
    {
        try {
            $id = trim($request->id);
            $getdata = TakeLeave::findOrFail($id)->delete();

            return response()->json([
                'message' => 'Status deleted SuccessFul',
                'success' => true,
                'data' => $getdata,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'messahe' => 'Something Wend Wrong',
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
