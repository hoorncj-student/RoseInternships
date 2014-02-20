<!DOCTYPE html>
<?php include 'dbconnection.php'; ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
	
	<?php
		
		$pid = mysqli_real_escape_string($conn,$_GET["positionid"]);

		$employment_results = mysqli_query($conn, "SELECT p.title, c.company_name, p.position_id " .
											"FROM employment e, companies c, positions p " .
											"WHERE e.position_id = p.position_id AND p.company_id = c.company_id AND e.employment_id = " . intval($pid));
													
		$employment_row = mysqli_fetch_assoc($employment_results);
		
		if(mysqli_num_rows($employment_results) >  0){
			echo"<div class= " ."container" .">
			<h1>Review Employment</h1>
			<p>review " . htmlspecialchars($employment_row["title"]) . " position at " . htmlspecialchars($employment_row["company_name"]) . " here</p>
			</div>";
			}else{
			echo "whats went wrong?";
			#   echo "<script> window.location = 'index.php';</script>";
    }
		
	?>

    <title>Add Review</title>
	
	

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

    <link href="css/header.css" rel="stylesheet">

    <link href="css/addExperience.css" rel="stylesheet">
	
	</head>
	
	
	    <div class="jumbotron">
      
      </div>
    
	  <body>

    <?php include 'header.php'; ?>
	
	
	<?php 
	
	$addRevError = '';
	
	if($_SERVER['REQUEST_METHOD'] =='POST'){
		if(isset($_POST['addRev'])){
		if(strlen ($_POST['review']) > 0){
			$ReviewText = $_POST['review'];
			$Rating = $_POST['SelRat'];
		
		}else{
			$addRevError .= "You must provide review text <br />";
			}
		
		if(!$addRevError){
			mysqli_query($conn, "INSERT INTO reviews (student_id, position_id, rating, review, time_posted)
									VALUES (". mysqli_real_escape_string($conn, $_COOKIE["user"]) .",". mysqli_real_escape_string($conn, $employment_row['position_id']) . "," . mysqli_real_escape_string($conn, $Rating) . ",'" . mysqli_real_escape_string($conn, $ReviewText). "', NOW())");
			$rev = mysqli_insert_id($conn);
			echo "<script> window.location = 'userProfile.php?studentid=". $_COOKIE["user"] ."';</script>";
		}
	}
	
}
	
	
	
	?>
<div class = "container">
	<form role = "form" id ="addreviewForm" class ="registration-form" method ="POST">
	<div class = "row">
		<h2> Rating </h2>
		<select id = "select_rating" name = "SelRat">
			<option value ="5"> 5</option>
			<option value ="4"> 4</option>
			<option value ="3"> 3</option>
			<option value ="2"> 2</option>
			<option value ="1"> 1</option>	
		</select>
	</div>
	
	<div class = "row">
		
		<h2>Review </h2>
		<div class = "col-xs-8">
			<textarea rows ="5" cols="80" name="review" form="addreviewForm" placeholder = "Enter review text here..."></textarea>
		</div>
	</div>
	<div class = "row">
	<button type="submit" name="addRev" class="btn btn-default button-submit">Add review</button>
	
	</div>
	</form>
	
	</div>
	
	
	</body>
	
	

	
</html>