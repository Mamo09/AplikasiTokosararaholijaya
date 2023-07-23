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

    // Periksa apakah kode_barang sudah ada dalam tabel data_barang
    $check_query = "SELECT kode_barang FROM data_barang WHERE kode_barang = '$kode_barang'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Kode_barang sudah ada, kirim peringatan dan kembali ke halaman sebelumnya
        return -1;
    } else {
        // Kode_barang belum ada, lanjutkan proses penambahan
        $query = "INSERT INTO data_barang (kode_barang, nama_barang, kategori, harga_modal, harga_satuan)
                    VALUES 
                    ('$kode_barang', '$nama_barang', '$kategori', $harga_modal, $harga_satuan)
                    ";

        mysqli_query($conn, $query);


        $riwayat_data = array(
		    'kode_barang' => $kode_barang,
		    'nama_barang' => $nama_barang,
		    'kategori' => $kategori,
		    'harga_modal'=> $harga_modal,
		    'harga_satuan'=> $harga_satuan
		);

    	catatRiwayatDataBarang('menambah', $riwayat_data);

        return mysqli_affected_rows($conn);
    }
}


function hapusbarang($kode_barang) {
    global $conn;

    // Ambil data barang sebelum dihapus
    $select_barang_query = "SELECT kode_barang, nama_barang, kategori, harga_modal, harga_satuan FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);
    $barang = mysqli_fetch_assoc($select_barang_result);

    if ($barang) {
        // Hapus data barang
        mysqli_query($conn, "DELETE FROM data_barang WHERE kode_barang = '$kode_barang'");

        $riwayat_data = array(
            'kode_barang' => $barang['kode_barang'],
            'nama_barang' => $barang['nama_barang'],
            'kategori' => $barang['kategori'],
            'harga_modal' => $barang['harga_modal'],
            'harga_satuan' => $barang['harga_satuan']
        );

        catatRiwayatDataBarang('menghapus', $riwayat_data);

        return mysqli_affected_rows($conn);
    } else {
        // Handle the case when $barang is null
        return 0;
    }
}


function updatebarang($data){
    global $conn;

    $kode_barang = $data["kode_barang"];
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $harga_modal = htmlspecialchars($data["harga_modal"]);
    $harga_satuan = htmlspecialchars($data["harga_satuan"]);

    // Ambil data barang sebelum diupdate
    $select_barang_query = "SELECT kode_barang, nama_barang, kategori, harga_modal, harga_satuan FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);
    $barang_lama = mysqli_fetch_assoc($select_barang_result);

    $query = "UPDATE data_barang SET
                nama_barang = '$nama_barang',
                kategori = '$kategori',
                harga_modal = $harga_modal,
                harga_satuan = $harga_satuan
                WHERE kode_barang = '$kode_barang'
                ";

    mysqli_query($conn, $query);


    catatRiwayatDataBarang('mengedit', $data);

    return mysqli_affected_rows($conn);

}

function editstok($data){
    global $conn;

    $kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $harga_modal = htmlspecialchars($data["harga_modal"]);
    $harga_satuan = htmlspecialchars($data["harga_satuan"]);
    $jumlah_stok = htmlspecialchars($data["jumlah_stok"]);

    // Ambil data barang sebelum diupdate
    $select_barang_query = "SELECT kode_barang, nama_barang, kategori, harga_modal, harga_satuan, jumlah_stok FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);
    $barang_lama = mysqli_fetch_assoc($select_barang_result);

    $query = "UPDATE data_barang SET
                nama_barang = '$nama_barang',
                kategori = '$kategori',
                harga_modal = $harga_modal,
                harga_satuan = $harga_satuan,
                jumlah_stok = $jumlah_stok
                WHERE kode_barang = '$kode_barang'
                ";

    mysqli_query($conn, $query);


    catatRiwayatstokbarang('mengedit', $data);

    return mysqli_affected_rows($conn);

}




