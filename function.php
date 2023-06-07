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

function addbarang($data){
	global $conn;

	$kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $harga_modal = htmlspecialchars($data["harga_modal"]);
    $harga_satuan = htmlspecialchars($data["harga_satuan"]);

    $query = "INSERT INTO data_barang 
    			VALUES
    			('$kode_barang','$nama_barang','kategori','$harga_modal','$harga_satuan')
    			";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusbarang($kode_barang){

	global $conn;

	mysqli_query($conn, "DELETE FROM data_barang WHERE kode_barang = '$kode_barang'");

	return mysqli_affected_rows($conn);
}

 ?>