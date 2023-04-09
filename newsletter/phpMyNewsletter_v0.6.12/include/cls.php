<?
/****************************************************************************************
 *											*
 *		Class uses in phpMyNewsLetter             				*
 *			<gregory.kokanosky@free.fr>					*
 ****************************************************************************************/

  class newsletter {
    
    var $id;
 
 var $nomnews;
 var $hebergeur;
 var $from;
 var $fromonline;
 var $limitconf;
 
 var $host;
 var $user;
 var $passwd;
 var $db;
 var $tablenews;
 var $tabletemp;
 var $tablelog;
 var $tableconfig;
 
 var $admin_pass;
 var $limitlog;
 var $url;
 var $pathtopmn;
 var $langfile;
 
 var $welcome_s;
 var $bienvenue;
 var $sub_msg;
 var $pied;
  
 var $validation;
  
  
  
  /*** fonction permettant de récuperer la config de la newsletter  ***/
  function get_config($host,$db,$user,$pass,$tabconf) {
   $mysql_link =  MYSQL_CONNECT($host,$user,$pass)  OR print("Unable to find server");
	@mysql_select_db($db ,$mysql_link )  or print("Unable to find database");
	$mysql_result = mysql_db_query( $db ,"SELECT * FROM $tabconf")  OR print(MYSQL_ERROR());
	if($mysql_result)
			  {
			  while($row = mysql_fetch_row($mysql_result))
					{      
					  $this->id = 		$row[0];
					  $this->nomnews =	$row[1];
					  $this->hebergeur = 	$row[2];
					  $this->from = 	$row[3];
					  $this->fromonline = 	$row[4];
					  $this->limitconf =	$row[5];
					  $this->host =		$row[6];
					  $this->user = 	$row[7];
					  $this->passwd =  	$row[8];
					  $this->db = 		$row[9];
					  $this->tablenews = 	$row[10];
					  $this->tabletemp =	$row[11];
					  $this->tablelog =	$row[12];
					  $this->tableconfig =	$row[13];
					  $this->admin_pass =	$row[14];
					  $this->limitlog =   	$row[15];
					  $this->url =		$row[16];
					  $this->pathtopmn =	$row[17];
					  $this->langfile = 	$row[18];	
					  $this->welcome_s =	$row[19];
					  $this->bienvenue = 	$row[20];
					  $this->sub_msg =	$row[21];
					  $this->pied =		$row[22];
					  $this->validation = 	$row[23];
					}
			  }
	
	if ($this->db=="") $this->db=$db;
	if ($this->host=="") $this->host=$host;
	if ($this->user=="") $this->user=$user;
	if ($this->passwd=="") $this->passwd=$pass;
	if ($this->tableconfig=="") $this->tableconfig=$tabconf;
	if ($this->langfile=="") $this->langfile="lang-en.php";
 
 }

  function get_hash($email)
    {
      $hash = mySQL_Fetch_Array(mySQL_Query("SELECT hash from $this->tablenews where email = '$email'"));
      $hashtemp = mySQL_Fetch_Array(mySQL_Query("SELECT hash from $this->tabletemp where email = '$email'"));    
      
         if($hash) 
	return $hash[0] ;
      else if($hashtemp)
	return $hashtemp[0];

    }

// Nouvelle fonction d'envoi de message //
    function send_email($to, $subject , $msg ,  $format ,$bcc="") {
 
      /**** Création des pieds des messages ***/
      
      $hash= $this->get_hash($to);

      $piedtxt ="\n\n------------------------------------------------------------------------------\n";
      $piedtxt.=stripslashes($this->pied)."\n\n".translate("Pour vous désinscrire, rendez-vous à l'adresse suivante")." :\n";
      $piedtxt.=$this->url.$this->pathtopmn."ml.php?type=desinscription&addr=".$to."&hash=".$hash."\n"; 
      $phtm=eregi_replace("<","&lt;",$this->pied);
      $phtm=eregi_replace(">","&gt;",$phtm);
      $phtm=nl2br($phtm);
      $piedhtm ="<br><br><hr><br>";
      $piedhtm.=stripslashes($phtm)."<br><br><br><a href=\"".$this->url.$this->pathtopmn."ml.php?type=desinscription&addr=".$to."&hash=".$hash."\">";
      $piedhtm.=translate("Pour vous desinscrire, cliquez ici")."</a>";
      $subject=stripslashes($subject);
      $msg=stripslashes($msg); 


      //création du header du mail
      $mail_header="Return-Path:".$this->from."\nContent-Transfer-Encoding: 8bit";
      if ($format=="text")   
	{ 
	  $mail_header .= "\nContent-Type: text/plain; charset=iso-8859-1";
	  $msg.=$piedtxt;
	}

      else  
	{
	  $mail_header.="\nContent-Type: text/html; charset=iso-8859-1";
	  $msg.=$piedhtm;
	}


      switch($this->hebergeur) 
	{
	case "nexen" :  // http://www.nexen.net
	  {
	    include "mail.inc";
	    if(email($to,$subject,$msg,"From: $this->from\n$mail_header")) return 1;
	    else return 0;
	  }
	  break;
	  

	  // thanks to Lea legris and pugi
	case "online" :    // http://www.online.fr 
	  if (email($this->fromonline,$to,$subject,$msg,$this->fromonline,$mail_header)) $erreur=1 ;
	  else $erreur=0;
	  return $erreur;
	  break;
	  
	default:
	      if(mail($to ,$subject,$msg,"From: $this->from\n$mail_header")) return 1;
	      else return 0;
		  
	  break;
	}
    }
  }



class logFile {



  var $filename;
  
  function logFile($file)
    {
      $this->filename = $file;
    
      
    }


  function write($message)
    {
      
      $fc = fopen($this->filename, "a+");
      $w = fwrite ($fc, $message ); 
      fclose($fc);
    }
}



?>
