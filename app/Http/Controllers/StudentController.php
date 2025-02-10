<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ViolationType;
use Barryvdh\DomPDF\Facade\Pdf;


class StudentController extends Controller
{
    public function download(Student $record)
    {
        //$student = Student::with(['violations.violationType', 'classroom'])->find($record->id);
        $student = Student::with(['violations.violationType'])->find($record->id);
        $pdf = Pdf::loadView('student.download', ['student' => $student]);
 
        return $pdf->stream(); 
        // return view('student.download', compact('record', 'violation'));
    }
}
