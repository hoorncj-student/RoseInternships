<!DOCTYPE html>
<?php
// Open a connection to the database
// (display an error if the connection fails)
$conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error());
mysqli_select_db($conn, 'rhitter') or die(mysqli_error());
?>
<html>
	<head>
		<title>Register</title>
	</head>
	<body>
		<h1>Register</h1>
		<?php
		// Only execute if we're receiving a post
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// This will be the string we collect errors in
			$errors = '';
			// Make sure the name field is filled
			$name = $_POST['name'];
			if (empty($name)) $errors .= '<li>Name is required</li>';
			// Make sure the username field is filled
			$username = $_POST['username'];
			if (empty($name)) $errors .= '<li>Username is required</li>';
			// Make sure the password field is filled
			$password = $_POST['password'];
			if (empty($password)) $errors .= '<li>Password is required</li>';
			// Make sure the passwords match
			$confirm = $_POST['confirmpassword'];
			if (strcmp($password, $confirm) != 0) $errors .= '<li>Passwords do not match</li>';
			// If we have any errors at this point, stop here and show them
			if (!empty($errors)) {
				echo '<ul>' . $errors . '</ul>';
			// Otherwise, begin the user creation process
			} else {
				$username = mysqli_real_escape_string($conn,$username);
				$name = mysqli_real_escape_string($conn,$name);
				$password = mysqli_real_escape_string($conn,$password);
				// First, check for that username already being taken
				$user_results = mysqli_query($conn, "SELECT username FROM users
														WHERE username = " . $username);
				// We don't care what the result is
				// If there is one, that means the username is taken
				if ($user_results) {
					if (mysqli_fetch_array($user_results)) {
						echo '<ul><li>Username already taken</li></ul>';
					}
				// If no duplicates are found, go ahead and create the new user
				} else {
					mysqli_query($conn,"INSERT INTO users (name, username, hashed_password) " .
										"VALUES ('" . $name . "', '" . $username . "', saltedHash('" . $username . "', '" . $password . "'))") or die(‘error’);
					// Show a success message
					echo '<ul><li>Registration successful!</li></ul>';
					// Set the name and username fields to empty strings so they don't
					// get automatically repopulated
					$name = '';
					$username = '';
				}
			}
		}
		?>
		<form action="" method="post">
			<label for="name">Name</label><br/>
			<input type="text" name="name"/><br/>
			<label for="username">Username</label><br/>
			<input type="text" name="username"/><br/>
			<label for="password">Password</label><br/>
			<input type="password" name="password"/><br/>
			<label for="confirmpassword">Confirm Password</label><br/>
			<input type="password" name="confirmpassword"/><br/>
			<input type="submit" value="Register"/>
		</form>
	</body>
</html>