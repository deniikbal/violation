<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Download</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .kop-surat img {
            width: 100%;
            height: auto;
        }

        .content {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="kop-surat text-center">
        <img src="{{ public_path('images/kop_surat.png') }}" alt="Kop Surat" style="max-width: 100%; height: auto;">
    </div>

    <!-- Teks PELANGGARAN SISWA di tengah halaman -->
    <div class="content">
        <h3>REKAPIN PELANGGARAN SISWA</h3>
    </div>
    <p>Berikut data rekap Pelanggaran Siswa:</p>
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
          overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
          font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg .tg-km2t{border-color:#ffffff;font-weight:bold;text-align:left;vertical-align:top}
        .tg .tg-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
        </style>
        <table class="tg" style="undefined;table-layout: fixed; width: 303px"><colgroup>
        <col style="width: 119px">
        <col style="width: 22px">
        <col style="width: 162px">
        </colgroup>
        <thead>
          <tr>
            <th class="tg-km2t">Nama Lengkap</th>
            <th class="tg-zv4m">:</th>
            <th class="tg-zv4m">Deni Muhamad Ikbal</th>
          </tr></thead>
        <tbody>
          <tr>
            <td class="tg-km2t">NIS</td>
            <td class="tg-zv4m">:</td>
            <td class="tg-zv4m">0098776525</td>
          </tr>
          <tr>
            <td class="tg-km2t">Kelas</td>
            <td class="tg-zv4m">:</td>
            <td class="tg-zv4m">XII IPS 3</td>
          </tr>
        </tbody>
        </table>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
