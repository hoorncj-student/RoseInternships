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


          <h2>Major</h2>
            <div class="form-group">
              <form>
                <select name="changeMajor">
                  <option value="EE">EE</option>
                  <option value="CS" selected="selected">CS</option>
                  <option value="ME">ME</option>
                  <option value="CPE">CPE</option>
                </select>
              </form>
            </div>


          <h2>Graduation Year</h2>
            <div class="col-xs-4">
              <input type="text" placeholder="change graduateion year to ..." class="form-control">
            </div><br/><br/>







          <h2>GPA</h2>
            <div class="col-xs-2">
              <input type="text" placeholder="change GPA to ..." class="form-control">
            </div><br/><br/>
  


          <h2>Password</h2>
            <div class="col-xs-4">
              <input type="password" placeholder="change password to ..." class="form-control">
            </div><br/><br/>

          <h2>Email</h2>
            <div class="col-xs-6">
              <input type="text" placeholder="change email to ..." class="form-control">
            </div><br/><br/>
          
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