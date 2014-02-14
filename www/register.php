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

    <title>Rose Internship Search</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="css/header.css" rel="stylesheet">

    <link href="css/register.css" rel="stylesheet">

  </head>

  <body>

    <?php include 'header.php'; ?>

    <?php
    $errmessage = '';
    $name = '';
    $username = '';
    $pass = '';
    $email = '';
    $m1 = '';
    $m2 = '';
    $m3 = '';
    $major = '';
    $gradyr = '';
    $gpa = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  		if(!isset($_POST['name']) or strlen($_POST['name']) == 0){
  			$errmessage .= 'name required<br />';
  		} else {
  			$name = $_POST['name'];
  		}
  		if(!isset($_POST['username']) or strlen($_POST['username']) == 0){
  			$errmessage .= 'username required<br />';
  		} else {
  			$username = $_POST['username'];
  		}
  		if(!isset($_POST['pass1']) or strlen($_POST['pass1']) ==0){
  			$errmessage .= 'password required<br />';
  		} else if($_POST['pass1'] != $_POST['pass2']){
  			$errmessage .= 'passwords must match<br />';
  		} else if(strlen($_POST['pass1']) < 6){
  			$errmessage .= 'passwords must be at lease 6 characters<br />';
  		} else {
  			$pass = $_POST['pass1'];
  		}
  		if(isset($_POST['email']) and strlen($_POST['email']) > 0){
  			$email = $_POST['email'];
  		}
  		if(isset($_POST['m1']) and strlen($_POST['m1']) > 0){
  			$m1 = $_POST['m1'];
  			$major .= $m1;
  			if(isset($_POST['m2']) and strlen($_POST['m2']) > 0){
  				$m2 = $_POST['m2'];
  				$major .= '/' . $m2;
  				if(isset($_POST['m3']) and strlen($_POST['m3']) > 0){
  					$m3 = $_POST['m3'];
  					$major .= '/' . $m3;
  				}
  			}
  		}
  		if(isset($_POST['gradyr']) and strlen($_POST['gradyr']) > 0){
  			$gradyr = $_POST['gradyr'];
  		}
  		if(isset($_POST['gpa']) and strlen($_POST['gpa']) > 0 and !is_numeric($_POST['gpa'])){
  			$errmessage .= 'gpa must be of format #.##<br />';
  		} else if(isset($_POST['gpa'])){
  			$gpa = $_POST['gpa'];
  		}
  		if(!$errmessage){
  			$paramstring = 'student_name, username, password';
  			$datastring = "'" . mysql_real_escape_string($name) . "', '" . mysql_real_escape_string($username) . "', saltedHash('" . mysql_real_escape_string($username) . "', '" . mysql_real_escape_string($pass) . "')";
  			if($email != ''){
  				$paramstring .= ', email';
  				$datastring .= ", '" . mysql_real_escape_string($email) . "'";
  			}
  			if($major != ''){
  				$paramstring .= ', major';
				$datastring .= ", '" . mysql_real_escape_string($major) . "'";
  			}
  			if($gradyr != ''){
  				$paramstring .= ', grad_year';
  				$datastring .= ", '" . mysql_real_escape_string($gradyr) . "'";
  			}
  			if($gpa != ''){
  				$paramstring .= ', gpa';
  				$datastring .= ", " . mysql_real_escape_string($gpa);
  			}
  			mysqli_query($conn, "INSERT INTO students (" . $paramstring . ")
                                 VALUES (" . $datastring . ")");
  			echo "<script> window.location = 'index.php';</script>";
  		}
  	}
  	?>
    <h1>Create an Account</h1>
    <?php echo '<p class="error">' . $errmessage . '</p>'; ?>
    <div class="container">
      <form role="form" class="registration-form" method="POST">
      	<div class="row">
          <label class="col-xs-4" for="inputFirstName">Display Name*</label>
          <div class="col-xs-8">
            <?php echo '<input type="text" class="form-control" id="inputFirstName" name="name"placeholder="Name" value=' . htmlspecialchars($name) . '>'; ?>
          </div>
        </div>
        <div class="row">
          <label class="col-xs-4" for="inputUsername">Username*</label>
          <div class="col-xs-8">
            <?php echo '<input type="text" class="form-control" id="inputUsername" name="username"placeholder="Username" value=' . htmlspecialchars($username) . '>'; ?>
          </div>
        </div>
        <div class="row">
          <label class="col-xs-4" for="inputPassword1">Password*</label>
          <div class="col-xs-8">
            <input type="password" class="form-control" id="inputPassword1" name="pass1"placeholder="Password" value=''>
          </div>
        </div>
        <div class="row">
          <label class="col-xs-4" for="inputPassword2">Re-Enter Password*</label>
          <div class="col-xs-8">
            <input type="password" class="form-control" id="inputPassword2" name="pass2"placeholder="Password" value=''>
          </div>
        </div>
        <div class="row">
          <label class="col-xs-4" for="inputEmail">Email</label>
          <div class="col-xs-8">
            <?php echo '<input type="email" class="form-control" id="inputEmail" name="email"placeholder="Email" value=' . htmlspecialchars($email) . '>'; ?>
          </div>
        </div>
        <div class="row">
          <label class="col-xs-4" for="inputMajor">Major</label>
          <div class="col-xs-8">
            <?php echo '<input type="text" class="form-control" id="inputMajor" name="m1"placeholder="Major" value=' . htmlspecialchars($m1) . '>'; ?>
          </div>
        </div>
        <div class="row">
          <label class="col-xs-4" for="inputEmail">Grad Year</label>
          <div class="col-xs-8">
            <?php echo '<input type="text" class="form-control" id="inputGradyr" name="gradyr"placeholder="Grad Year" value=' . htmlspecialchars($gradyr) . '>'; ?>
          </div>
        </div>
        <div class="row">
          <label class="col-xs-4" for="inputEmail">GPA</label>
          <div class="col-xs-8">
            <?php echo '<input type="text" class="form-control" id="inputGpa" name="gpa"placeholder="GPA" value=' . htmlspecialchars($gpa) . '>'; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-default button-submit">Create Account</button>
          </div>
        </div>
      </form>
    </div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>