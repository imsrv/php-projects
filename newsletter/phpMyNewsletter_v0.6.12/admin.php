<?
if (file_exists("include/config.inc.php")){
  include("include/config.inc.php");
}
else{ 
  header ("Location:include/chooselang.php");
}

require("include/fonction.php");
require("include/cls.php");

$news = new newsletter; 

// Get the newsletter config
$news->get_config($f_host,$f_db,$f_user,$f_passwd,$f_tableconfig); 

require("include/$news->langfile"); //include the langfile
if ($bye)
{
  setcookie("adminnews");
  setcookie("adminnewspass");
  header ("Location:admin.php");
  exit;
}

$auth1 = $HTTP_COOKIE_VARS["adminnews"];    

if($HTTP_COOKIE_VARS["adminnewspass"] == md5($news->admin_pass)) { $auth2=true;}
else {$auth2=false;}


$auth = $auth1 && $auth2;
if (!$auth)
{
  if ($formulaire)
    {
      if ($pass==$news->admin_pass)
        {
	  setcookie("adminnews", "true");
	  setcookie("adminnewspass",md5($news->admin_pass));
	  $ADMIN_MODE = true;
	}
      else
	{
	  echo "<body bgcolor=#FFFFFF><center><h3>".translate("Erreur ! Le mot de passe n'est pas valide")."</h3><br>";
	  echo "[<a href=".$HTTP_REFERER.">".translate("Retour")."</a>]<center></body>";
	  exit;      
	}
    }
    
  // Login form
  if (!$formulaire || $echec)
    {
      echo "<body bgcolor=\"#FFFFFF\" background=\"img/fond.png\" text=\"#FFFFFF\"  link=\"#D7DAD1\"  vlink=\"#D7DAD1\"  alink=\"#D7DAD1\" >
	<center><B>phpMyNewsletter : ".translate("Accès à l'administration")."</B><br>
	<br><BR><BR>

 <table width=\"400\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" bgcolor=\"#CCCCCC\" align=\"center\">
  <tr>
    <td>
      <div align=\"center\">
        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#8090A0\">
          <tr>
            <td align=\"center\" valign=\"middle\">

<img src=\"img/lock.gif\" align=\"middle\"><b><font size=4>".translate("Identification")."</font></b>
	<img src=\"img/lock.gif\" align=\"middle\"></center><br><BR>
	<form method=post action=admin.php>
      <div align=center>".translate("Mot de passe")."
      <input type=hidden name=formulaire value=ok>
      <input type=password name=pass size=20 maxlength=20>
      <br><BR><input type=submit name=Submit value=".translate("valider").">
      </div><BR></form>


	</TD></TR></TABLE></TD></TR></TABLE><BR><BR>
<CENTER><B>Powered by</B><BR> <IMG SRC=\"img/logo.png\"></CENTER>




</body>";
      exit;    
    }
  
}





/******** HACK  ******/
$limit=20;
/*********************/


//Mysql database connection
if (file_exists("include/config.inc.php")) 
{
  $mysql_link =  @MYSQL_CONNECT($news->host,$news->user,$news->passwd) OR DIE(translate("Impossible de trouver le serveur").MYSQL_ERROR());
  @mysql_select_db($news->db ,$mysql_link ) or die( translate("Impossible de trouver la base").MYSQL_ERROR());
}
$envoyer="";
$nonenvoyer="";
$i=0;
$nbr_abonne=0;

include("include/headeradm.inc.php");





