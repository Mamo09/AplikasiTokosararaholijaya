<?php
require 'config.php';

// Variable status reset password
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password Toko Sararaholi Jaya</title>
    <link rel="stylesheet" href="css/loginn.css">
</head>
<body>

<header>
    <h1>Reset Password</h1>
</header>
<?php if (!$resetStatus) : ?>
    <div class="container">
        <div class="form-container">
            <form action="" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" placeholder="Username" required />
                <label for="recovery_code">Kode Pemulihan:</label>
                <input type="text" name="recovery_code" placeholder="Kode Pemulihan" required />
                <button type="submit">Verifikasi</button>
            </form>
        </div>
        <div class="right">
            <img src="img/logo.jpg" alt="" />
        </div>
    </div>
    <p>
        <a href="index.php">Login</a>
    </p>
<?php else : ?>
    <?php include 'modallupapassword.php'; ?>
<?php endif; ?>

</body>
</html>
