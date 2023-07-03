<?php 
require 'config.php';
require 'login.php';
require 'function.php';

$datapembelian = query("SELECT * FROM pembelian");

if (isset($_POST["cari"])) {
    $keyword = $_POST['keyword'];
    $tanggalFilter = $_POST['tanggal'];
    $sort = $_POST['sort'];

    if ($keyword != '') {
        $datapembelian = caripembelian($keyword, $tanggalFilter, $sort);
    } else {
        // Menampilkan semua data jika hanya ada filter tanggal
        $datapembelian = caripembelian('', $tanggalFilter, $sort);
    }
} else {
    // Menampilkan semua data jika tidak ada pencarian, filter tanggal, atau pengurutan
    $datapembelian = query("SELECT * FROM pembelian");
}


if (isset($_POST['addpembelian'])) {

  if(addpembelian($_POST) > 0){
    echo "  <script>
          alert('data Berhasil ditambahkan');
          window.location='pembelian.php';
        </script>
    ";
    
  } else {
    echo "  <script>
          alert('data gagal ditambahkan');
          window.location='pembelian.php';
        </script>
    ";
  }
}

if (isset($_POST['editpembelian'])) {

  if(editpembelian($_POST) > 0){
      echo "  <script>
          alert('data Berhasil diubah');
          window.location='pembelian.php';
        </script>
    ";
    
  } else {
    echo "  <script>
          alert('data gagal diubah');
          window.location='pembelian.php';
        </script>
    ";
  }
}

