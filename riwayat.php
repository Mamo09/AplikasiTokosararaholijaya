<?php 
require 'config.php';
require 'login.php';
require 'function.php';

// Query untuk mengambil opsi bulan dan tahun unik dari tabel riwayat
$queryBulanTahun = "SELECT DISTINCT DATE_FORMAT(tanggal_riwayat, '%Y-%m') AS bulan_tahun FROM riwayat";
$resultBulanTahun = mysqli_query($conn, $queryBulanTahun);
$datariwayat = query("SELECT * FROM riwayat ORDER BY id_riwayat DESC");

if (isset($_GET['id_riwayat'])) {
    $id_riwayat = $_GET['id_riwayat'];

    if(hapusriwayat($id_riwayat) > 0){
      echo "  <script>
              alert('data Berhasil dihapus');
              window.location='riwayat.php';
            </script>
        ";
        
    } else {
      echo "  <script>
              alert('data Gagal dihapus');
              window.location='riwayat.php';
            </script>
        ";
    }

}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Toko Sararaholi Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">


    

    <!-- Bootstrap core CSS -->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Toko Sararaholi Jaya</a>
  
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

<div class="btn-group" style="padding-right: 5px;">
  <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    Settings
  </button>
  <ul class="dropdown-menu dropdown-menu-lg-end">
      <li><a class="dropdown-item" ><?php echo ucfirst($_SESSION['username']); ?></a></li>
      <li><a class="dropdown-item" href="reset_password.php">Ganti Password</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="nav-link px-3" href="logout.php">Sign Out</a></li>
  </ul>
</div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="penjualan.php">
              <span data-feather="file"></span>
              Penjualan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="databarang.php">
              <span data-feather="shopping-cart"></span>
              Data Barang
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="stokbarang.php">
              <span data-feather="users"></span>
              Stok Barang
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pembelian.php">
              <span data-feather="bar-chart-2"></span>
              Pembelian
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="riwayat.php">
              <span data-feather="layers"></span>
              Riwayat
            </a>
          </li>
        </ul>

        
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Riwayat</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>

      <div class="container">
    <form method="post" id="search-form">
    <div class="row">
    <div class="col">
      <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalcetak">
        <a data-feather="printer" style="vertical-align: middle"></a>
        <span class="fs-6" style="vertical-align: middle"> Cetak</span>
      </button>
    </div>

      <div class="col">
      </div>
      <div class="col">
        <input type="text" class="form-control" autofocus placeholder="Cari" autocomplete="off" name="keyword" id="keyword">
      </div>
      <div class="col">
        <select class="form-control" name="bulan_tahun" id="bulan-tahun">
          <option value="">Pilih Bulan dan Tahun</option>
          <!-- Opsi bulan dan tahun -->
            <?php while ($rowBulanTahun = mysqli_fetch_assoc($resultBulanTahun)) : ?>
              <?php
              // Konversi format bulan dan tahun menjadi nama bulan
              $bulanTahun = strtotime($rowBulanTahun['bulan_tahun']);
              $namaBulanTahun = date('F Y', $bulanTahun);
              ?>
              <option value="<?= $rowBulanTahun['bulan_tahun']; ?>"><?= $namaBulanTahun; ?></option>
            <?php endwhile; ?>

        </select>
      </div>
    </div>
  </form>

  <div class="table-responsive" style="max-height: 500px; overflow-y: scroll;">
    <table class="table table-striped table-sm" id="riwayat-table">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Deskripsi</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($datariwayat as $row) : ?>
          <tr>
            <td><?= $i; ?></td>
            <td> <?= $row["tanggal_riwayat"]; ?></td>
            <td> <?= $row["deskripsi"]; ?></td>
          </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p id="no-data" style="display: none; text-align: center;">Data tidak ditemukan</p>
  </div>
</div>
    </main>
  </div>
</div>


<!-- Tambahkan kode modal -->
    <div class="modal fade" id="modalcetak" tabindex="-1" role="dialog" aria-labelledby="modalcetakLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Cetak Riwayat</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form method="POST" action="cetak_riwayat.php">
                    <div class="modal-body">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                        <input type="date" class="form-control" name="tanggal_mulai" required>
                        <br>
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                        <input type="date" class="form-control" name="tanggal_akhir" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-secondary">Cetak Riwayat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>


    <script src="js/dashboard.js"></script>

    <script>
      feather.replace({ 'aria-hidden': 'true' })
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
  // Meng-handle perubahan pada input keyword
  $('#keyword').on('input', function() {
    var keyword = $(this).val().toLowerCase();
    filterRows(keyword);
  });

  // Meng-handle perubahan pada select bulan dan tahun
  $('#bulan-tahun').on('change', function() {
    var bulanTahun = $(this).val();
    filterRows(bulanTahun);
  });

  // Fungsi untuk memfilter baris berdasarkan keyword atau bulan dan tahun
  function filterRows(filter) {
    var noData = true;
    $('#riwayat-table tbody tr').each(function() {
      var rowText = $(this).text().toLowerCase();
      if (rowText.includes(filter)) {
        $(this).show();
        noData = false;
      } else {
        $(this).hide();
      }
    });

    if (noData) {
      $('#no-data').show();
    } else {
      $('#no-data').hide();
    }
  }
});

// $(document).ready(function() {
//   $('#btncetakriwayat').click(function() {
//     $.ajax({
//       url: 'cetak_riwayat.php', // Ganti dengan URL ke skrip PHP yang akan menghasilkan PDF menggunakan mpdf
//       method: 'POST',
//       success: function(response) {
//         // Response berisi hasil yang dikirimkan dari skrip PHP
//         // Anda dapat melakukan penanganan lebih lanjut, misalnya menampilkan pesan atau tindakan lainnya
//         console.log(response);
//       },
//       error: function(xhr, status, error) {
//         // Tangani kesalahan jika ada
//         console.log(xhr.responseText);
//       }
//     });
//   });
// });

</script>

  </body>

</html>
