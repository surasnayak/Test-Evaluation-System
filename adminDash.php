<?php

include('database_connection.php');
if($_SESSION['type'] != "admin")
{
	header("location:index.php");
}

if(isset($_POST['logout']))
{
	session_start();
	session_unset();
	session_destroy();
	header("Location:index.php");
}

?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">

	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Test Evaluation System</title>
</head>
<body>

	<!-- Header of the page -->
	<!-- <div class="jumbotron jumbotron-fluid">
	  <div class="container">
	    <h3 class="display-4">Admin Dashboard </h3>
	  </div>
	</div> -->

	<!-- Navigation Bar -->
	<br>
	<div class="container">
		<ul class="nav nav-tabs">
		  <li class="nav-item">
		    <a class="nav-link active" href="adminDash.php">Home</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="adminUpload.php">Upload</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="adminAssign.php">Assign</a>
		  </li>
		  <li class="nav-item">
		    <form method="post">
		    	<input type="submit" name="logout" value="Logout" class="btn btn-primary" />
		    </form>
		  </li>
		</ul>
		<br>
		<div class="jumbotron jumbotron-fluid">
		  <div class="container">
		    <h3 class="display-4">Admin Dashboard </h3>
		    <!-- <p>Welcome to the Admin Dashboard</p> -->
		    <br>
		    <p><b>Upload :</b> Click on <a href="#">Upload</a> to upload the scanned copies of students.</p>
		    <p><b>Assign :</b> Click on <a href="#">Assign</a> to assign students to teachers.</p>
		  </div>
		</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

