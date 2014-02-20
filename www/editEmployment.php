<!DOCTYPE html>

<?php 
include 'dbconnection.php';
$Notification = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST['editEmploymentSubmitButton'])){

    $newSalary = $_POST['newSalary'];
    $newHourlyPay = $_POST['newHourlyPay'];
    $newStartDate = $_POST['newStartDate'];
    $newEndDate = $_POST['newEndDate'];
    $newBenefits = $_POST['newBenefits'];

    //update start date
    if(!empty($newStartDate)){
      $newStartDate = mysqli_real_escape_string($conn,$newStartDate);
      $startDateUpdateResult = mysqli_query($conn,"UPDATE employment
                                                SET start_date = '".$newStartDate."'
                                                WHERE employment_id = ". $_GET["employment_id"]);
      if($startDateUpdateResult) $Notification.= "New start date updated successfully. </br>"; else $Notification.= "update start date error. </br>";
    }
    //update end date
    if(!empty($newEndDate)){
      $newEndDate = mysqli_real_escape_string($conn,$newEndDate);
      $endDateUpdateResult = mysqli_query($conn,"UPDATE employment
                                                SET end_date = '".$newEndDate."'
                                                WHERE employment_id = ". $_GET["employment_id"]);
      if($endDateUpdateResult) $Notification.= "New end date updated successfully. </br>"; else $Notification.= "update end date error. </br>";
    }
    //update salary
    if(!empty($newSalary)){
      $newSalary = mysqli_real_escape_string($conn,$newSalary);
      $salaryUpdateResult = mysqli_query($conn,"UPDATE employment
                                                SET salary ='".$newSalary."'
                                                WHERE employment_id = ". $_GET["employment_id"]);
      if($salaryUpdateResult) $Notification.= "New salary updated successfully. </br>";else $Notification.= "update salary error. </br>";
    }
    //update hourly pay
    if(!empty($newHourlyPay)){
      $newHourlyPay = mysqli_real_escape_string($conn,$newHourlyPay);
      $hourlyPayUpdateResult = mysqli_query($conn,"UPDATE employment
                                                  SET hourly_pay = '" .$newHourlyPay ."'
                                                  WHERE employment_id = ". $_GET["employment_id"]);
      if($hourlyPayUpdateResult) $Notification.= "New Password updated successfully. </br>";else $Notification.= "update password error. </br>";
    }
    //update benefits
    if(!empty($newBenefits)){
      $newBenefits = mysqli_real_escape_string($conn,$newBenefits);
      $benefitsUpdateResult = mysqli_query($conn,"UPDATE employment
                                                SET benefits = '". $newBenefits."'
                                                WHERE employment_id = ". $_GET["employment_id"]);
      if($benefitsUpdateResult) $Notification.= "New benefits updated successfully. </br>";else $Notification.= "update benefits error. </br>";
    }

    if(empty($newStartDate) && empty($newEndDate) && empty($newSalary) && empty($newHourlyPay)  && empty($newBenefits))
      $Notification.= "Nothing Changed.";

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

    <link href="css/editAccount.css" rel="stylesheet">

</head>
  <body>

    <?php include 'header.php'; ?>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Edit Your Employment</h1>
        <p>You can edit your employment information here. </p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <form role="form" method="POST" id="editEmployment">

          <h2>Salary</h2>
            <div class="col-xs-4">
              <input type="text" name = "newSalary" placeholder="change salary year to ..." class="form-control">
            </div><br/><br/>


          <h2>Hourly Pay</h2>
            <div class="col-xs-4">
              <input type="text" name = "newHourlyPay" placeholder="change hourly pay year to ..." class="form-control">
            </div><br/><br/>

          <h2>Start Date</h2>
            <div class="col-xs-4">
              <input type="date" name = "newStartDate" placeholder="change start date to ..." class="form-control">
            </div><br/><br/>

          <h2>End Date</h2>
            <div class="col-xs-4">
              <input type="date" name = "newEndDate" placeholder="change end date to ..." class="form-control">
            </div><br/><br/>

          <h2>Benefits</h2>
            <div class="col-xs-6">
              <textarea rows="4" cols="60" name="newBenefits" form="editEmployment" placeholder="new benefits information..."></textarea>
            </div><br/><br/>  


          <br/><br/><br/><br/>  
          <div class="row">
            <div class="col-xs-12">
              <button type="submit"  name="editEmploymentSubmitButton" class="btn btn-success">submit changes</button>
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