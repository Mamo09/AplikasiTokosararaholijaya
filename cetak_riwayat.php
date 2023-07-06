<?php
require 'config.php';
require_once __DIR__ . '/vendor/autoload.php'; // Memuat autoloader mpdf

use Mpdf\Mpdf;

// Cek apakah form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan tanggal mulai dan tanggal akhir dari input form
    $tanggalMulai = $_POST['tanggal_mulai'];
    $tanggalAkhir = $_POST['tanggal_akhir'];

    // Generate HTML untuk PDF
    $html = '
        <div>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 30%;"><img src="img/logo.jpg" alt="Logo" width="100" height="100"></td>
                    <td style="width: 70%; text-align: left;">
                        <h1>Toko Sararaholijaya</h1>
                        <h2>Riwayat Periode Tanggal</h2>
                        <p>Periode: ' . $tanggalMulai . ' - ' . $tanggalAkhir . '</p>
                    </td>
                </tr>
            </table>
        </div>
        </br>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Tanggal Riwayat</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
    ';

    // Query untuk mendapatkan data riwayat berdasarkan periode tanggal
    $sql = "SELECT tanggal_riwayat, deskripsi FROM riwayat WHERE tanggal_riwayat BETWEEN '$tanggalMulai' AND '$tanggalAkhir'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '
            <tr>
                <td>' . $row['tanggal_riwayat'] . '</td>
                <td>' . $row['deskripsi'] . '</td>
            </tr>
        ';
    }

    $html .= '
            </tbody>
        </table>
    ';

    // Buat file PDF menggunakan mPDF
    $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
    $mpdf->WriteHTML($html);

    // Nama file berdasarkan periode tanggal
    $namaFile = 'riwayat_periode_' . str_replace('-', '_', $tanggalMulai) . '-' . str_replace('-', '_', $tanggalAkhir) . '.pdf';

    // Output PDF
    $mpdf->Output($namaFile, 'I');
    exit; // Menghentikan eksekusi script setelah selesai mencetak
}
?>
