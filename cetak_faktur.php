<?php 

require 'config.php';
require_once('tcpdf/tcpdf.php');

// Cetak faktur
if (isset($_POST['penjualan'])) {
    $penjualan_id = $_POST['penjualan'];

    // Mendapatkan detail penjualan berdasarkan penjualan_id
    $sql = "SELECT p.id_penjualan, p.kode_barang, p.nama_pembeli, b.nama_barang, b.kategori, p.tanggal_penjualan, p.jumlah_jual, p.harga_jual
            FROM penjualan AS p
            INNER JOIN data_barang AS b ON p.kode_barang = b.kode_barang
            WHERE p.id_penjualan = '$penjualan_id'";
    $result = mysqli_query($conn, $sql);
    $penjualan = mysqli_fetch_assoc($result);

    // Generate PDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Company');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Faktur Penjualan');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Header
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Faktur Penjualan', 0, 1, 'C');

    // Nomor Faktur
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Nomor Faktur: ' . $penjualan['id_penjualan'], 0, 1);

    // Tanggal
    $pdf->Cell(0, 10, 'Tanggal: ' . $penjualan['tanggal_penjualan'], 0, 1);

    // Nama Pembeli
    $pdf->Cell(0, 10, 'Nama Pembeli: ' . $penjualan['nama_pembeli'], 0, 1);

    // Item yang dibeli
    $pdf->Cell(0, 10, 'Item yang dibeli:', 0, 1);

    // Tabel
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(30, 10, 'Kode Barang', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Nama Barang', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Kategori', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Jumlah', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Harga', 1, 0, 'C');
    $pdf->Cell(35, 10, 'Total Harga', 1, 1, 'C');

    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(30, 10, $penjualan['kode_barang'], 1, 0, 'C');
    $pdf->Cell(50, 10, $penjualan['nama_barang'], 1, 0, 'C');
    $pdf->Cell(40, 10, $penjualan['kategori'], 1, 0, 'C');
    $pdf->Cell(25, 10, $penjualan['jumlah_jual'], 1, 0, 'C');
    $pdf->Cell(30, 10, $penjualan['harga_jual'], 1, 0, 'C');
    $pdf->Cell(35, 10, ($penjualan['jumlah_jual'] * $penjualan['harga_jual']), 1, 1, 'C');

    // Output PDF
    $file_name = $penjualan['kode_barang'] . '_' . $penjualan['nama_pembeli'] . '_' . $penjualan['tanggal_penjualan'] . '.pdf';
    ob_end_clean(); // Membersihkan output sebelum menghasilkan PDF
    $pdf->Output($file_name, 'D');
    exit; // Menghentikan eksekusi script setelah menghasilkan PDF
}
?>