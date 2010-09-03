<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Forgotten Password Request</title>
	</head>
	<body>
		<h1>Forgotten Password Request</h1>
		<p>You (<?php echo $identity; ?>) have requested a new password.  If you did not request a new password, please ignore this email.</p>
		<p>Please click the below link to confirm the new password request.</p>
		
		<p><?php echo anchor('auth/forgotten_password_complete/'.$forgotten_password_code, 'Request New Password'); ?></p>
	</body>
</html>