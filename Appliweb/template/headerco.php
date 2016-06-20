<!DOCTYPE html>
<html lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Mon application</title>
    <link rel="stylesheet" href="./template/css/bootstrap.css">      
	<link rel="stylesheet" href="./template/css/styles.css">
</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Bibliothèque</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php?recherche=auteur">Auteurs</a></li>
            <li><a href="index.php?recherche=livre">Livres</a></li>
            <li><a href="index.php?recherche=editeur">Editeurs</a></li>			
<?php
	if($_SESSION['user']['niveau'] == 0)
{
	echo "			<li><a href='index.php?recherche=utilisateur'>Utilisateurs</a></li>";
}
?>
			<li><form class="search" action="index.php?recherche=<?php echo $theme;?>" method="post"><input name="search" placeholder="Search" type="text"/></form></li>
            <li><a href="index.php?action=logout" class="deconnexion"><button type="submit" class="btn btn-primary">Se déconnecter</button></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
			  <br/>