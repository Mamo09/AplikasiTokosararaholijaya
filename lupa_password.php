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
<style>
    .unique-modal-overlay {
        display: block;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .unique-modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 300px;
    }

    .unique-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .unique-modal-header h5 {
        margin: 0;
    }

    .unique-modal-close {
        background-color: transparent;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    .unique-modal-body {
        margin-top: 20px;
    }

    .unique-modal-form {
        margin-bottom: 0;
    }

    .unique-modal-form .form-group {
        margin-bottom: 10px;
    }

    .unique-modal-form label {
        display: block;
    }

    .unique-modal-form input[type="password"] {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .unique-modal-form button[type="submit"] {
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }
</style>
</head>
<body>

    <header>
        <h1>Lupa Password</h1>
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

<div class="unique-modal-overlay">
    <div class="unique-modal-content">
        <div class="unique-modal-header">
            <h5>Reset Password</h5>
            <button type="button" class="unique-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="unique-modal-body">
            <form class="unique-modal-form" method="post" action="update_password.php">
                <input type="hidden" name="username" value="<?php echo $username; ?>">
                <div class="form-group">
                    <label for="new_password">Password Baru:</label>
                    <input type="password" name="new_password" required>
                </div>
                <button type="submit" name="ganti">Ganti Password</button>
            </form>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

    <script>
        $(function () {
            var modal = $("#myModal");
            modal.modal("show");
        });

        function closeModal() {
        var modal = document.querySelector('.unique-modal-overlay');
        modal.style.display = 'none';
    }
    </script>
<?php endif; ?>
</body>
</html>
