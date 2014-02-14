<?php
// Open a connection to the database
// (display an error if the connection fails)
$conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error());
mysqli_select_db($conn, 'roseinternships') or die(mysqli_error());

if(isset($_COOKIE["user"])){
  $user_results = mysqli_query($conn, "SELECT student_id, student_name " .
                                      "FROM students ");
                                      #"WHERE student_id = 1");# . $_COOKIE["user"]);
  $user_row = mysqli_fetch_assoc($user_results);
}

function get_majors(){
	return array("AB","BE","CE","CHE","CHEM","CPE","CS","EE","EMGT","EP","MA","ME","OE","PH","SE");
}
?>