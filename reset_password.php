<?php

require 'config.php';

if (isset($_POST['reset'])) {
    $username = $_POST['username'];
    $lastPassword = $_POST['last_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validasi pengisian form
    if (empty($username) || empty($lastPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo '<script>alert("Mohon lengkapi semua field.");</script>';
    } else {
        // Cek apakah username dan last password cocok dengan data di database
        $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$lastPassword'");
        $rowCount = mysqli_num_rows($query);

        if ($rowCount > 0) {
            // Validasi password baru dan konfirmasi password
            if ($newPassword === $confirmPassword) {
                // Update password baru ke database
                $updateQuery = mysqli_query($conn, "UPDATE user SET password='$newPassword' WHERE username='$username'");
                if ($updateQuery) {
                    echo '<script>alert("Password berhasil direset.");</script>';
                } else {
                    echo '<script>alert("Gagal mereset password. Silakan coba lagi.");</script>';
                }
            } else {
                echo '<script>alert("Password baru dan konfirmasi password tidak cocok.");</script>';
            }
        } else {
            echo '<script>alert("Username atau password terakhir salah.");</script>';
        }
    }
}
?>

<?php
require 'config.php';

if (isset($_POST['reset'])) {
    // Kode reset password

    // ...

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Toko Sararaholi Jaya</title>
    <link rel="stylesheet" href = "css/loginn.css">
    
</head>
<body>
  <header>
    <h1>Reset Password</h1>
  </header>
  <div class="container">
  <div class="form-container">
  <form action="" method="post">
                <label for="username">Username :</label>
                <input type="text" name="username" placeholder="Username" required />

                <label for="last_password">Last Password :</label>
                <input type="password" name="last_password" placeholder="Last Password" required />

                <label for="new_password">New Password :</label>
                <input type="password" name="new_password" placeholder="New Password" required />

                <label for="confirm_password">Confirm Password :</label>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required />

                <button type="submit" name="reset">Reset Password</button>
            </form>
        </div>
        <div class="right">
        <img src="img/logo.jpg" alt="" />
      </div>
  </div>
      <p>
                    <a href="login.php">Back to Login</a>
                </p>
    </div>
</body>
</html>
