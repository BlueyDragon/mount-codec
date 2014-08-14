<?php
function getStat($statName, $userID) {
	require_once "config.php";
	$conn = mysql_connect($dbhost, $dbuser, $dbpass)
		or die("Error connecting to MySQL.");
	mysql_select_db($dbname);
	$query = sprintf("select value from userStats where stat_id = (select id from stats where displayName = '%s' or abbrev = '%s') and userID = '%s'",
		mysql_real_escape_string($statName),
		mysql_real_escape_string($statName),
		mysql_real_escape_string($userID));
	
	$result = mysql_query($query);
	list($value) = mysql_fetch_row($result);
	return $value;
}

function setStat($statName, $userID, $value) {
	require_once "config.php";
	$conn = mysql_connect($dbhost, $dbuser, $dbpass)
		or die("Error connecting to MySQL.");
	$query = sprintf("update userStats set value = '%s' where statID = (select id from stats where displayName = '%s' or abbrev = '%s') and userID = '%s'",
		mysql_real_escape_string($value),
		mysql_real_escape_string($statName),
		mysql_real_escape_string($statName),
		mysql_real_escape_string($userID));
	$result = mysql_query($query);
}
?>
