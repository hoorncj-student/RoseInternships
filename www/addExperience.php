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

    <title>Add Experience</title>

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
        <h1>Add An Experience</h1>
        <p>You can add a new experience here. </p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">


          <h2>Company</h2>
            <div class="form-group">
              <input type="text" placeholder="Please tell us the company name" class="form-control">
            </div>



          <h2>Position</h2>
            <div class="form-group">
              <input type="text" placeholder="Please tell us your position" class="form-control">
            </div>



          <h2>Hourly Salary</h2>
            <div class="form-group">
              <input type="text" placeholder="Please tell us your hourly salary" class="form-control">
            </div>



          <h2>Monthly Salary</h2>
            <div class="form-group">
              <input type="text" placeholder="Please tell us your monthly salary" class="form-control">
            </div>
  


          <h2>Start Date</h2>
            <div class="form-group">
              <input type="password" placeholder="Please tell us your start date for your experience" class="form-control">
            </div>



          <h2>End Date</h2>
            <div class="form-group">
              <input type="password" placeholder="Please tell us your end date for your experience" class="form-control">
            </div>


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