if (isset($_GET['id_pembelian'])) {
    $id_pembelian = $_GET['id_pembelian'];

    if(hapuspembelian($id_pembelian) > 0){

      echo "<script>
          alert('data berhasil dihapus');
          window.location='pembelian.php';
        </script>  
        ";
        
    } else {
      echo " <script>
          alert('data gagal dihapus');
          window.location='pembelian.php';
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
      }
      .input-group-append {
				cursor: pointer;
			}
      .gambarkotak{
        width: 50px;
        height: 50px;
        background-color: #f1f1f1;
        border: 2px solid #333;
      }
      .gambar{
        width: 48px;
        height: 48px;
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
            <a class="nav-link active" aria-current="page" href="pembelian.php">
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
        <h1 class="h2">Pembelian</h1>
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

      <form method="post">
        <div class="container">
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" autofocus placeholder="Cari" autocomplete="off" name="keyword">
            </div>
            <div class="col">
              <input type="date" class="form-control" name="tanggal">
            </div>
            <div class="col">
              <select id="sort" name="sort" class="form-control">
                <option value="ASC">
                  <span data-feather="arrow-down">ASC</span>
                </option>
                <option value="DESC">
                  <span data-feather="arrow-up">DESC</span>
                </option>
              </select>
            </div>
            <div class="col">
              <button class="btn btn-outline-secondary" type="submit" name="cari" >Cari</button>
            </div>
          </div>
        </div>
      </form>

    <div class="container">  
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Harga Beli</th>
              <th scope="col">jumlah Beli</th>
              <th scope="col">kwitansi</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <form method="post">
            <?php $i=1; ?>
            <?php foreach($datapembelian as $row): ?>
            <tr>
              <td><?= $i;  ?></td>
              <td> <?= $row["tanggal_pembelian"]; ?></td>
              <td> <?= $row["kode_barang"];  ?></td>
              <td> <?= $row["nama_barang"];  ?></td>
              <td> <?= $row["harga_beli"];  ?></td>
              <td> <?= $row["jumlah_beli"];  ?></td>
              <td> 
                <div class="gambarkotak">
                  <img src="temp_img/<?= $row["kwitansi"];?>" class="gambar">
                </div>
              </td>
              <td>
                  <a><span data-feather ="eye"></span></a>
                  <a>
                    <span data-feather ="edit" data-bs-toggle="modal" data-bs-target="#modaleditpembelian<?= $row["id_pembelian"]; ?>" ></span>
                  </a>
                  <a href="?id_pembelian=<?= $row['id_pembelian']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')" name="hapuspenjualan">
            <span data-feather="trash-2"></span></a>
              </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>

            </form>
          </tbody>
        </table>
      </div>
    </div>
    </main>


  </div>
</div>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

    <script src="js/dashboard.js"></script>
    <script>
      feather.replace({ 'aria-hidden': 'true' })
    </script>
    <script>
    	$('#datepicker').datepicker({
            uiLibrary: 'bootstrap5'
        });
    </script>
  </body>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembelian</h5>
                <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post" enctype="multipart/form-data">

            <div class="modal-body">

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
              <label for="exampleFormControlInput1" class="form-label">Jumlah Beli</label>
              <input type="number" class="form-control" id="exampleFormControlInput1" name="jumlah_beli" placeholder="Jumlah Beli" required>
            </div> 

            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Harga Beli</label>
              <input type="number" class="form-control" id="exampleFormControlInput1" name="harga_beli" placeholder="harga Beli" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="datepicker" placeholder="Tanggal" name="tanggal_pembelian" required>
            </div>
                <div class="mb-3">
                <label for="formFile" class="form-label">Masukkan Kwitansi</label>
                
                <input class="form-control" type="file" name="kwitansi" id="formFile">
                <label for="formFile" class="form-label">Max. 2MB</label>
            </div>
          </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-sm btn-outline-primary" name="addpembelian" value="addpembelian">Simpan</button>
              </div>
          </div>

        </form>

        </div>
    </div>



<!-- modal edit ppembelian-->
<?php foreach($datapembelian as $row): ?>
    <div class="modal fade" id="modaleditpembelian<?= $row["id_pembelian"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembelian</h5>
                <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post" enctype="multipart/form-data">

            <div class="modal-body">

            <input type="hidden" name="id_pembelian" value="<?= $row["id_pembelian"]; ?>">
            <input type="hidden" name="kwitansiLama" value="<?= $row["kwitansi"]; ?>">

            <div class="mb-3">
              <label for="sebelum" class="form-label"> Kode Barang Sebelumnya </label>

              <input type="text" class="form-control" id="sebelum" value="<?= $row["kode_barang"]; ?>" disabled>
            </div>

              <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Pilih Kode Barang</label>

              <select name="kode_barang" class="form-control" id="exampleFormControlInput1" value="<?= $row["kode_barang"]; ?>">

                <?php 
                  $databrg = mysqli_query($conn, "SELECT * FROM data_barang");
                  
                  while($fetcharray=mysqli_fetch_array($databrg)){

                  $kode_barang = $fetcharray["kode_barang"];

                 ?>
                 <option value= "<?=$kode_barang; ?>" > <?=$kode_barang; ?> </option>
                <?php } ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="jumlah_beli" class="form-label">Jumlah Beli</label>
              <input type="number" class="form-control" id="jumlah_beli" name="jumlah_beli" placeholder="Jumlah Beli" value="<?= $row["jumlah_beli"]; ?>"required>
            </div> 

            <div class="mb-3">
              <label for="harga_beli" class="form-label">Harga Beli</label>
              <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="harga Beli" value="<?= $row["harga_beli"]; ?>"required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="datepicker" placeholder="Tanggal" name="tanggal_pembelian" value="<?= $row["tanggal_pembelian"]; ?>"required>
            </div>

            <div class="mb-3">

                <label for="formFile" class="form-label">Masukkan Kwitansi</label> <br>
                <img src="temp_img/<?= $row["kwitansi"];?>" class="gambar" >
                <input class="form-control" type="file" name="kwitansi" id="formFile">             
                <label for="formFile" class="form-label">Max. 2MB</label>
            </div>
          </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-sm btn-outline-primary" name="editpembelian" value="editpembelian">Simpan</button>
              </div>
          </div>

        </form>

        </div>
    </div>
<?php endforeach; ?>
</html>
