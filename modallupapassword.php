<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password Toko Sararaholi Jaya</title>
    <link rel="stylesheet" href="css/loginn.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form action="update_password.php" method="post">
                <input type="hidden" name="username" value="<?php echo $username; ?>">
                <label for="new_password">Password Baru:</label>
                <input type="password" name="new_password" placeholder="Password Baru" required />
                <label for="confirm_password">Konfirmasi Password Baru:</label>
                <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" required />
                <button type="submit" name="reset">Reset Password</button>
            </form>
        </div>
        <div class="right">
            <img src="img/logo.jpg" alt="" />
        </div>
    </div>
</body>
</html>