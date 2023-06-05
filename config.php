<?php

session_start();
	
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

	
	//tambahkan data barang

	if(isset($_POST["adddatabarang"])){

    $kode_barang = $_POST["kode_barang"];
    $nama_barang = $_POST["nama_barang"];
    $kategori = $_POST["kategori"];
    $jumlah_stok = $_POST["jumlah_stok"];
    $harga_modal = $_POST["harga_modal"];
    $harga_satuan = $_POST["harga_satuan"];
  

  	$sql = "INSERT INTO data_barang (kode_barang, nama_barang, kategori, jumlah_stok, harga_modal, harga_satuan) VALUES ('$kode_barang','$nama_barang','$kategori','$jumlah_stok','$harga_modal','$harga_satuan')";
  
  	if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Data Berhasil Ditambahkan");</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
