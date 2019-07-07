<?php

include('database_connection.php');
if($_SESSION['type'] != "student")
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
if(isset($_POST['recheck']))
{
	$imageid=$_POST['imageid'];
	$qry="UPDATE studentans SET status='recheck' WHERE id='$imageid'";
	$stm=$connect->prepare($qry);
	$stm->execute();

	$message="Apllied for recheck Successfully";
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
		    <a class="nav-link active" href="studentDash.php">Home</a>
		  </li>
		  <li class="nav-item">
		    <form method="post">
		    	<input type="submit" name="logout" value="Logout" class="btn btn-primary" />
		    </form>
		  </li>
		</ul>
		<br>
		<div class="container">

		  <!-- Welcome message -->	
		  <div class="jumbotron jumbotron-fluid">
		    <div class="container"><h4>  Welcome <?php echo $_SESSION['name']." - ".$_SESSION['username'];?><h4></div>
		  </div>

		<!-- Table for Students Answer sheets -->
		<?php if($message!="") {echo "<div class='alert alert-warning'>$message</div>";} ?>
		<h4>Answer Sheets</h4>
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">S.No</th>
		      <th scope="col">Exam Type</th>
		      <th scope="col">Q.No</th>
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
		  			$studentid=$_SESSION['username'];
		  			
		  			$qry="SELECT * FROM studentans WHERE studid='$studentid'";

					$stm=$connect->prepare($qry);
					$stm->execute();
					$res=$stm->fetchAll();
					$cc=1;
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

						echo '
			    			<tr>
			      			<th scope="row">'.$cc.'</th>
			      			<td>'.$examtype.'</td>
			      			<td>'.$qno.'</td>
			      			<td><img id="myImg" height="300px" width="300px" src="'.$dest.'" id="myImg" alt="Snow" style="width:100%;max-width:300px" onclick="magnifyImg(this);" /></td>
			      			<td>
			      				<form method="post">
			      				<input type="hidden" value="'.$imageid.'" name="imageid">
			      				<input type="submit" name="recheck" value="Recheck" class="btn btn-primary" />
			      				</form>
			      			</td>
			      			<td>'.$marks.'</td>
			      			<td>'.$remarks.'</td>';
			      			if($status=="checked")
			      			{
			      				echo '
				      			<td><div class="alert alert-success"><b/>'.$status.'<div></td>
				    			</tr>
				    			';
			      			}
			      			else if($status=="unchecked")
			      			{
			      				echo '
				      			<td><div class="alert alert-danger"><b/>'.$status.'<div></td>
				    			</tr>
				    			';
			      			}
			      			else if($status=="recheck")
			      			{
			      				echo '
				      			<td><div class="alert alert-warning"><b/>'.$status.'<div></td>
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

