<?php 

/**
 * Retourne la requete SQL de recherche formée par les infos utilisateurs
 * @param  string $theme     theme de recherche / table
 * @param  string $search    recherche textuelle
 * @param  connexion $connexion conexion à la base de donnée
 * @return string            requete sql
 */
function getSql($theme, $search, $connexion)
{
    $sql 		= "SELECT * FROM auteur";
    if($theme) {

        $checktable = mysqli_query($connexion, "SHOW TABLES LIKE '$theme'");
        $table      = mysqli_num_rows($checktable) ? $theme : 'auteur';
        $sql 		= "SELECT * FROM $table";      
    }
    if ($search) {
		if ($theme == "auteur") {
        $sql.= " WHERE nom LIKE '%$search%'";
		}
		if ($theme == "livre") {
        $sql.= " WHERE titre LIKE '%$search%'";
		}
		if ($theme == "editeur") {
        $sql.= " WHERE nom LIKE '%$search%'";
		}
		if ($theme == "utilisateur") {
        $sql.= " WHERE identifiant LIKE '%$search%'";
		}
    }
    return $sql;
}

function supprSql($theme, $connexion, $id)
{
	$sql 		= "SELECT * FROM $theme";
    if($theme) {
		
        $checktable = mysqli_query($connexion, "SHOW TABLES LIKE '$theme'");
        $table      = mysqli_num_rows($checktable) ? $theme : 'auteur';
        $sql 		= "DELETE FROM $theme WHERE id=$id";      
    }
	return $sql;
}

function lienSql($theme, $connexion, $id)
{
    if($theme == 'auteur') {
        $sql 		= "SELECT * FROM livre WHERE id_auteur = $id;";      
    }
	elseif($theme == 'livre') {
        $sql 		= "SELECT auteur.id, nom, prenom, date_naissance FROM auteur INNER JOIN livre ON id_auteur = auteur.id WHERE id_auteur = $id;";      
	}
	else{
        $sql 		= "SELECT * FROM auteur INNER JOIN livre ON id_auteur = auteur.id WHERE auteur.id= $id;";      
	}
	return $sql;
}