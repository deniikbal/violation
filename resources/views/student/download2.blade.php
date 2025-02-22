<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Download</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="kop-surat">
                <img src="{{ public_path('images/kop_surat.png') }}" alt="Kop Surat">
            </div>
                <h4>LAPORAN PELANGGARAN SISWA</h4>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        
                        
                    </div>
                    
                        <h2>Data Siswa</h2>
                        <h3>Pelanggaran:</h3>
                        <ul>
                            {{$student->name}}
                                {{$student->nis}}
                                {{$student->classroom->name}}
                                @foreach ($student->violations as $violation)
                                    <li>
                                        ID Pelanggaran: {{ $violation->id }}<br>
                                        @if ($violation->violationType)
                                            Jenis Pelanggaran: {{ $violation->violationType->name }}<br>
                                            Point: {{ $violation->violationType->points }}<br>
                                            Tanggal : {{$violation->date}}
                                        @else
                                            Jenis Pelanggaran: Tidak Diketahui<br>
                                            Point: Tidak Diketahui<br>
                                        @endif
                                    </li>
                                @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
