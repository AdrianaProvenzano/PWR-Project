<?php
	include("sessione.php"); 
?>

<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> Pagina di prenotazione libri  </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Pagina di identificazione Biblioteca" >
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
			<div class="theHeader">Pagina di prenotazione libri - Biblioteca "Babele"</div>
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
				$con = mysqli_connect("localhost", "uReadOnly", "posso_solo_leggere", "biblioteca");
             
                if (mysqli_connect_errno()) 
                    echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
                else
				{
					if (!empty($_SESSION["uname"])) {
						//TABELLA LIBRI IN PRESTITO
						echo"<h1 style=\"text-align:center;\"> Libri attualmente in prestito</h1>"; 
						echo"<form name=\"flibri\" action=\"restituisci.php\" method=\"POST\" >";
						$query = "SELECT * FROM books WHERE prestito=?";
						$stmt = mysqli_prepare($con, $query);
						mysqli_stmt_bind_param($stmt, "s", $uname);
						$ok = mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
						$numlibri = mysqli_num_rows($result);	
												
						if(!$result)
							echo "<tr>\n<td colspan='3'>Errore query fallita: ".mysqli_error($con)."</td>\n</tr>\n";
						else if($numlibri>0)
						{
							echo"<table>\n<tr><th>Titolo</th>\n<th>Autori</th>\n<th>Disponibilit&agrave;</th>\n";
							while($row = mysqli_fetch_assoc($result)){
								echo "<tr>\n<td>$row[titolo]</td>\n<td>$row[autori]</td>\n<td>";
								echo"<input type=\"submit\" name=".$row["id"]." value=\"RESTITUISCI\">"; 
								echo"</td>\n</tr>\n";
							}
						
							echo"</table>";
							echo"</form>";
							mysqli_free_result($result);
							mysqli_close($con);
						} 
						else{
							echo"<p> Non hai libri in prestito!</p>";
							echo"</form>";
						}									
						
						//TABELLA LIBRI IN BIBLIOTECA
						echo"<h1 style=\"text-align:center;\"> Libri disponibili in biblioteca</h1>"; 
						echo"\n<form name=\"flibri\" action=\"prestito.php\" method=\"POST\">";
						echo"<table>\n<tr><th>Titolo</th>\n<th>Autori</th>\n<th>Disponibilit&agrave;</th>\n<th>Prendi in prestito</th>\n</tr>";
						$query = "SELECT * FROM books";
						$con = mysqli_connect("localhost", "uReadOnly", "posso_solo_leggere", "biblioteca");						
						$result = mysqli_query($con, $query);
						
						if(!$result){
							echo "<tr>\n<td colspan='3'>Errore query fallita: ".mysqli_error($con)."</td>\n</tr>\n";}
						else 
						{
							while($row = mysqli_fetch_assoc($result)){
								echo "<tr>\n<td>$row[titolo]</td>\n<td>$row[autori]</td>\n";			
									if($row["prestito"]==""){
										echo "<td><div class=\"disponibile\">DISPONIBILE</div></td>\n";
										echo"<td class=\"centro\"><input type='checkbox' name='checkbox[]' value='" . $row["id"] . "'></td>\n"; 
										echo"</tr>\n";
									} else if($row["prestito"]==$uname){
										if(time() - strtotime($row["data"]) > $row["giorni"] * 60 * 60 * 24){
											echo "<td><div class=\"scaduto\">PRESTITO SCADUTO</div></td>\n</tr>\n";
										} else
											echo"<td><div class=\"prestito\">IN PRESTITO</div></td>\n</tr>\n";
									}else{
										echo"<td>NON DISPONIBILE</td></tr>\n";
									}
							} 
							echo"</table>"; 
							mysqli_free_result($result);
							mysqli_close($con);
							echo"<br>";
							echo"<input type=\"submit\" value=\"PRESTITO\"> <p>Inserisci il numero di giorni per cui si vuole richiedere il prestito <input type=\"text\" name=\"numgiorni\"></p> ";							
							echo"\n</form>";
						}
					}
					else{
						$query = "SELECT * FROM books";
						$result = mysqli_query($con, $query);
						$tot = mysqli_num_rows($result);
						$disp=0; 
						echo "<h1 style=\"text-align:center;\"> Libri in biblioteca</h1>";
						echo"<table>\n<tr><th>Titolo</th>\n<th>Autori</th>\n<th>Disponibilit&agrave;</th>\n</tr>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<tr>\n<td>$row[titolo]</td>\n<td>$row[autori]</td>\n<td>";
							if($row["prestito"]==""){
								$disp++; 
								echo "<div class=\"disponibile\">DISPONIBILE</div></td>\n";}
							else
								echo"NON DISPONIBILE"; 
						}
						echo"</table>";
						mysqli_free_result($result);
						mysqli_close($con);
						echo"<p> In biblioteca sono presenti ".$tot." libri, di cui ".$disp." disponibili</p>"; 
						echo"<p>Per avere la lista dei libri in prestito e disponibili in biblioteca effettuare il login <a href=\"login.php\"> QUI </a>.</p>";
					}
				}
			}
					?>
				
			</div>
			<div class="theFooter">
				<div class="right"><?php echo basename($_SERVER['PHP_SELF']); ?></div>
				Creato da <address> <a href="mailto:s234708@studenti.polito.it">Adriana Provenzano</a> (matricola 234708)</address>
			</div>		
	</body>
</html>