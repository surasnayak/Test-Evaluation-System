<?php
	
include('database_connection.php');

if($_SESSION['type'] != "admin")
{
	header("location:index.php");
}

// logout option
if(isset($_POST['logout']))
{
	session_start();
	session_unset();
	session_destroy();
	header("Location:index.php");
}

$message="";
//Upload option.
if(isset($_POST["next"]))
{
	// $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));

	$file = $_FILES["image"]["tmp_name"];

	$studid=$_POST["studid"];
	$examtype=$_POST["examtype"];
	$qno=$_POST["qno"];
	$marks=0;
	$remarks="";
	$status="unchecked";

	// Check if the form is completely filled.
	if($studid=="" || $qno=="" || $examtype=="")
	{
		$message="Please fill up the form";
	}
	else
	{

		// Checking for proper file extension
		$allowed =  array('gif','png' ,'jpg', 'jpeg');
		$filename = $_FILES["image"]["name"];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		if(!in_array($ext,$allowed) ) 
		{
		    $message="Invalid File extension";
		}
		else
		{
			// Checking for valid stident id
			$qry = "SELECT * FROM studentinfo WHERE username='$studid'";
			$stm=$connect->prepare($qry);
			$stm->execute();

			$cnt=$stm->rowCount();
			if($cnt>0)
			{	
				//Check if the particular file allready exists.

				$qry="SELECT * FROM studentans WHERE studid='$studid' AND examtype='$examtype' AND qno='$qno'";
				$stm=$connect->prepare($qry);
				$stm->execute();
				$cnt=$stm->rowCount();

				if($cnt>0)
				{
					$message="This entry allready Exists";
				}
				else
				{
					// Insert into table.
					$target="images/".basename($_FILES['image']['name']);
					$image=$_FILES['image']['name'];
					$qry="INSERT INTO studentans(studid, examtype, qno, image, marks, remarks, status) VALUES('$studid', '$examtype', '$qno', '$image', '$marks', '$remarks', '$status')";
					$stm=$connect->prepare($qry);
					$stm->execute();

					if(move_uploaded_file($_FILES['image']['tmp_name'], $target))
					{
						$message="Upload Successful";
					}
					else
					{
						$message="Upload not successful";
					}

				}

			}
			else
			{
				$message="Invalid! Student Does not exist";
			}
		
		}
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
		    <a class="nav-link" href="adminDash.php">Home</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link active" href="adminUpload.php">Upload</a>
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

		<!-- Input form  -->
		<br>
		<?php if($message!="") {echo "<div class='alert alert-warning'>$message</div>";} ?>
		<form method="post" enctype="multipart/form-data">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Student Id :</label>
		    <input type="text" name="studid" class="form-control" id="studentid" placeholder="Example : iit2016511">
		  </div>
		  
		  <div class="form-group">
		    <label for="exampleInputEmail1">Examination :</label>
		    <select name="examtype" class="form-control form-control">
  				<option value="midterm">Mid Term</option>
  				<option value="endterm">End Term</option>
  				<option value="quiz1">Quiz 1</option>
  				<option value="quiz2">Quiz 2</option>
			</select>
		  </div>

		  <br><hr>

		  <div class="form-group">
		    <label for="exampleInputEmail1">Question No :</label>
		    <input name="qno" type="text" class="form-control" id="studentid" placeholder="Example : 4">
		  </div>

		  <div class="form-group">
		    <label for="exampleFormControlFile1">Upload image :</label>
		    <input name="image" type="file" class="form-control-file" id="exampleFormControlFile1">
		  </div>

		  <input type="submit" name="next" id="next" value="Submit" class="btn btn-primary" />
		  <!-- <input type="submit" name="submit" id="login" value="Submit" class="btn btn-primary" /> -->
		</form>
	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

<script>
$(document).ready(function(){
	$('#next').click(function(){
		var image_name = $('#image').val();
		if(image_name == '')
		{
			alert("Please Select Image");
			return false;
		}
		else
		{
			var extension = $('#image').val().split('.').pop().toLowerCase();
			if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg'] == -1))
			{
				alert('Invalid Image File');
				$('#image').val('');
				return false;
			}
		}
	});
});
</script>

