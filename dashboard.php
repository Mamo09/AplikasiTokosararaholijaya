<?php 
require 'config.php';
require 'login.php';


    // Mendapatkan tahun yang dipilih
    $selectedYear = date('Y');
    if (isset($_GET['year'])) {
        $selectedYear = $_GET['year'];
    }

    // Query untuk mendapatkan data penjualan dengan harga jual dan harga modal berdasarkan tahun yang dipilih
    $sql = "SELECT DATE_FORMAT(p.tanggal_penjualan, '%m') AS bulan, SUM(p.jumlah_jual * p.harga_jual) - SUM(p.jumlah_jual * b.harga_modal) AS keuntungan, b.nama_barang FROM penjualan p INNER JOIN data_barang b ON p.kode_barang = b.kode_barang WHERE YEAR(p.tanggal_penjualan) = $selectedYear GROUP BY bulan, b.nama_barang";
    $result = mysqli_query($conn, $sql);

    // Inisialisasi array untuk menyimpan data
    $labels = array();
    $data = array();
    $soldItems = array();

    // Memproses hasil query
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $monthNumber = $row['bulan'];
            $monthName = date("F", mktime(0, 0, 0, $monthNumber, 10));
            $labels[] = $monthName;
            $data[] = $row['keuntungan'];

            $itemName = $row['nama_barang'];
            if (!isset($soldItems[$monthName])) {
                $soldItems[$monthName] = array();
            }
            $soldItems[$monthName][] = $itemName;
        }
    }

    // Mengisi array dengan nama bulan yang hilang
    $fullLabels = array();
    $fullData = array();
    for ($i = 1; $i <= 12; $i++) {
        $monthName = date("F", mktime(0, 0, 0, $i, 10));
        $fullLabels[] = $monthName;
        $key = array_search($monthName, $labels);
        if ($key !== false) {
            $fullData[] = $data[$key];
        } else {
            $fullData[] = 0;
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    

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
            <a class="nav-link active" aria-current="page" href="dashboard.php">
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
            <a class="nav-link" href="riwayat.php">
              <span data-feather="layers"></span>
              Riwayat
            </a>
          </li>
        </ul>

        
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">

          <form method="GET" action="">
              <select name="year" id="year" type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <?php
                $currentYear = date('Y');
                for ($i = $currentYear; $i >= 2000; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
              </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary" >Filter</button>
          </form>

        </div>
      </div>

      <canvas id="myChart" width="900" height="380" ></canvas>

      <h2>Grafik Keuntungan</h2>
      <div class="table-responsive">
      </div>
    </main>
  </div>
</div>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

    <script src="js/dashboard.js"></script>

    <script>
        feather.replace({ 'aria-hidden': 'true' })
        // Membuat chart menggunakan data dari PHP
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($fullLabels); ?>,
                datasets: [{
                    label: 'Keuntungan',
                    data: <?php echo json_encode($fullData); ?>,
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    borderWidth: 4,
                }]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: false
                  }
                }]
              },
              legend: {
                display: false
              }
            }
        });

    </script>
  </body>
</html>
