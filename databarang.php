<?php
require 'config.php';
require 'login.php';
require 'function.php';

//pagination
$jumlahdataperhalaman = 10;
$jumlahdata = count(query("SELECT * FROM data_barang"));
$jumlahhalaman = ceil($jumlahdata / $jumlahdataperhalaman);
$halamanaktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awaldata = ($jumlahdataperhalaman * $halamanaktif) - $jumlahdataperhalaman;

$databarang = query("SELECT * FROM data_barang LIMIT $awaldata, $jumlahdataperhalaman");



if (isset($_POST["caribarang"])) {
    $databarang = caribarang($_POST["keywordbarang"]);
}


if (isset($_POST['adddatabarang'])) {
  if (addbarang($_POST) > 0) {
    echo "
      <script>
        alert('Data berhasil ditambahkan');
        window.location='databarang.php';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('Data gagal ditambahkan');
        window.location='databarang.php';
      </script>
    ";
  }
}

if (isset($_GET['kode_barang'])) {
  $kode_barang = $_GET['kode_barang'];
  if (hapusbarang($kode_barang) > 0) {
    echo "
      <script>
        alert('Data berhasil dihapus');
        window.location='databarang.php';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('Data gagal dihapus');
        window.location='databarang.php';
      </script>
    ";
  }
}

if (isset($_POST['updatebarang'])) {
  if (updatebarang($_POST) > 0) {
    echo "
      <script>
        alert('Data berhasil diubah');
        window.location='databarang.php';
      </script>
    ";
  } else {
    echo "
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
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Toko Sararaholi Jaya</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
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
              <a class="nav-link" href="penjualan.php">
                <span data-feather="file"></span>
                Penjualan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="databarang.php">
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
        </div>
      </nav>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Data Barang</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modaltambah">Tambah Data</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar"></span>
              Tahun Ini
            </button>
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

      <div class="container" style="height: 350px;">
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">No.</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Kategori</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <form method="post">
                <?php $i = 1; ?>
                <?php foreach ($databarang as $row): ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td><?= $row["kode_barang"]; ?></td>
                    <td><?= $row["nama_barang"]; ?></td>
                    <td><?= $row["kategori"]; ?></td>
                    <td><?= $row["harga_satuan"]; ?></td>
                    <td>
                      <a><span data-feather="eye"></span></a>
                      <a><span data-feather="edit" data-bs-toggle="modal" data-bs-target="#modalubah<?= $row["kode_barang"]; ?>"></span></a>
                      <a href="?kode_barang=<?= $row['kode_barang']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')">
                        <span data-feather="trash-2"></span>
                      </a>
                    </td>
                  </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
              </form>
            </tbody>
          </table>
        </div>
      </div>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <?php if ($halamanaktif > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $halamanaktif - 1; ?>">&laquo;</a>
              </li>
            <?php else: ?>
              <li class="page-item disabled">
                <span class="page-link">&laquo;</span>
              </li>
            <?php endif; ?>

            <?php
            $awalHalaman = max(1, $halamanaktif - 1);
            $akhirHalaman = min($awalHalaman + 2, $jumlahhalaman);

            if ($akhirHalaman - $awalHalaman < 2) {
              $awalHalaman = max(1, $akhirHalaman - 2);
            }

            for ($i = $awalHalaman; $i <= $akhirHalaman; $i++) {
              if ($i == $halamanaktif) {
                echo "<li class='page-item active'><a class='page-link' href='?page=$i'>$i</a></li>";
              } else {
                echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
              }
            }
            ?>

            <?php if ($halamanaktif < $jumlahhalaman): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $halamanaktif + 1; ?>">&raquo;</a>
              </li>
            <?php else: ?>
              <li class="page-item disabled">
                <span class="page-link">&raquo;</span>
              </li>
            <?php endif; ?>
          </ul>
        </nav>


      </div>
      </main>
    </div>
  </div>
  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script src="js/dashboard.js"></script>

  <script>
    feather.replace({ 'aria-hidden': 'true' })
  </script>
</body>
<div class="modal fade" tabindex="-1" id="modaltambah" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Barang</h5>
        <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Kode Barang</label>
            <input type="text" class="form-control" name="kode_barang" placeholder="Kode Barang" required>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang" required>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Kategori</label>
            <input type="text" class="form-control" name="kategori" placeholder="kategori" required>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Harga Modal</label>
            <input type="number" class="form-control" name="harga_modal" placeholder="harga modal" required>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga_satuan"placeholder="Harga" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-sm btn-outline-primary" name="adddatabarang" value="adddatabarang">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<?php foreach ($databarang as $row): ?>
  
  <div class="modal fade" tabindex="-1" id="modalubah<?= $row["kode_barang"]; ?>" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Data Barang</h5>
          <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
          <div class="modal-body">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Kode Barang</label>
              <input type="text" readonly class="form-control" name="kode_barang" value="<?= $row["kode_barang"]; ?>">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
              <input type="text" class="form-control" name="nama_barang" value="<?= $row["nama_barang"]; ?>" required>
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Kategori</label>
              <input type="text" class="form-control" name="kategori" value="<?= $row["kategori"]; ?>" required>
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Harga Modal</label>
              <input type="number" class="form-control" name="harga_modal" value="<?= $row["harga_modal"]; ?>" required>
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Harga</label>
              <input type="number" class="form-control" name="harga_satuan" value="<?= $row["harga_satuan"]; ?>" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-sm btn-outline-primary" name="updatebarang" value="updatebarang">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  
<?php endforeach; ?>

</html>
