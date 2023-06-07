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

<!DOCTYPE html>
<html>
<head>
  <title>Konfirmasi Penghapusan Data</title>
  <script>
    function confirmDelete() {
      var confirmation = confirm("Apakah Anda yakin ingin menghapus data?");
      if (confirmation) {
        document.getElementById("deleteForm").submit();
      }
    }
  </script>
</head>
<body>

<!-- Modal Konfirmasi -->
<div id="modalDelete" style="display: none;">
  <h3>Peringatan!</h3>
  <p>Apakah Anda yakin ingin menghapus data?</p>
  <button onclick="batal()">Batal</button>
  <button onclick="hapus()">Hapus</button>
</div>

<script>
  function batal() {
    var modal = document.getElementById("modalDelete");
    modal.style.display = "none";
  }

  function hapus() {
    var modal = document.getElementById("modalDelete");
    modal.style.display = "none";
    document.getElementById("deleteForm").submit();
  }
</script>

<!-- Form untuk Penghapusan Data -->
<form id="deleteForm" method="POST" action="">
  <input type="hidden" name="kode_barang" value="<?= $kode_barang; ?>">
  <!-- Tombol Hapus dengan Modal Konfirmasi -->
  <button type="button" onclick="confirmDelete()">Hapus</button>
</form>

</body>
</html>