switch($mode)
{
 case "ajout": //add a subscriber in the database
   {
     switch($go)
       {
       case "1":
	 {
	   if(EmailOK($addr))
	     {
	       if ($confirmer=="oui")
		 {
		   $existe = mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tablenews WHERE email='$addr'"));
		   if($existe) echo "<center><B>".translate("Erreur")." :</B><br>".translate("Déjà inscrit")."</center>";
		   else 
		     {
		       $hash = unique_id();
		       $sql=" INSERT INTO $news->tablenews (email,hash) VALUES ('$addr','$hash')";
		       $corpsmsg = urldecode(stripslashes("$news->bienvenue"));
		       $news->send_email($addr,$news->nomnews." : ".translate("Inscription"),$corpsmsg,"text","");
			      
		       if(!mysql_db_query($news->db,$sql))
			 echo "Erreur ! L' inscription n'a pas pu être effectuée ! Erreur renvoyée par le serveur : ".mysql_error()."<br>";
		       else
			 {
			   echo "<center><b>".translate("L'inscription s'est bien déroulée")."<b>
				<BR>".translate("Un mail de d'information va être envoyé").".<br>";
				
			 }	
			      
		     }
		      
		      
		 }
		  
	       else
		 {
		   $hash = unique_id();
		   $existe = mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tablenews WHERE email='$addr'"));
		   if($existe)  echo "<center><B>".translate("Erreur")." :</B><br>".translate("Déjà inscrit")."</center>";
		   else 
		     {
		       $sql=" INSERT INTO $news->tablenews (email,hash) VALUES ('$addr','$hash')";
		       if(!mysql_db_query($news->db,$sql))
			 echo translate("Erreur")." !".translate("Votre inscription n'a pas pu être effectuée")."!".translate("Erreur renvoyée par le serveur")." : ".mysql_error()."<br>";
		       else  echo "<br><center><b>".translate("L'inscription c'est bien déroulée").".</b>";
		     }
		 }
	     }
	   else echo "<br><br><center><b>".translate("Adresse Email non valide")."</b></center><br>";
	 }
	 break;
	
       default: 
	 include("include/ajout.html");
	 echo "	<img src=\"img/id.gif\" border=0 align=middle>&nbsp;
	<a href=\"admin.php?mode=import\">".translate("Importer un fichier texte dans la base de donnée")."</a>";
	 break;
       }
   }
   break;

  
  
 case "import": //import an email list in the database
   {
     switch ($go)
       {
       case "1":
	 {
	   if ($insert_file && $insert_file != "none") { 
	     
	     if(!file_exists("./TMP"))
	       mkdir("./TMP",0777);
	     else 
	       chmod("./TMP",0777);
	     
	     $import_file = "./TMP/import.txt";
	     if(move_uploaded_file($insert_file,$import_file ))
	       {
		 
		 //	   if(ereg("^php[0-9A-Za-z_.-]+$", basename($insert_file)))
		 if(!empty($insert_file) && $insert_file != "none" && ereg("^php[0-9A-Za-z_.-]+$", basename($insert_file)))
		   $liste = fread(fopen($import_file, "r"), filesize($import_file)); //pour NS et IE
		 
		 
		 $liste=ereg_replace("\n|\r|\n\r","\n",$liste);
		 $liste = explode( "\n",$liste);
		 
		 for($i=0;$i<sizeof($liste); $i++)
		   {
		     /* Ajouter un nouvel enregistrement dans la table */ 
		     $liste[$i]=trim($liste[$i]);
		     if(!empty($liste[$i])){
		       $hash = unique_id();
		       $query = "INSERT INTO $news->tablenews VALUES('$liste[$i]','$hash')"; 
		       $result= MYSQL_DB_QUERY($news->db,$query); 
		       if(mysql_error()) print $liste[$i]." : ".translate("Erreur")."  : ".mysql_error()."<br>";
		       else print $liste[$i]." : OK <BR>\n";
		     }

		   }
		 unlink($import_file);
		 echo "<br><br><center><b>".translate("Importation effectuée")."</b></center>";
	       }
	   
	   }
	   else echo "<br><br><center><b>".translate("Erreur")."</b></center>";

	   
	 }
	 break;
	 
       default:
	 {
	   echo "<br><center><img src=\"img/id.gif\" border=0 align=middle>&nbsp;
  <b>".translate("Importer un fichier texte dans la base de donnée")."</b>
  &nbsp;<img src=\"img/id.gif\" border=0 align=middle><center><br><br><br> <form action=\"admin.php\"
method=\"post\"  enctype=\"multipart/form-data\" name=\"importform\">
  <script language=\"javascript\">
  function Soumettre()
			{
			//if  (document.importform.insert_file.value==\"\") 
	                //alert(\"".translate("Tous les champs doivent être remplis")."\");		
			//else 
document.importform.fich.value=document.importform.insert_file.value;
document.importform.submit();
 	
			
			 }
		</script>
    		<input type=file name=\"insert_file\"><br><br>
		<input type=button value=\"Go !\" onclick=\"Soumettre()\">
		<input type=\"hidden\" name=\"mode\" value=\"import\">
		<input type=\"hidden\" name=\"go\" value=\"1\">
	<input type=\"hidden\" name=\"fich\" value=\"\">
		</form>";
	 }
	 break;
       }
   }
   break;
   

   
   
 case "envoi": //send a new message to the list
   {
     switch($msg)
       {
       case "valid":
	 {
	   $message2=nl2br($message);
	   echo "<center><h3>Valider votre message</h3></center><br>
		<table>
		<tr>
			<td>Sujet :</td><td>".stripslashes($sujet)."</td>
		</tr>
		<tr>	
		</table >
		Message :<br><table bgcolor=\"#F6FFD3\" width=100%><tr><td><FONT COLOR=\"#000000\">".stripslashes($message2)."</FONT></td></tr></table>
		<form method=post action=include/send.php><input type=hidden name=mode value=envoi><input type=hidden name=msg value=go>
           <input type=hidden name=sujet value=\"".$sujet."\"><input type=hidden name=message value=\"".urlencode($message)."\"><input type=hidden name=format value=".$format.">
        <input type=button value=\"<< ".translate("Retour")."\" onclick=\"javascript:history.go(-1)\"><input type=submit value=\"".translate("Envoyer le message")."\"></form>";
	   
	 }
	 break;
	 
       case "go":
	 echo "<center>Newsletter envoyée</center>";
	 if(file_exists("include/sending.log"))
	   include("include/sending.log");
	 break;
	 
       default:
	 {
	   print "
			<div align=\"center\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"79%\">
			    <tr>
			        <td width=\"868\" height=\"25\" align=\"left\" valign=\"top\" >
			            <p align=\"center\"><b><br><img src=\"img/mail.gif\" border=\"0\" align=\"middle\">&nbsp;".translate("Rédiger un nouveau message")."</b>&nbsp;<img src=\"img/mail.gif\" border=\"0\" align=\"middle\"></td>
			    </tr>
			    <tr>
			        <td width=\"868\" height=\"25\" align=\"left\" valign=\"top\"><p>&nbsp;</p>

				<form name=\"envoimail\" method=\"post\" action=\"admin.php\">
				<script language=\"javascript\">
				function Soumettre(){
				 if ( (document.envoimail.sujet.value==\"\") || (document.envoimail.message.value==\"\") )
			 	alert(\"".translate("Tous les champs doivent être remplis")."\");
				 else {
				document.envoimail.submit();
					 }
				 }
				</script>
			".translate("Sujet")." : <input type=\"text\" name=\"sujet\" value=\"".translate("Lettre d'information N°").$nbrnews."\" size=50 maxlength=50>   <br>
			Format : <input type=\"radio\" name=\"format\" value=\"text\" checked>".translate("Texte")." <input type=\"radio\" name=\"format\" value=\"html\">html   <br>
			<textarea name=\"message\" rows=30 cols=60></textarea><br>
			<input type=\"hidden\" name=\"mode\" value=\"envoi\"><input type=\"hidden\" name=\"msg\" value=\"valid\">
			<center><input type=\"button\" value=\"".translate("Appercu du message")."\" onclick=\"Soumettre()\"><input type=\"reset\" value=\"".translate("Réinitialiser")."\"></center>
			</form>
     
 	
		        </td>
			    </tr>
			</table></div>";
	 }
	 break;
       }
   }
   break;
   
   
   
   
 case "affiche": //display the subscribers list
   {
     if(!isset($debut)) $debut=0;
     $mysql_result = mysql_db_query( $news->db ,"SELECT * FROM $news->tablenews") OR print("ca plante");
     $nrows=mysql_num_rows($mysql_result);
     $mysql_result = mysql_db_query($news->db,"SELECT * FROM $news->tablenews order by email  limit $debut,$limit") OR print("ca plante");
     if($mysql_result)
       {
	 if($mysql_result!=0)
	   {
	     echo "<br><center><img src=\"img/address.gif\" border=\"0\" align=\"middle\">&nbsp;<b>".translate("Liste des abonnés")."</b>&nbsp;<img src=\"img/address.gif\" border=\"0\" align=\"middle\"></center>";		
	     
	     echo "<br>";
	     echo "<table align=center>";
	     while($row = mysql_fetch_row($mysql_result))
	       {      
		 $addr =			$row[0];
		 echo "<tr><td>".$addr."</td></tr>";
	       }
	     echo "<BR><tr><td><b>".translate("Nombre total d'abonnés")." : $nrows </b></td></tr></table>";
	     
	     /****************** Mise en place de la navigation. ************************************/
	     $nombre=ceil($nrows/($limit));
	     echo "<center>";
	     if($debut>0) echo "<a href=admin.php?mode=affiche&debut=".($debut-($limit))."><img src=\"img/aleft.gif\" border=0 align=\"middle\"></a>  ";	
	     if ($nombre>1) 
	       for($i=1; $i<=$nombre; $i++) echo "<a href=admin.php?mode=affiche&debut=".(($i-1)*($limit)).">".$i."</a> ";
	     if(($debut+($limit))<$nrows)  echo "<a href=admin.php?mode=affiche&debut=".($debut+($limit))."><img src=\"img/aright.gif\" border=0 align=\"middle\"></a>";
	     echo "</CENTER>";		
	   }
	 else echo "<br><center>".translate("Vous n'avez pas d'abonnés")."</center>";		
       }
     else print("erreur lors de la requete SQL");
     
   }
   break;
   
   
   
   
 case "del": //delete subscriber from the database
   {
     if(!isset($debut)) $debut=0;
     echo "<br><center><img src=\"img/del.gif\" border=\"0\" align=\"middle\">&nbsp;
     <b>".translate("Supprimer des abonnés")."</b>&nbsp;<img src=\"img/del.gif\" border=\"0\" align=\"middle\"></center><br>";
     
     
     switch($delete)
       {
       case "1":
	 {
	   while (list($key, $tab) = each($HTTP_POST_VARS)) 
	     while (list($key, $val) = @@each($tab)) 
	       $mysql_result = mysql_db_query( $news->db ,"DELETE  FROM $news->tablenews where email='$val' ") OR print("ca plante");
	   if($mysql_result==0) print("<Center><b>".translate("Erreur")."</center> $mysql_result");
	   else echo "<br><center><B>".translate("Les abonnés sélectionnés ont été supprimé")."</B><br></center>";
	   
	 }
	 break;
	 
       default:
	 {
	   $mysql_result = mysql_db_query($news->db ,"SELECT * FROM $news->tablenews") OR print("ca plante");
	   $nrows=mysql_num_rows($mysql_result);
	   $mysql_result = mysql_db_query($news->db,"SELECT * FROM $news->tablenews limit $debut,$limit") OR print("ca plante");
	   if($mysql_result)
	     {
	       if($mysql_result!=0)
		 {
		   $nbabo=mysql_num_rows($mysql_result);
		   if ($nbabo>0) 
		     {
		       print("<form action=admin.php method=post> ");
		       print("<input type=hidden name=mode value=del><input type=hidden name=delete value=1>");
		       echo "<center><b><br>".translate("Sélectionner les abonnés à supprimer")."</b><br><br></center><table align=center>";
		       while($row = mysql_fetch_row($mysql_result))
			 {      
			   $addr =			$row[0];
			   echo "<tr><td><input type=checkbox name=supadr[] value=$addr>$addr<BR></td></td>";
			 }
		       echo "<tr><td><input type=\"submit\" value=\"".translate("Supprimer les abonnés sélectionnés")."\"></td></tr></table>";
		       print("</form>");
		    
		    
		    
		       /****************** Mise en place de la navigation. ************************************/
		       $nombre=ceil($nrows/($limit));
		       echo "<center>";
		       if($debut>0) echo "<a href=admin.php?mode=del&debut=".($debut-($limit))."><img src=\"img/aleft.gif\" border=0 align=\"middle\"></a>  ";	
		       if ($nombre>1) 
			 for($i=1; $i<=$nombre; $i++)
			   echo "<a href=admin.php?mode=del&debut=".(($i-1)*($limit)).">".$i."</a> ";
		       if(($debut+($limit))<$nrows) echo "<a href=admin.php?mode=del&debut=".($debut+($limit))."><img src=\"img/aright.gif\" border=0 align=\"middle\"></a>";
		       echo "</CENTER>";		
		     }
		   else echo "<center><b>".translate("Vous n'avez pas d'abonnés")."</b></center>";
		 }
	     }
	   
	 }
	 break;
       }
   }
   break;

 case "viewlog": //display newsletter logs
   {
     if(!isset($debut)) $debut=0;
     echo "<br><center><img src=\"img/log.gif\" border=\"0\" align=\"middle\">&nbsp;
	<b>".translate("Logs de phpMyNewsletter"). "</b>&nbsp;<img src=\"img/log.gif\" border=\"0\" align=\"middle\">
	</center><br>";
     
     $mysql_result = mysql_db_query($news->db,"SELECT * FROM $news->tablelog") OR print("ca plante");
     $nrows=mysql_num_rows($mysql_result);
     $mysql_result = mysql_db_query($news->db,"SELECT * FROM $news->tablelog order by date limit $debut,$news->limitlog") OR print("ca plante");
     if($mysql_result)
       {
	 echo "<center><table cellspacing=0 cellpadding=5 border=0>
		<tr align=center bgcolor=#8090A0>
		<td><b><font size=3 color=#FFFFFF face=verdana> Date - ".translate("Heure")." </font></b></td>
		<td><b><font size=3 color=#FFFFFF face=verdana> Format </font></b></td>
		<td><b><font size=3 color=#FFFFFF face=verdana> ".translate("Sujet")." </font></b></td>
		<td><b><font size=3 color=#FFFFFF face=verdana> Message </font></b></td>
		</tr>";
	 while($row = mysql_fetch_row($mysql_result))
	   {      
	     echo "<tr>
				<td align=center valign=top>".$row[1]."</td>
				<td align=center valign=top><img src=\"img/".$row[2].".gif\" alt=\"format : ".$row[2]."\"></td>
				<td valign=top>".stripslashes($row[3])."</td>
				<td>".nl2br(stripslashes($row[4]))."<td>
				</tr>"; 
	   }
	 echo "</table><center><br>";
		
	 /****************** Mise en place de la navigation. ************************************/
	 $nombre=ceil($nrows/($news->limitlog));
		
	 if($debut>0) echo "<a href=admin.php?mode=viewlog&debut=".($debut-($news->limitlog))."><img src=\"img/aleft.gif\" border=0 align=\"middle\"></a>  ";	
	 if ($nombre>1) 
	   for($i=1; $i<=$nombre; $i++)
	     echo "<a href=admin.php?mode=viewlog&debut=".(($i-1)*($news->limitlog)).">".$i."</a> ";
	 if(($debut+($news->limitlog))<$nrows)
	   echo "<a href=admin.php?mode=viewlog&debut=".($debut+($news->limitlog))."><img src=\"img/aright.gif\" border=0 align=\"middle\"></a>";
	 echo "</CENTER>";
       }
     
     
     
   }
   break;
   
 case "config": //configure the newsletter
   {
     echo "<br><center><img src=\"img/config.gif\" border=\"0\" align=\"middle\">&nbsp;
	<b>".translate("Configuration de phpMyNewsletter")."</b>&nbsp;
	<img src=\"img/config.gif\" border=\"0\" align=\"middle\"></center>";	
     echo "<center><a href=admin.php?mode=config&op=conf>".translate("Editer la configuration")."</a>
	 | <a href=admin.php?mode=config&op=msg>".translate("Editer les messages de bienvenue ...")."</a></center>";
     
     switch($op)
       {
       case "conf": 
	 {
	   
	   switch($ok)
	     {
	     case "1": echo "<p align=center><b>".translate("Mise à jour de la configuration effectuée").".</b></p>"; 
	       /*********** Création du fichier de conf  **************/	
	       $configfile="<? \n$"."f_host=\"".$host."\";";
	     $configfile.="\n$"."f_user=\"".$user."\";";
	     $configfile.="\n$"."f_passwd=\"".$passwd."\";";	
	     $configfile.="\n$"."f_db=\"".$db."\";";
	     $configfile.="\n$"."f_tableconfig=\"".$tableconfig."\";";
	     $configfile.="\n ?>";
	     if(is_writable("include/"))
	       {
		 $fc = fopen("include/config.inc.php", "w");
		 $w = fwrite ($fc, $configfile ); 
	       }
	     
	     else echo "<center>".translate("Créé le fichier include/config.inc.php, puis Collez les lignes suivantes dans ce fichier.")."<BR><textarea rows=7 cols=40 readonly>$configfile</textarea></center>";
	     
	       
	       
	     $requete ="update $tableconfig set";
	     $requete.=" nomnews='$nomnews', hebergeur='$hebergeur', fromc='$fromonline@$domaine',";
	     $requete.=" fromonline='$fromonline', limitconf='$limitconf', host='$host', user='$user' ,";
	     $requete.=" passwd='$passwd', db='$db', tablenews='$tablenews', tabletemp='$tabletemp',";
	     $requete.=" tablelog='$tablelog', tableconfig='$tableconfig', admin_pass='$admin_pass',";
	     $requete.=" limitlog='$limitlog', url='$url', pathtopmn='$pathtopmn', langfile='$langfile', ";
	     $requete.=" validation='$validation' where id=1";
	     $mysql_result = mysql_db_query( $db ,$requete) OR print("Mise à jour de la table : ca plante");
	     break;
	       
	     default: include("include/conf.php") ;break;
	     }
	 }break;
	 
	 
       case "msg" : 
	 {
	   switch($ok)
	     {
	     case "1" :  echo "<p align=center><b>".translate("Mise à jour de la configuration effectuée").".</b></p>";
	       $welcome_msg=addslashes($welcome_msg);
	     $welcome_subj = addslashes($welcome_subj);
	     $sub_msg=addslashes($sub_msg);
	     $pied=addslashes($pied);
	     $requete ="update $news->tableconfig set";
	     $requete.=" welcome_msg = '$welcome_msg' , welcome_subj = '$welcome_subj' , sub_msg='$sub_msg' , pied='$pied'";
	     $requete.="where id=1";
	     $mysql_result = mysql_db_query( $news->db ,$requete) OR print("Mise à jour de la table : ca plante");
	     break;

	     default: 
	       include("include/mesgconf.php");
	       break;
	     }
	 }
       default: 
	 break;				
       }	
   }
   break;
   

 case "export":
   {
     
     echo "<br><center><img src=\"img/export.gif\" border=\"0\" align=\"middle\">&nbsp;
	<b>".translate("Exporter les abonnés")."</b>&nbsp;
	<img src=\"img/export.gif\" border=\"0\" align=\"middle\"></center>";	
     
     echo "<BR><BR><center>
	<FORM action=\"include/export.php\" method=\"post\">
<input type=hidden name=pass value=\"".$news->passwd."\">
<input type=hidden name=user value=\"".$news->user."\">
<input type=hidden name=host value=\"".$news->host."\">
<input type=hidden name=db value=\"".$news->db."\">
<input type=hidden name=tableconfig value=\"".$news->tableconfig."\">
       <br><BR>	<img src=\"img/id.gif\" border=0 align=middle><BR><input type=submit name=Submit value=".translate("exporter").">
</FORM></CENTER>";
     
     
     

   }

   break;










 default:
   {
     print "<p align=\"center\">
		 <font face=\"Arial,Helvetica\" size=\"4\" color=\"black\">
		 <img src=\"img/admin.gif\" border=\"0\" align=\"middle\">&nbsp;<b>".translate("Administration")."&nbsp;</b>
		 <img src=\"img/admin.gif\" border=\"0\" align=\"middle\"></font></td>";
     
     /************************* Flush DE LA TABLE TEMP **************************************/
     $date = date("Y/m/d");
     $elts = explode("/", $date);
     $an		= $elts[0];
     $mois	= $elts[1];
     $jour   = $elts[2];
     $avant = mktime(0, 0, 0, $mois, $jour - $news->limitconf, $an);
     $avant= date("Ymd", $avant);
     $sql= "DELETE FROM $news->tabletemp where date < '$avant'";
     
     if(!mysql_db_query($news->db,$sql))	 echo "<center> Erreur lors du flush de la table temp</center>";
     
   }
   break;
   
}

   




include("include/footeradm.inc.php");
?>
