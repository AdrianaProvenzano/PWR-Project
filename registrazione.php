<?php
	include("sessione.php"); 
?>
<!doctype html> 
<html lang="it">
	<head>
		<meta charset=utf-8>
		<title> Registrazione </title>
		<meta name="author" content="Adriana Provenzano">
		<meta name="description" content="Registrazione Biblioteca" >
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
				return true;
				}
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
				 <?php
				 $error = "";  
					if (!(isset($_REQUEST['uname'])) || $_REQUEST['uname']=="")
						$error="Errore - Inserire uno username\n";
					else if (!(isset($_REQUEST['pwd1'])) || $_REQUEST['pwd1']=="")
						$error="Errore - Password mancante\n";
					else if (!(isset($_REQUEST['pwd2'])) || $_REQUEST['pwd2']=="")
						$error="Errore - Confermare la password\n";
					else {
						$uname = trim($_REQUEST['uname']);
						$pwd1 = trim($_REQUEST['pwd1']);
						$pwd2 = trim($_REQUEST['pwd2']);
						$re_uname="/(?=.*[a-zA-Z])(?=.*[0-9%])^[a-zA-Z%]{1}[a-zA-Z0-9%]{2,5}$/"; 
						$re_pwd="/^(?=.*[a-z])(?=.*[A-Z])[A-Za-z]{4,8}$/"; 
						
						if(!(preg_match($re_uname, $uname)))
							$error="Errore - Lo username scelto non rispetta le caratteristiche!\n";	
						else if(!(preg_match($re_pwd, $pwd1)))
							$error="Errore - La password scelta non rispetta le caratteristiche!\n";
						else if($pwd1!=$pwd2){
							$error="Errore - La password di conferma non &egrave; uguale alla prima password inserita!\n"; 
						}
							
							//aggiunta utente al DB
							$con = mysqli_connect("localhost", "uReadWrite", "SuperPippo!!!", "biblioteca");           
							if (mysqli_connect_errno()) 
								$error="Errore connessione al DBMS: ".mysqli_connect_error()."\n";
							else
							{   
								$query = "INSERT INTO users(username,pwd) VALUES (?,?)";
								$stmt = mysqli_prepare($con, $query);
								mysqli_stmt_bind_param($stmt, "ss", $uname, $pwd1);
								$result = mysqli_stmt_execute($stmt);
								
								if(!$result)
									$error="Errore query fallita: ".mysqli_error($con)."\n";	
								else if($error==""){
									echo "<p><span class=\"ciao\">Caro/a $uname ,</span></p> <p>abbiamo ricevuto correttamente i tuoi dati. Ora sei un nuovo utente della Biblioteca \"Babele\"!</p>\n<p>La tua password contiene <span class=\"ciao\">".strlen($pwd1)."</span> caratteri e soddisfa i requisiti richiesti.</p>";
									echo"<br>";
									echo"<p> Per effettuare la gestione della prenotazione dei libri occorre accedere con il proprio account, clicca <a href=\"login.php\">QUI</a> per effettuare l'accesso. </p>"; 
								}
								mysqli_stmt_close($stmt);
							}
							
							mysqli_close($con);
							}
				
					if($error!=""){
						echo"<p> <div class=\"err\">".$error."\n</div>";
						echo"<form name=\"fsignin\" action=\"registrazione.php\" method=\"POST\" onSubmit=\"return validate(uname, pwd1, pwd2);\">";
						echo"<h1 style=\"text-align:center;\"> Crea il tuo account!</h1>"; 
						echo"<p> Inserisci i dati per effettuare la registrazione: </p>"; 
						echo"<p> Nome utente: <input type=\"text\" name=\"uname\" value=\"\"> </p>";
						echo"<p> Password: <input type=\"password\" name=\"pwd1\" value=\"\"> </p>";
						echo"<p> Conferma password: <input type=\"password\" name=\"pwd2\" value=\"\"> </p>";
						echo"<p> <input type=\"submit\" value=\"REGISTRAMI\"></p>";
						echo"</form>"; 
						echo"<br>";
						echo"<p> Affinch&egrave; la registrazione avvenga con successo, i parametri inseriti dall'utente
						devono rispettare le seguenti caratteristiche: </p>
						<ul>
						<li> lo USERNAME dell'utente pu&ograve; contenere solo caratteri alfabetici o numerici o il simbolo \"%\".
						Deve inoltre iniziare con un carattere alfabetico o con \"%\" e deve essere lungo da un minimo di 3 caratteri 
						a un massimo di 6. Inoltre, deve contenere almeno un carattere non numerico ed uno numerico. <div class=\"es\">(Esempi username validi: %Mario, Luigi5, Rob97)</div></li>
						<li> la PASSWORD dell'utente pu&ograve; contenere solo caratteri alfabetici, e pu&ograve; essere lunga 
						da un minimo di 4 caratteri ad un massimo di 8 e deve contenere almeno un carattere maiuscolo ed uno minuscolo.
						<div class=\"es\">(Esempi password valide: Luna, hoPe, POLITo)</div></li></ul> "; 
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