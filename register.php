<?php
	if($_POST) {
		$password = $_POST["password"];
		$confirm = $_POST["confirm"];
		if($password != $confirm) { ?>
<span style = "color: red"> Error: Passwords do not match.</span>
<?php	}
	else {
		require_once "config.php";
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die("Error connecting to the database.");
		mysql_select_db($dbname);
		$query = sprintf("select count(id) from users where upper(username) = upper('%s');",
			mysql_real_escape_string($_POST["username"]));
		$result = mysql_query($query);
		list($count) = mysql_fetch_row($result);
		if($count >= 1) { ?>
<span style = "color: red">Error: That username has been taken.</span>
<?php }
	else 	{	
		$query = sprintf("insert into users(username,password) values ('%s', '%s');",
			mysql_real_escape_string($_POST["username"]),
			mysql_real_escape_string(md5($password)));
		mysql_query($query);
?>
<span style = "color: green">Registration completed successfully.</span>
<?php
			}
		}
	}
?>

<form method="post" action="register.php">
	Username: <input type = "text" name = "username" /> <br/>
	Password: <input type = "password" name = "password" /> <br/>
	Confirm Password: <input type = "password" name = "confirm" /> <br/>
	<input type = "submit" value = "Register!" />
</form>
