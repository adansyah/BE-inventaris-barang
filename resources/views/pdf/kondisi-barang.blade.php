<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h3 style="text-align: center">DATA BARANG HASIL SENSUS/INVENTARIS BARANG </h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Hasil Inventarisasi</th>
                <th>Kondisi Baik</th>
                <th>Kondisi Rusak Berat</th>
                <th>Kehilangan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_kondisi as $tipe => $kondisi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ strtoupper($tipe) }}</td>
                    <td>{{ $kondisi['baik'] }}</td>
                    <td>{{ $kondisi['rusak berat'] }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        <tfoot>
            <td colspan="2">Total</td>
            <th>{{ $total_kondisi_baik }}</th>
            <th>{{ $total_kondisi_rusak }}</th>
            <th>-</th>
        </tfoot>
        </tbody>
    </table>

</body>

</html>
