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
        $sql.= " WHERE nom LIKE '%$search%'";
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

