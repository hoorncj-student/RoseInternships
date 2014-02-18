<?php

$cookieset = 0;
$errors = '';

function toMoney($val,$symbol='$',$r=2)
{


    $n = $val; 
    $c = is_float($n) ? 1 : number_format($n,$r);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n=number_format(abs($n),$r); 
    $j = (($j = strlen($i)) > 3) ? $j % 3 : 0; 

   return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;

}

// Only execute if we're receiving a post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST['login'])){

    // This will be the string we collect errors in
    // Make sure the username field is filled
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) or empty($password)){
      $errors .= '<li>Both fields required</li>';
    } else {
      //checking the username and password combination
      $username = mysqli_real_escape_string($conn,$username);
      $password = mysqli_real_escape_string($conn,$password);
      $user_results = mysqli_query($conn,
                                "SELECT student_id
                                FROM students
                                WHERE username = '" . $username . "'
                                AND password = saltedHash('" . $username . "', '" . $password . "')");
      //If the user+password combination exist
      if ($user_results) {
        $student_id = mysqli_fetch_array($user_results);
        if($student_id[0]){
          setcookie("user", $student_id[0]);    $cookieset = $student_id[0];  
        }else{
        $errors .= 'wrong credential';
        }
      }
    }
  }
  if(isset($_POST['logout'])){
    setcookie("user", 0, time()-3600);
    $cookieset = -1;
    echo "<script> window.location = 'index.php';</script>";
  }
}
?>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Rose Internship and Experience Database</a>
    </div>
    <div class="navbar-collapse collapse">
    	<ul class="nav navbar-nav">
    		<li id="hometab"><a href="index.php">Home</a></li>
    		<li id="searchtab"><a href="search.php">Search</a></li>
        <?php
        if($cookieset > 0 or (isset($_COOKIE["user"]) and $cookieset > -1)){
          if($cookieset > 0){
            echo '<li id="profiletab"><a href="userProfile.php?studentid=' . $cookieset . '">Profile</a><li>';
          } else {
    		    echo '<li id="profiletab"><a href="userProfile.php?studentid=' . $_COOKIE["user"] . '">Profile</a><li>';
          }
        }
        ?>
    	</ul>
      <?php
      if($cookieset > 0 or (isset($_COOKIE["user"]) and $cookieset > -1)){
        echo '<form class="navbar-form navbar-right" role="form" method="post">
          <button type="submit" class="btn btn-success" name="logout">Log out</button>
        </form>';
      } else {
        echo '<form class="navbar-form navbar-right" role="form" method="post">
                <div class="form-group">
                  <label id="loginerror">' . $errors . '</label>
                </div>
                <div class="form-group">
                  <input type="text" name="username" placeholder="Username" class="form-control">
                </div>
                <div class="form-group">
                  <input type="password" name="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success" name="login">Sign in</button>
                <a href="register.php"><button type="button" id="regbutton" class="btn btn-success" name="register">Register</button></a>
              </form>';  
              
      }
      ?>
    </div><!--/.navbar-collapse -->
  </div>
</div>