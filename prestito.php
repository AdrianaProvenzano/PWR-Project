<?php
	include("sessione.php"); 
?>

<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> Prestito libro </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Prestito libro Biblioteca" >
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
				if(isset($_SESSION["uname"]) && !empty($_POST["checkbox"]) && is_numeric($_POST["numgiorni"]) && !empty($_POST["checkbox"])){
					if(count($_POST["checkbox"])+$numlibri<=3){
						$libri=count($_POST["checkbox"])+$numlibri;
						echo"Benvenuto utente ".$uname.", hai in prestito ".$libri." libri";  }
						}
				else if(!isset($_SESSION["uname"]))
					echo"Benvenuto utente Anonimo, hai in prestito 0 libri";
				else
					echo"Benvenuto utente ".$uname.", hai in prestito ".$numlibri." libri";  
				?>
			</div>
			<div class="theHeader">Prestito libro - Biblioteca "Babele"</div>
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
				<?php
				$con = mysqli_connect("localhost", "uReadWrite", "SuperPippo!!!", "biblioteca");
				$regex='/^[0-9]\d*$/';
				$errore=""; 
                if (mysqli_connect_errno()) 
                    $errore="Errore connessione al DBMS: ".mysqli_connect_error()."\n";
                else
				{
					if ($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST["checkbox"])){
						$giorni = trim($_POST["numgiorni"]);
						$ok=false; 
						if(count($_POST["checkbox"])+$numlibri<=3){
							foreach(($_POST["checkbox"])as $sel){
								if(isset($sel) && $giorni>0 && (preg_match($regex, $giorni))){
									//aggiorno la situazione del libro
									$sql = "UPDATE books SET prestito=?,data=?,giorni=?  WHERE id=?";
									$data= date('Y-m-d H:i:s');
									$stmt = mysqli_prepare($con, $sql);
									mysqli_stmt_bind_param($stmt, "ssii", $uname, $data, $giorni, $sel);
									$ok=mysqli_stmt_execute($stmt);
									mysqli_stmt_close($stmt);
									if($ok){
										echo"<img src=\"./img/spunta2.png\" class=\"icon\">";
										echo"<h2> Il prestito &egrave; avvenuto con successo</h2>";
										
										//trovo il titolo del libro preso in prestito
										$sql="SELECT * FROM books WHERE id=?";
										$stmt = mysqli_prepare($con, $sql);
										mysqli_stmt_bind_param($stmt, "i", $sel);
										mysqli_stmt_execute($stmt);
										$result = mysqli_stmt_get_result($stmt);
										$row = mysqli_fetch_assoc($result);
										$libro=$row["titolo"];
										echo"<p> Prenotato libro ".$libro." per ".$giorni." giorni</p>"; 
										mysqli_stmt_close($stmt);
										mysqli_free_result($result);
									}
									
								} else if($giorni<=0 ||!( preg_match($regex, $giorni)))
									$errore="Inserisci un numero di giorni valido!"; }
							} else
								$errore="&Egrave; possibile prendere in prestito un massimo di 3 libri per volta!";
						}
						else
							 $errore="Selezionare almeno un libro!";
						mysqli_close($con);
				}
				if($errore!=""){
					echo"<img src=\"./img/rosso.png\" class=\"icon\">";
					echo"<h2> Errore! Il prestito non &egrave; avvenuto correttamente</h2>";
					echo"".$errore."\n"; 
				}
				?>
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