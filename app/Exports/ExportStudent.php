<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportStudent implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            "#",
            "Name",
            "Parent Name",
            "Gender",
            "Date of Birth",
            "Class Name",
            "Admission Number",
            "Roll Number",
            "Email",
            "Mobile",
            "Admission Date",
            "Status",
            "Height",
            "Weight",
            "Caste",
            "Religion",
            "Blood Group",
            "Created Date",
        ];
    }

    public function map($value):array
    {
        $student_name = $value->name.' '.$value->last_name;
        $parent_name = $value->parent_name.' '.$value->parent_last_name;
        return [
            $value->id,
            $student_name,
            $parent_name,
            $value->gender,
            date('d-m-Y', strtotime($value->date_of_birth)) ,
            $value->class_name,
            $value->admission_number,
            $value->roll_number,
            $value->email ,
            $value->mobile_number,
           date('d-m-Y', strtotime($value->admission_date)) ,
            $value->status == 0 ? 'Active' : 'In Active',
            $value->height,
            $value->weight,
            $value->caste,
            $value->religion,
            $value->blood_group,
            date('d-m-Y H:i A', strtotime($value->created_at)) ,

        ];
    }
    public function collection()
    {
        $remove_pagination =1;
        return User::getStudent(0,$remove_pagination);
    }
}
