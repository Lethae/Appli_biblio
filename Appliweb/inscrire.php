<?php
session_start();

// on inclus les variables statiques
require_once('includes/configuration.php');

// on récupère implicitement $connexion
require_once('includes/header.php');

// inclusion entete HTML + Styles
require_once('template/header.php');

// reception des variables get, post
$action 	= isset($_GET['action']) ? $_GET['action'] : NULL ;
$theme 		= isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur' ;

$login_r 		= isset($_POST['login_r']) ? $_POST['login_r'] : NULL ;
$login 		= isset($_POST['login']) ? $_POST['login'] : NULL ;
$password_r 	= isset($_POST['password_r']) ? $_POST['password_r'] : NULL ;
$password 	= isset($_POST['password']) ? $_POST['password'] : NULL ;
$email 	= isset($_POST['email']) ? $_POST['email'] : NULL ;

?>
	
	<div class="container">
      <form action="inscrire.php" method="post" class="form-signin">
        <h2 class="form-signin-heading">Inscription</h2>
		
		<label for="inputLogin" class="sr-only">Identifiant</label>
		<input type="text" name="login_r" id="inputLogin" class="form-control" placeholder="Identifiant" required autofocus>
        
		<label for="inputEmail" class="sr-only">Adresse Email</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Adresse Email">
        
		<label for="inputPassword" class="sr-only">Mot de Passe</label>
        <input type="password" name="password_r" id="inputPassword" class="form-control" placeholder="Mot de Passe" required>
		
        <button class="btn btn-lg btn-primary btn-block" type="submit">S'inscrire</button>
      </form>

    </div> <!-- /container -->
	
<?php 

// chargement des fonction de creation des requetes sql
require_once('includes/sql.php');

// inclusion de la fonction table
require_once('includes/html/tables.php');

// Tentative de login
if ($login && $password)
{
	$password = md5($password);
        $sql = "SELECT identifiant, email, niveau FROM utilisateur";
        $sql.= " WHERE identifiant = '$login' AND mot_de_passe = '$password' LIMIT 1";
        
        $sqlResult 	= mysqli_query($connexion, $sql);  
        $user 		= mysqli_fetch_assoc($sqlResult);
        
        if (isset($user) && $user) {
        	$_SESSION['user'] = $user;
        } else {
        	$errorLogin = true;
        }
}

// Inscription d'un utilisateur

if ($login_r && $email && $password_r)
{
	$password_r = md5($password_r);
	$sql = "INSERT INTO utilisateur VALUES ('', '$login_r', '$email', '$password_r', 2);";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien été inscrit. Merci de revenir à l'accueil pour vous connecter.";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

// Inclusion fin HTML
require_once('template/footer.php');

// Footer PHP - Ferme la connexion
require_once('includes/footer.php');

?>