// Fungsi untuk menambah data penjualan
function addpenjualan($data){
    global $conn;

    // Periksa apakah pengguna yang login adalah admin
    if ($_SESSION['role'] !== 'admin') {
        return -1; // Jika bukan admin, return -1 sebagai indikasi akses ditolak
    }

    $query = "SELECT kode_barang, nama_barang, kategori, jumlah_stok, harga_satuan FROM data_barang";
    $result = mysqli_query($conn, $query);
    $kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_pembeli = htmlspecialchars($data["nama_pembeli"]);
    $tanggal_penjualan = htmlspecialchars($data["tanggal_penjualan"]);
    $jumlah_jual = htmlspecialchars($data["jumlah_jual"]);
    $potongan = htmlspecialchars($data["potongan"]);

    $select_barang_query = "SELECT nama_barang, kategori, jumlah_stok, harga_satuan FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);

    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];
    $kategori = $barang['kategori'];
    $jumlah_stok = $barang['jumlah_stok'];
    $harga_satuan = $barang['harga_satuan'];

    // Hitung jumlah stok baru
    $stok_baru = $jumlah_stok - $jumlah_jual;

    if ($stok_baru >= 0) {
        // Hitung harga total
        $harga_total = $harga_satuan * $jumlah_jual - $potongan;

        $queryaddpenjualan = "INSERT INTO penjualan (id_penjualan, kode_barang, nama_pembeli, nama_barang, kategori, tanggal_penjualan, jumlah_jual, potongan, harga_total)
            VALUES
            ('','$kode_barang','$nama_pembeli','$nama_barang','$kategori','$tanggal_penjualan',$jumlah_jual,$potongan,$harga_total)
            ";

        mysqli_query($conn, $queryaddpenjualan);

        $id_penjualan = mysqli_insert_id($conn);

        // Update jumlah stok
        mysqli_query($conn, "UPDATE data_barang SET jumlah_stok = $stok_baru WHERE kode_barang = '$kode_barang'");


        // Membuat riwayat perubahan
        $riwayat_data = array(
            'id_penjualan' => $id_penjualan,
            'kode_barang' => $kode_barang,
            'nama_pembeli' => $nama_pembeli,
            'nama_barang' => $nama_barang,
            'kategori' => $kategori,
            'tanggal_penjualan' => $tanggal_penjualan,
            'jumlah_jual' => $jumlah_jual,
            'potongan' => $potongan,
            'harga_total' => $harga_total
        );

        catatRiwayatpenjualan('menambah', $riwayat_data);

        return mysqli_affected_rows($conn);
    } else {
        // Stok tidak mencukupi
        return -1;
    }
}


function editpenjualan($data) {
    global $conn;

    // Periksa apakah pengguna yang login adalah admin
    if ($_SESSION['role'] !== 'admin') {
        return -1; // Jika bukan admin, return -1 sebagai indikasi akses ditolak
    }

    $query = "SELECT kode_barang, nama_barang, kategori, harga_satuan FROM data_barang";
    $result = mysqli_query($conn, $query);

    $id_penjualan = $data["id_penjualan"];
    $kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_pembeli = htmlspecialchars($data["nama_pembeli"]);
    $tanggal_penjualan = htmlspecialchars($data["tanggal_penjualan"]);
    $jumlah_jual = htmlspecialchars($data["jumlah_jual"]);
    $potongan = htmlspecialchars($data["potongan"]);

    $select_barang_query = "SELECT nama_barang, kategori, harga_satuan FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);

    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];
    $kategori = $barang['kategori'];
    $harga_satuan = $barang['harga_satuan'];

    // Mengambil jumlah jual sebelumnya
    $query_jumlah_jual_sebelumnya = "SELECT jumlah_jual FROM penjualan WHERE id_penjualan = '$id_penjualan'";
    $result_jumlah_jual_sebelumnya = mysqli_query($conn, $query_jumlah_jual_sebelumnya);
    $jumlah_jual_sebelumnya = mysqli_fetch_assoc($result_jumlah_jual_sebelumnya)['jumlah_jual'];

    // Mengambil kode barang sebelumnya
    $query_kode_barang_sebelumnya = "SELECT kode_barang FROM penjualan WHERE id_penjualan = '$id_penjualan'";
    $result_kode_barang_sebelumnya = mysqli_query($conn, $query_kode_barang_sebelumnya);
    $kode_barang_sebelumnya = mysqli_fetch_assoc($result_kode_barang_sebelumnya)['kode_barang'];

    // Hitung harga total baru
    $harga_total_baru = $harga_satuan * $jumlah_jual - $potongan;

    $queryeditpenjualan = "UPDATE penjualan SET 
            kode_barang = '$kode_barang',
            nama_pembeli = '$nama_pembeli',
            nama_barang = '$nama_barang',
            kategori = '$kategori',
            tanggal_penjualan = '$tanggal_penjualan',
            jumlah_jual = $jumlah_jual,
            potongan = $potongan,
            harga_total = $harga_total_baru
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

        $affected_rows = mysqli_affected_rows($conn);
        if ($affected_rows > 0) {
            // Panggil fungsi catatEditRiwayat
            $data['harga_total'] = $harga_total_baru;
            catatEditRiwayatpenjualan('mengedit', $data);

            return $affected_rows;
        } else {
            return 1;
        }
    } 
}


