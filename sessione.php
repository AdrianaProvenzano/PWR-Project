<?php 
    $session = true;
	if( session_status() === PHP_SESSION_DISABLED  )
		$session = false;
	else if( session_status() !== PHP_SESSION_ACTIVE )
	{
		$con=mysqli_connect("localhost","uReadOnly","posso_solo_leggere","biblioteca"); 
		session_start();
		if (!empty($_SESSION["uname"])) {
			$uname = mysqli_real_escape_string($con, $_SESSION["uname"]);
			$query = "SELECT * FROM books WHERE prestito =?";
			$stmt = mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt, "s", $uname);
			$ok = mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$numlibri = mysqli_num_rows($result);						
		}
	}
?>