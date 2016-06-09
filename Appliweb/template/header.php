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
          <a class="navbar-brand" href="./index.php">Bibliothèque</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" action="index.php" method="post" >
            <div class="form-group">
              <input type="text" name="login" placeholder="Identifiant" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="password" placeholder="Mot de Passe" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
			<a href="./inscrire.php" class="btn btn-success">S'inscrire</a>
		</form>

        </div><!--/.navbar-collapse -->
      </div>
    </nav>
	