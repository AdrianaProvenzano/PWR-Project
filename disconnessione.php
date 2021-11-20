<?php
	include("sessione.php"); 
	$session = true;
	
	if( session_status() === PHP_SESSION_DISABLED  )
		$session = false;
	elseif( session_status() !== PHP_SESSION_ACTIVE )
		session_start();
		
	if(isset($_SESSION["uname"])){
		unset($_SESSION["uname"]);
		unset($_SESSION["libri"]);
		session_destroy();
	}
		  
?>

<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> Lista utenti </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Logout Biblioteca" >
		<link rel="icon" type="image/png" href="./img/icon.png">
		<link rel="stylesheet" type="text/css" href="style.css">	
	</head>
	<body>
		<?php
            if(!$session)
            {
                echo "<p>SESSIONI DISABILITATE, impossibile proseguire</p>\n";
            }
            else
            {
        ?>
		<div class="grid-container">
			<div class="theUser"> 
				<?php
				if(isset($_SESSION["uname"]))
					echo"Benvenuto utente ".$uname.", hai in prestito ".$numlibri." libri";  
				else
					echo"Benvenuto utente Anonimo, hai in prestito 0 libri";
				?>
			</div>
			<div class="theHeader">Logout - Biblioteca "Babele"</div>
			<div class="theMenu">
				<h1> Menu </h1>
				<h2> <a href="home.php">Homepage</a> </h2>
				<h2> <a href="libri.php">Prenota un libro</a> </h2>
				<h2> <a href="new.php">Registrati</a> </h2>
				<br>
				<?php 
					if(!(isset($_SESSION["uname"]))){
						echo"<h2><a href=\"login.php\">Login</a> </h2>";}
					else 
						echo"<h2><div id=\"notactive\">Login</div></h2>";
				
					if(isset($_SESSION["uname"])){
						echo"<h2><a href=\"logout.php\">Logout</a> </h2>";}
					else 
						echo"<h2><div id=\"notactive\">Logout</div></h2>";
				?>
			</div>
			<div class="theContent">
				<h1 class="userlogin">USER<span style="color: white">LOGOUT</span></h1>
				<img src="./img/logout2.png" alt="Logout" class="logout">
				<br><p> Il LOGOUT dell'utente &egrave; avvenuto con successo!</p>
				
			</div>
			<div class="theFooter">
				<div class="right"><?php echo basename($_SERVER['PHP_SELF']); ?></div>
				Creato da <address> <a href="mailto:s234708@studenti.polito.it">Adriana Provenzano</a> (matricola 234708)</address>
			</div>
			</div> 
		<?php
            }
        ?>
	</body>
	
	</html>