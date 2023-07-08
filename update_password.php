<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Memeriksa apakah password baru dan konfirmasi password sama
    if ($newPassword === $confirmPassword) {
        // Memperbarui password pengguna dalam database
        $sql = "UPDATE user SET password = '$newPassword' WHERE username = '$username'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Password berhasil direset');
                window.location = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Password gagal direset');
                window.location = 'lupa_password.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Password baru dan konfirmasi password tidak cocok');
            window.location = 'lupa_password.php';
        </script>";
    }
}
?>