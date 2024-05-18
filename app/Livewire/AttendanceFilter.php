<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Exports\AttendanceExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceFilter extends Component
{
    public $startDate;
    public $endDate;
    public $totalAttendances = 0;

    public function mount()
    {
        $today = now()->format('Y-m-d');
        $this->startDate = $today;
        $this->endDate = $today;
    }

    public function render()
    {
        return view('livewire.attendance-filter');
    }

    public function filter()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $this->totalAttendances = Attendance::whereBetween('date_attendance', [$this->startDate, $this->endDate])->count();
    }

    public function export()
    {
      return Excel::download(new AttendanceExport($this->startDate, $this->endDate), 'Asistencias_' . $this->startDate . '_to_' . $this->endDate . '.xlsx');
    }
}
