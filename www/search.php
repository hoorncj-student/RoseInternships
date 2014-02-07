<!DOCTYPE html>
<?php
// Open a connection to the database
// (display an error if the connection fails)
$conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error());
mysqli_select_db($conn, 'roseinternships') or die(mysqli_error());
?>
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
    <link href="css/jumbotron.css" rel="stylesheet">

    <script>
    function setSalary()
    {
      document.getElementById('salaryval').innerText = "$"+document.getElementById('salaryslider').value;
    }
    function setHourly()
    {
      document.getElementById('hourlyval').innerText = "$"+document.getElementById('hourlyslider').value;
    }
    </script>

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Rose Internship and Experience Database</a>
        </div>
        <div class="navbar-collapse collapse">
        	<ul class="nav navbar-nav">
        		<li><a href="index.php">Home</a></li>
        		<li class="active"><a href="search.php">Search</a></li>
        		<li><a href="#">Profile</a><li>
        	</ul>
          <form class="navbar-form navbar-right" role="form">
            <div class="form-group">
              <input type="text" placeholder="Username" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
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
            $searchfor .
            '<span class="caret"></span></button>';
          ?>
          <ul class="dropdown-menu">
            <li><a href='/search.php?searchfor=Internships'>Internships</a></li>
            <li><a href="/search.php?searchfor=Careers">Careers</a></li>
            <li><a href="/search.php?searchfor=Companies">Companies</a></li>
          </ul>
        </div>
      </h1>
      <div class="panel panel-default">
        <div class="panel-heading">Search Options</div>
        <form role="form" action="" method="POST">
          Field: <select name="field">
            <option value="any" selected>Any</option>
            <?php
              $fields = mysqli_query($conn, "SELECT DISTINCT(field) ".
                "FROM companies ");
              while ($field = mysqli_fetch_array($fields)) {
                echo '<option value="' . htmlspecialchars($field[0]) . '">' . htmlspecialchars($field[0]) . '</option>';
              }
            ?>
          </select>
          Major: <select name="major">
            <option value="any" selected>Any</option>
            <?php
              $majors = mysqli_query($conn, "SELECT DISTINCT(major) ".
                "FROM positions ");
              while ($major = mysqli_fetch_array($majors)) {
                echo '<option value="' . htmlspecialchars($major[0]) . '">' . htmlspecialchars($major[0]) . '</option>';
              }
            ?>
          </select>
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
            echo 'Salary: <input id="salaryslider" type="range" name="salary" min="30000" max="200000" step="10000" value="30000" onChange="setSalary()"><label id="salaryval">$30000</label>';
          }else{
            echo 'Hourly Pay: <input id="hourlyslider" type="range" name="salary" min="10" max="50" step="5" value="10" onChange="setHourly()"><label id="hourlyval">$10</label>';
          }
          ?>
          </select>
        </form>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">Results</div>
        <table class="table">
          <thead>
            <tr>
              <th>Time</th>
              <th>From</th>
              <th>Site</th>
              <th>Command</th>
            </tr>
          </thead>
          <tbody>
            %if texts :
              %for text in texts:
                <tr>
                  <td>{{text['time_stamp']}}</td>
                  <td>{{text['from_number']}}</td>
                  <td>{{text['url']}}</td>
                  <td>{{text['body']}}</td>
                </tr>
              %end
            %end
          </tbody>
        </table>
      </div>
    </div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>