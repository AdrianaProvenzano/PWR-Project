<?php
	include("sessione.php"); 
?>

<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> New User </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Pagina home Biblioteca" >
		<link rel="icon" type="image/png" href="./img/icon.png">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript">
            function validate(uname, pwd1, pwd2)
				{
				"use strict";
				var username=uname.value; 
				var pass1=pwd1.value; 
				var pass2=pwd2.value
				var regex_spazi=/\s/; 
				if(regex_spazi.test(username)){
					window.alert("Non ci devono essere spazi nell'username!"); 
					return false; 
				} else if (regex_spazi.test(pass1)){
					alert("Non ci devono essere spazi nella prima password!"); 
					return false; 
				}else if (regex_spazi.test(pass2)){
					alert("Non ci devono essere spazi nella seconda password!"); 
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
			<div class="theHeader">Pagina di registrazione - Biblioteca "Babele"</div>
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
				<form name="fsignin" action="registrazione.php" method="POST" onSubmit="return validate(uname, pwd1, pwd2);">
					<h1 style="text-align:center;"> Crea il tuo account!</h1>
					<p> Inserisci i dati per effettuare la registrazione: </p>
					<p> Nome utente: <input type="text" name="uname" value=""> </p>
					<p> Password: <input type="password" name="pwd1" value=""> </p> 
					<p> Conferma password: <input type="password" name="pwd2" value=""> </p> 
					<p> <input type="submit" value="REGISTRAMI"></p>
				</form> 
				<br> 
				<p> Affinch&egrave; la registrazione avvenga con successo, i parametri inseriti dall'utente
				devono rispettare le seguenti caratteristiche: </p>
				<ul>
				<li> lo USERNAME dell'utente pu&ograve; contenere solo caratteri alfabetici o numerici o il simbolo "%".
				Deve inoltre iniziare con un carattere alfabetico o con "%" e deve essere lungo da un minimo di 3 caratteri 
				a un massimo di 6. Inoltre, deve contenere almeno un carattere non numerico ed uno numerico. <div class="es">(Esempi username validi: %Mario, Luigi5, Rob97)</div></li>
				<li> la PASSWORD dell'utente pu&ograve; contenere solo caratteri alfabetici, e pu&ograve; essere lunga 
				da un minimo di 4 caratteri ad un massimo di 8 e deve contenere almeno un carattere maiuscolo ed uno minuscolo.
				<div class="es">(Esempi password valide: Luna, hoPe, POLITo)</div></li></ul>
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