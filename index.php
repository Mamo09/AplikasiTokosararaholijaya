<?php 
	session_start();

	require 'config.php';
	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$cekdata = mysqli_query($config, "SELECT * FROM user where username='$username' and password='$password'");
		
		$hitung = mysqli_num_rows($cekdata);

		if($hitung>0){
			$_SESSION['log'] = 'true';
			//header('location:dashboard.php');
			echo '<script>alert("Login Sukses");window.location="dashboard.php"</script>';
		}	else {
			echo '<script>alert("Login Gagal");history.go(-1);</script>';
		}


	}

	if(!isset($_SESSION['log'])){

	} else{
		echo '<script>alert("Anda Sudah Login");window.location="dashboard.php"</script>';
		//header('location:dashboard.php');
	}

 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href = "css/login.css">
  </head>
  <body>
    <div class="container">
      <div class="login">
        <form action="" method="post">
          <h1>Login</h1>
          <hr />
          <label for="">Username</label>
          <input type="text" name="username" placeholder="Username" />
          <label for="">Password</label>
          <input type="password" name="password" placeholder="Password" />
          <button type= "submit" name="login">Login</button>
          <p>
            <a href="register.html">Reset Password</a>
          </p>
        </form>
      </div>
      <div class="right">
        <img src="img/logo.jpg" alt="" />
      </div>
    </div>
  </body>
</html>

