<?php
	include("sessione.php"); 
	$numlibri--;
?>

<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> Restituzione libro </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Restituzione libro Biblioteca" >
		<link rel="icon" type="image/png" href="./img/icon.png">
		<link rel="stylesheet" type="text/css" href="style.css">	
	</head>
	<body>
		<?php
            if(!$session)
                echo "<p>SESSIONI DISABILITATE, impossibile proseguire</p>\n";
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
			<div class="theHeader">Restituzione libro - Biblioteca "Babele"</div>
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
             
                if (mysqli_connect_errno()) 
                    echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
                else
				{
					$sql = "SELECT * FROM books";
					$result = mysqli_query($con, $sql);
					while ($row = mysqli_fetch_assoc($result)) {
						if (!empty($_POST["" . $row["id"]])) {
							$nome=$row["titolo"]; 
							$durata = round((time() - strtotime($row["data"])) / 60 / 60 / 24);
							$query = "UPDATE books SET prestito = '', DATA = 0, giorni=0 WHERE id=?;";
							$stmt = mysqli_prepare($con, $query);
							mysqli_stmt_bind_param($stmt, "i", $row["id"]);
							mysqli_stmt_execute($stmt);
							}
						}
					echo"<img src=\"./img/spunta2.png\" class=\"icon\">";
					echo"<h2>  La restituzione &egrave; avvenuta con successo</h2>";
					echo "<p>  Il libro ".$nome." &egrave; stato restituito dopo ".$durata." giorni!</p>"; 
				}
					
				}
				?>
			</div>
			<div class="theFooter">
				<div class="right"><?php echo basename($_SERVER['PHP_SELF']); ?></div>
				Creato da <address> <a href="mailto:s234708@studenti.polito.it">Adriana Provenzano</a> (matricola 234708)</address>
			</div>
			</div> 
		
	</body>
	
	</html>