// Hapus data penjualan
function hapuspenjualan($id_penjualan){
    global $conn;

    // Periksa apakah pengguna yang login adalah admin
    if ($_SESSION['role'] !== 'admin') {
        return -1; // Jika bukan admin, return -1 sebagai indikasi akses ditolak
    }

    $query = "SELECT kode_barang, jumlah_jual, nama_pembeli, tanggal_penjualan, potongan, harga_total FROM penjualan WHERE id_penjualan = '$id_penjualan'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $penjualan = mysqli_fetch_assoc($result);
        $kode_barang = $penjualan['kode_barang'];
        $jumlah_jual = $penjualan['jumlah_jual'];
        $nama_pembeli = $penjualan['nama_pembeli'];
        $tanggal_penjualan = $penjualan['tanggal_penjualan'];
        $potongan = $penjualan['potongan'];
        $harga_total = $penjualan['harga_total'];

        $select_barang_query = "SELECT jumlah_stok FROM data_barang WHERE kode_barang = '$kode_barang'";
        $select_barang_result = mysqli_query($conn, $select_barang_query);

        $barang = mysqli_fetch_assoc($select_barang_result);
        $jumlah_stok = $barang['jumlah_stok'];

        // Hitung jumlah stok baru
        $stok_baru = $jumlah_stok + $jumlah_jual;

        mysqli_query($conn, "DELETE FROM penjualan WHERE id_penjualan = '$id_penjualan'");

        // Update jumlah stok
        mysqli_query($conn, "UPDATE data_barang SET jumlah_stok = $stok_baru WHERE kode_barang = '$kode_barang'");

        // Catat riwayat penghapusan
        $data = array(
            'id_penjualan' => $id_penjualan,
            'kode_barang' => $kode_barang,
            'jumlah_jual' => $jumlah_jual,
            'jumlah_stok' => $stok_baru,
            'nama_pembeli' => $nama_pembeli,
            'tanggal_penjualan' => $tanggal_penjualan,
            'potongan' => $potongan,
            'harga_total' => $harga_total
        );
        catatRiwayatpenjualan('menghapus', $data);

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

	 // Periksa apakah pengguna yang login adalah admin
    if ($_SESSION['role'] !== 'owner') {
        return -1; // Jika bukan admin, return -1 sebagai indikasi akses ditolak
    }


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
		$id_pembelian = mysqli_insert_id($conn);

		// Update jumlah_stok pada data_barang
		updateJumlahStok($kode_barang, $jumlah_beli, $jumlah_stok);

		$riwayat_data = array(
			'id_pembelian' => $id_pembelian,
			'kode_barang' => $kode_barang,
			'nama_barang' => $nama_barang,
			'tanggal_pembelian' => $tanggal_pembelian,
			'jumlah_beli' => $jumlah_beli,
			'harga_beli' => $harga_beli,
			'kwitansi' => $kwitansi
		);

		catatRiwayatPembelian('menambah', $riwayat_data);

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
	// Periksa apakah pengguna yang login adalah admin
    if ($_SESSION['role'] !== 'owner') {
        return -1; // Jika bukan admin, return -1 sebagai indikasi akses ditolak
    }
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

		catatRiwayateditPembelian('mengedit', $data);

		return mysqli_affected_rows($conn);
	} else {
		return false; // Barang tidak ditemukan
	}
}

