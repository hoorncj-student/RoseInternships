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
    $cid = mysqli_real_escape_string($conn,$_GET["companyid"]);
    $company_results = mysqli_query($conn, "SELECT * " .
                                      "FROM companies " .
                                      "WHERE company_id = " . $cid);
    $company_row = mysqli_fetch_assoc($company_results);
    echo "<title>" . htmlspecialchars($company_row["company_name"]) . "'s Profile</title>";
    ?>
    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

    <link href="css/header.css" rel="stylesheet">

    <link href="css/companyProfile.css" rel="stylesheet">

  </head>

  <body>

    <?php include 'header.php'; ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <?php
        echo '<h1>'. htmlspecialchars($company_row["company_name"]) .'</h1>
          <p>'. htmlspecialchars($company_row['description']) .'</p>';
        ?>
      </div>
    </div>
    <?php
    $internship_results = mysqli_query($conn, "SELECT title, description, major, ave_hourly_pay, position_id
                                                  FROM positions_view
                                                  WHERE type = 'internship' AND company_id = " . $cid);
    $career_results = mysqli_query($conn, "SELECT title, description, major, type, ave_salary, ave_hourly_pay, position_id
                                                  FROM positions_view
                                                  WHERE (type = 'full time' OR type = 'part time') AND company_id = " . $cid);

    $review_results = mysqli_query($conn, "SELECT rating, review, time_posted, student_name, title
                                                  FROM reviews_view
                                                  WHERE company_id = " . $cid);

    ?>
    <div class="container">
          <h2>Positions</h2>
          <div class="panel panel-default">
            <div class="panel-heading">Internships</div>
            <?php
            if(mysqli_num_rows($internship_results) > 0){
              echo '<table class="table">
              <thead>
                <tr>
                  <th>Position</th>
                  <th>Description</th>
                  <th>Major</th>
                  <th>Average Pay</th>
                </tr>
              </thead>
              <tbody>';
              while ($internship = mysqli_fetch_array($internship_results)) {
                echo '<tr>
                    <td>'. htmlspecialchars($internship[0]) .'</td>
                    <td>'. htmlspecialchars($internship[1]) .'</td>
                    <td>'. htmlspecialchars($internship[2]) .'</td>
                    <td>'. htmlspecialchars(toMoney($internship[3])) .'/hr</td>';
              }
              echo '</tbody>
                </table>';
            } else {
              echo 'No intern positions on record';
            }
            ?>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Careers</div>
            <?php
            if(mysqli_num_rows($career_results) > 0){
              echo '<table class="table">
                <thead>
                  <tr>
                    <th>Position</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Major</th>
                    <th>Average Salary</th>
                  </tr>
                </thead>
                <tbody>';
              while ($car = mysqli_fetch_array($career_results)) {
                $moneystring2 = ($car[4] > 0) ? toMoney($car[4]) . "/yr" : toMoney($car[5]) . "/hr";
                echo '<tr>
                    <td>'. htmlspecialchars($car[0]) .'</td>
                    <td>'. htmlspecialchars($car[3]) .'</td>
                    <td>'. htmlspecialchars($car[1]) .'</td>
                    <td>'. htmlspecialchars($car[2]) .'</td>
                    <td>'. $moneystring2 .'</td>
                  </tr>';
              }
              echo '</tbody>
                </table>';
            } else {
              echo 'No full or part time positions on record';
            }
            ?>
          </div>

          <h2>Reviews</h2>

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