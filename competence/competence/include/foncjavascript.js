<script language="JavaScript" type="text/javascript">
//---------------------
// fonction de gestion du pointeur sur table
//---------------------
/**  cette fonction provient de phpmyadmin 
 * Sets/unsets the pointer and marker in browse mode
 *
 * @param   object   the table row
 * @param   string   the action calling this script (over, out or click)
 * @param   string   the default background color
 * @param   string   the color to use for mouseover
 * @param   string   the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
//-------------------------------
// verif de saisie de formulaire création user
//
//  on ne vérifie que les deux password sont identiques
//------------------------------
  function vformlog()
{
	msgerr="";
// test si champs obligatoires sont saisis
   for (c = 1; c < 6; c++)
	{ 
	 if (document.f_user.elements[c-1].value ==""){msgerr =msgerr + "champ "+c+" obligatoire\n"} 
	}
// test si les deux mots de passe sont identiques	
	if (document.f_user.pass1.value != document.f_user.pass2.value)
	{msgerr =msgerr + "les deux mots de passe ne sont pas identiques\n";} 
// test si des erreurs trouvées
  if (msgerr =="")
	 {return true;}
	else
	 {
	 alert(msgerr);
	 return false;
	 } 	 
}	

//-------------------------------
// verif de saisie de formulaire création user
//
//  on verifie que tous les champs sont saisis
//------------------------------
  function veriform(myform)
{
	msgerr="";
// test si champs obligatoires sont saisis
   for (c = 1; c < myform.elements.length; c++)
	{ 
	 if (myform.elements[c-1].value ==""){msgerr =msgerr + "champ "+myform.elements.name+" obligatoire\n"} 
	}
// test si des erreurs trouvées
  if (msgerr =="")
	 {return true;}
	else
	 {
	 alert(msgerr);
	 return false;
	 } 	 
}

/*  
Made by Martial Boissonneault © 2002 http://getElementById.com/
May be used and changed freely as long as this msg is intact
Visit http://getElementById.com/ for more free scripts and tutorials.
*/

function show(id)
{

  document.getElementById(id).style.visibility = "visible";
}

function hide(id)
{
		document.getElementById(id).style.visibility = "hidden";
}

function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)){ 
		src.style.cursor = 'hand'; 
		src.bgColor = clrOver; 
	} 
} 
function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)){ 
		src.style.cursor = 'default'; 
		src.bgColor = clrIn; 
	} 
} 
</script>