<?php 
require 'config.php';
require 'login.php';
require 'function.php';

$databarang = query("SELECT * FROM data_barang");

if (isset($_POST["caribarang"])) {
    $databarang = caribarang($_POST["keywordbarang"]);
}


if (isset($_POST['editstok'])) {
  if (editstok($_POST) > 0) {
    echo "
      <script>
        alert('Data berhasil diubah');
        window.location='stokbarang.php';
      </script>
    ";
  } else {
    echo "<script>
        alert('Data gagal diubah');
        window.location='stokbarang.php';
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
  <div class="d-flex align-items-center">
    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 bg-dark" href="dashboard.php">
      <span data-feather="arrow-left"></span>
      Kembali
    </a>
  </div>

  <div class="ml-auto d-flex align-items-center">
    <div class="btn-group">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <a data-feather="user"></a>
        <?= ucfirst($_SESSION['username']); ?>
      </button>
      <ul class="dropdown-menu dropdown-menu-lg-end">
        <li><a class="dropdown-item"><?= ucfirst($_SESSION['username']); ?></a></li>
        <li><a class="dropdown-item" href="reset_password.php">Ganti Password</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="logout.php">Sign Out</a></li>
      </ul>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="penjualan.php">
              <span data-feather="shopping-cart"></span>
              Penjualan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="databarang.php">
              <span data-feather="database"></span>
              Data Barang
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="stokbarang.php">
              <span data-feather="layers"></span>
              Stok Barang
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pembelian.php">
              <span data-feather="shopping-bag"></span>
              Pembelian
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="riwayat.php">
              <span data-feather="archive"></span>
              Riwayat
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Stok Barang</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>

      <form method="post">
        <div class="container">
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" autofocus placeholder="Cari" name="keywordbarang" autocomplete="off">
            </div>
            <div class="col">
              <button class="btn btn-outline-secondary" type="submit" name="caribarang" >Cari</button>
            </div>
          </div>
        </div>
      </form>

      <div class="container">
      <div class="table-responsive" style="max-height: 450px; overflow-y: scroll;">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Kategori</th>
              <th scope="col">Jumlah Stok</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          
          <tbody>
            <?php $i=1; ?>
            <?php foreach($databarang as $row): ?>
            <tr>
              <td><?= $i;  ?></td>
              <td> <?= $row["kode_barang"];  ?></td>
              <td> <?= $row["nama_barang"];  ?></td>
              <td> <?= $row["kategori"];  ?></td>
              <td> <?= $row["jumlah_stok"];  ?></td>

              <td>
                  <a type="button">
                    <span data-feather ="edit" data-bs-toggle="modal" data-bs-target="#modaleditstok<?= $row["kode_barang"]; ?>"></span>
                  </a>
                  <!-- <a type="button">
                    <span data-feather ="plus-square" data-bs-toggle="modal" data-bs-target="#modaltambahstok<?= $row["kode_barang"]; ?>"></span>
                  </a>
                  <a type="button">
                    <span data-feather ="minus-square" data-bs-toggle="modal" data-bs-target="#modalkurangstok<?= $row["kode_barang"]; ?>"></span>
                  </a> -->
              </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
            <?php if(empty($databarang)): ?>
               <tr>
                  <td colspan="10">Data tidak ditemukan</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>
        </div>
      </div>
    </main>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

    <script src="js/dashboard.js"></script>

    <script>
      feather.replace({ 'aria-hidden': 'true' })
    </script>
  </body>

   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <form  method="post">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Data Stok Barang</h5>
              <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Kode Barang</label>
              <input type="text" class="form-control" placeholder="Kode Barang" name="kode_barang">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Jumlah</label>
              <input type="text" class="form-control"  placeholder="Jumlah Stok" name="jumlah_stok">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-sm btn-outline-primary" value="addstok" name="addstok">Simpan</button>
            </div>
          </div>     
        </div>
        </form>
      </div>
    </div>
  </div>


<?php foreach($databarang as $row): ?>
              <div class="modal fade" id="modaleditstok<?= $row["kode_barang"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                      <form  method="post">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Stok Barang</h5>
                        <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Kode Barang</label>
                        <input type="text" readonly class="form-control" placeholder="Kode Barang" name="kode_barang" value="<?= $row["kode_barang"]; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Jumlah</label>
                        <input type="number" class="form-control"  placeholder="Jumlah Stok" name="jumlah_stok" value="<?= $row["jumlah_stok"]; ?>" required>
                      </div>

                      <input type="hidden" class="form-control" name="nama_barang" value="<?= $row["nama_barang"]; ?>" >
                      <input type="hidden" class="form-control" name="kategori" value="<?= $row["kategori"]; ?>" >
                      <input type="hidden" class="form-control" name="harga_modal" value="<?= $row["harga_modal"]; ?>" >
                      <input type="hidden" class="form-control" name="harga_satuan" value="<?= $row["harga_satuan"]; ?>" >

                      <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-outline-primary" value="editstok" name="editstok">Simpan</button>
                      </div>
                    </div>     
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
</html>
