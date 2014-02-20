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

    <!-- Custom styles for this template -->
    <link href="css/search.css" rel="stylesheet">

    <link href="css/header.css" rel="stylesheet">

    <script>
    function setSalary()
    {
      document.getElementById('salaryval').innerText = "$"+document.getElementById('salaryslider').value;
    }
    function setRating()
    {
      document.getElementById('ratingval').innerText = document.getElementById('ratingslider').value;
    }
    function setHourly()
    {
      document.getElementById('hourlyval').innerText = "$"+document.getElementById('hourlyslider').value;
    }
    </script>

  </head>

  <body>

    <?php include 'header.php'; ?>
    <div class="container">
      <?php
        if(isset($_GET['searchfor'])){
          $searchfor = $_GET['searchfor'];
        } else {
          $searchfor = 'Internships';
        }
      ?>
      <h1>Search for :
        <div class="btn-group">
          <?php
          echo '<button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown">' .
            htmlspecialchars($searchfor) .
            '<span class="caret"></span></button>';
          ?>
          <ul class="dropdown-menu">
            <li><a href='/search.php?searchfor=Internships'>Internships</a></li>
            <li><a href="/search.php?searchfor=Careers">Careers</a></li>
            <li><a href="/search.php?searchfor=Companies">Companies</a></li>
            <li><a href="/search.php?searchfor=Positions">Positions</a></li>
          </ul>
        </div>
      </h1>
      <div class="panel panel-default">
        <div class="panel-heading">Search Options</div>
        <form role="form" action="" method="POST">

        <?php    
          if($searchfor != "Positions"){
          echo 'Field: <select name="field">
            <option value="any" selected>Any</option>';
            
              $fields = mysqli_query($conn, "SELECT DISTINCT(field) ".
                "FROM companies ");
              while ($field = mysqli_fetch_array($fields)) {
                echo '<option value="' . htmlspecialchars($field[0]) . '">' . htmlspecialchars($field[0]) . '</option>';
              }
        
          echo '</select>';
        }
        ?>  

        <?php
        if($searchfor != "Companies") {
          echo 'Major: <select name="major">
            <option value="any" selected>Any</option>';
              $majors = mysqli_query($conn, "SELECT DISTINCT(major) ".
                "FROM positions ");
              while ($major = mysqli_fetch_array($majors)) {
                echo '<option value="' . htmlspecialchars($major[0]) . '">' . htmlspecialchars($major[0]) . '</option>';
              }
           echo '</select>';
          }
        ?>


          
          <?php
          if( $searchfor != 'Companies'){
            echo 'Company: <select name="company">
            <option value="any" selected>Any</option>';
            $companies = mysqli_query($conn, "SELECT  company_name ".
              "FROM companies ");
            while ($company = mysqli_fetch_array($companies)) {
              echo '<option value="' . htmlspecialchars($company[0]) . '">' . htmlspecialchars($company[0]) . '</option>';
            }
            echo '</select>';
          }
          ?>
          <?php
          if( $searchfor != 'Internships'){
            if($searchfor =="Companies" || $searchfor=="Positions"){
                echo 'Average Salary: <input id="salaryslider" type="range" name="ave_salary" min="0" max="200000" step="10000" value="0" onChange="setSalary()"><label id="salaryval">$0</label>';
                echo 'Average Rating: <input id="ratingslider" type="range" name="ave_rating" min="0" max="5" step="1" value="0" onChange="setRating()"><label id="ratingval">0</label>';
            }else{
                echo 'Salary: <input id="salaryslider" type="range" name="salary" min="0" max="200000" step="10000" value="0" onChange="setSalary()"><label id="salaryval">$0</label>';
            }
          }else{
            echo 'Hourly Pay: <input id="hourlyslider" type="range" name="hourly_pay" min="0" max="50" step="5" value="0" onChange="setHourly()"><label id="hourlyval">$0</label>';
          }
          ?>

          <?php
          if ($searchfor =="Internships" || $searchfor =="Careers"){
                echo '<select name="offer_or_employment">
                        <option value="employment" selected>Employment</option>
                        <option value="offer" selected>Offer</option>
                    </select>';}
          ?>

          <button type="submit" class="btn btn-success" name="search_button">Search</button>
        </form>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">Results</div>
        <table class="table">
        <thead>

            <?php
            if($searchfor=="Internships")
            echo '  <tr>
                      <th>Company Name</th>
                      <th>Major</th>
                      <th>Field</th>
                      <th>Student</th>
                      <th>Hourly Pay</th>
                    </tr>';
            else if($searchfor=="Companies")
            echo '  <tr>
                      <th>Company Name</th>
                      <th>Field</th>
                      <th>Average Salary</th>
                      <th>Average Rating</th>
                      <th>Description</th>
                    </tr>';
            else if($searchfor=="Careers")
            echo '  <tr>
                      <th>Company Name</th>
                      <th>Major</th>
                      <th>Field</th>
                      <th>Student</th>
                      <th>Salary</th>
                      <th>Hourly Pay</th>
                    </tr>';
            else if($searchfor=="Positions")
            echo '<tr>
                      <th>Company Name</th>
                      <th>Major</th>
                      <th>Title</th>
                      <th>Average Salary</th>
                      <th>Average Hourly Pay</th>
                      <th>Average Rating</th>
                    </tr> ';        
            ?>

          </thead>
          <tbody>

        
<?php
$debug_print = "";
$SQLWhereCondition = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['search_button'])){
        //=========================================================== Internships =============================================================
        if($searchfor=="Internships"){
            $debug_print.="</br>searching for internships. </br>";
            $field = $_POST['field'];
            $major = $_POST['major'];
            $company = $_POST['company'];
            $hourly_pay = $_POST['hourly_pay'];
        
            //build the query condition
            if ($field =="any" && $major =="any" && $company =="any" && $hourly_pay == 0)
                $SQLWhereCondition = "WHERE type = 'internship' ";
            else{
                $SQLWhereCondition = "WHERE type = 'internship' AND ";
                if($field !="any")  $SQLWhereCondition.=" field = '". $field ."' AND ";
                if($major !="any")  $SQLWhereCondition.=" major = '". $major ."' AND ";
                if($company !="any")  $SQLWhereCondition.=" company_name = '". $company ."' AND ";
                $SQLWhereCondition .= "hourly_pay >=". $hourly_pay;
            }    
            $debug_print.="querry condition: ". $SQLWhereCondition ." </br>";
            $offer_or_employment = $_POST['offer_or_employment'];
            if($offer_or_employment == "offer"){
                $internship_results = mysqli_query($conn,
                                    "SELECT company_name, hourly_pay, major, student_name, field, student_id, company_id
                                    FROM offers_view " . $SQLWhereCondition);     
            }else if ($offer_or_employment == "employment"){
                $internship_results = mysqli_query($conn,
                                    "SELECT company_name, hourly_pay, major, student_name, field, student_id, company_id
                                    FROM employment_view " . $SQLWhereCondition);
            }          
            if($internship_results){
                if (mysqli_num_rows($internship_results)==0) echo '<label id="noResult"> no result found. </label>';
                else{
                    $debug_print.="querry runs. </br>";
                    while ($internships = mysqli_fetch_array($internship_results)) {
                        echo '
                        <tr>
                          <td><a href="companyProfile.php?companyid='.htmlspecialchars($internships["company_id"]).'">'. htmlspecialchars($internships["company_name"]) .'</a></td>
                          <td>'. $internships["major"]          .'</td>
                          <td>'. $internships["field"]          .'</td>
                          <td><a href="userProfile.php?studentid='. htmlspecialchars($internships["student_id"]).'">'. htmlspecialchars($internships["student_name"]) .'</a></td>
                          <td>'. toMoney($internships["hourly_pay"])     .'</td>
                        </tr>';
                    }  
                }
            }else{
                $debug_print.="querry does not run, may be bad. </br>";
            }
        //=========================================================== Companies =============================================================
        }else if ($searchfor=="Companies"){
            $debug_print.="</br>searching for companies. </br>";
            $field = $_POST['field'];
            $ave_salary = $_POST['ave_salary'];
            $ave_rating = $_POST['ave_rating'];
            //build the query condition
            if ($field =="any" && $ave_salary == 0 && $ave_rating==0)
                $SQLWhereCondition = "";
            else{
                $SQLWhereCondition = "WHERE ";
                if($field !="any")  $SQLWhereCondition.=" field = '". $field ."' AND ";
                if($ave_rating !=0)  $SQLWhereCondition.=" ave_rating >= '". $ave_rating ."' AND ";
                if($ave_salary==0) 
                    $SQLWhereCondition .= "TRUE"; //" (ave_salary >= 0 OR hourly_pay >= 0)";
                else
                    $SQLWhereCondition .= " ave_salary >=". $ave_salary;
            }
            $debug_print.="querry condition: ". $SQLWhereCondition ." </br>";
            $company_results = mysqli_query($conn,
                                "SELECT company_name, ave_salary, field, description, ave_rating, company_id
                                FROM company_view " . $SQLWhereCondition);             
            if($company_results){
                if (mysqli_num_rows($company_results)==0) echo '<label id="noResult"> no result found. </label>';
                else{
                    $debug_print.="querry runs. </br>";
                    while ($companies = mysqli_fetch_array($company_results)) {
                        echo '
                        <tr>
                          <td><a href="companyProfile.php?companyid='.htmlspecialchars($companies["company_id"]).'">'. htmlspecialchars($companies["company_name"]) .'</a></td>
                          <td>'. $companies["field"]            .'</td>
                          <td>'. toMoney($companies["ave_salary"])       .'</td>
                          <td>'. sprintf("%.1f",$companies["ave_rating"])       .'</td>
                          <td>'. $companies["description"]      .'</td>
                        </tr>';
                    }
                }
            }else{
                $debug_print.="querry does not run, may be bad. </br>";
            }
        //=========================================================== Careers =============================================================
        }else if ($searchfor=="Careers"){
            $debug_print.="</br>searching for careers. </br>";
            $field = $_POST['field'];
            $major = $_POST['major'];
            $salary = $_POST['salary'];
            $company = $_POST['company'];
            //build the query condition
            if ($field =="any" && $major =="any" && $company =="any" && $salary == 0)
                $SQLWhereCondition = "WHERE (type = 'full time' OR type = 'part time') ";
            else{
                $SQLWhereCondition = "WHERE (type = 'full time' OR type = 'part time') AND ";
                if($field !="any")  $SQLWhereCondition.=" field = '". $field ."' AND ";
                if($major !="any")  $SQLWhereCondition.=" major = '". $major ."' AND ";
                if($company !="any")  $SQLWhereCondition.=" company_name = '". $company ."' AND ";
                if ($salary==0)
                    $SQLWhereCondition .= "(salary >= 0 OR hourly_pay >= 0) ";
                else
                    $SQLWhereCondition .= " salary >=". $salary;
            }
            $debug_print.="querry condition: ". $SQLWhereCondition ." </br>";
            $offer_or_employment = $_POST['offer_or_employment'];
            if($offer_or_employment == "offer"){
                $career_results = mysqli_query($conn,
                                    "SELECT company_name, salary, major, student_name, field, hourly_pay, student_id, company_id
                                    FROM offers_view " . $SQLWhereCondition);  
            }else if($offer_or_employment == "employment")  {
                $career_results = mysqli_query($conn,
                                    "SELECT company_name, salary, major, student_name, field, hourly_pay, student_id, company_id
                                    FROM employment_view " . $SQLWhereCondition);  
            }         
            if($career_results){
                if (mysqli_num_rows($career_results)==0) echo '<label id="noResult"> no result found. </label>';
                else{
                    $debug_print.="querry runs. </br>";
                    while ($careers = mysqli_fetch_array($career_results)) {
                        echo '
                        <tr>
                          <td><a href="companyProfile.php?companyid='.htmlspecialchars($careers["company_id"]).'">'. htmlspecialchars($careers["company_name"]) .'</a></td>
                          <td>'. $careers["major"]            .'</td>
                          <td>'. $careers["field"]            .'</td>
                          <td><a href="userProfile.php?studentid='. htmlspecialchars($careers["student_id"]).'">'. htmlspecialchars($careers["student_name"]) .'</a></td>
                          <td>'. toMoney($careers["salary"])           .'</td>
                          <td>'. toMoney($careers["hourly_pay"])       .'</td>
                        </tr>';
                    }
                }
            }else{
                $debug_print.="querry does not run, may be bad. </br>";
            }
        //=========================================================== Positions =============================================================    
        }else if($searchfor == "Positions"){
            $debug_print.="</br>searching for careers. </br>";
            $major = $_POST['major'];
            $ave_salary = $_POST['ave_salary'];
            $company = $_POST['company'];
            $ave_rating = $_POST['ave_rating'];
            //build the query condition
            if ($major =="any" && $company =="any" && $ave_salary == 0 && $ave_rating==0)
                $SQLWhereCondition = "";
            else{
                $SQLWhereCondition = "WHERE ";
                if($major !="any")  $SQLWhereCondition.=" major = '". $major ."' AND ";
                if($ave_rating !=0)  $SQLWhereCondition.=" ave_rating >= '". $ave_rating ."' AND ";
                if($company !="any")  $SQLWhereCondition.=" company_name = '". $company ."' AND ";

                if ($ave_salary==0)
                    $SQLWhereCondition .= "TRUE";
                else
                    $SQLWhereCondition .= " ave_salary >=". $ave_salary;
            }
            $debug_print.="querry condition: ". $SQLWhereCondition ." </br>";
            $position_results = mysqli_query($conn,
                                    "SELECT company_name, ave_salary, major, ave_hourly_pay, company_id, title, ave_rating
                                    FROM positions_view " . $SQLWhereCondition); 
            if($position_results){
                if (mysqli_num_rows($position_results)==0) echo '<label id="noResult"> no result found. </label>';
                else{
                    $debug_print.="querry runs. </br>";
                    while ($positions = mysqli_fetch_array($position_results)) {
                        echo '
                        <tr>
                          <td><a href="companyProfile.php?companyid='.htmlspecialchars($positions["company_id"]).'">'. htmlspecialchars($positions["company_name"]) .'</a></td>
                          <td>'. $positions["major"]            .'</td>
                          <td>'. $positions["title"]            .'</td>
                          <td>'. toMoney($positions["ave_salary"])           .'</td>
                          <td>'. toMoney($positions["ave_hourly_pay"])       .'</td>
                          <td>'. sprintf("%.1f",$positions["ave_rating"])       .'</td>
                        </tr>';
                    }
                }
            }else{
                $debug_print.="querry does not run, may be bad. </br>";
            }

        }
        echo "". $debug_print;
    }
}
?>




          </tbody>
        </table>
      </div>
    </div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script>
    document.getElementById("searchtab").className = "active";
    </script>
  </body>
</html>