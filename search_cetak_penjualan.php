<?php 
require 'config.php';

$searchText = $_POST['search'];
$searchDate = $_POST['date'];


// Membangun query pencarian
$sql = "SELECT * FROM penjualan WHERE 1=1";

// Mengecek apakah ada teks pencarian
if (!empty($searchText)) {
  $sql .= " AND nama_barang LIKE '%$searchText%'
  OR nama_pembeli LIKE '%$searchText%'";
}

// Mengecek apakah ada tanggal pencarian
if (!empty($searchDate)) {
  $sql .= " AND tanggal_penjualan = '$searchDate'";
}

$result = mysqli_query($conn, $sql);

// Memperbarui tabel penjualan dengan hasil pencarian
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["nama_pembeli"] . "</td>";
    echo "<td>" . $row["kode_barang"] . "</td>";
    echo "<td>" . $row["nama_barang"] . "</td>";
    echo "<td>" . $row["tanggal_penjualan"] . "</td>";
    echo "<td>";
    echo "<label for='penjualan_" . $row["id_penjualan"] . "'>";
    echo "<input type='checkbox' name='penjualan[]' id='penjualan_" . $row["id_penjualan"] . "' value='" . $row["id_penjualan"] . "'>";
    echo "</label>";
    echo "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='4'>Tidak ditemukan hasil pencarian</td></tr>";
}

mysqli_close($conn);
?>
 ?>