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

$message="";
if(isset($_POST["assign"]))
{
	$studid=$_POST["studid"];
	$teachid=$_POST["teachid"];
	$status="assigned";

	$qry = "SELECT * FROM studentinfo WHERE username='$studid'";
	$stm=$connect->prepare($qry);
	$stm->execute();
	$ct1=$stm->rowCount();

	$qry = "SELECT * FROM teacherinfo WHERE username='$teachid'";
	$stm=$connect->prepare($qry);
	$stm->execute();
	$ct2=$stm->rowCount();

	if($studid=="")
	{
		$message="Enter Student id";
	}
	else if($teachid=="")
	{
		$message="Enter Teacher id";
	}
	else if($ct1==0 && $ct2==0)
	{
		$message="Invaid Student ID and Invalid Teacher ID";
	}
	else if($ct1==0)
	{
		$message="Invalid Student ID";
	}
	else if($ct2==0)
	{
		$message="Invalid Teacher ID";
	}
	else
	{
		// Check if student is allready assigned

		$qry="SELECT * FROM assigntable WHERE studentid='$studid'";
		$stm=$connect->prepare($qry);
		$stm->execute();
		$ct=$stm->rowCount();
		if($ct>0)
		{
			$message="Student Allready Assigned";
		}
		else
		{

			$query = "INSERT INTO assigntable VALUES('$studid', '$teachid', '$status')";
			$stm=$connect->prepare($query);
			$stm->execute();

			$message="Sucessful";
		}
	}
}

