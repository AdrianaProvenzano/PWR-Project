<?php
	include("sessione.php"); 
?>

<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> Homepage </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Pagina home Biblioteca" >
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
		<div class="theHeader">Pagina home - Biblioteca "Babele"
		</div>
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
			<h2>La nostra biblioteca </h2>
			<hr>
			<p>In un antico palazzo del 1500 in Minervino (Lecce), la Biblioteca Babele comprende: </p>
			<ul>
			<li>sezioni  per il prestito libri agli adulti e per la consultazione di periodici;</li> 
			<li>una sezione per la consultazione di enciclopedie, dizionari e altre opere di carattere generale;</li> 
			<li>una sezione dedicata al fondo locale che raccoglie tutte le opere relative alla regione Puglia e in particolar modo al territorio salentino; </li>
			<li>una sezione ragazzi con libri, fumetti, musica. </li></ul>
			<p>Sono infine disponibili postazioni fisse e un servizio wi-fi per l'accesso gratuito a internet.</p>
			<img src="./img/biblio.jpg" alt="foto biblioteca" class="center">
			<br>
			<h2>Servizio online</h2>
			<hr>
			<p> La biblioteca “Babele” mette a disposizione dei suoi utenti il servizio di consultazione online, un metodo semplice e veloce per sapere quali libri sono disponibili 
			ed, eventualmente, prenderli in prestito e restituirli con un semplice click. </p>
			<p>I libri a disposizione sono visibili nella pagina <a href="libri.php">LIBRI</a> che, in caso di utente loggato, visualizzerà anche la lista dei libri attualmente in prestito.</p> 
			<img src="./img/copertine.png" alt="copertine libri" class="center">
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