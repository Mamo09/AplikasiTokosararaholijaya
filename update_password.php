<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];

    // Memperbarui password pengguna dalam database
    $sql = "UPDATE user SET password = '$newPassword' WHERE username = '$username'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
          alert('Password Berhasil direset');
          window.location='index.php';
        </script>";
    } else {
        echo "<script>
          alert('Password gagal direset');
          window.location='index.php';
        </script>";
    }
}
?>