$message1="";
if(isset($_POST['deassign']))
{
	$studid11=$_POST['studid1'];

	//Check if student is present in database.
	$qry = "SELECT * FROM studentinfo WHERE username='$studid11'";
	$stm=$connect->prepare($qry);
	$stm->execute();
	$ct1=$stm->rowCount();

	if($ct1==0)
	{
		$message1="Invalid Student ID";
	}
	else
	{
		// Check if student is assigned.
		$qry="SELECT * FROM assigntable WHERE studentid='$studid11'";
		$stm=$connect->prepare($qry);
		$stm->execute();
		$ct=$stm->rowCount();

		if($ct==0)
		{
			$message1="Student was not assigned previously";
		}
		else
		{
			// DElete record from table.
			$qry="DELETE FROM assigntable WHERE studentid='$studid11'";
			$stm=$connect->prepare($qry);
			$stm->execute();

			$message1="Successful";
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->

	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

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
		    <a class="nav-link" href="adminDash.php">Home</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="adminUpload.php">Upload</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link active" href="adminAssign.php">Assign</a>
		  </li>
		  <li class="nav-item">
		    <form method="post">
		    	<input type="submit" name="logout" value="Logout" class="btn btn-primary" />
		    </form>
		  </li>
		</ul>

		<br>
		<!-- Table for students -->
		<span id="alert_action"><?php if($message!="") {echo "<div class='alert alert-warning'>$message</div>";} ?></span>
		<span id="alert_action"><?php if($message1!="") {echo "<div class='alert alert-warning'>$message1</div>";} ?></span>
		<h4>Student Table</h4>

		<div id="table-wrapper">
  		<div id="table-scroll">

		<table id="example1" class="display" style="width:100%">
		  <thead>
		    <tr>
		      <th scope="col">S.No</th>
		      <th scope="col">Student ID</th>
		      <th scope="col">Name</th>
		      <th scope="col">Status</th>
		    </tr>
		  </thead>
		  <tbody>

		    <?php
		    	$query = "SELECT * FROM studentinfo";
		    	$stm=$connect->prepare($query);
		    	$stm->execute();

		    	$cnt=$stm->rowCount();
		    	$res=$stm->fetchAll();
		    	$cc=1;
		    	foreach($res as $row)
		    	{
		    		$studid=$row['username'];
		    		$name=$row['name'];

		    		$qry="SELECT * FROM assigntable WHERE studentid='$studid'";
		    		$stm=$connect->prepare($qry);
		    		$stm->execute();

		    		$cnt=$stm->rowCount();

		    		echo '
		    			<tr>
		      			<th scope="row">'.$cc.'</th>
		      			<td>'.$studid.'</td>
		      			<td>'.$name.'</td>
		      			';
		      		if($cnt==0)
		      		{
		      			echo '
		      			<td><div class="btn btn-warning">Not Assigned</div></td>
		    			</tr>
		    		';
		      		}
		      		else{
		      			echo '
		      			<td><div class="btn btn-success">Assigned</div></td>
		    			</tr>
		    		';
		      		}
		      		

		    		$cc = $cc + 1;
		    	}
		    ?>

		  </tbody>
		</table>

		</div>
		</div>

		<br>
		<!-- Table for teachers -->
		<h4>Teacher Table</h4>
		<table id="example2" class="display" style="width:100%">
		  <thead>
		    <tr>
		      <th scope="col">S.No</th>
		      <th scope="col">Teacher ID</th>
		      <th scope="col">Name</th>
		      <th scope="col">Student Count</th>
		    </tr>
		  </thead>
		  <tbody>
		  
		  	<?php
		    	// include('database_connection.php');

		    	$query = "SELECT * FROM teacherinfo";
		    	$stm=$connect->prepare($query);
		    	$stm->execute();

		    	$cnt=$stm->rowCount();
		    	$res=$stm->fetchAll();
		    	$cc=1;
		    	foreach($res as $row)
		    	{
		    		$studid=$row['username'];
		    		$name=$row['name'];

		    		$qry = "SELECT * FROM assigntable WHERE teacherid='$studid'";
		    		$stm=$connect->prepare($qry);
		    		$stm->execute();
		    		$cnt=$stm->rowCount();

		    		echo '
		    			<tr>
		      			<th scope="row">'.$cc.'</th>
		      			<td>'.$studid.'</td>
		      			<td>'.$name.'</td>
		      			<td>'.$cnt.'</td>
		    			</tr>
		    		';

		    		$cc = $cc + 1;
		    	}
		    ?>

		  </tbody>
		</table>

		<!-- Status Table -->
		<br>
		<h4>Status Table</h4>

		<div id="table-wrapper">
  		<div id="table-scroll">

			<table id="example3" class="display" style="width:100%">
			  <thead>
			    <tr>
			      <th scope="col">S.No</th>
			      <th scope="col">Student ID</th>
			      <th scope="col">Teacher ID</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php
			    	// include('database_connection.php');

			    	$query = "SELECT * FROM assigntable";
			    	$stm=$connect->prepare($query);
			    	$stm->execute();

			    	$cnt=$stm->rowCount();
			    	$res=$stm->fetchAll();
			    	$cc=1;
			    	foreach($res as $row)
			    	{
			    		$studid=$row['studentid'];
			    		$teachid=$row['teacherid'];

			    		echo '
			    			<tr>
			      			<th scope="row">'.$cc.'</th>
			      			<td>'.$studid.'</td>
			      			<td>'.$teachid.'</td>
			    			</tr>
			    		';

			    		$cc = $cc + 1;
			    	}
			    ?>

			  </tbody>
			</table>
		</div>
		</div>

		<!-- form for assignment -->
		<br>
		<hr>
		<br>
		<h4> Assignment Form</h4>
		<span id="alert_action"><?php if($message!="") {echo "<div class='alert alert-warning'>$message</div>";} ?></span>
		<form method="post">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Student ID</label>
		    <input type="text" name="studid" class="form-control" id="username" placeholder="Example : iit2016001">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Teacher ID</label>
		    <input type="text" name="teachid" class="form-control" id="password" placeholder="Example : phc2016001">
		  </div>
		  <input type="submit" name="assign" value="Assign" class="btn btn-primary" />
		</form>
		<br><br>

		<!-- form for assignment -->
		<hr>
		<br>
		<h4> Deassign</h4>
		<span id="alert_action"><?php if($message1!="") {echo "<div class='alert alert-warning'>$message1</div>";} ?></span>
		<form method="post">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Student ID</label>
		    <input type="text" name="studid1" class="form-control" id="username" placeholder="Example : iit2016001">
		  </div>
		  <input type="submit" name="deassign" value="Deassign" class="btn btn-primary" />
		</form>
		<br><br>
	</div>


	

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<!-- DataTables -->
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script> 
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		 $('#example1').DataTable();
		});
		$(document).ready(function() {
		 $('#example2').DataTable();
		});
		$(document).ready(function() {
		 $('#example3').DataTable();
		});
	</script>
</body>
</html>