// Hapus data pembelian
function hapuspembelian($id_pembelian){
	global $conn;

	// Periksa apakah pengguna yang login adalah admin
    if ($_SESSION['role'] !== 'owner') {
        return -1; // Jika bukan admin, return -1 sebagai indikasi akses ditolak
    }

	$select_pembelian_query = "SELECT kode_barang, jumlah_beli, nama_barang, tanggal_pembelian, harga_beli, kwitansi FROM pembelian WHERE id_pembelian = '$id_pembelian'";
	$select_pembelian_result = mysqli_query($conn, $select_pembelian_query);

	if(mysqli_num_rows($select_pembelian_result) > 0) {
		$pembelian = mysqli_fetch_assoc($select_pembelian_result);
		$kode_barang = $pembelian['kode_barang'];
		$jumlah_beli = $pembelian['jumlah_beli'];
		$nama_barang = $pembelian['nama_barang'];
		$tanggal_pembelian = $pembelian['tanggal_pembelian'];
		$harga_beli = $pembelian['harga_beli'];
		$kwitansi = $pembelian['kwitansi'];


		$select_barang_query = "SELECT jumlah_stok FROM data_barang WHERE kode_barang = '$kode_barang'";
		$select_barang_result = mysqli_query($conn, $select_barang_query);

		if(mysqli_num_rows($select_barang_result) > 0) {
			$barang = mysqli_fetch_assoc($select_barang_result);
			$jumlah_stok = $barang['jumlah_stok'];

			mysqli_query($conn, "DELETE FROM pembelian WHERE id_pembelian = '$id_pembelian'");

			// Update jumlah_stok pada data_barang
			updateJumlahStok($kode_barang, -$jumlah_beli, $jumlah_stok);

		$riwayat_data = array(
			'id_pembelian' => $id_pembelian,
			'kode_barang' => $kode_barang,
			'nama_barang' => $nama_barang,
			'tanggal_pembelian' => $tanggal_pembelian,
			'jumlah_beli' => $jumlah_beli,
			'harga_beli' => $harga_beli,
			'kwitansi' => $kwitansi
		);

		catatRiwayatPembelian('menambah', $riwayat_data);


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

    $query = "SELECT * FROM penjualan 
    			WHERE (nama_barang LIKE '%$keyword%' OR 
    			nama_pembeli LIKE '%$keyword%' OR
    			kategori LIKE '%$keyword%')
    			";

    if ($tanggalFilter != '') {
        $query .= " AND tanggal_penjualan = '$tanggalFilter'";
    }

	return query($query);

}

function caribarang($keywordbarang){
    $query = "SELECT * FROM data_barang
                WHERE nama_barang LIKE '%$keywordbarang%' OR
                kode_barang LIKE '%$keywordbarang%' OR
                kategori LIKE '%$keywordbarang%'
                ";

    return query($query);
}

function caripembelian($keyword, $tanggalFilter){
    $query = "SELECT * FROM pembelian
                WHERE (kode_barang LIKE '%$keyword%' OR
                nama_barang LIKE '%$keyword%')
                ";

    if ($tanggalFilter != '') {
        $query .= "AND tanggal_pembelian = '$tanggalFilter'";
    }

    return query($query);
}

function catatRiwayatpenjualan($action, $data) {
    // Koneksi ke database
    global $conn;

    // Mengambil waktu saat ini
    $tanggalRiwayat = date('Y-m-d H:i:s');

    // Ambil data barang dari tabel data_barang berdasarkan kode_barang
    $kode_barang = $data['kode_barang'];
    $select_barang_query = "SELECT nama_barang, kategori FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);
    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];
    $kategori = $barang['kategori'];

	$session_login = ucfirst($_SESSION['username']);

    // Membuat deskripsi perubahan
    $deskripsi = $session_login . " ";
    $deskripsi .= $action . " data pada tabel penjualan:\n";
    $deskripsi .= "ID Penjualan: " . $data['id_penjualan'] . "\n";
    $deskripsi .= "Kode Barang: " . $kode_barang . "\n";
    $deskripsi .= "Nama Pembeli: " . $data['nama_pembeli'] . "\n";
    $deskripsi .= "Nama Barang: " . $nama_barang . "\n";
    $deskripsi .= "Kategori: " . $kategori . "\n";
    $deskripsi .= "Tanggal Penjualan: " . $data['tanggal_penjualan'] . "\n";
    $deskripsi .= "Jumlah Jual: " . $data['jumlah_jual'] . "\n";
    $deskripsi .= "Harga Potongan: " . $data['potongan']. "\n";
    $deskripsi .= "Harga Total: " . $data['harga_total'] . "\n";
    $deskripsi .= "Tanggal Perubahan: " . $tanggalRiwayat;

    // Menyimpan riwayat perubahan ke tabel riwayat
    $sql = "INSERT INTO riwayat (deskripsi, tanggal_riwayat) VALUES ('$deskripsi', '$tanggalRiwayat')";
	mysqli_query($conn, $sql);
}

function catateditRiwayatpenjualan($action, $data) {
    // Koneksi ke database
    global $conn;

    // Mengambil waktu saat ini
    $tanggalRiwayat = date('Y-m-d H:i:s');

    // Ambil data barang dari tabel data_barang berdasarkan kode_barang
    $kode_barang = $data['kode_barang'];
    $select_barang_query = "SELECT nama_barang, kategori FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);
    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];
    $kategori = $barang['kategori'];

	$session_login = ucfirst($_SESSION['username']);

    // Membuat deskripsi perubahan
    $deskripsi = $session_login . " ";
    $deskripsi .= $action . " data pada tabel penjualan:\n";
    $deskripsi .= "ID Penjualan: " . $data['id_penjualan'] . "\n";
    $deskripsi .= "Kode Barang: " . $kode_barang . "\n";
    $deskripsi .= "Nama Pembeli: " . $data['nama_pembeli'] . "\n";
    $deskripsi .= "Nama Barang: " . $nama_barang . "\n";
    $deskripsi .= "Kategori: " . $kategori . "\n";
    $deskripsi .= "Tanggal Penjualan: " . $data['tanggal_penjualan'] . "\n";
    $deskripsi .= "Jumlah Jual: " . $data['jumlah_jual'] . "\n";
    $deskripsi .= "Harga Potongan: " . $data['potongan']. "\n";
    $deskripsi .= "Harga Total: " . $data['harga_total'] . "\n";
    $deskripsi .= "Tanggal Perubahan: " . $tanggalRiwayat;

    // Menyimpan riwayat perubahan ke tabel riwayat
    $sql = "INSERT INTO riwayat (deskripsi, tanggal_riwayat) VALUES ('$deskripsi', '$tanggalRiwayat')";
	mysqli_query($conn, $sql);
}

