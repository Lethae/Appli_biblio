<?php
session_start();

// on inclus les variables statiques
require_once('includes/configuration.php');

// on réupère implicitement $connexion
require_once('includes/header.php');

// inclusion entete HTML + Styles
require_once('template/header.php');

// reception des variables get, post
$action 	= mysqli_real_escape_string($connexion,isset($_GET['action']) ? $_GET['action'] : NULL) ;
$theme 		= mysqli_real_escape_string($connexion,isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur' ;
// $id	= mysqli_real_escape_string($connexion,isset($_GET['id']) ? $_GET['id'] : NULL) ;

$login 		= mysqli_real_escape_string($connexion,isset($_POST['login']) ? $_POST['login'] : NULL) ;
$password 	= mysqli_real_escape_string($connexion,isset($_POST['password']) ? $_POST['password'] : NULL) ;

//Add auteur
$name 	= mysqli_real_escape_string($connexion,isset($_POST['name']) ? $_POST['name'] : NULL) ;
$surname 	= mysqli_real_escape_string($connexion,isset($_POST['surname']) ? $_POST['surname'] : NULL) ;
$dateN 	= mysqli_real_escape_string($connexion,isset($_POST['dateN']) ? $_POST['dateN'] : NULL) ;

//Add livre 
$title 	= mysqli_real_escape_string($connexion,isset($_POST['title']) ? $_POST['title'] : NULL) ;
$description	= mysqli_real_escape_string($connexion,isset($_POST['description']) ? $_POST['description'] : NULL) ;
$auteur	= mysqli_real_escape_string($connexion,isset($_POST['auteur']) ? $_POST['auteur'] : NULL) ;
$editeur	= mysqli_real_escape_string($connexion,isset($_POST['editeur']) ? $_POST['editeur'] : NULL) ;
$dateP 	= mysqli_real_escape_string($connexion,isset($_POST['dateP']) ? $_POST['dateP'] : NULL) ;

// Constantes
define('TARGET', '/images/');    // Repertoire cible
define('MAX_SIZE', 100000);    // Taille max en octets du fichier
define('WIDTH_MAX', 800);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 800);    // Hauteur max de l'image en pixels
 
// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$message = '';
$nomImage = '';
 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
/*if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
 */
/************************************************************
 * Script d'upload
 *************************************************************/
if(!empty($_POST))
{
  // On verifie si le champ est rempli
  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
 
    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
 
      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error']) 
            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
          {
            // On renomme le fichier
            $nomImage = md5(uniqid()) .'.'. $extension;
 
            // Si c'est OK, on teste l'upload
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
            {
              $message = 'Upload réussi !';
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          }
          else
          {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
  else
  {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }
}

//Add editeur
$nameed 	= mysqli_real_escape_string($connexion,isset($_POST['nameed']) ? $_POST['nameed'] : NULL) ;

//Enregistrement
$login_r 		= mysqli_real_escape_string($connexion,isset($_POST['login_r']) ? $_POST['login_r'] : NULL) ;
$password_r 	= mysqli_real_escape_string($connexion,isset($_POST['password_r']) ? $_POST['password_r'] : NULL) ;
$email 	= mysqli_real_escape_string($connexion,isset($_POST['email']) ? $_POST['email'] : NULL) ;

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
			
			<label for="inputAuteur" class="sr-only">Auteur</label>
			<select name="auteur" id="inputAuteur">
			
			<?php
				$sql = "SELECT * FROM auteur";
				$reponse = mysqli_query($connexion, $sql);
				
				while ($donnees = mysqli_fetch_assoc($reponse))
				{
			?>
					<option value="<?php echo $donnees['id']; ?> "> <?php echo $donnees['nom']; ?> </option>
				<?php
				}
				?>
			</select>
			
			<label for="inputEditeur" class="sr-only">Editeur</label>
			<select name="editeur" id="inputEditeur">
			
			<?php
				$sql = "SELECT * FROM editeur";
				$reponse = mysqli_query($connexion, $sql);
				
				while ($donnees = mysqli_fetch_assoc($reponse))
				{
			?>
					<option value="<?php echo $donnees['id']; ?> "> <?php echo $donnees['nom']; ?> </option>
				<?php
				}
				?>
			</select>
			
			<label for="inputDescription" class="sr-only">Description</label>
			<textarea name="description" id="inputDescription" class="form-control textzone" placeholder="Description"></textarea>
			
			<label for="inputDateP" class="sr-only">Date de Publication</label>
			<input type="text" name="dateP" id="inputDateP" class="form-control" placeholder="Date de Publication (aaaa-mm-jj)">
	
            <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier :</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
            <input name="fichier" type="file" id="fichier_a_uploader" />
			<button class="btn btn-lg btn-primary btn-block" type="submit">Ajouter</button>
		  </form>

		</div> <!-- /container -->

<?php
	}
	elseif ($theme=="editeur") {
?>

		<div class="container">
		  <form action="ajout.php" method="post" class="form-signin">
			<h2 class="form-signin-heading">Ajouter un éditeur</h2>
			
			<label for="inputNameed" class="sr-only">Nom</label>
			<input type="text" name="nameed" id="inputNameed" class="form-control" placeholder="Nom" required autofocus>
			
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

if ($auteur && $editeur && $title && $description && $dateP)
{
	$sql = "INSERT INTO livre VALUES ('', '$auteur', '$editeur', '$title', '$description', '', '$dateP');";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien ajouté le livre $title";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

if ($nameed)
{
	$sql = "INSERT INTO editeur VALUES ('', '$nameed');";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien ajouté l'éditeur $nameed";
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
		echo "Vous avez bien inscrit cet utilisateur.";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

// Inclusion fin HTML
require_once('template/footer.php');

// Footer PHP - Ferme la connexion
require_once('includes/footer.php');

?>