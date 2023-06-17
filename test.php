<?php

require 'cetak_faktur.php';
require_once('tcpdf/tcpdf.php');

// Koneksi ke database
    $servername = "localhost"; // ganti dengan nama server database Anda
    $username = "root"; // ganti dengan username database Anda
    $password = ""; // ganti dengan password database Anda
    $dbname = "toko_sararaholijaya"; // ganti dengan nama database Anda

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }



// Mendapatkan data penjualan
$sql = "SELECT * FROM penjualan";
$result = mysqli_query($conn, $sql);

// Formulir untuk memilih penjualan
echo "<form method='post' action='cetak_faktur.php' id='cetak-form'>";
echo "<label for='penjualan'>Pilih Penjualan:</label>";
echo "<select name='penjualan' id='penjualan'>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['id_penjualan'] . "'>" . $row['id_penjualan'] . "</option>";
}
echo "</select>";
echo "<input type='submit' value='Cetak Faktur'>";
echo "</form>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Filter Penjualan</title>
</head>
<body>
    <h2>Filter Penjualan Berdasarkan Tanggal</h2>
    <form method="POST" action="">
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" required>
        <button type="submit" name="submit">Filter</button>
    </form>

    <?php
    // Menampilkan data penjualan yang telah difilter
    if (isset($filteredPenjualan) && !empty($filteredPenjualan)) {
        echo "<h3>Data Penjualan pada Tanggal $tanggalFilter:</h3>";
        foreach ($filteredPenjualan as $penjualan) {
            echo 'ID: ' . $penjualan['id'] . ', Tanggal: ' . $penjualan['tanggal'] . ', Nama Barang: ' . $penjualan['nama_barang'] . '<br>';
        }
    }
    ?>

</body>
</html>