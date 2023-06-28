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



// Tambah data penjualan
function addpenjualan($data){
    global $conn;

    $query = "SELECT kode_barang, nama_barang, kategori, jumlah_stok FROM data_barang";
    $result = mysqli_query($conn, $query);
    $kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_pembeli = htmlspecialchars($data["nama_pembeli"]);
    $tanggal_penjualan = htmlspecialchars($data["tanggal_penjualan"]);
    $jumlah_jual = htmlspecialchars($data["jumlah_jual"]);
    $harga_jual = htmlspecialchars($data["harga_jual"]);

    $select_barang_query = "SELECT nama_barang, kategori, jumlah_stok FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);

    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];
    $kategori = $barang['kategori'];
    $jumlah_stok = $barang['jumlah_stok'];

    // Hitung jumlah stok baru
    $stok_baru = $jumlah_stok - $jumlah_jual;

    if ($stok_baru >= 0) {
        $queryaddpenjualan = "INSERT INTO penjualan (id_penjualan, kode_barang, nama_pembeli, nama_barang, kategori, tanggal_penjualan, jumlah_jual, harga_jual)
            VALUES
            ('','$kode_barang','$nama_pembeli','$nama_barang','$kategori','$tanggal_penjualan',$jumlah_jual,$harga_jual)
            ";

        mysqli_query($conn, $queryaddpenjualan);

        // Update jumlah stok
        mysqli_query($conn, "UPDATE data_barang SET jumlah_stok = $stok_baru WHERE kode_barang = '$kode_barang'");

        return mysqli_affected_rows($conn);
    } else {
        // Stok tidak mencukupi
        return -1;
    }
}

// Edit data penjualan
function editpenjualan($data){
    global $conn;

    $query = "SELECT kode_barang, nama_barang, kategori FROM data_barang";
    $result = mysqli_query($conn, $query);

    $id_penjualan = $data["id_penjualan"];
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

    // Mengambil jumlah jual sebelumnya
    $query_jumlah_jual_sebelumnya = "SELECT jumlah_jual FROM penjualan WHERE id_penjualan = '$id_penjualan'";
    $result_jumlah_jual_sebelumnya = mysqli_query($conn, $query_jumlah_jual_sebelumnya);
    $jumlah_jual_sebelumnya = mysqli_fetch_assoc($result_jumlah_jual_sebelumnya)['jumlah_jual'];

    // Mengambil kode barang sebelumnya
    $query_kode_barang_sebelumnya = "SELECT kode_barang FROM penjualan WHERE id_penjualan = '$id_penjualan'";
    $result_kode_barang_sebelumnya = mysqli_query($conn, $query_kode_barang_sebelumnya);
    $kode_barang_sebelumnya = mysqli_fetch_assoc($result_kode_barang_sebelumnya)['kode_barang'];

    $queryeditpenjualan = "UPDATE penjualan SET 
            kode_barang = '$kode_barang',
            nama_pembeli = '$nama_pembeli',
            nama_barang = '$nama_barang',
            kategori = '$kategori',
            tanggal_penjualan = '$tanggal_penjualan',
            jumlah_jual = $jumlah_jual,
            harga_jual = $harga_jual
            WHERE id_penjualan = '$id_penjualan'
            ";

    if (mysqli_query($conn, $queryeditpenjualan)) {
        // Mengupdate jumlah stok
        if ($kode_barang !== $kode_barang_sebelumnya) {
            // Jika kode barang berubah, update stok untuk kedua barang
            mysqli_query($conn, "UPDATE data_barang SET jumlah_stok = jumlah_stok + $jumlah_jual_sebelumnya WHERE kode_barang = '$kode_barang_sebelumnya'");
            mysqli_query($conn, "UPDATE data_barang SET jumlah_stok = jumlah_stok - $jumlah_jual WHERE kode_barang = '$kode_barang'");
        } else {
            // Jika kode barang tetap, update stok dengan selisih jumlah jual
            $selisih_jumlah_jual = $jumlah_jual_sebelumnya - $jumlah_jual;
            mysqli_query($conn, "UPDATE data_barang SET jumlah_stok = jumlah_stok + $selisih_jumlah_jual WHERE kode_barang = '$kode_barang'");
        }

        return mysqli_affected_rows($conn);
    } else {
        return -1;
    }
}

