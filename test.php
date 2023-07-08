<?php

require 'cetak_faktur.php';
require_once('tcpdf/tcpdf.php');

// Koneksi ke database
    $servername = "localhost"; // ganti dengan nama server database Anda
    $username = "root"; // ganti dengan username database Anda
    $password = ""; // ganti dengan password database Anda
    $dbname = "toko_sararaholijaya"; // ganti dengan nama database Anda

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Pemulihan Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?php

    // Variabel status reset password
    $resetStatus = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Mengambil data dari form
        $username = $_POST['username'];
        $recoveryCode = $_POST['recovery_code'];

        // Mengecek apakah username dan kode pemulihan cocok
        $sql = "SELECT * FROM user WHERE username = '$username' AND kode_pemulihan = '$recoveryCode'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $resetStatus = true;
        } else {
            echo "<script>alert('Username atau kode pemulihan salah');history.go(-1);</script>";
        }
    }
    ?>

    <div class="container mt-5">
        <?php if (!$resetStatus) : ?>
            <h2>Pemulihan Password</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="form-group">
                    <label for="recovery_code">Kode Pemulihan:</label>
                    <input type="text" class="form-control" name="recovery_code" required>
                </div>
                <button type="submit" class="btn btn-primary">Verifikasi</button>
            </form>
        <?php else : ?>
            <div id="myModal" class="modal" style="display: block;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reset Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="update_password.php">
                                <input type="hidden" name="username" value="<?php echo $username; ?>">
                                <div class="form-group">
                                    <label for="new_password">Password Baru:</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Ganti Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <script>
                $(function() {
                    var modal = $("#myModal");
                    modal.modal("show");
                });
            </script>
        <?php endif; ?>
    </div>
</body>
</html>


