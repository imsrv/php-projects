<?
$path=""; 	// Si vous voulez include le formulaire dans une autre page mettez ici le chemin jusqu'a phpMyNewsletter
		// exemple : si on inclus le formulaire dans index.php à la racine et que phpMyNewsletter est dans 
		// le repertoire tools/newsletter, $path="tools/newsletter/"; 
		// Sinon ne rien mettre.
		//
		//If you want to include this form in an other page, just put in $path the path to form.php
		//egs: if you want to include form.php in index.php at the server root set when phpMyNewsletter
		//is installed in tools/newsletter/  :   $path="tools/newsletter/"; 
		//Else, leave $path empty;
		


include($path."include/config.inc.php");  /// modifier ici si vous desirez faire un include de ce fichier dans un autre.
include($path."include/cls.php");
$news = new newsletter;
$news->get_config($f_host,$f_db,$f_user,$f_passwd,$f_tableconfig);
include($path."include/$news->langfile");
$news->showsubscribers=1;
if($news->showsubscribers){
 $sql="SELECT count(email) FROM $news->tablenews";
 $mysql_result = mysql_db_query( $news->db ,$sql) OR print(MYSQL_ERROR());
 $row = mysql_fetch_row($mysql_result);
 $sub = $row[0]>1 ? "inscrits" : "inscrit";
 echo $row[0]." ".translate($sub);
}
echo "
	<script language=\"javascript\">
		function Submitform()
			{
		

			if  (document.sub.addr.value=='') alert(\"".translate("Adresse Email non valide")."\");
			else 
				{
				if ( ((document.sub.addr.value.indexOf('@',1))==-1)||(document.sub.addr.value.indexOf('.',1))==-1 )
				      alert(\"".translate("Adresse Email non valide")."\");
      				 
				else 	document.sub.submit();
			 	}
			
			 }
		</script>


<p>&nbsp;
            <form name=sub method=post action=\"".$path."ml.php\">
            <p>".translate("Adresse e-mail")." <input type=text name=addr 
             maxlength=250 size=30>

 </p>
            <p><input type=radio name=type value=inscription checked> ".translate("Inscription")."<input type=radio name=type value=desinscription> ".translate("Désinscription")."</p>
            <p><input type=button  value=\"Go !\" onclick=Submitform()></form>
";     


 
?>
