<?php
$e=$_POST['eleve'];
$exo=$_POST[$e.'1'];

if($exo=="Nouveau"){$exo=$_POST['nexo'];}
echo "l'exercice ".$exo." de ".$e;
echo "</br></br>";

$eexo.="\r\t\t<exercice>";
$eexo.="\r\t\t\t<date>".$_POST['date']."</date>";
$eexo.="\r\t\t\t<note>".$_POST['note']."</note>";
$eexo.="\r\t\t\t<duree>".$_POST['Duree']."</duree>";
$eexo.="\r\t\t\t<commentaire>".$_POST['Commentaire']."</commentaire>";
$eexo.="\r\t\t\t<resultat>a</resultat>";
$eexo.="\r\t\t\t<erreurs>";
$tab=explode('ø',$_POST['errs']);
for($i=1;$i<count($tab);$i++){
	$eexo.="\r\t\t\t\t<erreur>".substr($tab[$i],0,-2)."</erreur>";
}
$eexo.="\r\t\t\t</erreurs>";
$eexo.="\r\t\t</exercice>";


if(!file_exists("eleve/".$e)){if(!mkdir("eleve/".$e)){echo "probleme de droit, voir code";}} 
//Si ça ne marche pas, mettre www html cible.php et eleve avec comme droit 777
if(!file_exists("eleve/".$e."/".$exo.".xml")){
	echo "a faire";
	$file = fopen("eleve/".$e."/".$exo.".xml", "w");
	$envoi="<?xml version=\"1.0\" encoding=\"utf-8\"?>";
	$envoi.="\r<eleve>";
	$envoi.="\r\t<info>";
	$envoi.="\r\t\t<nom>".$_POST['nom']."</nom>";
	$envoi.="\r\t\t<prenom>".$_POST['prenom']."</prenom>";
	$envoi.="\r\t\t<classe>".$_POST['classes']."</classe>";
	$envoi.="\r\t\t<type>".$_POST['type']."</type>";
	$envoi.="\r\t\t<lien>".$_POST['lien']."</lien>";
	$envoi.="\r\t\t<correction>".$_POST['correction']."</correction>";
	$envoi.="\r\t\t<commentaire>".$_POST['Commentaire']."</commentaire>";
	$envoi.="\r\t\t<ecole>".$_POST['ecole']."</ecole>";
	$envoi.="\r\t</info>";
	$envoi.="\r\t<exercices>";
	$envoi.=$eexo;
	$envoi.="\r\t</exercices>";
	$envoi.="\r</eleve>";
	fwrite($file,$envoi);
	fclose($file);

	}else{
	echo "rajout</br>";
	$file = file_get_contents("eleve/".$e."/".$exo.".xml");
	$tf=explode("</exercices>",$file);
	$envoi=$tf[0].$eexo."\r</exercices>".$tf[1];
	$file = fopen("eleve/".$e."/".$exo.".xml", "w");
	fwrite($file,$envoi);
	fclose($file);
	echo $eexo;
	}

?>
