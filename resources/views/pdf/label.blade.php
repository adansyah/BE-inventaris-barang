<!DOCTYPE html>
<html>

<head>
    <style>
        .label {
            width: 280px;
            padding: 6px;
            border: 1px solid #d4a017;
            margin-bottom: 10px;
            background: white;
            float: left;
            margin-right: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #777;
            margin-bottom: 4px;
        }

        .header img {
            width: 15px;
            height: 15px;
            border-radius: 50%;
        }

        .content {
            display: flex;
        }

        .qr-box img {
            width: 40px;
            height: 40px;
        }

        .text {
            margin-left: 5px;
            font-size: 10px;
        }
    </style>
</head>

<body>

    @foreach ($items as $data)
        <div class="label">

            <div class="header">
                <div style="display:flex; align-items:center; gap:2px;">
                    <img src="{{ public_path('logo.png') }}" alt="">
                    <span style="font-size:10px;">PEM. KOTA BANDUNG</span>
                </div>
                <span style="font-size:10px;">KEC. BANDUNG KIDUL</span>
            </div>

            <div class="content">
                <div class="qr-box">
                    <img src="{{ public_path('storage/' . $data->gambar_qr) }}" alt="QR">
                </div>

                <div class="text">
                    <div>Kode : <strong>{{ $data->kode_barang }}</strong></div>
                    <div>Nama : <strong>{{ $data->nama_barang }}</strong></div>
                    <div>NUP : <strong>{{ $data->nup }}</strong></div>
                    <div>Tahun : <strong>{{ $data->tahun }}</strong></div>
                </div>
            </div>

        </div>
    @endforeach

</body>

</html>
