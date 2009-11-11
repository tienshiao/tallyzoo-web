<? session_start();
	$file = $_GET['file'];
	echo $_SESSION[$file];
?>