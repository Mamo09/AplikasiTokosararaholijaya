<?php 

//menampilkan data
function query($query) {
	
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
}

//tambah data barang
function addbarang($data){
	global $conn;

	$kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $harga_modal = htmlspecialchars($data["harga_modal"]);
    $harga_satuan = htmlspecialchars($data["harga_satuan"]);

    $query = "INSERT INTO data_barang (kode_barang,nama_barang,kategori,harga_modal,harga_satuan)
    			VALUES 
    			('$kode_barang','$nama_barang','kategori','$harga_modal','$harga_satuan')
    			";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

//hapus data barang
function hapusbarang($kode_barang){

	global $conn;

	mysqli_query($conn, "DELETE FROM data_barang WHERE kode_barang = '$kode_barang'");

	return mysqli_affected_rows($conn);
}

//add data penjualan
function addpenjualan($data){
	global $conn;

	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$nama_pembeli = htmlspecialchars($data["nama_pembeli"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $tanggal_penjualan = htmlspecialchars($data["tanggal_penjualan"]);
    $jumlah_jual = htmlspecialchars($data["jumlah_jual"]);
    $harga_jual = htmlspecialchars($data["harga_jual"]);

    $query = "INSERT INTO penjualan 
    			VALUES
    			('','$kode_barang','$nama_pembeli','$nama_barang','$kategori','$tanggal_penjualan','$jumlah_jual','$harga_satuan')
    			";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}













 ?>

