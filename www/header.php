<?php

$cookieset = 0;

// Only execute if we're receiving a post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST['login'])){
    // This will be the string we collect errors in
    $errors = '';
    // Make sure the username field is filled
    /*$username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($name) or empty($password)){
      $errors .= '<li>Both fields required</li>';
    } else {
      // Otherwise, begin the user creation process
      $username = mysqli_real_escape_string($conn,$username);
      $password = mysqli_real_escape_string($conn,$password);
      // First, check for that username already being taken
      $user_results = mysqli_query($conn,"SELECT [password]
                                WHERE username = " . $username . 
                                " AND password = saltedHash('" . $username . "', '" . $password . ")");
      // We don't care what the result is
      // If there is one, that means the username is taken
      if ($user_results) {
        $user_id = mysqli_fetch_array($user_results);
        if($user_id[0]){
          setcookie("user", $user_id[0]);
        }
      }
    }*/
    setcookie("user", 1);
    $cookieset = 1;
  }
  if(isset($_POST['logout'])){
    setcookie("user", 0, time()-3600);
    $cookieset = -1;
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
      <a class="navbar-brand" href="#">Rose Internship and Experience Database</a>
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
                  <input type="text" placeholder="Username" class="form-control">
                </div>
                <div class="form-group">
                  <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success" name="login">Sign in</button>
                <a href="register.php"><button type="button" id="regbutton" class="btn btn-success" name="register">Register</button></a>
              </form>';
      }
      ?>
    </div><!--/.navbar-collapse -->
  </div>
</div>