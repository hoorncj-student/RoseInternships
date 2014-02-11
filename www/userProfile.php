<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>XXX's Profile</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

  </head>

  <body>

    <?php include 'header.php'; ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>XXX's Profile</h1>
        <p>XXX is a student/alumni major in xxx, graduated/will graduate at 20xx. </p>
        <p><a class="btn btn-default" href="editAccount.php" role="button"> Edit Account &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->



          <h2>Experiences</h2>
          <p><a class="btn btn-default" href="addExperience.php" role="button"> Add Experience &raquo;</a></p>


          <h2>Reviews</h2>



          <h2>Classes</h2>



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
    <script>
    document.getElementById("profiletab").className = "active";
    </script>
  </body>
</html>