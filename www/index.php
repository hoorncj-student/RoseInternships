<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Rose Internship Login</title>

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
        <h1>Welcome Rose-Hulman Students!</h1>
        <p>This site was designed with the purpose of aiding students like yourself in their internship and job searches. Whether you're a Sophomore looking for your first internship or a Senior looking for a career, we hope that you find our tools helpful and informative. </p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Internships</h2>
          <p>Looking for the perfect experience to kickstart your career? Have a look at what Rose Students have been up to over the summer.</p>
          <p><a class="btn btn-default" href="search.php?searchfor=Internships" role="button">Find Internships &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Careers</h2>
          <p>Still trying to figure out what to do after Rose? Find out what you might be worth based on statsitics from Rose Graduates.</p>
          <p><a class="btn btn-default" href="search.php?searchfor=Careers" role="button">Find Careers &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Companies</h2>
          <p>Interested in learning more about who's looking for you? See what past Rose Student have to say about their employers.</p>
          <p><a class="btn btn-default" href="search.php?searchfor=Companies" role="button">Find Companies &raquo;</a></p>
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
    <script>
    document.getElementById("hometab").className = "active";
    </script>
  </body>
</html>