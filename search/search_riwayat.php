<?php
require '../config.php';

// Ambil nilai filter bulan dan tahun
$bulanTahun = $_POST['bulan_tahun'];

// Query data riwayat sesuai dengan filter bulan dan tahun
$query = "SELECT * FROM riwayat";
if (!empty($bulanTahun)) {
  $query .= " WHERE DATE_FORMAT(tanggal_riwayat, '%Y-%m') = '$bulanTahun'";
}
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
