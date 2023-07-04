<?php 
	require 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengambil data pengguna dari database berdasarkan username
    $cekdata = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");

    if (mysqli_num_rows($cekdata) > 0) {
        $row = mysqli_fetch_assoc($cekdata);
        $storedPassword = $row['password'];
        $userType = $row['username'];

        // Verifikasi password
        if ($password === $storedPassword) {
            // Membuat session berdasarkan jenis pengguna
            if ($userType === 'admin') {
                $_SESSION['username'] = 'admin';
            } elseif ($userType === 'owner') {
                $_SESSION['username'] = 'owner';
            }

            $_SESSION['username'] = $username;
            $_SESSION['log'] = true;

            echo '<script>alert("Login Sukses");window.location="dashboard.php"</script>';
        } else {
            echo '<script>alert("Login Gagal");history.go(-1);</script>';
        }
    } else {
        echo '<script>alert("Login Gagal");history.go(-1);</script>';
    }
}

	if(!isset($_SESSION['log'])){

	} else{
		echo '<script>window.location="dashboard.php";</script>';
		//header('location:dashboard.php');
	}
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Login Toko Sararaholi Jaya</title>
    <link rel="stylesheet" href = "css/loginn.css">

<body>
  <header>
    <h1>Login</h1>
  </header>
  <div class="container">
  <div class="form-container">
    <form action="" method="post">
      <label for="">Username:</label>
      <input type="text" name="username" placeholder="Username" />
      <label for="">Password:</label>
      <input type="password" name="password" placeholder="Password" />
      <button type="submit" name="login">Login</button>
    </form>   
  </div>

  <div class="right">
    <img src="img/logo.jpg" alt="" />
  </div>
</div>
    <p>
            <a href="reset_password.php">Reset Password</a>
          </p>
  </body>
</html>
