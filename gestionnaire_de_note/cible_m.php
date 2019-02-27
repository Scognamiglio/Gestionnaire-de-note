<?php





		$xml = simplexml_load_file($_POST['ele']);
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
$v=substr($_POST['coucou'],3,4);



$d=$xml->exercices->exercice[$tab[explode("tab",$_POST['coucou'])[1]]]->date;



$file = file_get_contents($_POST['ele']);
	
$a=explode("<exercice>",explode("<exercices>",$file)[1]);

$c=explode(" ",$d);


for($i=0;$i<count($a);$i++){

	if(strstr($a[$i],$c[0]) && strstr($a[$i],$c[1]) ){
		$change=$i;
	}

}

$eexo.="\r\t\t\t<date>".$_POST['date'.$v]."</date>";
$eexo.="\r\t\t\t<note>".$_POST['note'.$v]."</note>";
$eexo.="\r\t\t\t<duree>".$_POST['Duree'.$v]."</duree>";
$eexo.="\r\t\t\t<commentaire>".$_POST['Comm'.$v]."</commentaire>";
$eexo.="\r\t\t\t<resultat>".$_POST['Res'.$v]."</resultat>";
$eexo.="\r\t\t\t<erreurs>\r\t\t\t\t<erreur></erreur>\r\t\t\t</erreurs>";
$eexo.="\r\t\t</exercice>";

$a[$change]=$eexo;
$final=explode("<exercices>",$file)[0]."\r\t<exercices>";

for($i=1;$i<count($a);$i++){
	$final.="\r\t\t<exercice>".$a[$i];

	}
if(count($a)==($change+1)){$final.="\r\t</exercices>\r</eleve>";}

$files = fopen($_POST['ele'], "w");
fwrite($files,$final);
fclose($files);



?>
