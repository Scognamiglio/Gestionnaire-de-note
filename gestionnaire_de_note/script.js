	avant=0; //La variable dois rester à cet endroit
	function select(a){ //Fonction qui permet d'afficher seulement une liste déroulante pour l'élève selectionner
		if(a=="eleve"){document.getElementsByName(avant)[0].className = "vide";} //Vide est une classe qui "supprime" un élément
		
		else{
			if (avant != "0"){
				document.getElementsByName(avant)[0].className = "vide";
			}
			document.getElementsByName(a)[0].className = "visible"; //visible annule la proprieté de vide
			avant=a;
		}
	}
	
	function ouvrir(b){ //Fonction qui permet de recharcher la page avec en mémoire, le fichier xml à utiliser
		if(b!="exercice"){
			
		
		var c=document.getElementsByName("eleve")[0].value+"/"+b; //Récupère le nom de l'élève et le nom de l'exercice
		location.href="index.php?e="+c; //Dans un lien, tous ce qui est après "?" sert de variable, donc j'indique que la variable e= le contenu de c
		}
	}

function test(a){ //Permet simplement de copié le contenu d'une div dans le press papier (div invisible)

var lien = a;
   var container = document.createElement("div");
   container.innerHTML = lien;
   container.style.opacity = 0 ;
   document.body.appendChild(container);

   var sel = window.getSelection();
   var rangeObj = document.createRange();
   rangeObj.selectNodeContents(container);
   sel.removeAllRanges();
   sel.addRange(rangeObj);

   if (document.execCommand('copy')) {
      alert("copié");
   }
   else {
      alert("retenter");
   }					
				}
function erreur(){
new_err=document.getElementsByName('err')[0].value;
if(new_err != ""){
	document.getElementsByName('errs')[0].value+="ø"+new_err+"\n";
}
}

function truc(){
b=document.getElementsByName('lenew')[0].value;
document.getElementsByName('lenew')[0].value="";

a=(document.getElementsByName('eleve')[0].innerHTML).split('<option>Nouv');
c=a[0]+"<option>"+b+"</option><option>Nouveau</option>";
document.getElementsByName('eleve')[0].innerHTML=c;
document.getElementsByName('Nouveau')[0].className = "vide";

tot=document.getElementsByName("total")[0].innerHTML;
tot=tot.split("<input class=")[0];
tot+='<div class="vide" name="'+b+'"><select onchange=\"verif(this.value);\" name="'+b+'1"><option>Exercice</option><option>Nouveau</option></select></div><input class=\"vide\" name=\"nexo\"></input>';

document.getElementsByName("total")[0].innerHTML=tot;

}

function verif(a){

if(a=="Nouveau"){
	document.getElementsByName('nexo')[0].className = "visible";
	}
else{
	document.getElementsByName('nexo')[0].className = "vide";
}

}

function sup(){
cont=document.getElementsByName('errs')[0].value.split("\n");

renvoi="";
for(i=0;i<cont.length-2;i++){

	renvoi+=cont[i]+"\n";
	}
document.getElementsByName('errs')[0].value=renvoi;
}

