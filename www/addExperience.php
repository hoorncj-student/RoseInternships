<!DOCTYPE html>
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
        		<li><a href="search.php">Search</a></li>
        		<li><a href="userProfile.php">Profile</a><li>
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