<?php 
require 'config.php';
require 'login.php';
require 'function.php';


$datapenjualan = query("SELECT * FROM penjualan");

if (isset($_POST['addpenjualan'])) {

  if(addpenjualan($_POST) > 0){
    echo "  <script>
          alert('data Berhasil ditambahkan');
          window.location='penjualan.php';
        </script>
    ";
    
  } else {
    echo "  <script>
          alert('data gagal ditambahkan');
          indow.location='penjualan.php';
        </script>
    ";
  }
}


if (isset($_GET['id_penjualan'])) {
    $id_penjualan = $_GET['id_penjualan'];

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


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Toko Sararaholi Jaya</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

     <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

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
        .input-group-append {
        cursor: pointer;
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
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="logout.php">Sign out</a>
    </div>
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
            <a class="nav-link active" aria-current="page" href="penjualan.php">
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
            <a class="nav-link" href="riwayat.php">
              <span data-feather="layers"></span>
              Riwayat
            </a>
          </li>
        </ul>

        
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Penjualan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"data-bs-target="#exampleModal">Tambah Data</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            Tahun Ini
          </button>
        </div>
      </div>

      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Nama Pembeli</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Harga Terjual</th>
              <th scope="col">Kategori</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <form method="post">
            <?php $i=1; ?>
            <?php foreach($datapenjualan as $row): ?>
            <tr>
              <td><?= $i;  ?></td>
              <td> <?= $row["nama_pembeli"];  ?></td>
              <td> <?= $row["tanggal_penjualan"]; ?></td>
              <td> <?= $row["nama_barang"];  ?></td>
              <td> <?= $row["jumlah_jual"];  ?></td>
              <td> <?= $row["harga_jual"];  ?></td>
              <td> <?= $row["kategori"];  ?></td>
              <td>
                  <a><span data-feather ="eye"></span></a>
                  <a><span data-feather ="edit" ></span></a>
                  <a href="?id_penjualan=<?= $row['id_penjualan']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')" name="hapuspenjualan">
            <span data-feather="trash-2"></span></a>
              </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>

            </form>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

    <script src="js/dashboard.js"></script>

    <script>
      $('#datepicker').datepicker({
            uiLibrary: 'bootstrap5'
        });
    </script>
  </body>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">

          <div class="modal-content">
            <form method="post">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <div class="mb-3">
                  <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                  <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" placeholder="Nama Pembeli">
                </div>
                <div class="mb-3">
                  <label for="datepicker" class="form-label">Date</label>
                  <input type="date" class="form-control" id="datepicker" placeholder="Tanggal" name="tanggal_penjualan" >
                </div>

                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Pilih Kode Barang</label>
                  <select name="kode_barang" class="form-control" id="exampleFormControlInput1">
                    <?php 

                      $databrg = mysqli_query($conn, "SELECT * FROM data_barang");
                      
                      while($fetcharray=mysqli_fetch_array($databrg)){

                      $kode_barang = $fetcharray["kode_barang"];

                     ?>
                     <option value= "<?=$kode_barang; ?>"> <?=$kode_barang; ?> </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="jumalah" class="form-label">Jumlah</label>
                  <input type="number" class="form-control" id="jumlah" placeholder="jumlah" name="jumlah_jual">
                </div>

                <div class="mb-3">
                  <label for="harga_jual" class="form-label">Harga Jual</label>
                  <input type="number" class="form-control" id="harga_jual" placeholder="harga terjual" name="harga_jual">
                </div>

              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-sm btn-outline-primary" name="addpenjualan" value="addpenjualan">Simpan</button>
              </div>
          </form>
          
          </div>
        </div>
    </div>


</html>
