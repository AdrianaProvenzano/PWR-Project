<?php
	include("sessione.php"); 
?>

<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> Login </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Pagina di identificazione Biblioteca" >
		<link rel="icon" type="image/png" href="./img/icon.png">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript">
            function validate(uname, pwd)
				{
				"use strict";
				var username=uname.value; 
				var pass=pwd.value; 
				var regex_spazi=/\s/; 
				if(regex_spazi.test(username)){
					window.alert("Non ci devono essere spazi nell'username!"); 
					return false; 
				} else if (regex_spazi.test(pass)){
					alert("Non ci devono essere spazi nella password!"); 
					return false; 
				}
				return true;}
		</script>
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
			<div class="theHeader">Pagina di identificazione - Biblioteca "Babele"</div>
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
				<h1 class="userlogin">USER<span style="color: white">LOGIN</span></h1>
				<img src="./img/user.png" alt="Lucchetto" class="icon">
				<form name="flogin" action="accesso.php" method="POST"  onSubmit="return validate(uname, pwd);">
					<p> Inserisci i dati per effettuare l'accesso: </p>
					<p> Nome utente: <input type="text" name="uname" 
					<?php
						if(isset($_COOKIE["lastlogin"])){
							$login=$_COOKIE["lastlogin"];
							echo"value=$login"; }
					?>
						> </p>
					<p> Password: <input type="password" name="pwd" value=""> </p> 
					<p> <input type="submit" value="OK"> 
					<input type="reset" value="PULISCI"></p> 
					<br>
					<p class="mini">Sei un nuovo utente? <a href="new.php">CLICCA QUI.</a></p>
				</form> 
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