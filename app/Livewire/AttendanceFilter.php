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
    public $message = '';

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
        $customMessages = [
            'startDate.required' => 'La fecha de inicio es obligatoria.',
            'startDate.date' => 'La fecha de inicio debe ser una fecha válida.',
            'endDate.required' => 'La fecha de fin es obligatoria.',
            'endDate.date' => 'La fecha de fin debe ser una fecha válida.',
            'endDate.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];

        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ], $customMessages);

        $this->totalAttendances = Attendance::whereBetween('date_attendance', [$this->startDate, $this->endDate])->count();

        if ($this->totalAttendances === 0) {
            $this->message = 'No se encontraron asistencias registradas en esta fecha.';
        } else {
            $this->message = '';
        }
    }

    public function export()
    {
      return Excel::download(new AttendanceExport($this->startDate, $this->endDate), 'Asistencias_' . $this->startDate . '_to_' . $this->endDate . '.xlsx');
    }
}
