<?php
include('database_connection.php');

if($_SESSION['type'] != "teacher")
{
	header("location:teacherPage.php");
}


if(isset($_POST['logout']))
{
	session_start();
	session_unset();
	session_destroy();
	header("Location:index.php");
}

if(isset($_POST['assign']))
{
	//$_SESSION['current']=$_POST['stuid'];
	$studentid=$_POST["stuid"];

	// validate if the student is assigned to him.
	$teacherid=$_SESSION['username'];
	$qry="SELECT * FROM assigntable WHERE studentid='$studentid' AND teacherid='$teacherid'";
	$stm=$connect->prepare($qry);
	$stm->execute();

	$cnt=$stm->rowCount();
	if($cnt>0)
	{
		$_SESSION['current']=$_POST["stuid"];
		header("Location:teacherAssign.php");
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
		    <a class="nav-link active" href="teacherDash.php">Home</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="#">Assign</a>
		  </li>
		  <li class="nav-item">
		    <form method="post">
		    	<input type="submit" name="logout" value="Logout" class="btn btn-primary" />
		    </form>
		  </li>
		</ul>
		<br>
		<div class="jumbotron jumbotron-fluid">
		  <div class="container"><h4>  Welcome - <?php echo $_SESSION['name']." - ".$_SESSION['username'];?><h4></div>
		</div>

		<!-- Table for Assigned Studenst -->
		<h4>Students Assigned</h4>
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">S.No</th>
		      <th scope="col">Student ID</th>
		    </tr>
		  </thead>
		  <tbody>
		  
		  	<?php
		    	// include('database_connection.php');

		    	$qry="SELECT * FROM assigntable WHERE teacherid = :teacherid";

				$stm=$connect->prepare($qry);
				$stm->execute(array('teacherid' => $_SESSION['username']));
				$res=$stm->fetchAll();
				$cc=1;
				foreach($res as $row)
				{
					$studid=$row['studentid'];

					echo '
		    			<tr>
		      			<th scope="row">'.$cc.'</th>
		      			<td>'.$studid.'</td>
		      			<td>
			      				<form method="post">
			      				<input type="hidden" value="'.$studid.'" name="stuid">
			      				<input type="submit" name="assign" value="Assign" class="btn btn-primary" />
			      				</form>
			      			</td>
		    			</tr>
		    		';

		    		$cc = $cc + 1;
				}
		    ?>

		  </tbody>
		</table>
		<br>
	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

