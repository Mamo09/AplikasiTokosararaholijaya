<?php
require '../config.php';

// Ambil nilai filter tanggal awal dan akhir
$tanggalAwal = $_POST['tanggal_awal'];
$tanggalAkhir = $_POST['tanggal_akhir'];

// Query data riwayat sesuai dengan filter tanggal awal dan akhir
$query = "SELECT * FROM riwayat WHERE tanggal_riwayat BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";

// Lakukan query ke database sesuai dengan filter
$result = mysqli_query($conn, $query);

// Cek apakah ada data riwayat yang ditemukan
if (mysqli_num_rows($result) > 0) {
  // Tampilkan data riwayat dalam bentuk HTML
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['tanggal_riwayat'] . '</td>';
    echo '<td>' . $row['deskripsi'] . '</td>';
    echo '</tr>';
  }
} else {
  // Tampilkan pesan jika tidak ada data riwayat yang ditemukan
  echo '<tr><td colspan="3">Tidak ada data riwayat yang ditemukan.</td></tr>';
}
?>

?>
