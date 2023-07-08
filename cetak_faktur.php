<?php


require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

require 'config.php';

// Cetak faktur
if (isset($_POST['penjualan'])) {
    $penjualan_ids = $_POST['penjualan'];

    // Generate PDF
    $mpdf = new Mpdf();
    $mpdf->SetTitle('Faktur Penjualan');

    // Array untuk menggabungkan data penjualan dengan nama pembeli dan tanggal yang sama
    $merged_penjualan = array();

    foreach ($penjualan_ids as $penjualan_id) {
        // Mendapatkan detail penjualan berdasarkan penjualan_id
        $sql = "SELECT p.id_penjualan, p.kode_barang, p.nama_pembeli, b.nama_barang, b.kategori, p.tanggal_penjualan, p.jumlah_jual, p.harga_jual
                FROM penjualan AS p
                INNER JOIN data_barang AS b ON p.kode_barang = b.kode_barang
                WHERE p.id_penjualan = '$penjualan_id'";
        $result = $conn->query($sql);
        $penjualan = $result->fetch_assoc();

        // Membuat kunci berdasarkan nama pembeli dan tanggal penjualan
        $key = $penjualan['nama_pembeli'] . '-' . $penjualan['tanggal_penjualan'];

        // Menggabungkan data penjualan dengan nama pembeli dan tanggal yang sama
        if (isset($merged_penjualan[$key])) {
            $merged_penjualan[$key]['kode_barang'][] = $penjualan['kode_barang'];
            $merged_penjualan[$key]['nama_barang'][] = $penjualan['nama_barang'];
            $merged_penjualan[$key]['kategori'][] = $penjualan['kategori'];
            $merged_penjualan[$key]['jumlah_jual'][] = $penjualan['jumlah_jual'];
            $merged_penjualan[$key]['harga_jual'][] = $penjualan['harga_jual'];
            $merged_penjualan[$key]['total_harga'][] = $penjualan['jumlah_jual'] * $penjualan['harga_jual'];
        } else {
            $merged_penjualan[$key] = array(
                'nama_pembeli' => $penjualan['nama_pembeli'],
                'tanggal_penjualan' => $penjualan['tanggal_penjualan'],
                'kode_barang' => array($penjualan['kode_barang']),
                'nama_barang' => array($penjualan['nama_barang']),
                'kategori' => array($penjualan['kategori']),
                'jumlah_jual' => array($penjualan['jumlah_jual']),
                'harga_jual' => array($penjualan['harga_jual']),
                'total_harga' => array($penjualan['jumlah_jual'] * $penjualan['harga_jual'])
            );
        }
    }

    foreach ($merged_penjualan as $data_penjualan) {
        // Header
        $mpdf->WriteHTML('
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 20%;">
                    <img src="img/logo.jpg" alt="Logo" width="70" height="70" >

                    </td>
                    <td style="width: 80%; text-align: left;">
                        <h1>Toko Sararaholi jaya</h1>
                        <p>jl. Sirao No. 14 Kel. Pasar, Gunungsitoli, Sumatera Utara</p>
                    </td>
                
                </tr>

            </table>
            <hr style="border: 1px solid #000; margin-top: 10px;">');

        // Nomor Faktur
        $nomor_faktur = 'INV/' . rand(1000000000, 9999999999) . '/' . str_replace('-', '', $data_penjualan['tanggal_penjualan']);
        $mpdf->WriteHTML('<p>Nomor Faktur: ' . $nomor_faktur . '</p>');


        // Nama Pembeli
        $mpdf->WriteHTML('<p>Nama Pembeli: ' . $data_penjualan['nama_pembeli'] . '</p>');
        // Tanggal
        $tanggal_penjualan = date('d F Y', strtotime($data_penjualan['tanggal_penjualan']));
        $mpdf->WriteHTML('<p>Tanggal: ' . $tanggal_penjualan . '</p>');

        

        // Item yang dibeli
        $mpdf->WriteHTML('<p>Item yang dibeli:</p>');

        // Tabel
        $html = '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>';

        $total_harga = 0;
        $nomor_item = 1;

        for ($i = 0; $i < count($data_penjualan['kode_barang']); $i++) {
            $html .= '<tr>
                        <td>' . $nomor_item . '</td>
                        <td>' . $data_penjualan['kode_barang'][$i] . '</td>
                        <td>' . $data_penjualan['nama_barang'][$i] . '</td>
                        <td>' . $data_penjualan['kategori'][$i] . '</td>
                        <td>' . $data_penjualan['jumlah_jual'][$i] . '</td>
                        <td>' . $data_penjualan['harga_jual'][$i] . '</td>
                        <td>' . $data_penjualan['total_harga'][$i] . '</td>
                    </tr>';

            $total_harga += $data_penjualan['total_harga'][$i];
            $nomor_item++;
        }

        $html .= '</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">Total Harga</td>
                            <td>' . $total_harga . '</td>
                        </tr>
                    </tfoot>
                </table>';

        $mpdf->WriteHTML($html);
        $mpdf->AddPage();
    }

    // Output PDF dengan nama file yang disesuaikan
    $nama_pembeli = str_replace(' ', '_', $data_penjualan['nama_pembeli']);
    $tanggal_penjualan = str_replace('-', '', $data_penjualan['tanggal_penjualan']);
    $file_name = $nama_pembeli . '-' . $tanggal_penjualan . '.pdf';

    $mpdf->Output($file_name, 'D');
    exit; // Menghentikan eksekusi script setelah selesai mencetak
}



?>
