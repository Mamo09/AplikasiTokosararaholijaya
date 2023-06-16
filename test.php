<!DOCTYPE html>
<html>
<head>
    <title>Chart Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <form method="GET" action="">
        <label for="year">Pilih Tahun:</label>
        <select name="year" id="year">
            <?php
            $currentYear = date('Y');
            for ($i = $currentYear; $i >= 2000; $i--) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <canvas id="myChart"></canvas>

    <?php
    // Koneksi ke database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "toko_sararaholijaya";

    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

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

    // Tutup koneksi database
    mysqli_close($conn);
    ?>

    <script>
        // Membuat chart menggunakan data dari PHP
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($fullLabels); ?>,
                datasets: [{
                    label: 'Keuntungan',
                    data: <?php echo json_encode($fullData); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Menampilkan daftar barang yang terjual
        var soldItemsContainer = document.createElement('div');
        soldItemsContainer.innerHTML = '<h3>Barang Terjual:</h3>';

        <?php
        foreach ($soldItems as $month => $items) {
            echo "soldItemsContainer.innerHTML += '<p><strong>$month:</strong> " . implode(", ", $items) . "</p>';";
        }
        ?>

        document.body.appendChild(soldItemsContainer);
    </script>
</body>
</html>