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
echo "<form method='post' action='cetak_faktur.php'>";
echo "<label for='penjualan'>Pilih Penjualan:</label>";
echo "<select name='penjualan' id='penjualan'>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['id_penjualan'] . "'>" . $row['id_penjualan'] . "</option>";
}
echo "</select>";
echo "<input type='submit' value='Cetak Faktur'>";
echo "</form>";


?>