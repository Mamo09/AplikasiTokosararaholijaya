<?php 
require'config.php';
require'function.php';


if (isset($_POST['hapuspenjualan'])) {

    if(hapuspenjualan($id_penjualan) > 0){

        echo "  <script>
              alert('data Berhasil dihapus');
              window.location='penjualan.php';
            </script>
        ";
        
    } else {
        echo "  <script>
              alert('data Gagal dihapus');
              window.location='penjualan.php';
            </script>
        ";
    }
}




 ?>

