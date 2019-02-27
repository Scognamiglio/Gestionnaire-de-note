<html>
	
	<head>
		<link rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
<?php
		
		$fichier = 'eleve/'.$_GET['e'].".xml"; ///Indication du fichier à lire pour le code
		$xml = simplexml_load_file($fichier);
		$nbr=count($xml->exercices->exercice);

		for($i=0;$i<$nbr;$i++){$tab[]=$i;}

		for($i2=1;$i2<$nbr;$i2++){
			$d2 = new DateTime($xml->exercices->exercice[$tab[$i2]]->date);
			$d = new DateTime($xml->exercices->exercice[$tab[$i2-1]]->date);
			if ($d > $d2){
				$a=$tab[$i2-1];
				$tab[$i2-1]=$tab[$i2];
				$tab[$i2]=$a;
				$i2=0;
			}
		}
	echo "<form method=\"post\" action=\"cible_m.php\">";
	echo "<input name=\"ele\" class=\"vide\" value=\"".$fichier."\"></input>";
	echo "<table>";
	echo "<tr><td><label>Classes</label></td><td><input value=\"".$xml->info->classe."\"name='classe'></input></br></td></tr>";
	echo "<tr><td><label>Lien</label></td><td><input name='lien' value=\"".$xml->info->lien."\"></input></br></td></tr>";
	echo "<tr><td><label>Correction</label></td><td><input name='cor' value=\"".$xml->info->correction."\"></input></br></td></tr>";
	echo "</table>";



	echo "<select onchange=\"select(this.value);\" name='coucou'>";
	
	for($i=0;$i<$nbr;$i++){
		echo "<option value=\"tab".$i."\" name= \"exo".$i."\">Exercice du ".$xml->exercices->exercice[$tab[$i]]->date."</option>";
	}
	echo "</select></br></br>";
	
	for($i=0;$i<$nbr;$i++){
		$d=$xml->exercices->exercice[$tab[$i]]->date;
		echo "<table class=\"vide\" name=\"tab".$i."\">";
		echo "<tr><td><label>Date</label></td><td><input name='date".$i."' value=\"".$xml->exercices->exercice[$tab[$i]]->date."\"></input></br></td></tr>";
		echo "<tr><td><label>Note</label></td><td><input name='note".$i."' value=\"".$xml->exercices->exercice[$tab[$i]]->note."\"></input></br></td></tr>";
		echo "<tr><td><label>Duree</label></td><td><input name='Duree".$i."' value=\"".$xml->exercices->exercice[$tab[$i]]->duree."\"></input></br></td></tr>";
		echo "<tr><td><label>Commentaire</label></td><td><input name='Comm".$i."' value=\"".$xml->exercices->exercice[$tab[$i]]->commentaire."\"></input></br></td></tr>";
		echo "<tr><td><label>Resultat</label></td><td><input name='Res".$i."' value=\"".$xml->exercices->exercice[$tab[$i]]->resultat."\"></input></br></td></tr>";
		echo "</table>";
		
	}echo "<Button>Envoi</Button></form>";
?>
</body>
</html>
