<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Prestasi;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use FPDF;

class PrintRekapStudentController extends Controller
{
    protected $pdf;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function print(Student $record)
    {
        Carbon::setLocale('id');
        // Ambil data siswa beserta pelanggaran dan jenis pelanggaran
        $student = Student::with(['violations.violationType'])->find($record->id);

        // Inisialisasi FPDF
        $this->pdf = new FPDF('P','mm','A4');
        $this->pdf->SetLeftMargin(15);

        // Tambahkan halaman baru
        $this->pdf->AddPage();

        // Set font dan ukuran teks
        $image = asset('images/kop_surat.png');
        $this->pdf->Image($image,5,5,0,0);
        $this->pdf->Ln(50);
        $this->pdf->SetFont('Times', 'B', 16);
        $this->pdf->Cell(190, 5, 'REKAP PELANGGARAN SISWA', 0, 0, 'C');
        $this->pdf->Ln(15);

        // Set font dan ukuran teks untuk judul "Data Pribadi Pendaftar"
        $this->pdf->SetFont('Times','', 12);
        $this->pdf->Cell(190, 7, 'Berikut adalah data pelanggaran atas nama : ', 0, 1, 'L');

        // Set font dan ukuran teks untuk data pribadi
        $this->pdf->SetFont('Times', '', 11);
        $this->pdf->Ln(5);

        // Tampilkan data pribadi siswa
        $this->pdf->SetX(50);
        $this->pdf->SetFont('Times', 'B', 12);
        $this->pdf->Cell(40, 7, 'Nama Lengkap', 0, 0, 'L');
        $this->pdf->Cell(5, 7, ':', 0, 0, 'L');
        $this->pdf->SetFont('Times', '', 12);
        $this->pdf->Cell(150, 7, $student->name, 0, 1, 'L');
        $this->pdf->SetX(50);
        $this->pdf->SetFont('Times', 'B', 12);
        $this->pdf->Cell(40, 7, 'NIS', 0, 0, 'L');
        $this->pdf->Cell(5, 7, ':', 0, 0, 'L');
        $this->pdf->SetFont('Times', '', 12);
        $this->pdf->Cell(150, 7, $student->nis, 0, 1, 'L');
        $this->pdf->SetX(50);
        $this->pdf->SetFont('Times', 'B', 12);
        $this->pdf->Cell(40, 7, 'Kelas', 0, 0, 'L');
        $this->pdf->Cell(5, 7, ':', 0, 0, 'L');
        $this->pdf->SetFont('Times', '', 12);
        $this->pdf->Cell(150, 7, $student->classroom->name, 0, 1, 'L');

        // Tampilkan data pelanggaran jika ada
        //$dateviolation = Carbon::parse($student->violations->date)->isoFormat('D MMMM YYYY');

        if ($student->violations->count() > 0) {
            $this->pdf->Ln(10);
            // Membuat header tabel
            $this->pdf->setX(20);
            $this->pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $this->pdf->Cell(60, 7, 'Jenis Pelanggaran', 1, 0, 'C');
            $this->pdf->Cell(30, 7, 'Point', 1, 0, 'C');
            $this->pdf->Cell(60, 7, 'Tanggal Pelanggaran', 1, 1, 'C');
            $this->pdf->setX(20);
            $no = 1;
            foreach ($student->violations as $violation) {
                $this->pdf->setX(20);
                $this->pdf->SetFont('Times', '', 10);
                $text1 = $violation->violationType ? $violation->violationType->name : 'Tidak Diketahui';
                $text2 = $violation->violationType ? $violation->violationType->points : 'Tidak Diketahui';
                $date01 = Carbon::parse($violation->date)->isoFormat('D MMMM YYYY'); // Tanggal yang sudah diformat

                // Simpan posisi awal
                $x = $this->pdf->GetX();
                $y = $this->pdf->GetY();

                // Cetak kolom pertama dengan MultiCell
                $this->pdf->SetX(30);
                //$this->pdf->SetLetterSpacing(0.5);
                $this->pdf->MultiCell(60, 7, $text1, 1, 'L');

                // Hitung tinggi maksimum dari MultiCell
                $cellHeight = $this->pdf->GetY() - $y;

                // Kembali ke posisi awal untuk mencetak nomor urut
                $this->pdf->SetXY($x, $y);
                $this->pdf->Cell(10, $cellHeight, $no++, 1, 0, 'C');

                // Set posisi untuk kolom kedua
                $this->pdf->SetXY($x + 70, $y); // Pindah ke posisi setelah kolom pertama
                $this->pdf->Cell(30, $cellHeight, $text2, 1, 0, 'C');

                // Set posisi untuk kolom ketiga
                $this->pdf->SetXY($x + 100, $y); // Pindah ke posisi setelah kolom kedua
                $this->pdf->Cell(60, $cellHeight, $date01, 1, 1, 'C');
            }

        }
        $totalPoints = $student->violations->sum(function ($violation) {
            return $violation->violationType ? $violation->violationType->points : 0;
        });
        // Tampilkan total point pelanggaran dengan nama siswa (bold)
        $this->pdf->Ln(10);
        // Set font normal untuk teks awal
        $this->pdf->SetFont('Times', '', 12); // Font normal
        $this->pdf->Cell(40, 7, 'Berdasarkan rekap pelanggaran total point pelanggaran '.$student->name.' adalah : '.$totalPoints.'', 0, 1, 'L');

        $date = Carbon::now()->isoFormat('D MMMM YYYY');
        $this->pdf->Ln(10);
        $this->pdf->setX(120);
        $this->pdf->SetFont('Times', '', 12);
        $this->pdf->Cell(40, 7, 'Bantarujeg, '.$date.'', 0, 1, 'L');
        $this->pdf->setX(120);
        $this->pdf->SetFont('Times', 'B', 12);
        $this->pdf->Cell(40, 7, 'Wakasek Kesiswaan', 0, 1, 'L');
        $this->pdf->Ln(30);
        $this->pdf->setX(120);
        $this->pdf->SetFont('Times', 'B', 12);
        $this->pdf->Cell(40, 7, 'Aam Amilasari, S.Pd.', 0, 1, 'L');
        $this->pdf->setX(120);
        $this->pdf->SetFont('Times', '', 12);
        $this->pdf->Cell(40, 7, 'NIP : 19850216 200901 2 003', 0, 1, 'L');

        // Output PDF
        $this->pdf->Output();
        exit;
    }
}
