<?php
session_start();

// on inclus les variables statiques
require_once('includes/configuration.php');

// on réupère implicitement $connexion
require_once('includes/header.php');

// inclusion entete HTML + Styles
require_once('template/header.php');

// reception des variables get, post
$action 	= isset($_GET['action']) ? $_GET['action'] : NULL ;
$theme 		= isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur' ;

$login 		= isset($_POST['login']) ? $_POST['login'] : NULL ;
$password 	= isset($_POST['password']) ? $_POST['password'] : NULL ;

$name 	= isset($_POST['name']) ? $_POST['name'] : NULL ;
$surname 	= isset($_POST['surname']) ? $_POST['surname'] : NULL ;
$dateN 	= isset($_POST['dateN']) ? $_POST['dateN'] : NULL ;

$title 	= isset($_POST['title']) ? $_POST['title'] : NULL ;
$description	= isset($_POST['description']) ? $_POST['description'] : NULL ;
$dateP 	= isset($_POST['dateP']) ? $_POST['dateP'] : NULL ;

$login_r 		= isset($_POST['login_r']) ? $_POST['login_r'] : NULL ;
$password_r 	= isset($_POST['password_r']) ? $_POST['password_r'] : NULL ;
$email 	= isset($_POST['email']) ? $_POST['email'] : NULL ;

// chargement des fonction de creation des requetes sql
require_once('includes/sql.php');

// inclusion de la fonction table
require_once('includes/html/tables.php');

if (isset($_SESSION['user']) && $_SESSION['user']) { // User connecté

	require_once('template/headerco.php');

	if($theme=="auteur"){
?>

		<div class="container">
		  <form action="ajout.php" method="post" class="form-signin">
			<h2 class="form-signin-heading">Ajouter un auteur</h2>
			
			<label for="inputName" class="sr-only">Nom</label>
			<input type="text" name="name" id="inputName" class="form-control" placeholder="Nom" required autofocus>
			
			<label for="inputSurname" class="sr-only">Prénom</label>
			<input type="text" name="surname" id="inputSurname" class="form-control" placeholder="Prénom" required>
			
			<label for="inputDateN" class="sr-only">Date de Naissance</label>
			<input type="text" name="dateN" id="inputDateN" class="form-control" placeholder="Date de Naissance (aaaa-mm-jj)">
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Ajouter</button>
		  </form>

		</div> <!-- /container -->

<?php
	}
	elseif ($theme=="livre") {
?>

		<div class="container">
		  <form action="ajout.php" method="post" class="form-signin">
			<h2 class="form-signin-heading">Ajouter un livre</h2>
			
			<label for="inputTitle" class="sr-only">Titre</label>
			<input type="text" name="title" id="inputTitle" class="form-control" placeholder="Titre" required autofocus>
			
			<label for="inputDescription" class="sr-only">Description</label>
			<textarea name="description" id="inputDescription" class="form-control textzone" placeholder="Description"></textarea>
			
			<label for="inputDateP" class="sr-only">Date de Publication</label>
			<input type="text" name="dateP" id="inputDateP" class="form-control" placeholder="Date de Publication (aaaa-mm-jj)">
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Ajouter</button>
		  </form>

		</div> <!-- /container -->

<?php
	}
	else{
?>

		<div class="container">
		  <form action="ajout.php" method="post" class="form-signin">
			<h2 class="form-signin-heading">Ajouter un utilisateur</h2>
		
		<label for="inputLogin" class="sr-only">Identifiant</label>
		<input type="text" name="login_r" id="inputLogin" class="form-control" placeholder="Identifiant" required autofocus>
        
		<label for="inputEmail" class="sr-only">Adresse Email</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Adresse Email">
        
		<label for="inputPassword" class="sr-only">Mot de Passe</label>
        <input type="password" name="password_r" id="inputPassword" class="form-control" placeholder="Mot de Passe" required>
		
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ajouter</button>
		  </form>

		</div> <!-- /container -->

<?php
	}
	
}

if ($name && $surname && $dateN)
{
	$sql = "INSERT INTO auteur VALUES ('', '$name', '$surname', '$dateN');";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien ajouté l'auteur $name $surname";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

if ($title && $description && $dateP)
{
	$sql = "INSERT INTO livre VALUES ('', '1', '1', '$title', '$description', '$dateP');";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien ajouté le livre $title";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

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