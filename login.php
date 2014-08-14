<?php
	// Start up our session, or recreate it if it already exists.
	session_start();
	if($_POST) {
		require_once "config.php";
		$username = $_POST["username"];
		$password = $_POST["password"];
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die("Error connecting to database.");
		mysql_select_db($dbname);
		$query = sprintf("select count(id) from users where upper(username) = upper('%s') and password = '%s'",
			mysql_real_escape_string($username),
			mysql_real_escape_string(md5($password)));
		$result = mysql_query($query);
		list($count) = mysql_fetch_row($result);
		if($count == 1) { 
			$_SESSION["authenticated"] = true;
			$_SESSION["username"] = $username;
			$query = sprintf("update users set lastLogin = now() where upper(username) = upper('%s') and password = '%s'",
				mysql_real_escape_string($username),
				mysql_real_escape_string(md5($password)));
			mysql_query($query);
		$query = sprintf("select isAdmin from users where upper(username) = upper('%s') and password = '%s'",
			mysql_real_escape_string($username),
			mysql_real_escape_string(md5($password)));
		
		$result = mysql_query($query);
		list($isAdmin) = mysql_fetch_row($result);
		if($isAdmin == 1) {
			// If the user is an administrator, redirect to the admin page.
			header("Location:admin.php");
		}
		
		else {
			// If the user is not an administrator, redirect to the normal page.
			header("Location:index.php");
		}
	} else {	?>		

<span style = "color: red">Error: That username and password combination does not exist.</span>
<?php }
	}
?>

<form action = "login.php" method = "post">
	Username: <input type = "text" name = "username" /> <br/>
	Password: <input type = "password" name = "password" /> <br/>
	<input type = "submit" value = "Login" />
</form>
