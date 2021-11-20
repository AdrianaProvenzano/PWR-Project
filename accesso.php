<?php
	include("sessione.php"); 
?>

<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> Accesso </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Accesso Biblioteca" >
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
			<div class="theHeader">Pagina di accesso - Biblioteca "Babele"</div>
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
				 $tipo_errore=""; 
					if (!(isset($_REQUEST['uname'])) && $_REQUEST['uname']!="")
						$tipo_errore="Errore - Inserire uno username\n";
					else if (!(isset($_REQUEST['pwd'])) && $_REQUEST['pwd']!="")
						$tipo_errore="Errore - Password mancante\n";
					else {
						$uname = trim($_REQUEST['uname']);
						$pwd = trim($_REQUEST['pwd']);
						$regex='/\s/';
				
						//controllo se esiste un'utente con quell'username e quella password
						$con = mysqli_connect("localhost", "uReadOnly", "posso_solo_leggere", "biblioteca");           
						if (mysqli_connect_errno()) 
							$tipo_errore="Errore connessione al DBMS: ".mysqli_connect_error()."\n";
						if($uname != str_replace(' ','',$uname) )
							$tipo_errore="Non ci devono essere spazi prima e/o dopo l'username\n"; 
						if($pwd != str_replace(' ','',$pwd))
							$tipo_errore="Non ci devono essere spazi prima e/o dopo la password\n"; 
						else
						{   
							$query = "SELECT * FROM users WHERE username=? AND pwd=?";
							$stmt = mysqli_prepare($con, $query);
							mysqli_stmt_bind_param($stmt, "ss", $uname, $pwd);
							$ok = mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);
						
							if(!$ok)
								$tipo_errore="Errore query fallita: ".mysqli_error($con)."\n";
							else{
								$row = mysqli_fetch_array($result, MYSQLI_NUM);
								$count = mysqli_num_rows($result);
								if($count==1){
									$_SESSION["uname"] = $uname;
									setcookie("lastlogin", $uname, time() + (86400 * 2), "/");
									header("location: libri.php");
									
								}
								else
									$tipo_errore="I dati inseriti non sono validi\n";
							}
							mysqli_stmt_close($stmt);
						}
						mysqli_close($con);
						}
						
						if($tipo_errore!=""){
							echo"<p> <div class=\"err\">".$tipo_errore."\n</div>";
							echo"<h1 class=\"userlogin\">USER<span style=\"color: white\">LOGIN</span></h1>";
							echo "<img src=\"./img/user.png\" alt=\"Lucchetto\" class=\"icon\">";
							echo"<form name=\"flogin\" action=\"accesso.php\" method=\"POST\" onSubmit=\"return validate(uname, pwd);\">";
							echo"<p> Inserisci i dati per effettuare l'accesso: </p>"; 
							echo"<p> Nome utente: <input type=\"text\" name=\"uname\"";  
							if(isset($_COOKIE["lastlogin"])){
								$login=$_COOKIE["lastlogin"];
								echo"value=$login"; }
							echo"> </p>"; 
							echo"<p> Password: <input type=\"password\" name=\"pwd\" value=\"\"> </p>"; 
							echo"<p> <input type=\"submit\" value=\"OK\"> ";
							echo"<input type=\"reset\" value=\"PULISCI\"></p>";  
							echo"<br>";
							echo"<p class=\"mini\">Sei un nuovo utente? <a href=\"new.php\">CLICCA QUI.</a></p>"; 
							echo"</form>";
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