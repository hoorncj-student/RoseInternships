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
    $sid = mysqli_real_escape_string($conn,$_GET["studentid"]);
    $student_results = mysqli_query($conn, "SELECT * " .
                                      "FROM students " .
                                      "WHERE student_id = " . $sid);
    $student_row = mysqli_fetch_assoc($student_results);
    echo "<title>" . htmlspecialchars($student_row["student_name"]) . "'s Profile</title>";
    ?>
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
        <?php
        echo '<h1>'. htmlspecialchars($student_row["student_name"]) . "'" . 's Profile</h1>
          <p>' . htmlspecialchars($student_row["student_name"]) . ' is a member of the class of ' . htmlspecialchars($student_row["grad_year"]) . ' with a major in ' . htmlspecialchars($student_row["major"]) .'</p>
          <p><a class="btn btn-default" href="editAccount.php" role="button"> Edit Account &raquo;</a></p>'
        ?>
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