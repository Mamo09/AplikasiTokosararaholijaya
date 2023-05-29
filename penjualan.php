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
      <a class="nav-link px-3" href="#">Sign out</a>
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

      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">tanggal</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Harga Terjual</th>
              <th scope="col">Kategori</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
	            <td>1</td>
	            <td>random</td>
	            <td>data</td>
	            <td>placeholder</td>
	            <td>text</td>
	            <td>halo </td>
	            <td>
	              	<button type="button" class="btn btn-sm btn-outline-secondary">Tambah</button>
	              	<button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
	              	<button type="button" class="btn btn-sm btn-outline-secondary">Hapus</button>
	          	</td>
       
          </tbody>
        </table>
      </div>
    </main>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nama Pembeli</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="nama pembeli">
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="text" class="form-control" id="datepicker" placeholder="Tanggal">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Kode Barang</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="kode barang">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Jumlah</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="jumlah">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Hargaa Jual</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="harga terjual">
            </div>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-outline-primary">Simpan</button>
              </div>
          </div>
        </div>
    </div>
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
</html>
