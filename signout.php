<?php
	# Stop Hacking attempt
    define('__APP__', TRUE);

	# Start session
	session_start();
	
	
	unset($_POST);
	unset($_SESSION['user']);

	$_SESSION['user']['valid'] = 'false';
	$_SESSION['message'] = '<p>See you next time!</p>';
	
	header("Location: index.php?menu=1");
	exit;