<?php 

defined('APP') or die;

/**
 * Affiche un tableau php sous forme de table html
 * @param $array
 * @return html
 */

function getHtmlTable($array) 
{
	$theme = isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur' ;
	$table = "<table>";
	foreach ($array as $item)
	{	
		$table.= "<tr>";
		foreach ($item as $key => $value) {
			$table.= "<td>".$value."</td>";
		}
		$table.="<td><a href=index.php?recherche=$theme&action=modif&id=".$item['id'].">Modifier</a></td>";
		$table.="<td><a href=index.php?recherche=$theme&action=suppr&id=".$item['id'].">Supprimer</a></td>";
		$table.= "</tr>";
	}
	$table.= "</table>";
	if($theme=="auteur"){
		echo "<a href=ajout.php?recherche=auteur>Ajouter un auteur</a>";
	}
	elseif ($theme =="livre"){
		echo "<a href=ajout.php?recherche=livre>Ajouter un livre</a>";
	}
	else {
		echo "<a href=ajout.php?recherche=utilisateur>Ajouter un utilisateur</a>";
	}
	
	return $table;
	return $value;
}

?>