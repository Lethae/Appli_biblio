<?php
session_start();

// on inclus les variables statiques
require_once('includes/configuration.php');

// on récupère implicitement $connexion
require_once('includes/header.php');

// reception des variables get, post
<<<<<<< HEAD
$action 	= htmlentities(mysqli_real_escape_string($connexion,isset($_GET['action']) ? $_GET['action'] : NULL)); 
$theme 		= htmlentities(mysqli_real_escape_string($connexion,isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur' ));

$login 		= htmlentities(mysqli_real_escape_string($connexion,isset($_POST['login']) ? $_POST['login'] : NULL)); 
$password 	= htmlentities(mysqli_real_escape_string($connexion,isset($_POST['password']) ? $_POST['password'] : NULL)); 
$niveau = htmlentities(mysqli_real_escape_string($connexion,isset($_POST['niveau']) ? $_POST['niveau'] : '2'));
$email 	= htmlentities(mysqli_real_escape_string($connexion,isset($_POST['email']) ? $_POST['email'] : NULL));
$search 	= htmlentities(mysqli_real_escape_string($connexion,isset($_POST['search']) ? $_POST['search'] : NULL));
$id	= htmlentities(mysqli_real_escape_string($connexion,isset($_GET['id']) ? $_GET['id'] : NULL));
=======
$action 	= mysqli_real_escape_string($connexion,isset($_GET['action']) ? $_GET['action'] : NULL); 
$theme 		= mysqli_real_escape_string($connexion,isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur' );

$login 		= mysqli_real_escape_string($connexion,isset($_POST['login']) ? $_POST['login'] : NULL); 
$password 	= mysqli_real_escape_string($connexion,isset($_POST['password']) ? $_POST['password'] : NULL); 
$niveau = mysqli_real_escape_string($connexion,isset($_POST['niveau']) ? $_POST['niveau'] : '2');
$email 	= mysqli_real_escape_string($connexion,isset($_POST['email']) ? $_POST['email'] : NULL);
$search 	= mysqli_real_escape_string($connexion,isset($_POST['search']) ? $_POST['search'] : NULL);
$id	= mysqli_real_escape_string($connexion,isset($_GET['id']) ? $_GET['id'] : NULL);
>>>>>>> origin/master

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

// Déconnexion utilisateur
if ($action == 'logout') {
	unset($_SESSION['user']);
	session_destroy();
}

// chargement des fonction de creation des requetes sql
require_once('includes/sql.php');

// inclusion de la fonction table
require_once('includes/html/tables.php');

// inclusion entete HTML + Styles
require_once('template/header.php');


if (isset($_SESSION['user']) && $_SESSION['user']) { // User connecté

<<<<<<< HEAD
require_once('template/headerco.php'); 					//On récupère le menu de quand on est connecté
=======
require_once('template/headerco.php');
>>>>>>> origin/master

$sql        	= getSql($theme, $search, $connexion);
$sqlResult 	= mysqli_query($connexion, $sql);
$rowCount   	= mysqli_num_rows($sqlResult);

// affichage des resultats de la recherche utilisateur
	if ( isset($rowCount) && $rowCount )  {
	    while($row = mysqli_fetch_assoc($sqlResult))
	    {
	        $result[] 	= $row;
	    }
	    echo getHtmlTable($result,$action);
	} else {
	    echo "pas de résultats";
	}

// Suppression d'une ligne
	if($action == "suppr" && $_SESSION['user']['niveau'] < 2) {
		$sql = supprSql($theme, $connexion, $id);
		$sqlResult = mysqli_query($connexion, $sql);
		echo "Suppression réussie $id";
	}
	
<<<<<<< HEAD
// Accès aux éléments liés entre eux
=======
>>>>>>> origin/master
	if($action == "lien") {
		$sql = lienSql($theme, $connexion, $id);
		$sqlResult = mysqli_query($connexion, $sql);
		echo "<br/>";
		if ( isset($rowCount) && $rowCount )  {
	    while($row = mysqli_fetch_assoc($sqlResult))
	    {
	        $result[] 	= $row;
	    }
	    echo getFiche($sqlResult,$action);
	} else {
	    echo "pas de résultats";
	}
	}
	
} else { // User non connecté
	
	if (isset($errorLogin) && $errorLogin) {
		echo "Ce couple de login et pass ne correspondent à aucun utilisateur enregistré";
	}

}

// Inclusion fin HTML
require_once('template/footer.php');

// Footer PHP - Ferme la connexion
require_once('includes/footer.php');