<?php

include('database_connection.php');
$_SESSION['type']="";

$message="";
if(isset($_POST["login"]))
{
	$qry="SELECT * FROM teacherinfo WHERE username = :username";

	$stm=$connect->prepare($qry);
	$stm->execute(array('username' => $_POST["user"]));

	$cnt=$stm->rowCount();
	if($cnt>0)
	{
		$res=$stm->fetchAll();
		foreach($res as $row)
		{
			if($_POST["pass"]==$row["password"])
			{
				$_SESSION['type']="teacher";
				$_SESSION['name']=$row['name'];
				$_SESSION['username']=$row['username'];

				header("location:teacherDash.php");
			}
			else
			{
				$message="Wrong Password";
			}
		}
	}
	else
	{
		$message="User does not exist";
	}
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
	<div class="jumbotron jumbotron-fluid">
	  <div class="container">
	    <h1 class="display-4">Teacher Login</h1>
	  </div>
	</div>

	<!-- Login form -->
	<div class="container">
		<!-- error message -->
		<span id="alert_action"><?php if($message!="") {echo "<div  class='alert alert-warning'>$message</div>";}?></span>

		<form method="post">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Username</label>
		    <input type="text" name="user" class="form-control" id="username" placeholder="Enter email">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Password</label>
		    <input type="password" name="pass" class="form-control" id="password" placeholder="Password">
		  </div>
		  <input type="submit" name="login" value="Login" class="btn btn-primary" />
		</form>
	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

