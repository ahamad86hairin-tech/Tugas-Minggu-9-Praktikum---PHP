<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form_data_diri.html");
    exit;
}


$nama = trim($_POST["nama"] ?? "");
$tanggalLahir = $_POST["tanggal_lahir"] ?? "";
$hobiDipilih = $_POST["hobi"] ?? [];


if ($nama === "") {
    die("Nama lengkap wajib diisi. <a href='form_data_diri.html'>Kembali ke Form</a>");
}


$tanggal = DateTime::createFromFormat("!Y-m-d", $tanggalLahir);
if (!$tanggal || $tanggal->format("Y-m-d") !== $tanggalLahir) {
    die("Tanggal lahir tidak valid. <a href='form_data_diri.html'>Kembali ke Form</a>");
}


$namaBulan = [
    1 => "Januari", "Februari", "Maret", "April",
    "Mei", "Juni", "Juli", "Agustus",
    "September", "Oktober", "November", "Desember"
];

$tanggalIndonesia = (int)$tanggal->format("d") . " " .
                    $namaBulan[(int)$tanggal->format("m")] . " " .
                    $tanggal->format("Y");


$daftarHobi = ["Membaca", "Olahraga", "Musik", "Lainnya"];
if (!is_array($hobiDipilih)) {
    $hobiDipilih = [];
}
$hobiValid = array_values(array_intersect($daftarHobi, $hobiDipilih));

if (count($hobiValid) > 0) {
    $hasilHobi = implode(", ", $hobiValid);
} else {
    $hasilHobi = "Tidak ada hobi yang dipilih";
}


$namaAman = htmlspecialchars($nama, ENT_QUOTES, "UTF-8");
$hobiAman = htmlspecialchars($hasilHobi, ENT_QUOTES, "UTF-8");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Data Diri</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 45px 16px;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f6f8;
            color: #222;
        }
        .card {
            max-width: 620px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,.08);
        }
        h1 {
            margin: 0 0 22px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e8e8e8;
            font-size: 25px;
        }
        .data-row {
            display: grid;
            grid-template-columns: 125px 1fr;
            gap: 12px;
            margin: 22px 0;
            line-height: 1.5;
        }
        .data-row strong { font-size: 15px; }
        .back {
            display: inline-block;
            margin-top: 22px;
            color: #087bfa;
            text-decoration: none;
            font-size: 14px;
        }
        .back:hover { text-decoration: underline; }
        @media (max-width: 480px) {
            .card { padding: 22px; }
            .data-row { grid-template-columns: 1fr; gap: 3px; }
        }
    </style>
</head>
<body>
    <main class="card">
        <h1>Tampilan Data Anda</h1>

        <div class="data-row">
            <strong>Nama Lengkap:</strong>
            <span><?= $namaAman ?></span>
        </div>

        <div class="data-row">
            <strong>Tanggal Lahir:</strong>
            <span><?= htmlspecialchars($tanggalIndonesia, ENT_QUOTES, "UTF-8") ?></span>
        </div>

        <div class="data-row">
            <strong>Hobi:</strong>
            <span><?= $hobiAman ?></span>
        </div>

        <a class="back" href="form_data_diri.html">&laquo; Kembali ke Form</a>
    </main>
</body>
</html>
