<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h3 style="text-align: center">DATA BARANG HASIL SENSUS/INVENTARIS KONDISI BARANG BAIK</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama/Jenis Barang</th>
                <th>Register</th>
                <th>Merk</th>
                <th>Tahun Perolehan</th>
                <th>Harga Perolehan</th>
            </tr>
        </thead>
        @foreach ($kib as $data)
            <tbody>
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nama_barang }}</td>
                    <td>{{ $data->no_register }}</td>
                    <td>Dell</td>
                    <td>{{ $data->created_at->translatedFormat('Y') }}</td>
                    <td>{{ number_format($data->harga_satuan) }}</td>
                </tr>
            </tbody>
        @endforeach

        <tfoot>
            <tr>
                <td colspan="5">Total</td>
                <th>Rp.{{ number_format($total) }}</th>
            </tr>
        </tfoot>

    </table>

</body>

</html>