function catatRiwayatDataBarang($action, $data) {
    // Koneksi ke database
    global $conn;
    // Mengambil waktu saat ini
    $tanggalRiwayat = date('Y-m-d H:i:s');

    $session_login = ucfirst($_SESSION['username']);

    // Membuat deskripsi perubahan
    $deskripsi = $session_login . " ";
    $deskripsi .= $action . " data pada tabel data barang:\n";
    $deskripsi .= "Kode Barang: " . $data['kode_barang'] . "\n";
    $deskripsi .= "Nama Barang: " . $data['nama_barang'] . "\n";
    $deskripsi .= "Kategori: " . $data['kategori'] . "\n";
    $deskripsi .= "Harga Modal: " . $data['harga_modal'] . "\n";
    $deskripsi .= "Harga Satuan: " . $data['harga_satuan'] . "\n";
    $deskripsi .= "Tanggal Perubahan: " . $tanggalRiwayat;

    // Menyimpan riwayat perubahan ke tabel riwayat
    $sql = "INSERT INTO riwayat (deskripsi, tanggal_riwayat) VALUES ('$deskripsi', '$tanggalRiwayat')";
    mysqli_query($conn, $sql);
}

function catatRiwayatstokbarang($action, $data) {
    // Koneksi ke database
    global $conn;
	
    // Mengambil waktu saat ini
    $tanggalRiwayat = date('Y-m-d H:i:s');

    $kode_barang = $data['kode_barang'];
    $nama_barang = $data['nama_barang'];
    $jumlah_stok = $data['jumlah_stok'];
    $session_login = ucfirst($_SESSION['username']);

    // Membuat deskripsi perubahan
    $deskripsi = $session_login . " ";
    $deskripsi .= $action . " data pada stok barang:\n";
    $deskripsi .= "Kode Barang: " . $kode_barang . "\n";
    $deskripsi .= "Nama Barang: " . $nama_barang . "\n";
    $deskripsi .= "Jumlah Stok: " . $jumlah_stok . "\n";
    $deskripsi .= "Tanggal Perubahan: " . $tanggalRiwayat;

    // Menyimpan riwayat perubahan ke tabel riwayat
    $sql = "INSERT INTO riwayat (deskripsi, tanggal_riwayat) VALUES ('$deskripsi', '$tanggalRiwayat')";
	mysqli_query($conn, $sql);
}

