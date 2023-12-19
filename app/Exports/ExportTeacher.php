<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportTeacher implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            "#",
            "Teacher Name",
            "Email",
            "Gender",
            "Date of Birth",
            "Date of Joining",
            "Mobile Number",
            "Marital Status",
            "Current Address",
            "Permanent Address",
            "Qualification",
            "Work Experience",
            "Note",
            "Status",
            "Created Date",
        ];
    }

    public function map($value): array
    {
        $teacher_name = $value->name . ' ' . $value->last_name;

        $date_of_birth = '';
        if (!empty($value->date_of_birth))
            $date_of_birth = date('d-m-Y', strtotime($value->date_of_birth));
        $admission_date = '';
        if (!empty($value->admission_date))
           $admission_date= date('d-m-Y', strtotime($value->admission_date));

        $status = $value->status == 0 ? 'Active' : 'Inactive';
        date('d-m-Y H:i A', strtotime($value->created_at));
        return [
            $value->id,
            $teacher_name,
            $value->email,
            $value->gender,
            $date_of_birth,
            $admission_date,
            $value->mobile_number,
            $value->marital_status,
            $value->address,

            $value->permanent_address,
            $value->qualification,
            $value->work_experience,
            $value->note,
            $status,
        ];
    }
    public function collection()
    {
        $remove_pagination = 1;
        return User::getTeacher(0,$remove_pagination);
    }
}
