<?php

class Model_Mail {
	public function send($_to, $_cc, $_bcc, $_read, $_)
	$to = array(
					'0'=> array('name' => 'Usukhbaatar Dotgonvanchig','email' => 'osohoo02@gmail.com'),
					//'1'=> array('name' => 'Raj Trivedi','email' => 'raj.trivedi82@yahoo.in'),
					//'2'=> array('name' => 'Shweta Agrawal','email' => 'lovely.shweta@rocketmail.com')
				);
	$cc = array(
					/*'0'=> array('name' => 'Raj Trivedi','email' => 'raj.ktrivedi82@gmail.com'),
					'1'=> array('name' => 'Raj Trivedi','email' => 'raj.trivedi82@yahoo.in'),
					'2'=> array('name' => 'Shweta Agrawal','email' => 'lovely.shweta@rocketmail.com')*/
				);
	$bcc = array(
					//'0'=> array('name' => 'Raj Trivedi','email' => 'raj.ktrivedi82@gmail.com'),
					//'1'=> array('name' => 'Raj Trivedi','email' => 'raj.trivedi82@yahoo.in'),
					//'2'=> array('name' => 'Shweta Agrawal','email' => 'lovely.shweta@rocketmail.com')
				);
	$read = array(
					//'0'=> array('name' => 'Raj Trivedi','email' => 'raj.ktrivedi82@gmail.com'),
				);
	$reply = array(
					//'0'=> array('name' => 'Raj Trivedi','email' => 'raj.ktrivedi82@gmail.com'),
				);
	
	$sender = 'service@foru.mn';
	$senderName = 'ForU.MN';
	$subject = 'This is an test mail';
	$message = '<html>
				<head>
				  <title>Birthday Reminders for August</title>
				</head>
				<body>
				  <p>Here are the birthdays upcoming in August!</p>
				  <table>
					<tr>
					  <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
					</tr>
					<tr>
					  <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
					</tr>
					<tr>
					  <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
					</tr>
				  </table>
				</body>
				</html>';
	
	$obj = new sendMail($to, $sender, $subject, $message, $cc, $bcc, $senderName);
	echo $obj->sendEmail();
}