function catatRiwayatPembelian($action , $data) {
    // Koneksi ke database
    global $conn;
	
    // Mengambil waktu saat ini
    $tanggalRiwayat = date('Y-m-d H:i:s');

    $id_pembelian = $data['id_pembelian'];
    $kode_barang = $data['kode_barang'];

    // Mendapatkan informasi kode_barang dan nama_barang dari tabel data_barang
    $select_barang_query = "SELECT nama_barang FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);
    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];

    $tanggal_pembelian = $data['tanggal_pembelian'];
    $jumlah_beli = $data['jumlah_beli'];
    $harga_beli = $data['harga_beli'];
    $kwitansi = $data["kwitansi"];
    $session_login = ucfirst($_SESSION['username']);

    // Membuat deskripsi perubahan
    $deskripsi = $session_login . " ";
    $deskripsi .= $action . " data pada tabel pembelian:\n";
    $deskripsi .= "ID Pembelian: " . $id_pembelian . "\n";
    $deskripsi .= "Kode Barang: " . $kode_barang . "\n";
    $deskripsi .= "Nama Barang: " . $nama_barang . "\n";
    $deskripsi .= "Tanggal Pembelian: " . $tanggal_pembelian . "\n";
    $deskripsi .= "Jumlah Beli: " . $jumlah_beli . "\n";
    $deskripsi .= "Harga Beli: " . $harga_beli . "\n";
    $deskripsi .= "Kwitansi: " . $kwitansi . "\n";
    $deskripsi .= "Tanggal Perubahan: " . $tanggalRiwayat;

    // Menyimpan riwayat perubahan ke tabel riwayat
    $sql = "INSERT INTO riwayat (deskripsi, tanggal_riwayat) VALUES ('$deskripsi', '$tanggalRiwayat')";
    mysqli_query($conn, $sql);
}


function catatRiwayateditPembelian($action , $data) {
    // Koneksi ke database
    global $conn;
	
    // Mengambil waktu saat ini
    $tanggalRiwayat = date('Y-m-d H:i:s');

    $id_pembelian = $data['id_pembelian'];
    $kode_barang = $data['kode_barang'];

    // Mendapatkan informasi kode_barang dan nama_barang dari tabel data_barang
    $select_barang_query = "SELECT nama_barang FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);
    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];

    $tanggal_pembelian = $data['tanggal_pembelian'];
    $jumlah_beli = $data['jumlah_beli'];
    $harga_beli = $data['harga_beli'];
	$session_login = ucfirst($_SESSION['username']);
    $kwitansiLama = $data["kwitansiLama"];

	if($_FILES['kwitansi']['error']==4){
		$kwitansi = $kwitansiLama;
	} else {
		$kwitansi = upload();
	}
    $session_login = ucfirst($_SESSION['username']);

    // Membuat deskripsi perubahan
    $deskripsi = $session_login . " ";
    $deskripsi .= $action . " data pada tabel pembelian:\n";
    $deskripsi .= "ID Pembelian: " . $id_pembelian . "\n";
    $deskripsi .= "Kode Barang: " . $kode_barang . "\n";
    $deskripsi .= "Nama Barang: " . $nama_barang . "\n";
    $deskripsi .= "Tanggal Pembelian: " . $tanggal_pembelian . "\n";
    $deskripsi .= "Jumlah Beli: " . $jumlah_beli . "\n";
    $deskripsi .= "Harga Beli: " . $harga_beli . "\n";
    $deskripsi .= "Kwitansi: " . $kwitansi . "\n";
    $deskripsi .= "Tanggal Perubahan: " . $tanggalRiwayat;

    // Menyimpan riwayat perubahan ke tabel riwayat
    $sql = "INSERT INTO riwayat (deskripsi, tanggal_riwayat) VALUES ('$deskripsi', '$tanggalRiwayat')";
    mysqli_query($conn, $sql);
}


function getHargaSatuan($kode_barang) {
    global $conn;

    $query = "SELECT harga_satuan FROM data_barang WHERE kode_barang = '$kode_barang'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["harga_satuan"];
    }

    return "N/A";
}

 ?>

