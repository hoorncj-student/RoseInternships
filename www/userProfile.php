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

    <link href="css/userProfile.css" rel="stylesheet">

  </head>

  <body>

    <?php include 'header.php'; ?>

    <?php
    if(isset($_POST['accept_offer'])){
      $acceptsuccess = mysqli_query($conn, "CALL accept_offer(".$_POST['offer_id'].")");
      while(mysqli_more_results($conn))
      {
          mysqli_next_result($conn);
          if($res = mysqli_store_result($conn))
          {
              $res->free(); 
          }
      }
    }
    if(isset($_POST['delete_offer'])){
      mysqli_query($conn, "DELETE FROM offers
                                            WHERE offer_id = ".$_POST['offer_id']);
    }
    ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <?php
        echo '<h1>'. htmlspecialchars($student_row["student_name"]) . "'" . 's Profile</h1>
          <p>' . htmlspecialchars($student_row["student_name"]) . ' is a member of the class of ' . htmlspecialchars($student_row["grad_year"]) . ' with a major in ' . htmlspecialchars($student_row["major"]) .'</p>';
        if($student_row['student_id'] == $user_row['student_id'] ){
          echo '<p><a class="btn btn-default" href="editAccount.php" role="button"> Edit Account &raquo;</a></p>';
        }
        ?>
      </div>
    </div>
    <?php
    $offer_results = mysqli_query($conn, "SELECT company_name, title, start_date, salary, hourly_pay, offer_id
                                                  FROM offers_view
                                                  WHERE student_id = " . $sid);
    $employment_results = mysqli_query($conn, "SELECT company_name, title, start_date, end_date, salary, hourly_pay, offer_id
                                                  FROM employment_view
                                                  WHERE student_id = " . $sid);
    $accepted = mysqli_query($conn, "SELECT "."o.offer_id ".
                                        "FROM offers o, employment e
                                        WHERE o.offer_id = e.offer_id");
    $acceptedarray = array();
    while($accepter = mysqli_fetch_array($accepted)){
      $acceptedarray[] = $accepter[0];
    }
    ?>
    <div class="container">
          <h2>Experiences</h2>
          <div class="panel panel-default">
            <div class="panel-heading">Offers</div>
            <table class="table">
              <thead>
                <tr>
                  <th>Company</th>
                  <th>Position</th>
                  <th>Start Date</th>
                  <th>Salary</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  while ($offer = mysqli_fetch_array($offer_results)) {
                    $moneystring = ($offer[3] == 0) ? toMoney($offer[4]) . "/hr" : toMoney($offer[3]) . "/yr";
                    echo '<tr>
                        <td>'. $offer[0] .'</td>
                        <td>'. $offer[1] .'</td>
                        <td>'. $offer[2] .'</td>
                        <td>'. $moneystring .'</td>';
                    echo '<td><form role="form" method="POST">
                              <input type="hidden" name="offer_id" value='.$offer[5].' />';
                    if(!in_array($offer[5],$acceptedarray)){
                      echo '<button type="submit" name="accept_offer" class="btn btn-primary button-submit">Accept</button>';
                    }
                    echo '<button type="submit" name="delete_offer" class="btn btn-primary button-delete">Delete</button>
                          </form></td></tr>';
                  }
                ?>
              </tbody>
            </table>
          </div>

          <?php
          if($student_row['student_id'] == $user_row['student_id'] ){
            echo '<p><a class="btn btn-default" href="addExperience.php" role="button"> Add Experience &raquo;</a></p>';
          }
          ?>

          <h2>Reviews</h2>

          <h2>Classes</h2>

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