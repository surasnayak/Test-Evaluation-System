<?php
include('database_connection.php');

$message="";
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

//$_SESSION['current']="";
$studentid="";
if(isset($_POST["select"]))
{
	$studentid=$_POST["studid"];

	// validate if the student is assigned to him.
	$teacherid=$_SESSION['username'];
	$qry="SELECT * FROM assigntable WHERE studentid='$studentid' AND teacherid='$teacherid'";
	$stm=$connect->prepare($qry);
	$stm->execute();

	$cnt=$stm->rowCount();
	if($cnt>0)
	{
		$_SESSION['current']=$_POST["studid"];
	}
	else{
		$message="This student is not assigned to you";
	}
}

if(isset($_POST['submit11']))
{
	$marks=$_POST['marks'];
	$remarks=$_POST['remarks'];
	$imageid=$_POST['imageid'];
	$studentid=$_POST['studentid'];
	//$_SESSION['current']=$studentid;

	//print_r($studentid);

	if($marks=="")
	{
		$message="Please enter valid marks";
	}
	else if($marks!="" && $remarks=="")
	{
		$qry="UPDATE studentans SET marks='$marks', status='checked' WHERE id='$imageid'";
		$stm=$connect->prepare($qry);
		$stm->execute();
	}
	else{

		$qry="UPDATE studentans SET marks='$marks', remarks='$remarks', status='checked' WHERE id='$imageid'";
		$stm=$connect->prepare($qry);
		$stm->execute();
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

	<style type="text/css">
		 /* Style the Image Used to Trigger the Modal */
	#myImg {
	    border-radius: 5px;
	    cursor: pointer;
	    transition: 0.3s;
	}

	#myImg:hover {opacity: 0.7;}

	/* The Modal (background) */
	.modal {
	    display: none; /* Hidden by default */
	    position: fixed; /* Stay in place */
	    z-index: 1; /* Sit on top */
	    padding-top: 100px; /* Location of the box */
	    left: 0;
	    top: 0;
	    width: 100%; /* Full width */
	    height: 100%; /* Full height */
	    overflow: auto; /* Enable scroll if needed */
	    background-color: rgb(0,0,0); /* Fallback color */
	    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
	}

	/* Modal Content (Image) */
	.modal-content {
	    margin: auto;
	    display: block;
	    width: 80%;
	    max-width: 700px;
	}

	/* Caption of Modal Image (Image Text) - Same Width as the Image */
	#caption {
	    margin: auto;
	    display: block;
	    width: 80%;
	    max-width: 700px;
	    text-align: center;
	    color: #ccc;
	    padding: 10px 0;
	    height: 150px;
	}

	/* Add Animation - Zoom in the Modal */
	.modal-content, #caption {
	    animation-name: zoom;
	    animation-duration: 0.6s;
	}

	@keyframes zoom {
	    from {transform:scale(0)}
	    to {transform:scale(1)}
	}

	/* The Close Button */
	.close {
	    position: absolute;
	    top: 15px;
	    right: 35px;
	    color: #f1f1f1;
	    font-size: 40px;
	    font-weight: bold;
	    transition: 0.3s;
	}

	.close:hover,
	.close:focus {
	    color: #bbb;
	    text-decoration: none;
	    cursor: pointer;
	}

	/* 100% Image Width on Smaller Screens */
	@media only screen and (max-width: 700px){
	    .modal-content {
	        width: 100%;
	    }
	} 
	</style>

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
		    <a class="nav-link" href="teacherDash.php">Home</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link active" href="teacherAssign.php">Assign</a>
		  </li>
		  <li class="nav-item">
		    <form method="post">
		    	<input type="submit" name="logout" value="Logout" class="btn btn-primary" />
		    </form>
		  </li>
		</ul>
		<br>

		 <!-- Select student form --> 
		<form method="post">
			<h4>Select Your Students Here</h4>
			<br>
			<span id="alert_action"><?php if($message!="") {echo "<div class='alert alert-warning'>$message</div>";} ?></span>
		  <div class="form-group">
		    <label for="exampleInputEmail1">Student ID</label>
		    <input type="text" name="studid" class="form-control" id="username" placeholder="Example : iit2016511">
		  </div>
		  <input type="submit" name="select" value="Go" class="btn btn-primary" />
		</form>
		<br>

		<!-- Table for Students Answer sheets -->
		<h4>Answer Sheets</h4>
		
		<br>
		<?php
			echo 'Student ID : '.$_SESSION['current'];
		?>
		<br>
		<br>
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">S.No</th>
		      <th scope="col">Q.No</th>
		      <th scope="col">Exam Type</th>
		      <th scope="col">Sheet</th>
		      <th scope="col"></th>
		      <th scope="col">Marks</th>
		      <th scope="col">Remarks</th>
		      <th scope="col">Status</th>
		    </tr>
		  </thead>
		  <tbody>
		  
		  	<?php
		    	// include('database_connection.php');

		  			$student1=$_SESSION['current'];
		  			$qry="SELECT * FROM studentans WHERE studid='$student1'";

					$stm=$connect->prepare($qry);
					$stm->execute();
					$res=$stm->fetchAll();
					$cc=1;

					$cnt=$stm->rowCount();
					if($cnt==0)
					{
						echo '<div class="alert alert-warning"> <b/>NO RECORDS PRESENT</div>';
					}	


					foreach($res as $row)
					{
						$imageid=$row['id'];
						$studid=$row['studid'];
						$examtype=$row['examtype'];
						$qno=$row['qno'];
						$image=$row['image'];
						$marks=$row['marks'];
						$status=$row['status'];
						$remarks=$row['remarks'];

						$dest="images/".$image;

						if($status=="checked")
						{
						echo '
			    			<tr>
			      			<th scope="row">'.$cc.'</th>
			      			<td>'.$qno.'</td>
			      			<td>'.$examtype.'</td>
			      			<td>
			      				<img height="300px" width="300px" src="'.$dest.'" id="myImg" alt="Snow" style="width:100%;max-width:300px" onclick="magnifyImg(this);" />
			      			</td>
			      			<td>
			      				<form method="post">
				      				<div class="form-group">
									    <label for="exampleInputEmail1">Marks : </label>
									    <input type="number" name="marks" class="form-control" id="username" data-id="'.$imageid.'">
									 </div>
									 <div class="form-group">
									    <label for="exampleInputEmail1">Remarks : </label>
									    <input type="text" name="remarks" class="form-control" id="username" data-id="'.$imageid.'">
									 </div>
									 <input type="hidden" value="'.$imageid.'" name="imageid">
									 <input type="hidden" value="'.$studentid.'" name="studentid">
			      				<input type="submit" name="submit11" value="Go" class="btn btn-primary" />
			      				</form>
			      			</td>
			      			<td>'.$marks.'</td>
			      			<td>'.$remarks.'</td>
			      			<td><div class="alert alert-success"><b/>'.$status.'</div></td>
			    			</tr>
			    		';
			    		}
			    		else if($status=="unchecked")
			    		{
			    		echo '
			    			<tr>
			      			<th scope="row">'.$cc.'</th>
			      			<td>'.$qno.'</td>
			      			<td>'.$examtype.'</td>
			      			<td><img height="300px" width="300px" src="'.$dest.'" id="myImg" alt="Snow" style="width:100%;max-width:300px" onclick="magnifyImg(this);" /></td>
			      			<td>
			      				<form method="post">
				      				<div class="form-group">
									    <label for="exampleInputEmail1">Marks : </label>
									    <input type="number" name="marks" class="form-control" id="username" data-id="'.$imageid.'">
									 </div>
									 <div class="form-group">
									    <label for="exampleInputEmail1">Remarks : </label>
									    <input type="text" name="remarks" class="form-control" id="username" data-id="'.$imageid.'">
									 </div>
									 <input type="hidden" value="'.$imageid.'" name="imageid">
									 <input type="hidden" value="'.$studentid.'" name="studentid">
			      				<input type="submit" name="submit11" value="Go" class="btn btn-primary" />
			      				</form>
			      			</td>
			      			<td>'.$marks.'</td>
			      			<td>'.$remarks.'</td>
			      			<td><div class="alert alert-danger"><b/>'.$status.'</div></td>
			    			</tr>
			    		';	
			    		}
			    		else if($status=="recheck")
			    		{
			    		echo '
			    			<tr>
			      			<th scope="row">'.$cc.'</th>
			      			<td>'.$qno.'</td>
			      			<td>'.$examtype.'</td>
			      			<td><img height="300px" width="300px" src="'.$dest.'" id="myImg" alt="Snow" style="width:100%;max-width:300px" onclick="magnifyImg(this);" /></td>
			      			<td>
			      				<form method="post">
				      				<div class="form-group">
									    <label for="exampleInputEmail1">Marks : </label>
									    <input type="number" name="marks" class="form-control" id="username" data-id="'.$imageid.'">
									 </div>
									 <div class="form-group">
									    <label for="exampleInputEmail1">Remarks : </label>
									    <input type="text" name="remarks" class="form-control" id="username" data-id="'.$imageid.'">
									 </div>
									 <input type="hidden" value="'.$imageid.'" name="imageid">
									 <input type="hidden" value="'.$studentid.'" name="studentid">
			      				<input type="submit" name="submit11" value="Go" class="btn btn-primary" />
			      				</form>
			      			</td>
			      			<td>'.$marks.'</td>
			      			<td>'.$remarks.'</td>
			      			<td><div class="alert alert-warning"><b/>'.$status.'</div></td>
			    			</tr>
			    		';	
			    		}


			    		$cc = $cc + 1;

			    		echo '<!-- The Modal -->
								<div id="myModal" class="modal">

								  <!-- The Close Button -->
								  <span class="close">&times;</span>

								  <!-- Modal Content (The Image) -->
								  <img class="modal-content" id="img01">

								  <!-- Modal Caption (Image Text) -->
								  <div id="caption"></div>
								</div> ';
					}
		  		
		    ?>

		  </tbody>
		</table>

	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<script type="text/javascript">
		// Get the modal
		function magnifyImg(img){
			var modal = document.getElementById('myModal');

			// Get the image and insert it inside the modal - use its "alt" text as a caption
			var modalImg = document.getElementById("img01");
			var captionText = document.getElementById("caption");
		    modal.style.display = "block";
		    modalImg.src = img.src;
		    captionText.innerHTML = img.alt;
		    console.log(img);

		    // Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
			  modal.style.display = "none";
			} 
		}	
		// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
			  modal.style.display = "none";
			}
	</script>

</body>
</html>

