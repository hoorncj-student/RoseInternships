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

    <title>Add Experience</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

    <link href="css/header.css" rel="stylesheet">

    <script>
    function setOtherCompany()
    {
      var comp = document.getElementById('companyselect');
      if(comp.value == 'other'){
        document.getElementById('othercompany').style.display = "block";
        document.getElementById('othercompanydesc').style.display = "block";
        document.getElementById('companyfielddiv').style.display = "block";
      } else {
        document.getElementById('othercompany').style.display = "none";
        document.getElementById('othercompanydesc').style.display = "none";
        document.getElementById('companyfielddiv').style.display = "none";
      }
      getPositions();
    }
    function setOtherField()
    {
      var comp = document.getElementById('companyfieldselect');
      if(comp.value == 'other'){
        document.getElementById('othercompanyfield').style.display = "block";
      } else {
        document.getElementById('othercompanyfield').style.display = "none";
      }
    }
    function setOtherPosition()
    {
      var comp = document.getElementById('positionselect');
      if(comp.value == 'other'){
        document.getElementById('otherposition').style.display = "block";
        document.getElementById('otherpositiondesc').style.display = "block";
      } else {
        document.getElementById('otherposition').style.display = "none";
        document.getElementById('otherpositiondesc').style.display = "none";
      }
    }
    </script>

    <script>
    var xmlhttp;
    function loadXMLDoc(url,cfunc)
    {
      if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp= new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttp.onreadystatechange=cfunc;
      xmlhttp.open("GET",url,true);
      xmlhttp.send();
    }

    function getPositions()
    {
      var comp = document.getElementById('companyselect'); 
      loadXMLDoc("ajaxcalls.php?function_to_call=0&companyid="+comp.value,function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {
          document.getElementById("positionselect").innerHTML=xmlhttp.responseText;
          }
        });
    }
    </script>

  </head>

  <body>

    <?php include 'header.php'; ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Add An Experience</h1>
        <p>You can add a new experience here. </p>
      </div>
    </div>

    <div class="container">
      <form role="form" class="registration-form" method="POST">
        <div class="row">
          <h2>Company</h2>
          <select id="companyselect" onChange="setOtherCompany()" name="company">
            <?php
            $companies = mysqli_query($conn, "SELECT  company_id, company_name ".
              "FROM companies ");
            while ($company = mysqli_fetch_array($companies)) {
              echo '<option value="' . htmlspecialchars($company[0]) . '">' . htmlspecialchars($company[1]) . '</option>';
            }
            echo '<option value="other">Other</option>';
            ?>
          </select>
          <input type="text" style="display:none" placeholder="Please tell us the company name" id="othercompany" class="form-control">
          <input type="text" style="display:none" placeholder="Please give a short description of the company" id="othercompanydesc" class="form-control">
          <div id="companyfielddiv" style="display:none">
            <h3>Field</h3>
            <select id="companyfieldselect" onChange="setOtherField()" name="companyfield">
              <?php
              $fields = mysqli_query($conn, "SELECT  DISTINCT(field) FROM companies ");
              while ($field = mysqli_fetch_array($fields)) {
                echo '<option value="' . htmlspecialchars($field[0]) . '">' . htmlspecialchars($field[0]) . '</option>';
              }
              echo '<option value="other">Other</option>';
              ?>
            </select>
            <input type="text" style="display:none" placeholder="Please provide the company's field" id="othercompanyfield" class="form-control">
          </div>
        </div>
        <div class="row">
          <h2>Position</h2>
          <select id="positionselect" onChange="setOtherPosition()" name="position">
            <option value="other">Other</option>
          </select>
          <input type="text" style="display:none" placeholder="Please tell us the position title" id="otherposition" class="form-control">
          <input type="text" style="display:none" placeholder="Please give a short description of the position" id="otherpositiondesc" class="form-control">
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
      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script>getPositions();</script>
  </body>
</html>