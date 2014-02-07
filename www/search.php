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
            '<span class="caret"></span></button>'
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
              $fields = mysqli_query($conn, "SELECT field ".
                "FROM positions ");
              // Display each post
              while ($field = mysqli_fetch_array($fields)) {
                echo '<option value="' . htmlspecialchars($field[0]) . '">' . htmlspecialchars($field[0]) . '</option>';
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