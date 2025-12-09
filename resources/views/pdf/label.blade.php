<!DOCTYPE html>
<html>

<head>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 10px;
        }

        .label-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .label {
            width: 280px;
            padding: 8px;
            border: 2px solid #d4a017;
            background: white;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #777;
            padding-bottom: 3px;
            margin-bottom: 6px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .header img {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            object-fit: cover;
        }

        .header-text {
            font-size: 9px;
            font-weight: 600;
            line-height: 1;
        }

        .content {
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .qr-box {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            border: 1px solid #ddd;
            padding: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .text {
            flex: 1;
            font-size: 9px;
            line-height: 1.6;
        }

        .text-row {
            display: flex;
            margin-bottom: 2px;
        }

        .text-label {
            width: 40px;
            flex-shrink: 0;
        }

        .text-value {
            font-weight: 600;
            flex: 1;
            word-break: break-word;
        }

        /* Print optimization */
        @media print {

            /* Biar layout stabil */
            .content {
                display: table;
                width: 100%;
            }

            .qr-box {
                display: table-cell;
                width: 50px;
                vertical-align: top;
            }

            .text {
                display: table-cell;
                padding-left: 8px;
                vertical-align: top;
            }

            /* Biar row text tetap rata 3 kolom */
            .text-row {
                display: table;
                width: 100%;
            }

            .text-label,
            .text-row span:nth-child(2),
            .text-value {
                display: table-cell;
            }

            .text-label {
                width: 40px;
            }

            .text-row span:nth-child(2) {
                width: 5px;
                /* posisi titik dua */
            }

            .text-value {
                width: auto;
            }

            /* Kunci ukuran label biar tidak melebar */
            .label {
                width: 280px;
            }

            /* Hapus perubahan otomatis browser */
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }
    </style>
</head>

<body>
    <div class="label-container">
        @foreach ($items as $data)
            <div class="label">
                <!-- HEADER -->
                <div class="header">
                    <div class="header-left">
                        <img src="{{ public_path('logo.png') }}" alt="Logo">
                        <span class="header-text">PEM. KOTA BANDUNG</span>
                    </div>
                    <span class="header-text">KEC. BANDUNG KIDUL</span>
                </div>

                <!-- CONTENT -->
                <div class="content">
                    <!-- QR CODE -->
                    <div class="qr-box">
                        <img src="{{ public_path('storage/' . $data->gambar_qr) }}" alt="QR">
                    </div>

                    <!-- TEXT INFO -->
                    <div class="text">
                        <div class="text-row">
                            <span class="text-label">Kode</span>
                            <span>:</span>
                            <span class="text-value">{{ $data->kode_barang }}</span>
                        </div>
                        <div class="text-row">
                            <span class="text-label">Nama</span>
                            <span>:</span>
                            <span class="text-value">{{ $data->nama_barang }}</span>
                        </div>
                        <div class="text-row">
                            <span class="text-label">NUP</span>
                            <span>:</span>
                            <span class="text-value">{{ $data->nup ?? '0001' }}</span>
                        </div>
                        <div class="text-row">
                            <span class="text-label">Tahun</span>
                            <span>:</span>
                            <span class="text-value">{{ $data->tahun }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
