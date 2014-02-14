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

    <link href="css/addExperience.css" rel="stylesheet">

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

    <?php

    $addExperror = '';
    $company = '';
    $companyname = '';
    $companyfield = '';
    $position = '';
    $postitle = '';
    $posdesc = '';
    $hourlypay = '';
    $salary = '';
    $startdate = '';
    $enddate = '';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if(isset($_POST['addExp'])){
        if(is_numeric($_POST['company'])){
          $company = $_POST['company'];
        } elseif( strlen($_POST['companyname']) > 0  and strlen($_POST['companydesc']) > 0 and (is_numeric($_POST['companyfield']) or strlen($_POST['othercompanyfield']) > 0)) {
          $companyname = $_POST['companyname'];
          $companydesc = $_POST['companydesc'];
          if( is_numeric($_POST['companyfield'])){
            $companyfield = $_POST['companyfield'];
          } else {
            $companyfield = $_POST['othercompanyfield'];
          }
        } else {
          $addExperror .= 'You must provide a company name, field, and description if you select "Other"';
        }

        if(is_numeric($_POST['position'])){
          $position = $_POST['position'];
        } elseif( strlen($_POST['postitle']) > 0  and strlen($_POST['posdesc']) > 0 ) {
          $postitle = $_POST['postitle'];
          $posdesc = $_POST['posdesc'];
        } else {
          $addExperror .= 'You must provide a position title and description if you select "Other"';
        }

        if(strlen($_POST['salary']) > 0){
          if($_POST['saltype'] == 'hourly'){
            $hourlypay = $_POST['salary'];
          } elseif($_POST['saltype'] == 'monthly') {
            $salary = $_POST['salary'] * 12;
          } else {
            $salary = $_POST['salary'];
          }
        } else {
          $addExperror .= 'You must provide a salary amount';
        }

        echo $_POST['startdate'];
      }
    }
    ?>

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
          <input type="text" name="companyname" style="display:none" placeholder="Please tell us the company name" id="othercompany" class="form-control">
          <input type="text" name="companydesc" style="display:none" placeholder="Please give a short description of the company" id="othercompanydesc" class="form-control">
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
            <input type="text" style="display:none" name="othercompanyfield" placeholder="Please provide the company's field" id="othercompanyfield" class="form-control">
          </div>
        </div>

        <div class="row">
          <h2>Position</h2>
          <select id="positionselect" onChange="setOtherPosition()" name="position">
            <option value="other">Other</option>
          </select>
          <input type="text" style="display:none" name="postitle" placeholder="Please tell us the position title" id="otherposition" class="form-control">
          <input type="text" style="display:none" name="posdesc" placeholder="Please give a short description of the position" id="otherpositiondesc" class="form-control">
        </div>

        <div class="row">
          <h2>Salary</h2>
          <select  id="salarytypeselect" name="saltype">
            <option value="annual">Annual</option>
            <option value="monthly">Monthly</option>
            <option value="hourly">Hourly</option>
          </select>
          <div  class="input-group">
            <span class="input-group-addon">$</span>
            <input type="text" name="salary" placeholder="Dollar amount" class="form-control">
          </div>
        </div>
  
        <div class="row">
          <h2>Start Date</h2>
          <div class="col-xs-4">
            <input type="date" name="startdate">
          </div>
        </div>


        <div class="row">
          <h2>End Date</h2>
          <div class="col-xs-4">
            <input type="date" name="enddate">
          </div>
        </div>
        <br>
        <div class="row">
          <button type="submit" name="addExp" class="btn btn-default button-submit">Add Experience</button>
        </div>

      </form>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script>getPositions();</script>
  </body>
</html>