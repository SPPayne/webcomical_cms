<html>
<body>
	<h1><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h1>
	<p>A password reset request was made for the account '<?php echo $identity; ?>' tied to this email address.</p>
	<p><?php echo anchor('auth/reset_password/'. $forgotten_password_code, 'Please click this link to reset your password'); ?>.</p>
	<p>If you did not request a password reset, please ignore this email.</p>
</body>
</html>