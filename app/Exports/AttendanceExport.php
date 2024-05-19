<?php

namespace App\Exports;

use App\Models\Attendance;
// use App\Models\type_degree;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Attendance::whereBetween('date_attendance', [$this->startDate, $this->endDate])
            ->with(['client.degree'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'FECHA',
            'DOCUMENTO',
            'NOMBRES',
            'APELLIDOS',
            'GÉNERO',
            'GRADO',
            'TIPO_DE_GRADO',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->date_attendance,
            $attendance->client->document,
            $attendance->client->name,
            $attendance->client->surname,
            $attendance->client->gender,
            $attendance->client->degree->name,
            $attendance->client->typeClient->name,
        ];
    }
}
