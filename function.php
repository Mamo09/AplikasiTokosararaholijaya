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
    			('$kode_barang','$nama_barang','$kategori',$harga_modal,$harga_satuan)
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

//edit data barang
function updatebarang($data){

	global $conn;

	$kode_barang = $data["kode_barang"];
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $harga_modal = htmlspecialchars($data["harga_modal"]);
    $harga_satuan = htmlspecialchars($data["harga_satuan"]);

    $query = "UPDATE data_barang SET 
    			nama_barang = '$nama_barang',
    			kategori = '$kategori',
    			harga_modal = $harga_modal,
    			harga_satuan = $harga_satuan 
    			WHERE kode_barang = '$kode_barang'
    			"; 

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

//edit stok barang
function editstok($data){

	global $conn;

	$kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $harga_modal = htmlspecialchars($data["harga_modal"]);
    $harga_satuan = htmlspecialchars($data["harga_satuan"]);
    $jumlah_stok = htmlspecialchars($data["jumlah_stok"]);

    $query = "UPDATE data_barang SET
    			nama_barang = '$nama_barang',
    			kategori = '$kategori',
    			harga_modal = $harga_modal,
    			harga_satuan = $harga_satuan,
    			jumlah_stok	= $jumlah_stok 
    			WHERE kode_barang = '$kode_barang'
    			";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

//add data penjualan
function addpenjualan($data){
	global $conn;

	$query = "SELECT kode_barang, nama_barang, kategori FROM data_barang";
	$result = mysqli_query($conn, $query);

	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$nama_pembeli = htmlspecialchars($data["nama_pembeli"]);
    $tanggal_penjualan = htmlspecialchars($data["tanggal_penjualan"]);
    $jumlah_jual = htmlspecialchars($data["jumlah_jual"]);
    $harga_jual = htmlspecialchars($data["harga_jual"]);

    $select_barang_query = "SELECT nama_barang, kategori FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);


    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];
    $kategori = $barang['kategori'];

    $queryaddpenjualan = "INSERT INTO penjualan (id_penjualan, kode_barang, nama_pembeli, nama_barang, kategori, tanggal_penjualan, jumlah_jual, harga_jual)
    			VALUES
    			('','$kode_barang','$nama_pembeli','$nama_barang','$kategori','$tanggal_penjualan',$jumlah_jual,$harga_jual)
    			";

    mysqli_query($conn, $queryaddpenjualan);

    return mysqli_affected_rows($conn);
}

//hapus data penjualan

function hapuspenjualan($id_penjualan){

	global $conn;

	mysqli_query($conn, "DELETE FROM penjualan WHERE id_penjualan = '$id_penjualan'");

	return mysqli_affected_rows($conn);
}



function addpembelian($data){
	global $conn;

	$query = "SELECT kode_barang, nama_barang FROM data_barang";
	$result = mysqli_query($conn, $query);

	$kode_barang = htmlspecialchars($data["kode_barang"]);
    $tanggal_pembelian = htmlspecialchars($data["tanggal_pembelian"]);
    $jumlah_beli = htmlspecialchars($data["jumlah_beli"]);
    $harga_beli = htmlspecialchars($data["harga_beli"]);

	// upload gambar 
    $kwitansi = upload();
    if(!$kwitansi){
    	return false;
    }




    $select_barang_query = "SELECT nama_barang FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);

    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];

    $queryaddpembelian = "INSERT INTO pembelian (id_pembelian, kode_barang, nama_barang, tanggal_pembelian, jumlah_beli, harga_beli, kwitansi)
    			VALUES
    			('','$kode_barang','$nama_barang','$tanggal_pembelian',$jumlah_beli,$harga_beli,'$kwitansi')
    			";

    mysqli_query($conn, $queryaddpembelian);

    return mysqli_affected_rows($conn);
}

function upload(){

	$namaFile = $_FILES['kwitansi']['name'];
	$ukuranFile = $_FILES['kwitansi']['size'];
	$error = $_FILES['kwitansi']['error'];
	$tmpName = $_FILES['kwitansi']['tmp_name'];

	//cek gambar ada atau tidak
	if( $error === 4){
		echo "  <script>
              alert('Pilih Gambar Terlebih Dahulu');
            </script>
        ";
        return false;
	}

	//cek upload kalau itu gambar
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = explode('.',$namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));

	if(!in_array($ekstensiGambar,$ekstensiGambarValid)){
		echo "  <script>
              alert('File yang Masukkan Bukan Gambar');
            </script>
        ";
        return false;
	}

	//cek ukuran file gambar
	if( $ukuranFile >2000000){
		echo "  <script>
              alert('Ukuran Gambar Terlalu besarF');
            </script>
        ";
        return false;
	}

	//upload gambar
	$namaFileBaru = uniqid();
	$namaFileBaru .='.' ;
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, 'temp_img/'.$namaFileBaru);

	return $namaFileBaru;

}




function hapuspembelian($id_pembelian){

	global $conn;

	mysqli_query($conn, "DELETE FROM pembelian WHERE id_pembelian = '$id_pembelian'");

	return mysqli_affected_rows($conn);
}




 ?>

