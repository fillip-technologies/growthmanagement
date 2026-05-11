<?php

namespace App\Http\Controllers;

use App\Models\AddTask;
use App\Models\AttendanceInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
