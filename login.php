<?php
if(isset($_SESSION['log'])){

} else{
	//header('location:index.php');
	//echo 'window.location="index.php';
	echo '<script>window.location="index.php";</script>';
}
?>