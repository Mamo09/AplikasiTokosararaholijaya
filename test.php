<?php

	$servername = "localhost"; // ganti dengan nama server database Anda
	$username = "root"; // ganti dengan username database Anda
	$password = ""; // ganti dengan password database Anda
	$dbname = "toko_sararaholijaya"; // ganti dengan nama database Anda

	// Membuat koneksi
	$conn = new mysqli($servername, $username, $password, $dbname);

// Langkah-langkah sebelumnya untuk menghubungkan ke database

// Mengambil data dari tabel data_barang
$query = "SELECT kode_barang, nama_barang, kategori FROM data_barang";
$result = mysqli_query($conn, $query);


// Form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menyimpan data dari form
    $nama_pembeli = $_POST['nama_pembeli'];
    $tanggal_penjualan = $_POST['tanggal_penjualan'];
    $jumlah_jual = $_POST['jumlah_jual'];
    $harga_jual = $_POST['harga_jual'];
    $kode_barang = $_POST['kode_barang'];

    // Mengambil informasi barang dari tabel data_barang
    $select_barang_query = "SELECT nama_barang, kategori FROM data_barang WHERE kode_barang = '$kode_barang'";
    $select_barang_result = mysqli_query($conn, $select_barang_query);

    $barang = mysqli_fetch_assoc($select_barang_result);
    $nama_barang = $barang['nama_barang'];
    $kategori = $barang['kategori'];

    // Memasukkan data ke tabel penjualan
    $insert_query = "INSERT INTO penjualan (id_penjualan, nama_pembeli, tanggal_penjualan, jumlah_jual, harga_jual, kode_barang, nama_barang, kategori) VALUES ('','$nama_pembeli', '$tanggal_penjualan', $jumlah_jual, $harga_jual, '$kode_barang', '$nama_barang', '$kategori')";
    $insert_result = mysqli_query($conn, $insert_query);


    echo 'Data penjualan berhasil dimasukkan.';

    // Menampilkan data penjualan terakhir
    $last_insert_id = mysqli_insert_id($conn);
    $select_query = "SELECT * FROM penjualan WHERE id_penjualan = $last_insert_id";
    $select_result = mysqli_query($conn, $select_query);
    if (!$select_result) {
        die('Error: ' . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($select_result);
    echo 'Data penjualan terakhir:';
    echo '<br>Nama Pembeli: ' . $row['nama_pembeli'];
    echo '<br>Tanggal Penjualan: ' . $row['tanggal_penjualan'];
    echo '<br>Jumlah Jual: ' . $row['jumlah_jual'];
    echo '<br>Harga Jual: ' . $row['harga_jual'];
    echo '<br>Kode Barang: ' . $row['kode_barang'];
    echo '<br>Nama Barang: ' . $row['nama_barang'];
    echo '<br>Kategori: ' . $row['kategori'];

    mysqli_close($conn);
}
?>

<!-- Form input data penjualan -->
<form method="POST" action="">
    <label for="nama_pembeli">Nama Pembeli:</label>
    <input type="text" name="nama_pembeli" id="nama_pembeli" required>

    <label for="tanggal_penjualan">Tanggal Penjualan:</label>
    <input type="date" name="tanggal_penjualan" id="tanggal_penjualan" required>

    <label for="jumlah_jual">Jumlah Jual:</label>
    <input type="number" name="jumlah_jual" id="jumlah_jual" required>

    <label for="harga_jual">Harga Jual:</label>
    <input type="number" name="harga_jual" id="harga_jual" required>

    <label for="kode_barang">Kode Barang </label>
    <select name="kode_barang" id="kode_barang">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <option value="<?php echo $row['kode_barang']; ?>"><?php echo $row['kode_barang']; ?></option>
        <?php endwhile; ?>
    </select>

    <input type="submit" value="Simpan">
</form>

