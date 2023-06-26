<?php 

require 'config.php';
require_once('tcpdf/tcpdf.php');

// Cetak faktur
if (isset($_POST['penjualan'])) {
    $penjualan_ids = $_POST['penjualan'];

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

    // Array untuk menggabungkan data penjualan dengan nama pembeli dan tanggal yang sama
    $merged_penjualan = array();

    foreach ($penjualan_ids as $penjualan_id) {
        // Mendapatkan detail penjualan berdasarkan penjualan_id
        $sql = "SELECT p.id_penjualan, p.kode_barang, p.nama_pembeli, b.nama_barang, b.kategori, p.tanggal_penjualan, p.jumlah_jual, p.harga_jual
                FROM penjualan AS p
                INNER JOIN data_barang AS b ON p.kode_barang = b.kode_barang
                WHERE p.id_penjualan = '$penjualan_id'";
        $result = mysqli_query($conn, $sql);
        $penjualan = mysqli_fetch_assoc($result);

        // Membuat kunci berdasarkan nama pembeli dan tanggal penjualan
        $key = $penjualan['nama_pembeli'] . '-' . $penjualan['tanggal_penjualan'];

        // Menggabungkan data penjualan dengan nama pembeli dan tanggal yang sama
        if (isset($merged_penjualan[$key])) {
            $merged_penjualan[$key]['kode_barang'][] = $penjualan['kode_barang'];
            $merged_penjualan[$key]['nama_barang'][] = $penjualan['nama_barang'];
            $merged_penjualan[$key]['kategori'][] = $penjualan['kategori'];
            $merged_penjualan[$key]['jumlah_jual'][] = $penjualan['jumlah_jual'];
            $merged_penjualan[$key]['harga_jual'][] = $penjualan['harga_jual'];
        } else {
            $merged_penjualan[$key] = array(
                'nama_pembeli' => $penjualan['nama_pembeli'],
                'tanggal_penjualan' => $penjualan['tanggal_penjualan'],
                'kode_barang' => array($penjualan['kode_barang']),
                'nama_barang' => array($penjualan['nama_barang']),
                'kategori' => array($penjualan['kategori']),
                'jumlah_jual' => array($penjualan['jumlah_jual']),
                'harga_jual' => array($penjualan['harga_jual'])
            );
        }
    }

    foreach ($merged_penjualan as $data_penjualan) {
        // Nomor Faktur
        $nomor_faktur = 'INV/' . implode('-', $data_penjualan['kode_barang']) . '/' . $data_penjualan['tanggal_penjualan'];
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Nomor Faktur: ' . $nomor_faktur, 0, 1);

        // Tanggal
        $pdf->Cell(0, 10, 'Tanggal: ' . $data_penjualan['tanggal_penjualan'], 0, 1);

        // Nama Pembeli
        $pdf->Cell(0, 10, 'Nama Pembeli: ' . $data_penjualan['nama_pembeli'], 0, 1);

        // Item yang dibeli
        $pdf->Cell(0, 10, 'Item yang dibeli:', 0, 1);

        // Tabel
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(30, 10, 'Kode Barang', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Kategori', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Harga', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Total Harga', 1, 1, 'C');

        $pdf->SetFont('helvetica', '', 11);
        $total_harga = 0;

        // Menampilkan data penjualan yang digabungkan
        for ($i = 0; $i < count($data_penjualan['kode_barang']); $i++) {
            $pdf->Cell(30, 10, $data_penjualan['kode_barang'][$i], 1, 0, 'C');
            $pdf->Cell(40, 10, $data_penjualan['nama_barang'][$i], 1, 0, 'C');
            $pdf->Cell(30, 10, $data_penjualan['kategori'][$i], 1, 0, 'C');
            $pdf->Cell(25, 10, $data_penjualan['jumlah_jual'][$i], 1, 0, 'C');
            $pdf->Cell(30, 10, $data_penjualan['harga_jual'][$i], 1, 0, 'C');
            $total_harga += $data_penjualan['jumlah_jual'][$i] * $data_penjualan['harga_jual'][$i];
            $pdf->Cell(35, 10, $data_penjualan['jumlah_jual'][$i] * $data_penjualan['harga_jual'][$i], 1, 1, 'C');
        }

        $pdf->Cell(155, 10, 'Total Harga', 1, 0, 'R');
        $pdf->Cell(35, 10, $total_harga, 1, 1, 'C');
    }

    // Output PDF
    $file_name = 'faktur_penjualan.pdf';
    ob_end_clean(); // Membersihkan output sebelum menghasilkan PDF
    $pdf->Output($file_name, 'I');
    exit; // Menghentikan eksekusi script setelah selesai mencetak
}
?>