// Hapus data penjualan
function hapuspenjualan($id_penjualan){
    global $conn;

    $query = "SELECT kode_barang, jumlah_jual FROM penjualan WHERE id_penjualan = '$id_penjualan'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $penjualan = mysqli_fetch_assoc($result);
        $kode_barang = $penjualan['kode_barang'];
        $jumlah_jual = $penjualan['jumlah_jual'];

        $select_barang_query = "SELECT jumlah_stok FROM data_barang WHERE kode_barang = '$kode_barang'";
        $select_barang_result = mysqli_query($conn, $select_barang_query);

        $barang = mysqli_fetch_assoc($select_barang_result);
        $jumlah_stok = $barang['jumlah_stok'];

        // Hitung jumlah stok baru
        $stok_baru = $jumlah_stok + $jumlah_jual;

        mysqli_query($conn, "DELETE FROM penjualan WHERE id_penjualan = '$id_penjualan'");

        // Update jumlah stok
        mysqli_query($conn, "UPDATE data_barang SET jumlah_stok = $stok_baru WHERE kode_barang = '$kode_barang'");

        return mysqli_affected_rows($conn);
    } else {
        return -1;
    }
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

// Add data pembelian
function addpembelian($data){
	global $conn;

	$query = "SELECT kode_barang, nama_barang FROM data_barang";
	$result = mysqli_query($conn, $query);

	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$tanggal_pembelian = htmlspecialchars($data["tanggal_pembelian"]);
	$jumlah_beli = htmlspecialchars($data["jumlah_beli"]);
	$harga_beli = htmlspecialchars($data["harga_beli"]);

	// Upload gambar 
	$kwitansi = upload();
	if(!$kwitansi){
		return false;
	}

	$select_barang_query = "SELECT nama_barang, jumlah_stok FROM data_barang WHERE kode_barang = '$kode_barang'";
	$select_barang_result = mysqli_query($conn, $select_barang_query);

	if(mysqli_num_rows($select_barang_result) > 0) {
		$barang = mysqli_fetch_assoc($select_barang_result);
		$nama_barang = $barang['nama_barang'];
		$jumlah_stok = $barang['jumlah_stok'];

		$queryaddpembelian = "INSERT INTO pembelian (id_pembelian, kode_barang, nama_barang, tanggal_pembelian, jumlah_beli, harga_beli, kwitansi)
					VALUES
					('','$kode_barang','$nama_barang','$tanggal_pembelian',$jumlah_beli,$harga_beli,'$kwitansi')
					";

		mysqli_query($conn, $queryaddpembelian);

		// Update jumlah_stok pada data_barang
		updateJumlahStok($kode_barang, $jumlah_beli, $jumlah_stok);

		return mysqli_affected_rows($conn);
	} else {
		return false; // Barang tidak ditemukan
	}
}

// Update jumlah stok pada data_barang
function updateJumlahStok($kode_barang, $selisih_jumlah_beli, $jumlah_stok){
	global $conn;

	$jumlah_stok_baru = $jumlah_stok + $selisih_jumlah_beli;

	if ($jumlah_stok_baru < 0) {
		$jumlah_stok_baru = 0; // Jumlah stok tidak boleh negatif
	}

	$query = "UPDATE data_barang SET jumlah_stok = $jumlah_stok_baru WHERE kode_barang = '$kode_barang'";
	mysqli_query($conn, $query);
}

