
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Produk</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #dde8ec;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #14263a;
        }

        h1 {
            margin-bottom: 30px;
            text-align: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 90%;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(20, 38, 58, 0.15);
        }

        .input {
            display: flex;
            flex-direction: column;
            margin: 10px 0;
        }

        label {
            margin-bottom: 5px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 8px;
            border: 2px solid #c3d1d9;
            border-radius: 8px;
        }

        input:focus {
            outline: none;
            border-color: #2457f5;
        }

        .button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            background: #14263a;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            color: white;
            font-weight: bold;
        }

        .button:hover {
            background-color: #2457f5;
        }

        .error {
            margin-top: 15px;
            padding: 10px;
            background-color: #ffe5e5;
            border: 1px solid #e74c3c;
            border-radius: 8px;
            color: #b71c1c;
        }

        .hasil {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f4f8fa;
        }

        th, td {
            border: 1px solid #c3d1d9;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #14263a;
            color: white;
        }

        .total {
            font-weight: bold;
            background-color: #fff0b3;
        }
    </style>
</head>

<body>
    <h1>Form Pemesanan Produk</h1>

    <div class="container">
        <form action="" method="POST">
            <div class="input">
                <label for="produk">Nama Produk</label>
                <input
                    type="text"
                    name="produk"
                    id="produk"
                    value="<?= htmlspecialchars($_POST['produk'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
            </div>

            <div class="input">
                <label for="jumlah">Jumlah</label>
                <input
                    type="number"
                    name="jumlah"
                    id="jumlah"
                    min="1"
                    value="<?= htmlspecialchars($_POST['jumlah'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
            </div>

            <div class="input">
                <label for="harga">Harga Satuan (Rp)</label>
                <input
                    type="number"
                    name="harga"
                    id="harga"
                    min="1"
                    value="<?= htmlspecialchars($_POST['harga'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
            </div>

            <input
                type="submit"
                class="button"
                name="btn_proses"
                value="Hitung Total"
            >

            <input
                type="reset"
                class="button"
                value="Hapus"
            >
        </form>

        <?php
        function hitungTotal($jumlah, $harga)
        {
            $total = $jumlah * $harga;


            $totalBayar = $total;

            return [
                'total' => $total,
                'totalBayar' => $totalBayar
            ];
        }

        if (isset($_POST['btn_proses'])) {
            $produk = trim($_POST['produk'] ?? '');
            $jumlahInput = $_POST['jumlah'] ?? '';
            $hargaInput = $_POST['harga'] ?? '';

            // Validasi menggunakan if else
            if (
                $produk == '' ||
                $jumlahInput === '' ||
                $hargaInput === ''
            ) {
                echo '<div class="error">Semua field wajib diisi!</div>';
            } else {
                $jumlah = filter_var($jumlahInput, FILTER_VALIDATE_INT);
                $harga = filter_var($hargaInput, FILTER_VALIDATE_FLOAT);

                if ($jumlah === false || $jumlah <= 0) {
                    echo '<div class="error">Jumlah harus lebih dari 0!</div>';
                } elseif ($harga === false || $harga <= 0) {
                    echo '<div class="error">Harga harus lebih dari 0!</div>';
                } else {
                    $hasil = hitungTotal($jumlah, $harga);

                    echo '<div class="hasil">';
                    echo '<h3>Hasil Pemesanan</h3>';

                    echo '<table>';
                    echo '<tr><th>Keterangan</th><th>Hasil</th></tr>';

                    echo '<tr><td>Nama Produk</td><td>'
                        . htmlspecialchars($produk, ENT_QUOTES, 'UTF-8')
                        . '</td></tr>';

                    echo '<tr><td>Jumlah</td><td>'
                        . number_format($jumlah, 0, ',', '.')
                        . '</td></tr>';

                    echo '<tr><td>Harga Satuan</td><td>Rp '
                        . number_format($harga, 0, ',', '.')
                        . '</td></tr>';

                    echo '<tr><td>Total Harga</td><td>Rp '
                        . number_format($hasil['total'], 0, ',', '.')
                        . '</td></tr>';


                    echo '<tr class="total"><td>Total Bayar</td><td>Rp '
                        . number_format($hasil['totalBayar'], 0, ',', '.')
                        . '</td></tr>';

                    echo '</table>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</body>
</html>