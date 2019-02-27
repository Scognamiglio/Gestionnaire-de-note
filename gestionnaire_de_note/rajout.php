<html>
<head>
	<title>Rajout</title>

<script type="text/javascript" src="script.js"></script>
<link rel="stylesheet" href="style.css" />


<body>

<form method="post" action="cible.php">
<?php
	$MyDirectory = opendir(getcwd()."/eleve") or die('Erreur');
	///Création de la liste déroulante pour les élèves
	echo "<select onchange='select(this.value);' name='eleve'><option>eleve</option>";
	while("" != $Entry = @readdir($MyDirectory)){
		if(($Entry != ".") && ($Entry !="..")){
			echo "<option>".$Entry."</option>";
			$tabi[]=$Entry;
		}
	}
	echo "<option>Nouveau</option>";
	echo "</select>";
	echo "<span class='vide' name='Nouveau'><input name=\"lenew\"></input><input type=\"button\" onclick='truc()' value=\"rajouter\"></input></span>";
	
	

	///Lecture et stockage de tous les exercices.
	for($i=0;$i<count($tabi);$i++){
		$MyDirectory2 = opendir(getcwd()."/eleve/".$tabi[$i]);
		$chaine="";
		for($i2=0;"" != $Entry = @readdir($MyDirectory2);$i2++){
			if(($Entry != ".") && ($Entry !="..")){
				$chaine.=$Entry."+";	
			}	
		}
		$tabi2[$i]=substr($chaine,0,-1);
	}
	
	///Création des listes déroulantes (en display) pour les exercices.
	echo "<div name=\"total\">";
	for($i=0;$i<count($tabi2);$i++){
		
		echo "<div class=\"vide\" name=\"".$tabi[$i]."\"><select onchange='verif(this.value);' value=\"exercice\" name=\"".$tabi[$i]."1\"><option> exercice</option>";
		$cas=explode("+",$tabi2[$i]);
		for($i2=0;$i2<count($cas);$i2++){
			echo "<option>".substr($cas[$i2],0,-4)."</option>";
		}
		echo "<option>Nouveau</option>";	
		echo "</select></div>";
		
	}
	echo "<input class=\"vide\" name=\"nexo\"></input>";
	echo "</div>";
	
?>
</br>

</br></br>
<table>
<caption><abbr title="a laisser vide si deja compl&eacute;t&eacute; ant&egrave;rieurement pour cet eleve, toute modification ecrasera les anciennes informations">Partie information<abbr></caption>
<tr><td><label>Nom</label></td><td><input name="nom"></input></td></tr>
<tr><td><label>prenom</label></td><td><input name="prenom"></input></td></tr>
<tr><td><label>classes</label></td><td><input name="classes"></input></td></tr>
<tr><td><label>Type</label></td><td><input name="type"></input></td></tr>
<tr><td><label>Lien</label></td><td><input name="lien"></input></td></tr>
<tr><td><label>Correction</label></td><td><input name="correction"></input></td></tr>
<tr><td><label>Commentaire</label></td><td><input name="Commentaire"></input></td></tr>
<tr><td><label>Ecole</label></td><td><input name="ecole"></input></td></tr>
</table>
</br></br></br>
<table>
<caption>Partie exercice</caption>
<tr><td><label>date</label></td><td><input type="date" name="date"></input></td></tr>
<tr><td><label>note</label></td><td><input name="note"></input></td></tr>
<tr><td><label>Duree</label></td><td><input name="Duree"></input></td></tr>
<tr><td><label>Commentaire</label></td><td><input name="Commentaire"></input></td></tr>
<tr><td><label>Nombre d'erreur</label></td><td><input name="nbr_err"></input></td></tr>
<tr><td><label>Erreur</label></td><td><input name="err"></input></td>
<td><input type="button"  value="Rajout" onclick='erreur();'></input></td>
<td><input type="button"  value="suppr" onclick='sup();'></input></td>
</tr>
</table>
</br></br></br>
Erreurs</br>

<textarea name="errs" readonly="readonly"></textarea>
</br></br>
<button>Cr&eacute;er</button>


</form>

</body>
</html>