// Edit data pembelian
function editpembelian($data){
	global $conn;

	$query = "SELECT kode_barang, nama_barang FROM data_barang";
	$result = mysqli_query($conn, $query);

	$id_pembelian = $data["id_pembelian"];
	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$tanggal_pembelian = htmlspecialchars($data["tanggal_pembelian"]);
	$jumlah_beli = htmlspecialchars($data["jumlah_beli"]);
	$harga_beli = htmlspecialchars($data["harga_beli"]);
	$kwitansiLama = $data["kwitansiLama"];

	if($_FILES['kwitansi']['error']==4){
		$kwitansi = $kwitansiLama;
	} else {
		$kwitansi = upload();
	}

	$select_barang_query = "SELECT nama_barang, jumlah_stok FROM data_barang WHERE kode_barang = '$kode_barang'";
	$select_barang_result = mysqli_query($conn, $select_barang_query);

	if(mysqli_num_rows($select_barang_result) > 0) {
		$barang = mysqli_fetch_assoc($select_barang_result);
		$nama_barang = $barang['nama_barang'];
		$jumlah_stok = $barang['jumlah_stok'];

		$select_pembelian_query = "SELECT jumlah_beli FROM pembelian WHERE id_pembelian = '$id_pembelian'";
		$select_pembelian_result = mysqli_query($conn, $select_pembelian_query);
		$pembelian = mysqli_fetch_assoc($select_pembelian_result);
		$jumlah_beli_lama = $pembelian['jumlah_beli'];

		$queryeditpembelian = "UPDATE pembelian SET
								kode_barang = '$kode_barang',
								nama_barang = '$nama_barang',
								tanggal_pembelian = '$tanggal_pembelian',
								jumlah_beli = $jumlah_beli,
								harga_beli = $harga_beli,
								kwitansi = '$kwitansi'
								WHERE id_pembelian = $id_pembelian";

		mysqli_query($conn, $queryeditpembelian);

		// Update jumlah_stok pada data_barang
		$selisih_jumlah_beli = $jumlah_beli - $jumlah_beli_lama;
		updateJumlahStok($kode_barang, $selisih_jumlah_beli, $jumlah_stok);

		return mysqli_affected_rows($conn);
	} else {
		return false; // Barang tidak ditemukan
	}
}

// Hapus data pembelian
function hapuspembelian($id_pembelian){
	global $conn;

	$select_pembelian_query = "SELECT kode_barang, jumlah_beli FROM pembelian WHERE id_pembelian = '$id_pembelian'";
	$select_pembelian_result = mysqli_query($conn, $select_pembelian_query);

	if(mysqli_num_rows($select_pembelian_result) > 0) {
		$pembelian = mysqli_fetch_assoc($select_pembelian_result);
		$kode_barang = $pembelian['kode_barang'];
		$jumlah_beli = $pembelian['jumlah_beli'];

		$select_barang_query = "SELECT jumlah_stok FROM data_barang WHERE kode_barang = '$kode_barang'";
		$select_barang_result = mysqli_query($conn, $select_barang_query);

		if(mysqli_num_rows($select_barang_result) > 0) {
			$barang = mysqli_fetch_assoc($select_barang_result);
			$jumlah_stok = $barang['jumlah_stok'];

			mysqli_query($conn, "DELETE FROM pembelian WHERE id_pembelian = '$id_pembelian'");

			// Update jumlah_stok pada data_barang
			updateJumlahStok($kode_barang, -$jumlah_beli, $jumlah_stok);

			return mysqli_affected_rows($conn);
		} else {
			return false; // Barang tidak ditemukan
		}
	} else {
		return false; // Pembelian tidak ditemukan
	}
}



//untuk melakukan pencarian
function caripenjualan($keyword, $tanggalFilter){

	global $awaldata, $jumlahdataperhalaman,$halamanaktif;

	$awaldata = ($halamanaktif - 1) * $jumlahdataperhalaman;

    $sql = "SELECT * FROM penjualan 
    			WHERE (nama_barang LIKE '%$keyword%' OR 
    			nama_pembeli LIKE '%$keyword%' OR
    			kategori LIKE '%$keyword%')
    			";

    if ($tanggalFilter != '') {
        $sql .= " AND tanggal_penjualan = '$tanggalFilter'";
    }

    $sql .= " LIMIT $awaldata, $jumlahdataperhalaman";

    $result = query($sql);
    return $result;

}

function caribarang($keywordbarang){
    $query = "SELECT * FROM data_barang
                WHERE nama_barang LIKE '%$keywordbarang%' OR
                kode_barang LIKE '%$keywordbarang%' OR
                kategori LIKE '%$keywordbarang%'
                ";

    return query($query);
}

function caripembelian($keyword, $tanggalFilter, $sort){
    $query = "SELECT * FROM pembelian
                WHERE (kode_barang LIKE '%$keyword%' OR
                nama_barang LIKE '%$keyword%')
                ";

    if ($tanggalFilter != '') {
        $query .= "AND tanggal_pembelian = '$tanggalFilter'";
    }

    $query .= " ORDER BY tanggal_pembelian $sort";

    return query($query);
}

 ?>

