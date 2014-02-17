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
        document.getElementById('postypeselect').style.display = "block";
      } else {
        document.getElementById('otherposition').style.display = "none";
        document.getElementById('otherpositiondesc').style.display = "none";
        document.getElementById('postypeselect').style.display = "none";
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
          setOtherPosition();
          }
        });
    }
    </script>

  </head>

  <body>

    <?php include 'header.php'; ?>

    <?php
    if(isset($_GET['exptype'])){
      $exptype = $_GET['exptype'];
    } else {
      $exptype = 'Offer';
    }
    if($exptype == 'Offer'){
      $exptable = 'offers';
    } else {
      $exptable = 'employment';
    }

    $addExperror = '';
    $company = '';
    $companyname = '';
    $companyfield = '';
    $position = '';
    $postitle = '';
    $posdesc = '';
    $postype = '';
    $salparam = '';
    $salary = '';
    $startdate = '';
    $enddate = '';
    $enddateparam = '';
    $enddateinput = '';
    $benefits = '';
    $benefitsparam = '';
    $benefitsinput = '';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if(isset($_POST['addExp'])){
        if(is_numeric($_POST['company'])){
          $company = $_POST['company'];
        } elseif( strlen($_POST['companyname']) > 0  and strlen($_POST['companydesc']) > 0 and ($_POST['companyfield'] != 'other' or strlen($_POST['othercompanyfield']) > 0)) {
          $companyname = $_POST['companyname'];
          $companydesc = $_POST['companydesc'];
          if( $_POST['companyfield'] != 'other'){
            $companyfield = $_POST['companyfield'];
          } else {
            $companyfield = $_POST['othercompanyfield'];
          }
        } else {
          $addExperror .= 'You must provide a company name, field, and description if you select "Other"<br />';
        }

        if(is_numeric($_POST['position'])){
          $position = $_POST['position'];
        } elseif( strlen($_POST['postitle']) > 0  and strlen($_POST['posdesc']) > 0 ) {
          $postitle = $_POST['postitle'];
          $posdesc = $_POST['posdesc'];
          $postype = $_POST['postype'];
        } else {
          $addExperror .= 'You must provide a position title and description if you select "Other"<br />';
        }

        if(strlen($_POST['salary']) > 0){
          if($_POST['saltype'] == 'hourly'){
            $salary = $_POST['salary'];
            $salparam = ', hourly_pay';
          } elseif($_POST['saltype'] == 'monthly') {
            $salary = $_POST['salary'] * 12;
            $salparam = ', salary';
          } else {
            $salary = $_POST['salary'];
            $salparam = ', salary';
          }
        } else {
          $addExperror .= 'You must provide a salary amount<br />';
        }

        if(strlen($_POST['startdate']) > 0){
          $startdate = $_POST['startdate'];
        } else {
          $addExperror .= 'You must select a start date<br />';
        }

        if(strlen($_POST['enddate']) > 0){
          $enddate = $_POST['enddate'];
          $enddateparam = ', end_date';
        }

        if(strlen($_POST['benefits']) > 0){
          $benefits = $_POST['benefits'];
          $benefitsparam = ', benefits';
        }

        if(!$addExperror){
          if(strlen($companyname) > 0){
            mysqli_query($conn, "INSERT INTO companies (company_name, field)
                                  VALUES ('". mysqli_real_escape_string($conn,$companyname) ."','". mysqli_real_escape_string($conn,$companyfield) ."')");
            $company = mysqli_insert_id($conn);
          }
          if(strlen($postitle) > 0){

            mysqli_query($conn, "INSERT INTO positions (company_id, title, description, type, major)
                                  VALUES ('". mysqli_real_escape_string($conn,$company) ."','". mysqli_real_escape_string($conn,$postitle) ."','". mysqli_real_escape_string($conn,$posdesc) ."','". mysqli_real_escape_string($conn,$postype) ."','". mysqli_real_escape_string($conn,$user_row['major']) ."')");
            $position = mysqli_insert_id($conn);
          }
          if(strlen($enddate)>0){
            $enddateinput = ", '".mysqli_real_escape_string($conn,$enddate)."'";
          }
          if(strlen($benefits)>0){
            $benefitsinput = ", '".mysqli_real_escape_string($conn,$benefits)."'";
          }
          mysqli_query($conn, "INSERT INTO ". mysqli_real_escape_string($conn,$exptable) ." (student_id, position_id, start_date".$enddateparam.$salparam.$benefitsparam.")
                                  VALUES ('". mysqli_real_escape_string($conn,$_COOKIE["user"]) ."','". mysqli_real_escape_string($conn,$position) ."','". mysqli_real_escape_string($conn,$startdate) . "'". $enddateinput .",". mysqli_real_escape_string($conn,$salary) . $benefitsinput .")");
          echo "<script> window.location = 'userProfile.php?studentid=". $_COOKIE["user"] ."';</script>";
        }
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
      <form role="form" id="addexpform" class="registration-form" method="POST">
        <div class="row">
          <label id="addExpErrorLabel"><?php echo $addExperror; ?></label>
          <h1>Add:
            <div class="btn-group">
              <?php
              echo '<button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown">' .
                htmlspecialchars($exptype) .
                '<span class="caret"></span></button>';
              ?>
              <ul class="dropdown-menu">
                <li><a href='/addExperience.php?exptype=Offer'>Offer</a></li>
                <li><a href='/addExperience.php?exptype=Employment'>Employment</a></li>
              </ul>
            </div>
          </h1>
          <h2>Company*</h2>
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
            <h3>Field*</h3>
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
          <h2>Position*</h2>
          <select id="positionselect" onChange="setOtherPosition()" name="position">
            <option value="other">Other</option>
          </select>
          <input type="text" style="display:none" name="postitle" placeholder="Please tell us the position title" id="otherposition" class="form-control">
          <input type="text" style="display:none" name="posdesc" placeholder="Please give a short description of the position" id="otherpositiondesc" class="form-control">
          <select id="postypeselect" style="display:none" name="postype">
            <option value="full time">Full Time</option>
            <option value="part time">Part Time</option>
            <option value="internship">Internship</option>
          </select>
        </div>

        <div class="row">
          <h2>Salary*</h2>
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
          <h2>Start Date*</h2>
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

        <div class="row">
          <h2>Benefits</h2>
          <div class="col-xs-8">
            <textarea rows="4" cols="60" name="benefits" form="addexpform" placeholder="Benefits Information..."></textarea>
          </div>
        </div>
        <br>
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
    <script>
      getPositions();
      setOtherCompany();
      setOtherField();
    </script>
  </body>
</html>