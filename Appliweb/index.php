<?php
session_start();

// on inclus les variables statiques
require_once('includes/configuration.php');

// on récupère implicitement $connexion
require_once('includes/header.php');

// reception des variables get, post
$action 	= isset($_GET['action']) ? $_GET['action'] : NULL ;
$theme 		= isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur' ;

$login 		= isset($_POST['login']) ? $_POST['login'] : NULL ;
$password 	= isset($_POST['password']) ? $_POST['password'] : NULL ;
$niveau = isset($_POST['niveau']) ? $_POST['niveau'] : '2';
$email 	= isset($_POST['email']) ? $_POST['email'] : NULL ;
$search 	= isset($_POST['search']) ? $_POST['search'] : NULL ;
$id	= isset($_GET['id']) ? $_GET['id'] : NULL ;

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

require_once('template/headerco.php');


$sql        	= getSql($theme, $search, $connexion);
$sqlResult 	= mysqli_query($connexion, $sql);
$rowCount   	= mysqli_num_rows($sqlResult);

	// affichage des resultats de la recherche utilisateur
	if ( isset($rowCount) && $rowCount )  {
	    while($row = mysqli_fetch_assoc($sqlResult))
	    {
	        $result[] 	= $row;
	    }
	    echo getHtmlTable($result);
	} else {
	    echo "pas de résultats";
	}

	if($action == "suppr") {
		$sql = supprSql($theme, $connexion, $id);
		$sqlResult = mysqli_query($connexion, $sql);
		echo "Suppression réussie $id";
	}
	
		if($action == "modif") {
		$sql = modifSql($theme, $connexion, $id);
		$sqlResult = mysqli_query($connexion, $sql);
		echo "Modification réussie $id";
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