<?php

namespace App\Exports;

use App\Models\AttendanceInfo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return AttendanceInfo::with(['employee', 'project'])->get();
    }

    public function map($attendance): array
    {
        return [
            $attendance->employee->name ?? '-',
            $attendance->project->name ?? '-',
            $attendance->date,
            $attendance->day,
            $attendance->start_work,
            $attendance->end_work,
            $attendance->lunch_start,
            $attendance->lunch_out,
            $attendance->total_hours,
            ucfirst($attendance->status),
           strip_tags($attendance->today_works),
        ];
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Project Name',
            'Date',
            'Day',
            'Start Work',
            'End Work',
            'Lunch Start',
            'Lunch Out',
            'Total Hours',
            'Status',
            'Today Works',
        ];
    }
}
