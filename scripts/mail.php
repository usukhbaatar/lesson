<?php

class My_Mail {
	private $receive = array();
	private $cc = array();
	private $bcc = array();
	private $sender = '';
	private $senderName = '';
	private $subject = '';
	private $message = '';
	private $setReply = true;
	private $whereReply = '';
	private $readRecipt = true;
	private $whereRecipt = '';
	private $setheader = "MIME-Version: 1.0 \r\n";
	function __construct($senderName, $sender, $receive, $subject, $message, $cc = array(), $bcc = array(), $whereRecipt = '', $readRecipt = false, $whereReply = '', $setReply = false) {
		$this -> receive = $receive;
		$this -> cc = $cc;
		$this -> bcc = $bcc;
		$this -> sender = $sender;
		$this -> senderName = $senderName;
		$this -> subject = $subject;
		$this -> message = $message;
		$this -> setReply = $setReply;
		$this -> whereReply = $whereReply;
		$this -> readRecipt = $readRecipt;
		$this -> whereRecipt = $whereRecipt;
	}

	function generateHeader() {
		$this -> setheader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$this -> setheader .= 'From: ' . $this -> senderName . ' <' . $this -> sender . '>' . "\r\n";
		$this -> setheader .= $this -> generateHeaderStr($this -> receive, 'To');
		if (is_array($this -> cc) && count($this -> cc) > 0) {
			$this -> setheader .= $this -> generateHeaderStr($this -> cc, 'Cc');
		}
		if (is_array($this -> bcc) && count($this -> bcc) > 0) {
			$this -> setheader .= $this -> generateHeaderStr($this -> bcc, 'Bcc');
		}
		if (is_array($this -> whereReply) && ($this -> setReply == true) && (count($this -> whereReply) > 0)) {

			$this -> setheader .= $this -> generateHeaderStr($this -> whereReply, 'Reply-To');
		}
		if (is_array($this -> whereRecipt) && ($this -> readRecipt == true) && (count($this -> whereRecipt) > 0)) {
			$this -> setheader .= $this -> generateHeaderStr($this -> whereRecipt, 'Disposition-Notification-To');
		}
		return $this -> setheader;
	}

	public function sendEmail() {
		$mailHeader = $this -> generateHeader();
		if (mail($this -> generateHeaderStr($this -> receive), $this -> subject, $this -> message, $mailHeader)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function generateHeaderStr($whom, $param = '') {
		$returnHeader = "";
		if ($param == '') {
			if (count($whom) > 0) {
				$i = 0;
				foreach ($whom as $rVal) {
					$i++;
					if ($i == count($whom)) {
						$returnHeader .= strtolower($rVal['email']);
					} else {
						$returnHeader .= strtolower($rVal['email']) . ', ';
					}
				}
			}
		} else {
			$returnHeader .= $param . ': ';
			if (count($whom) > 0) {
				$i = 0;
				foreach ($whom as $rVal) {
					$i++;
					if ($i == count($whom)) {
						$returnHeader .= ucwords($rVal['name']) . ' <' . strtolower($rVal['email']) . '>' . "\r\n";
					} else {
						$returnHeader .= ucwords($rVal['name']) . ' <' . strtolower($rVal['email']) . '>, ';
					}
				}
			}
		}
		return $returnHeader;
	}

	function __destruct() {
	}

}
?>