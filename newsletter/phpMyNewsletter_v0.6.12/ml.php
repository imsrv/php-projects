<?
//PHPMYNEWSLETTER v0.6 par Grégory KOKANOSKY <gregory.kokanosky@free.fr>
require("include/config.inc.php");
require("include/fonction.php");
require("include/cls.php");

$news = new newsletter;
$news->get_config($f_host,$f_db,$f_user,$f_passwd,$f_tableconfig);

require("include/$news->langfile");
$mysql_link =  MYSQL_CONNECT("$news->host","$news->user","$news->passwd") OR DIE("Unable to connect to database !!");
@mysql_select_db($news->db ,$mysql_link ) or die( "Unable to select database ??");

if (($news->hebergeur)=="online") $news->from=$news->fromonline;
if(empty($addr)) header ("Location:./");
echo "<html><head>  <title>phpMyNewsletter v0.6</title></head><body bgcolor=white text=#000000>";

if(!empty($addr))
{
  if(EmailOK($addr))
    {
      
      switch($news->validation) {
      case "1":
	{
	  /************** DEBUT AVEC VALIDATION *********************/
	  
	  if($type=="confirmation")
	    {
	      if(empty($hash) || empty($id))   echo "<center>".translate("Il manque des paramêtres")."</center>";
	      else
		{
		  $result=mysql_db_query($news->db,"select email from $news->tabletemp where hash='$hash'");
		  while($row = mysql_fetch_array($result))  $email = $row["email"];
		  
		  if($email==$addr)
		    {
		      $supp=mysql_db_query($news->db,"DELETE FROM $news->tabletemp where id='$id'");
		      $add=mysql_db_query($news->db, "INSERT INTO $news->tablenews (email,hash) VALUES ('$addr','$hash')");
		      $corpsmsg = urldecode(stripslashes("$news->bienvenue"));
		      $news->send_email($email,$news->welcome_s,$corpsmsg,"text","");
		      echo "<table width=700 border=0 cellspacing=0 cellpadding=1 bgcolor=#CCCCCC align=center>
				  <tr>
				    <td>
				      <div align=center>
				        <table width=100% border=0 cellspacing=0 cellpadding=0 bgcolor=#8090A0>
			        	  <tr>
				          <td align=center ><font color=#FFFFFF>[ ".$news->nomnews." ]</td>
				          </tr>
				          <tr>
				            <td align=center valign=middle  bgcolor=#FFFFFF>
				            ".translate("Votre inscription a été confirmée")."<br><br><a href=\"".$news->url."\">".$news->url."</a>
				            </td>
		
				          </tr>
				        </table>
				      </div>
				    </td>
				  </tr>
				</table>";
		    }
		}
	    }
	

	
	
	
	
	  if($type=='inscription') ##########INSCRIPTION
	    {
	      $existe = mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tablenews WHERE email='$addr'"));
	      $existetemp = mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tabletemp WHERE email='$addr'"));
	      if(($existe) or ($existetemp)) echo "<center><B>".translate("Erreur")." :</B><br>".translate("Vous êtes déjà inscrit")."</center>";
	      else 
		{
		  $hash = unique_id();
		  $date=date("Ymd");
		  $sql=" INSERT INTO $news->tabletemp (email,date,hash) VALUES ('$addr','$date','$hash')";
		  if(!mysql_db_query($news->db,$sql)) echo translate("Erreur ! Votre inscription n'a pas pu être effectuée ! Erreur renvoyée par le serveur")." : ".mysql_error()."<br>";
		  else
		    {
		      $result=mysql_db_query($news->db,"select hash,id from $news->tabletemp where email='$addr'");
		      while($row = mysql_fetch_array($result)) 
			{
			  $id = $row["id"];
			  $hash = $row["hash"];
			}
		      $submessage=$news->sub_msg."\n".translate("Rendez-vous à l'adresse suivante pour confirmer votre inscription")." :\n".$news->url.$news->pathtopmn."ml.php?type=confirmation&addr=".$addr."&id=".$id."&hash=".$hash."\n".translate("Si vous n'avez pas demandé d'inscription à cette newsletter, ignorez simplement ce message")."\n";
		      $corpsmsg = stripslashes("$submessage");
		      $news->send_email($addr,translate("Confirmation de l'inscription"), $corpsmsg,"text","");
		      echo "<table width=700 border=0 cellspacing=0 cellpadding=1 bgcolor=#CCCCCC align=center>
						  <tr>
						    <td>
						      <div align=center>
						        <table width=100% border=0 cellspacing=0 cellpadding=0 bgcolor=#8090A0>
					        	  <tr>
						          <td align=center ><font color=#FFFFFF>[ ".$news->nomnews." ]</td>
						          </tr>
						          <tr>
						            <td align=center valign=middle  bgcolor=#FFFFFF>
						            ".translate("Votre inscription s'est bien déroulée").".<BR>
							".translate("Vous allez recevoir un mail de confirmation")."<br><br><a href=\"".$news->url."\">".$news->url."</a>
						            </td>
					
				   			       </tr>
				 		       </table>
						      </div>
						    </td>
						  </tr>
						</table>";
		    }	
		}
	    }
	
	  if($type=='desinscription')
	    {
	      if (!empty($addr) && !empty($hash))
		{ 
		  $existe = mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tablenews WHERE email='$addr' and hash='$hash'"));
		  $existetmp= mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tabletemp WHERE email='$addr' and hash='$hash'"));
		  if( ($existe) || ($existetmp))
		    {
		      $sql="DELETE FROM $news->tablenews WHERE email='$addr'";
		      $sql2="DELETE FROM $news->tabletemp WHERE email='$addr'";
		      if( (!mysql_db_query($news->db,$sql)) & (!mysql_db_query($news->db,$sql2)))
			echo "<CENTER>".translate("Erreur lors de la desinscription")."<CENTER>";
		      else {
			echo "<table width=700 border=0 cellspacing=0 cellpadding=1 bgcolor=#CCCCCC align=center>
						  <tr>
						    <td>
						      <div align=center>
						        <table width=100% border=0 cellspacing=0 cellpadding=0 bgcolor=#8090A0>
					        	  <tr>
						          <td align=center ><font color=#FFFFFF>[ ".$news->nomnews." ]</td>
						          </tr>
						          <tr>
						            <td align=center valign=middle  bgcolor=#FFFFFF>"
			  .translate("Désinscription de")." : $addr ".translate("effectuée, merci de votre visite").".<BR>".translate("Si vous désirez vous réinscrire, rendez vous à l'adresse suivante")." :<br>[ <a href=\"".$news->url.$news->pathtopmn."ml.php?type=inscription&addr=$addr\">".$news->url.$news->pathtopmn."ml.php?type=inscription&addr=$addr</a> ]<br><br><a href=\"".$news->url."\">".$news->url."</a>
						            </td>
					
				   			       </tr>
				 		       </table>
						      </div>
						    </td>
						  </tr>
						</table>";	 	
		      }
		    }
		  else  print "<center><B>".translate("Erreur")." !!!</B><BR>".translate("Vous n'êtes pas inscrit à cette Newsletter")."<center>";
		}
	      else
		{
		  switch($ok) {
		  case "1": echo "ok"; break;
		  default : echo "<center><b>".translate("Désinscription: une demande de confirmation vous a été envoyée par email")."</b></center>";
		    
		  $unsubmessage=$news->sub_msg."\n".translate("Veuillez confirmer votre désinscription").".\n";
		  $corpsmsg = stripslashes("$unsubmessage");
		  $news->send_email($addr,translate("Confirmation de la desinscription"), $corpsmsg,"text","");
		  break;
		  }
		}
	    }
	}
	break;
	
	/************************** FIN AVEC VALIDATION ********************************/
	
	
	  /************ DEBUT SANS VALIDATION **************************************************/
	
	
	case "0" : {
	  if($type=='inscription') ##########INSCRIPTION
	    {
	      $hash = unique_id();
	      $existe = mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tablenews WHERE email='$addr'"));
	      if($existe) echo "<center><B>".translate("Erreur")." :</B><br>".translate("Vous êtes déjà inscrit")."</center>";
	      $sql=" INSERT INTO $news->tablenews (email,hash) VALUES ('$addr','$hash')";
	      if(!mysql_db_query($news->db,$sql)) 
		echo translate("Erreur ! Votre inscription n'a pas pu être effectuée ! Erreur renvoyée par le serveur")." : ".mysql_error()."<br>";
	      else{
		$corpsmsg = stripslashes("$news->bienvenue");
		if(!($news->send_email($addr,$news->welcome_s,$corpsmsg,"text",""))) echo "Email non envoyé !";
	      
	      
		echo "<table width=700 border=0 cellspacing=0 cellpadding=1 bgcolor=#CCCCCC align=center>
				  <tr>
				    <td>
				      <div align=center>
				        <table width=100% border=0 cellspacing=0 cellpadding=0 bgcolor=#8090A0>
			        	  <tr>
				          <td align=center ><font color=#FFFFFF>[ ".$news->nomnews." ]</td>
				          </tr>
				          <tr>
				            <td align=center valign=middle  bgcolor=#FFFFFF>
				            ".translate("Votre inscription a été confirmée")."<br><br><a href=\"".$news->url."\">".$news->url."</a>
				            </td>
		
				          </tr>
				        </table>
				      </div>
				    </td>
				  </tr>
				</table>";
	      }	
	    }
	  
	  

	  if($type=='desinscription')
	    {
	      if (!empty($addr) && !empty($hash))
		{ 
		  $existe = mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tablenews WHERE email='$addr' and hash='$hash'"));
		  $existetmp= mySQL_Fetch_Array(mySQL_Query("SELECT * FROM $news->tabletemp WHERE email='$addr' and hash='$hash'"));
		  if( ($existe) || ($existetmp))
		    {
		      $sql="DELETE FROM $news->tablenews WHERE email='$addr'";
		      $sql2="DELETE FROM $news->tabletemp WHERE email='$addr'";
		      if( (!mysql_db_query($news->db,$sql)) & (!mysql_db_query($news->db,$sql2)))
			echo "<CENTER>".translate("Erreur lors de la desinscription")."<CENTER>";
		      else {
			echo "<table width=700 border=0 cellspacing=0 cellpadding=1 bgcolor=#CCCCCC align=center>
						  <tr>
						    <td>
						      <div align=center>
						        <table width=100% border=0 cellspacing=0 cellpadding=0 bgcolor=#8090A0>
					        	  <tr>
						          <td align=center ><font color=#FFFFFF>[ ".$news->nomnews." ]</td>
						          </tr>
						          <tr>
						            <td align=center valign=middle  bgcolor=#FFFFFF>"
			  .translate("Désinscription de")." : $addr ".translate("effectuée, merci de votre visite").".<BR>".translate("Si vous désirez vous réinscrire, rendez vous à l'adresse suivante")." :<br>[ <a href=\"".$news->url.$news->pathtopmn."ml.php?type=inscription&addr=$addr\">".$news->url.$news->pathtopmn."ml.php?type=inscription&addr=$addr</a> ]<br><br><a href=\"".$news->url."\">".$news->url."</a>
						            </td>
					
				   			       </tr>
				 		       </table>
						      </div>
						    </td>
						  </tr>
						</table>";	 	
		      }
		    }
		  else  print "<center><B>".translate("Erreur")." !!!</B><BR>".translate("Vous n'êtes pas inscrit à cette Newsletter")."<center>";
		}
	      else
		{
		  switch($ok) {
		  case "1": echo "ok"; break;
		  default : echo "<center><b>".translate("Désinscription: une demande de confirmation vous a été envoyée par email")."</b></center>";
		    
		  $unsubmessage=$news->sub_msg."\n".translate("Veuillez confirmer votre désinscription").".\n";
		  $corpsmsg = stripslashes("$unsubmessage");
		  $news->send_email($addr,translate("Confirmation de la desinscription"), $corpsmsg,"text","");
		  break;
		  }
		}
	    }
	}
	break;






	//default : break;
	
	}
      }
      else echo "<center><b>".translate("Erreur")." : ".translate("Adresse Email non valide").".</b></center>";	
  
    }
  else if(isset($op) && ($op=="byebye"))
    {echo "
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


<p>&nbsp;<center><h3>".translate("Désinscription")."</h3>
            <form name=sub method=post action=\"".$path."ml.php\">
            <p>".translate("Adresse e-mail")." <input type=text name=addr 
             maxlength=250 size=30>




 </p>
            <p><input type=hidden name=type value=desinscription></p>
            <p><input type=button  value=\"Go !\" onclick=Submitform()></form></center>
";     


    }
  else echo "<CENTER>".translate("erreur")."</CENTER>";

  echo "<br><br><center><a href=\"http://gregory.kokanosky.free.fr/phpmynewsletter/\"><img src=\"img/logo.png\" border=0></a></center>";
  echo "</body></html>";
  mysql_close($mysql_link);
    ?>

    