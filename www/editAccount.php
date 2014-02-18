<!DOCTYPE html>

<?php 
include 'dbconnection.php';
$Notification = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST['editAccountSubmitButton'])){

    $newMajor = $_POST['newMajor'];
    $newGPA = $_POST['newGPA'];
    $newPassword = $_POST['newPassword'];
    $newEmail = $_POST['newEmail'];
    $newGradYear = $_POST['newGradYear'];

    //update major
    if(!empty($newMajor)){
      $newMajor = mysqli_real_escape_string($conn,$newMajor);
      $majorUpdateResult = mysqli_query($conn,"UPDATE students
                                                SET major = '".$newMajor."'");
      if($majorUpdateResult) $Notification.= "New major updated successfully. </br>"; else $Notification.= "update major error. </br>";
    }

    if(!empty($newGradYear)){
      $newGradYear = mysqli_real_escape_string($conn,$newGradYear);
      $gradYearUpdateResult = mysqli_query($conn,"UPDATE students
                                                SET grad_year = ". $newGradYear);
      if($gradYearUpdateResult) $Notification.= "New graduation year updated successfully. </br>";else $Notification.= "update graduation year error. </br>";
    }

    //update GPA
    if(!empty($newGPA)){
      $newGPA = mysqli_real_escape_string($conn,$newGPA);
      $GPAUpdateResult = mysqli_query($conn,"UPDATE students
                                                SET password =".$newGPA);
      if($GPAUpdateResult) $Notification.= "New GPA updated successfully. </br>";else $Notification.= "update GPA error. </br>";
    }
    //update Password
    if(!empty($newPassword)){
      $newPassword = mysqli_real_escape_string($conn,$newPassword);
      $original_username = $user_row["username"];
      $passwordUpdateResult = mysqli_query($conn,"UPDATE students
                                                  SET password = saltedHash('" .$original_username . "', '" . $newPassword . "')");
      if($passwordUpdateResult) $Notification.= "New Password updated successfully. </br>";else $Notification.= "update password error. </br>";
    }
    //update email
    if(!empty($newEmail)){
      $newEmail = mysqli_real_escape_string($conn,$newEmail);
      $emailUpdateResult = mysqli_query($conn,"UPDATE students
                                                SET email = '". $newEmail."'");
      if($emailUpdateResult) $Notification.= "New email updated successfully. </br>";else $Notification.= "update email error. </br>";
    }

  }
}
?>



<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Edit Your Account</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

    <link href="css/header.css" rel="stylesheet">

</head>
  <body>

    <?php include 'header.php'; ?>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Edit Your Account</h1>
        <p>You can edit your accunt information here. </p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <form role="form" method="POST">
          <h2>Major</h2>
            <div class="form-group">
              
                <select name="newMajor">
                  <?php
                  $majors = get_majors();
                  for($x=0;$x<count($majors);$x++){
                    echo '<option value="' . $majors[$x] . '">' . $majors[$x] . '</option>';
                  }
                  ?>
                </select>
              
            </div>


          <h2>Graduation Year</h2>
            <div class="col-xs-4">
              <input type="text" name = "newGradYear" placeholder="change graduateion year to ..." class="form-control">
            </div><br/><br/>


          <h2>GPA</h2>
            <div class="col-xs-2">
              <input type="text" name = "newGPA" placeholder="change GPA to ..." class="form-control">
            </div><br/><br/>
  


          <h2>Password</h2>
            <div class="col-xs-4">
              <input type="password" name = "newPassword" placeholder="change password to ..." class="form-control">
            </div><br/><br/>

          <h2>Email</h2>
            <div class="col-xs-6">
              <input type="text" name = "newEmail" placeholder="change email to ..." class="form-control">
            </div><br/><br/>

          <br/><br/><br/><br/>  
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" id="submitbutton" name="editAccountSubmitButton" class="btn btn-default button-submit">submit changes</button>
            </div>
          </div>
        </form>  <br/><br/>
        <?php
          echo '<label>' . $Notification . '</label>';
        ?>


      </div>

      <hr>
      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>