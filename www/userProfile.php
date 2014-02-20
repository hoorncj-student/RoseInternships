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
    if(mysqli_num_rows($student_results) > 0){
      echo "<title>" . htmlspecialchars($student_row["student_name"]) . "'s Profile</title>";
    } else {
      echo "<script> window.location = 'index.php';</script>";
    }
    ?>
    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

    <link href="css/header.css" rel="stylesheet">

    <link href="css/userProfile.css" rel="stylesheet">

    <script>
    function setOtherClass(){
      thing = document.getElementById('selectclassname');
      if(thing.value == 'other'){
        document.getElementById('otherclassfield').style.display = "block";
      } else {
        document.getElementById('otherclassfield').style.display = "none";
      }
    }
    </script>

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
      mysqli_query($conn, "UPDATE employment
                            SET offer_id = NULL
                            WHERE offer_id = ".$_POST['offer_id']);
      mysqli_query($conn, "DELETE FROM offers
                            WHERE offer_id = ".$_POST['offer_id']);
    }
    if(isset($_POST['delete_employment'])){
      mysqli_query($conn, "DELETE FROM employment
                            WHERE employment_id = " .$_POST['employment_id']);
    }
    if(isset($_POST['add_class'])){
      if(is_numeric($_POST['classname']) or $_POST['classname'] == 'other' and strlen($_POST['otherclassname']) > 0){
        $classid = $_POST['classname'];
        if($_POST['classname'] == 'other'){
          mysqli_query($conn, "INSERT INTO classes (class_name)
                                VALUES ('".$_POST['otherclassname']."')");
          $classid = mysqli_insert_id($conn);
        }
        mysqli_query($conn, "INSERT INTO enrollment (class_id, student_id, grade, start_date)
                                VALUES ('".$classid."','".$user_row['student_id']."','".$_POST['grade']."','".$_POST['classdate']."')");
      }
    }
    if(isset($_POST['delete_class'])){
      mysqli_query($conn, "DELETE FROM enrollment
                            WHERE class_id = " .$_POST['class_id']. " AND student_id = ".$user_row['student_id']);
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
    $offer_results = mysqli_query($conn, "SELECT company_name, title, start_date, salary, hourly_pay, offer_id, company_id
                                                  FROM offers_view
                                                  WHERE student_id = " . $sid);
    $employment_results = mysqli_query($conn, "SELECT company_name, title, start_date, end_date, salary, hourly_pay, employment_id, company_id
                                                  FROM employment_view
                                                  WHERE student_id = " . $sid);
    $accepted = mysqli_query($conn, "SELECT "."o.offer_id ".
                                        "FROM offers o, employment e
                                        WHERE o.offer_id = e.offer_id");
    $class_results = mysqli_query($conn, "SELECT c.class_name, e.grade, e.start_date, e.class_id
                                          FROM enrollment e, classes c
                                          WHERE e.class_id = c.class_id AND e.student_id = ".$user_row['student_id']);
    $acceptedarray = array();
    while($accepter = mysqli_fetch_array($accepted)){
      $acceptedarray[] = $accepter[0];
    }
    ?>
    <div class="container">
          <h2>Experiences</h2>
          <div class="panel panel-default">
            <div class="panel-heading">Offers</div>
            <?php
            if(mysqli_num_rows($offer_results) > 0){
              echo '<table class="table">
              <thead>
                <tr>
                  <th>Company</th>
                  <th>Position</th>
                  <th>Start Date</th>
                  <th>Salary</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>';
              while ($offer = mysqli_fetch_array($offer_results)) {
                $moneystring = ($offer[3] == 0) ? toMoney($offer[4]) . "/hr" : toMoney($offer[3]) . "/yr";
                echo '<tr>
                    <td><a href="companyProfile.php?companyid='.htmlspecialchars($offer[6]).'">'. htmlspecialchars($offer[0]) .'</a></td>
                    <td>'. htmlspecialchars($offer[1]) .'</td>
                    <td>'. htmlspecialchars($offer[2]) .'</td>
                    <td>'. $moneystring .'</td>';
                echo '<td><form role="form" method="POST">
                          <input type="hidden" name="offer_id" value='.$offer[5].' />';
                if(!in_array($offer[5],$acceptedarray)){
                  echo '<button type="submit" name="accept_offer" class="btn btn-primary button-submit">Accept</button>';
                }
                echo '<button type="submit" name="delete_offer" class="btn btn-primary button-delete">Delete</button>
                      </form></td></tr>';
              }
              echo '</tbody>
                </table>';
            } else {
              echo 'No offers on record';
            }
            ?>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Employment</div>
            <?php
            if(mysqli_num_rows($employment_results) > 0){
              echo '<table class="table">
                <thead>
                  <tr>
                    <th>Company</th>
                    <th>Position</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Salary</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>';
              while ($emp = mysqli_fetch_array($employment_results)) {
                $moneystring2 = ($emp[4] == 0) ? toMoney($emp[5]) . "/hr" : toMoney($emp[4]) . "/yr";
                echo '<tr>
                    <td><a href="companyProfile.php?companyid='.htmlspecialchars($emp[7]).'">'. htmlspecialchars($emp[0]) .'</a></td>
                    <td>'. htmlspecialchars($emp[1]) .'</td>
                    <td>'. htmlspecialchars($emp[2]) .'</td>
                    <td>'. htmlspecialchars($emp[3]) .'</td>
                    <td>'. $moneystring2 .'</td>
                    <td><form role="form" method="POST">
                          <input type="hidden" name="employment_id" value='.$emp[6].' />
                          <button type="submit" name="delete_employment" class="btn btn-primary button-delete">Delete</button>
                        </form></td>
                  </tr>';
              }
              echo '</tbody>
                </table>';
            } else {
              echo 'No employment on record';
            }
            ?>
          </div>

          <?php
          if($student_row['student_id'] == $user_row['student_id'] ){
            echo '<p><a class="btn btn-default" href="addExperience.php" role="button"> Add Experience &raquo;</a></p>';
          }
          ?>

          <h2>Reviews</h2>

          <h2>Classes</h2>
          <div class="panel panel-default">
            <?php
            if(mysqli_num_rows($class_results) > 0){
              echo '<table class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Date Taken</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>';
              while ($cl = mysqli_fetch_array($class_results)) {
                echo '<tr>
                    <td>'. htmlspecialchars($cl[0]) .'</a></td>
                    <td>'. htmlspecialchars($cl[1]) .'</td>
                    <td>'. htmlspecialchars($cl[2]) .'</td>
                    <td><form role="form" method="POST">
                          <input type="hidden" name="class_id" value='.$cl[3].' />
                          <button type="submit" name="delete_class" class="btn btn-primary button-delete">Delete</button>
                        </form></td>
                  </tr>';
              }
              echo '</tbody>
                </table>';
            } else {
              echo 'No employment on record';
            }
            ?>
          </div>
          <?php
          if($student_row['student_id'] == $user_row['student_id'] ){
            echo '<form role="form" method="POST">
                    <div class="row">
                      <button type="submit" name="add_class" class="btn btn-default button-submit col-xs-2">Add Class &raquo</button>
                      <div class="col-xs-1">
                        <label>Class Name: </label><select id="selectclassname" onChange="setOtherClass()" name="classname">';
            $classes = mysqli_query($conn, "SELECT  class_name, class_id FROM classes ");
            while ($class = mysqli_fetch_array($classes)) {
              echo '<option value="' . htmlspecialchars($class[1]) . '">' . htmlspecialchars($class[0]) . '</option>';
            }
            echo '<option value="other">Other</option></select></div>
                <div id="otherclassfield" style="display:none" class="col-xs-3"><input type="text" class="form-control" name="otherclassname" placeholder="Class Name"></div>
                <div class="col-xs-4">
                  <label>Grade: </label><select name="grade">';
            $grades = get_grades();
            for($x=0;$x<count($grades);$x++){
                echo '<option value="' . htmlspecialchars($grades[$x]) . '">' . htmlspecialchars($grades[$x]) . '</option>';
            }
            echo '</select></div>
                  <div class="col-xs-2">
                    <label>Date Taken: </label><input type="date" name="classdate">
                  </div>
                </div>
              </form>';
          }
          ?>
        </div>

    </div> <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <?php
    if($student_row['student_id'] == $user_row['student_id']){
      echo '<script>
              document.getElementById("profiletab").className = "active";
            </script>';
    }
    ?>
    <script>
      setOtherClass();
    </script>
  </body>
</html>