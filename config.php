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


// Mengelola tabel "data_barang"




?>


