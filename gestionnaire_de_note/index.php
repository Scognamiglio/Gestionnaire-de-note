<?php
	if ($_GET['e']!=""){
		$fichier = 'eleve/'.$_GET['e'].".xml"; ///Indication du fichier à lire pour le code
		$xml = simplexml_load_file($fichier);
		$nbr=count($xml->exercices->exercice);
	}
	
	$MyDirectory = opendir(getcwd()."/eleve") or die('Erreur');

?>	

<html>
	
	<head>
		<link rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>

<?php

	echo "<p>Projet stage</p>";

	///Création de la liste déroulante pour les élèves
	echo "<select onchange='select(this.value);' name='eleve'><option>eleve</option>";
	while("" != $Entry = @readdir($MyDirectory)){
		if(($Entry != ".") && ($Entry !="..")){
			echo "<option>".$Entry."</option>";
			$tabi[]=$Entry;
		}
	}
	echo "</select>";
	
	

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
	for($i=0;$i<count($tabi2);$i++){
		
		echo "<div class=\"vide\" name=\"".$tabi[$i]."\"><select onchange='ouvrir(this.value);'><option> exercice</option>";
		$cas=explode("+",$tabi2[$i]);
		for($i2=0;$i2<count($cas);$i2++){
			echo "<option>".substr($cas[$i2],0,-4)."</option>";
		}
		echo "</select></div>";
	}
	if ($_GET['e']!=""){
		
		///Création de option d'importation (rapport, correction, énonçé)
		echo "<div class='btn'>";
		echo "<a href=\"".$xml->info->lien."\" download=\"énonçé\">énonçé</a>";
		echo "</br></br>";
		echo "<a href=\"".$xml->info->correction."\" download=\"corrigé\">corrigé</a>";
		echo "</div>";

		///Calcul de la moyenne général de l'élève
		$eleve=explode("/",$_GET['e'])[0];
		$exercices=explode("+",$tabi2[array_search($eleve,$tabi)]);
		$moy_f=0;
		for($i=0;$i<count($exercices);$i++){
			$xml2 = simplexml_load_file("eleve/".$eleve."/".$exercices[$i]);
			$nbr2=count($xml2->exercices->exercice);
			$moy=0;
			for($i2=0;$i2<$nbr2;$i2++){
					$note=$xml2->exercices->exercice[$i2]->note[0];
					$moy+=explode("/",$note)[0];
				}
				$moy_f+=round($moy/$nbr2,2);
		}
		$moy_f=round($moy_f/count($exercices),2);

		///Calcul de la moyennes de tous les élèves sur l'exercice
		$exercice=explode("/",$_GET['e'])[1];

		$chaine="";
		for($i=0;$i<count($tabi);$i++){
		
			$MyDir = opendir(getcwd()."/eleve/".$tabi[$i]);
			for($i2=0;"" != $Entry = @readdir($MyDir);$i2++){
				if($Entry == $exercice.".xml"){
					$pris[]=$tabi[$i];	
					}	
			}
		
	}	
		for($i=0;$i<count($pris);$i++){
			$xml2 = simplexml_load_file("eleve/".$pris[$i]."/".$exercice.".xml");
			$nbr2=count($xml2->exercices->exercice);
			$moy=0;
			for($i2=0;$i2<$nbr2;$i2++){
					$note=$xml2->exercices->exercice[$i2]->note[0];
					$moy+=explode("/",$note)[0];
				}
			$moy_eleves+=round($moy/$nbr2,2);
		}
			$moy_eleves=round($moy_eleves/count($pris),2);
		
		///Trie des exercices par ordre chronologique.
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
		///Ligne de texte affiché avec des informations
		echo "<p>exercice de <b>".$xml->info->type."</b> de l'élève <b>".$xml->info->nom." ".$xml->info->prenom." </b>en classe de <b>".$xml->info->classe."</b>";
		echo "</br></br>";
		echo "La moyenne de la totalité des exercices est de ".$moy_f." sur ".explode("/",$xml->exercices->exercice[0]->note)[1];
		echo "</br></br>";
		echo "Le nombre d'exercices fait ".$nbr." avec comme dernière note ".$xml->exercices->exercice[$tab[$nbr-1]]->note;



	///Création du graphique en fonction des notes.
	echo "<table class='test'><tr>";
	echo "</br></br></br>20/20";
	$moy=0;
	for($i=0;$i<$nbr;$i++){
		$note=$xml->exercices->exercice[$tab[$i]]->note[0];
		$res=explode("/",$note)[0]/explode("/",$note)[1]*300;
		$moy=$moy+explode("/",$note)[0];
	#Je récupère la valeur de la note, avant de la séparé par le /, puis je divise la note par la note max, puis je multiplie par 30, pour avoir une valeur à utiliser comme hauteur dans le tableau.

		if($moy_eleves < $note == 1)	{$col="green";}
		else if($note==0)		{$res="300";$col="white";}
		else				{$col="blue";}
		///// Gestion des erreurs dans presse papier
		$nbr_err=0;
		$erreurs="</br></br>Les erreurs sont</br>";
		for ($i2=0;$i2<count($xml->exercices->exercice[$tab[$i]]->erreurs->erreur);$i2++){
			if($xml->exercices->exercice[$tab[$i]]->erreurs->erreur[$i2]!=""){$nbr_err++;}
			$erreurs.=$xml->exercices->exercice[$tab[$i]]->erreurs->erreur[$i2]."</br>";
			}

		///Création du commentaire quand on laisse la souris sur un des batons du graphique
		$a="note:".$xml->exercices->exercice[$tab[$i]]->note." \ndurée:".$xml->exercices->exercice[$tab[$i]]->duree."\ndate:".$xml->exercices->exercice[$tab[$i]]->date."\nExercice fait:".$xml->exercices->exercice[$tab[$i]]->resultat."\nNombre erreur:".$nbr_err."\nCommentaire:".$xml->exercices->exercice[$tab[$i]]->commentaire; 


		echo "<td valign='bottom' ><abbr title='".$a."\n\nCliquer sur le graphique pour copier les informations.";

		
		////
		echo "'><div onclick='test(\"".str_replace("\n","</br>",$a).$erreurs."\");' style='background-color:".$col.";height:".$res.";'</div></abbr></td>"; 
		#voir script.js pour copié coller
	}
	echo "</tr>";
	///Création des informations en dessous du grapiques (date et heure)
	for($i=0;$i<$nbr;$i++){
		$date=$xml->exercices->exercice[$tab[$i]]->date;
		echo "<td>".str_replace(" ","</br>",$date)."</td>";
		}
	echo "</table>";
	
	echo "La moyenne pour cet exercice est de ".round($moy/$nbr,2)." et celle de classe est ".$moy_eleves." donc il a ".(round($moy/$nbr,2)-$moy_eleves)." points de différence";
	}
echo "</br></br><input type=\"button\" value=\"modifier\" OnClick=\"window.location.href='modif.php?e=".$_GET['e']."'\" />";



?>


<!--  
apt-get install libapache2-mod-php5
apt-get install phpmyadmin

!!!IMPORTANT!!! faire chmod -R 777 /var/www au moins fois pour ça fonctionne.!!!IMPORTANT!!!

Je ne sais plus le quel à bien fait fonctionner le tout.

utiliser un tableau pour les graphiques
-->
