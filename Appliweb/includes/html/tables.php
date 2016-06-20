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
<<<<<<< HEAD
			if($theme=='auteur' || $theme=='editeur') {
			$table.= "<td><a href=index.php?recherche=$theme&action=lien&id=".$item['id'].">".$value."</a></td>";
			}
			elseif($theme=='livre'){
			$table.= "<td><a href=index.php?recherche=$theme&action=lien&id=".$item['id_auteur'].">".$value."</a></td>";
			}
			else{
			$table.= "<td>$value</td>";
			}
=======
			$table.= "<td><a href=index.php?recherche=$theme&action=lien&id=".$item['id'].">".$value."</a></td>";
>>>>>>> origin/master
		}
			if($_SESSION['user']['niveau'] < 2)
		{
			$table.="<td><a href=modif.php?recherche=$theme&id=".$item['id'].">Modifier</a></td>";
			$table.="<td><a href=index.php?recherche=$theme&action=suppr&id=".$item['id'].">Supprimer</a></td>";
		}
		$table.= "</tr>";
	}
	$table.= "</table>";
	if($theme){
		echo "<a href=ajout.php?recherche=$theme>Ajouter un $theme</a>";
	}	
	return $table;
	return $value;
}

function getFiche($array) 
{	
	$theme = isset($_GET['recherche']) ? $_GET['recherche'] : 'auteur' ;
	$table = "<table>";
	foreach ($array as $item)
	{	
		$table.= "<tr>";
		foreach ($item as $key => $value) {
			$table.= "<td>$value</td>";
		}
			if($_SESSION['user']['niveau'] < 2)
		{
			$table.="<td><a href=modif.php?recherche=$theme&id=".$item['id'].">Modifier</a></td>";
			$table.="<td><a href=index.php?recherche=$theme&action=suppr&id=".$item['id'].">Supprimer</a></td>";
		}
		$table.= "</tr>";
	}
	$table.= "</table>";	
	return $table;
}

?>