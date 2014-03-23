<?php

require 'mail.php';

$username="forumbmc_lesson";
$password="LEADER";
$database="forumbmc_lesson";
$connection = mysql_connect("localhost", $username, $password) or die('Could not connect'.mysql_error());
mysql_select_db($database, $connection) or die( "Cannot select db.");
mysql_set_charset('utf8', $connection);


$sender = NULL;
$to = NULL;
$name = NULL;
$subject = NULL;
$body = NULL;

$id = $argv[1];
$code = $argv[2];


if ($code == 'GGT') {
	$query = "SELECT * FROM email WHERE id = " . $id;
	$try = 10;

	while ($try--) {
		$flag = FALSE;
		$result = mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			$flag = TRUE;
			$name = $row['name'];
			$sender = $row['sender'];
			$to = array('0' => array('name' => $row['to_name'], 'email' => $row['to_email']));
			$subject = $row['subject'];
			$body = $row['body'];
		}
		if ($flag)
			break;
	}

	$mail = new My_Mail($name, $sender, $to, $subject, $body);
	$res = $mail -> sendEmail();
}