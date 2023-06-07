<?php 
require'config.php';
require'function.php';

$kode_barang = $_GET['kode_barang'];


if(hapusbarang($kode_barang) > 0){

	echo "  <script>
          alert('data Berhasil dihapus');
          window.location='databarang.php';
        </script>
    ";
    
} else {
	echo "  <script>
          alert('data Gagal dihapus');
          window.location='databarang.php';
        </script>
    ";
}




 ?>
