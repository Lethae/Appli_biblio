<?php
session_start();

// on inclus les variables statiques
require_once('includes/configuration.php');

// on récupère implicitement $connexion
require_once('includes/header.php');


// reception des variables get, post
$action 	= mysqli_real_escape_string($connexion,isset($_GET['action']) ? $_GET['action'] : NULL) ;
$theme 		= mysqli_real_escape_string($connexion,isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur') ;
$id	= mysqli_real_escape_string($connexion,isset($_GET['id']) ? $_GET['id'] : NULL) ;

$login 		= mysqli_real_escape_string($connexion,isset($_POST['login']) ? $_POST['login'] : NULL) ;
$password 	= mysqli_real_escape_string($connexion,isset($_POST['password']) ? $_POST['password'] : NULL) ;

//Add auteur
$name 	= mysqli_real_escape_string($connexion,isset($_POST['name']) ? $_POST['name'] : NULL) ;
$surname 	= mysqli_real_escape_string($connexion,isset($_POST['surname']) ? $_POST['surname'] : NULL) ;
$dateN 	= mysqli_real_escape_string($connexion,isset($_POST['dateN']) ? $_POST['dateN'] : NULL) ;

//Add livre 
$title 	= mysqli_real_escape_string($connexion,isset($_POST['title']) ? $_POST['title'] : NULL) ;
$description	= mysqli_real_escape_string($connexion,isset($_POST['description']) ? $_POST['description'] : NULL) ;
$dateP 	= mysqli_real_escape_string($connexion,isset($_POST['dateP']) ? $_POST['dateP'] : NULL) ;

//Add editeur
$nameed 	= mysqli_real_escape_string($connexion,isset($_POST['nameed']) ? $_POST['nameed'] : NULL) ;

//Update auteur
$name_u 	= mysqli_real_escape_string($connexion,isset($_POST['name_u']) ? $_POST['name_u'] : NULL) ;
$surname_u 	= mysqli_real_escape_string($connexion,isset($_POST['surname_u']) ? $_POST['surname_u'] : NULL) ;
$dateN_u 	= mysqli_real_escape_string($connexion,isset($_POST['dateN_u']) ? $_POST['dateN_u'] : NULL) ;

//Update livre 
$title_u 	= mysqli_real_escape_string($connexion,isset($_POST['title_u']) ? $_POST['title_u'] : NULL) ;
$id_auteur_u	= mysqli_real_escape_string($connexion,isset($_POST['id_auteur_u']) ? $_POST['id_auteur_u'] : NULL) ;
$id_editeur_u	= mysqli_real_escape_string($connexion,isset($_POST['id_editeur_u']) ? $_POST['id_editeur_u'] : NULL) ;
$description_u	= mysqli_real_escape_string($connexion,isset($_POST['description_u']) ? $_POST['description_u'] : NULL) ;
$dateP_u 	= mysqli_real_escape_string($connexion,isset($_POST['dateP_u']) ? $_POST['dateP_u'] : NULL) ;

//Update editeur
$nameed_u 	= mysqli_real_escape_string($connexion,isset($_POST['nameed_u']) ? $_POST['nameed_u'] : NULL) ;

//Enregistrement
$login_r 		= mysqli_real_escape_string($connexion,isset($_POST['login_r']) ? $_POST['login_r'] : NULL) ;
$password_r 	= mysqli_real_escape_string($connexion,isset($_POST['password_r']) ? $_POST['password_r'] : NULL) ;
$email 	= mysqli_real_escape_string($connexion,isset($_POST['email']) ? $_POST['email'] : NULL) ;

//Update user
$login_u 		= mysqli_real_escape_string($connexion,isset($_POST['login_u']) ? $_POST['login_u'] : NULL) ;
$password_u 	= mysqli_real_escape_string($connexion,isset($_POST['password_u']) ? $_POST['password_u'] : NULL) ;
$email_u 	= mysqli_real_escape_string($connexion,isset($_POST['email_u']) ? $_POST['email_u'] : NULL) ;
$level_u = mysqli_real_escape_string($connexion,isset($_POST['level_u']) ? $_POST['level_u'] : NULL) ;

// chargement des fonction de creation des requetes sql
require_once('includes/sql.php');

// inclusion de la fonction table
require_once('includes/html/tables.php');

if (isset($_SESSION['user']) && $_SESSION['user']) { // User connecté

	require_once('template/headerco.php');

	if($theme=="auteur"){
		$sql = "SELECT nom, prenom, date_naissance FROM auteur WHERE id='$id'";
		$resultat = mysqli_query($connexion, $sql);
		$auteur_u = mysqli_fetch_assoc($resultat);

		echo '<div class="container">';
		echo '<form action="modif.php?id='.$id.'" method="post" class="form-signin">';
		  
?>
			<h2 class="form-signin-heading">Modifier un auteur</h2>
			
			<label for="inputName" class="sr-only">Nom</label>
			<input type="text" name="name_u" id="inputName" class="form-control" value="<?php echo $auteur_u['nom']; ?>" required autofocus>
			
			<label for="inputSurname" class="sr-only">Prénom</label>
			<input type="text" name="surname_u" id="inputSurname" class="form-control" value="<?php echo $auteur_u['prenom']; ?>" required>
			
			<label for="inputDateN" class="sr-only">Date de Naissance</label>
			<input type="text" name="dateN_u" id="inputDateN" class="form-control" value="<?php echo $auteur_u['date_naissance']; ?>">
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Modifier</button>
			<input type="hidden" name="id" value="<?php echo $id; ?>">
		  </form>

		</div> <!-- /container -->

<?php
	}
	elseif ($theme=="livre") {
		$sql = "SELECT titre, date_publication FROM livre WHERE id='$id'";
		$resultat = mysqli_query($connexion, $sql);
		$livre_u = mysqli_fetch_assoc($resultat);

		echo '<div class="container">';
		echo '<form action="modif.php?id='.$id.'" method="post" class="form-signin">';
?>
			<h2 class="form-signin-heading">Modifier un livre</h2>
			
			<label for="inputTitle" class="sr-only">Titre</label>
			<input type="text" name="title_u" id="inputTitle" class="form-control" value="<?php echo $livre_u['titre']; ?>" required autofocus>
			
			<label for="inputAuteur" class="sr-only">Auteur</label>
			<select name="id_auteur_u" id="inputAuteur">
			
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
			<select name="id_editeur_u" id="inputEditeur">
			
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
			<textarea name="description_u" id="inputDescription" class="form-control textzone"></textarea>
			
			<label for="inputDateP" class="sr-only">Date de Publication</label>
			<input type="text" name="dateP_u" id="inputDateP" class="form-control" value="<?php echo $livre_u['date_publication']; ?>">
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Modifier</button>
		  </form>

		</div> <!-- /container -->

<?php
	}
	elseif ($theme=="editeur") {
		$sql = "SELECT nom FROM editeur WHERE id='$id'";
		$resultat = mysqli_query($connexion, $sql);
		$editeur_u = mysqli_fetch_assoc($resultat);

		echo '<div class="container">';
		echo '<form action="modif.php?id='.$id.'" method="post" class="form-signin">';
?>
			<h2 class="form-signin-heading">Modifier l'éditeur </h2>
			
			<label for="inputNameed" class="sr-only">Nom</label>
			<input type="text" name="nameed_u" id="inputNameed" class="form-control" value="<?php echo $editeur_u['nom']; ?>" required autofocus>
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Modifier</button>
		  </form>

		</div> <!-- /container -->

<?php
	}
	else{
		$sql = "SELECT identifiant, email, mot_de_passe, niveau FROM utilisateur WHERE id='$id'";
		$resultat = mysqli_query($connexion, $sql);
		$user_u = mysqli_fetch_assoc($resultat);

		echo '<div class="container">';
		echo '<form action="modif.php?id='.$id.'" method="post" class="form-signin">';
?>
	<h2 class="form-signin-heading">Modifier un utilisateur</h2>
		
		<label for="inputLogin" class="sr-only">Identifiant</label>
		<input type="text" name="login_u" id="inputLogin" class="form-control" value="<?php echo $user_u['identifiant']; ?>" required autofocus>
        
		<label for="inputEmail" class="sr-only">Adresse Email</label>
        <input type="email" name="email_u" id="inputEmail" class="form-control" value="<?php echo $user_u['email']; ?>">
        
		<label for="inputPassword" class="sr-only">Mot de Passe</label>
        <input type="password" name="password_u" id="inputPassword" class="form-control" placeholder="Mot de Passe" required>
		
		<label for="inputLevel" class="sr-only">Niveau</label>
		<select name="level_u" id="inputLevel"> <option value="<?php echo $user_u['niveau'];?>"> <?php echo $user_u['niveau'];?> </option>
												<option value="0">0</option>	<option value="1">1</option>	<option value="2">2</option> </select>
		
        <button class="btn btn-lg btn-primary btn-block" type="submit">Modifier</button>
		 </form>

		</div> <!-- /container -->

<?php
	}
	
}

if ($name_u && $surname_u && $dateN_u)
{
	$sql = "UPDATE auteur SET nom = '$name_u', prenom = '$surname_u', date_naissance = '$dateN_u' WHERE id = '$id';";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien ajouté l'auteur $name_u $surname_u";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

if ($id_auteur_u && $id_editeur_u && $title_u && $description_u && $dateP_u)
{
	$sql = "UPDATE livre SET id_auteur = '$id_auteur_u', id_editeur = '$id_editeur_u', titre = '$title_u', description = '$description_u', date_publication = '$dateP_u' WHERE id = '$id';";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien ajouté le livre $title_u";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

if ($nameed_u)
{
	$sql = "UPDATE editeur SET nom = '$nameed_u' WHERE id = '$id';";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien modifié l'éditeur $nameed_u";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

if ($login_u && $email_u && $password_u && $level_u)
{
	$password_u = md5($password_u);
	$sql = "UPDATE utilisateur SET identifiant = '$login_u', email = '$email_u', mot_de_passe = '$password_u', niveau = '$level_u' WHERE id = '$id';";
	mysqli_query($connexion, $sql);
	
	if(mysqli_affected_rows($connexion) == 1)
	{
		echo "Vous avez bien modifié l'utilisateur $login_u.";
	}
	else
		echo "Une erreur a eu lieu. Merci de réessayer.";
}

// Inclusion fin HTML
require_once('template/footer.php');

// Footer PHP - Ferme la connexion
require_once('includes/footer.php');

?>