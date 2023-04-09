<?
// phpMyNewsletter installation process


if (file_exists("config.inc.php")) header ("Location:../admin.php");

include $langfile;




/* create table and database */

if($createdb==1)
{
  echo "<center><b>".translate("Création de la base de donnée")." : $db</b><BR>";
  $link = @mysql_connect ($host, $user, $passwd)  OR DIE (translate("Impossible de trouver le serveur").MYSQL_ERROR());
  if (mysql_create_db ($db)) {
    print ("OK");
  } else {
    echo translate("Erreur").": ".mysql_error();
  }
  mysql_close($link);
  echo "</center>";
}



if($createtable==1)
{
  $link =  @MYSQL_CONNECT($host,$user,$passwd) OR DIE(translate("Impossible de trouver le serveur").MYSQL_ERROR());
  @mysql_select_db($db ,$link) or die( translate("Impossible de trouver la base").MYSQL_ERROR());
  
  echo "<center>  <b>".translate("Création des tables")."</b><BR>";
  
  echo "<LI> - ".$tablenews.": ";
  $sql = "CREATE TABLE ".$tablenews."(
   email char(255) NOT NULL,
  hash varchar(255) NOT NULL default '',
 PRIMARY KEY(email),UNIQUE email (email));";

  if(!mysql_db_query($db,$sql)) 
    echo MYSQL_ERROR();
  else
    echo "OK";
  
     
  echo "<LI> - ".$tabletemp.": ";
  $sql = "CREATE TABLE ".$tabletemp." (
   id int(11) NOT NULL auto_increment,
   email char(255) NOT NULL,
   date date DEFAULT '0000-00-00' NOT NULL,
  hash varchar(255) NOT NULL default '',
   PRIMARY KEY (id),
   UNIQUE id (id)
);";

  if(!mysql_db_query($db,$sql)) 
    echo MYSQL_ERROR();
  else
    echo "OK";
  


  echo "<LI> - ".$tablelog.": ";
  $sql = "CREATE TABLE ".$tablelog."
 (
   id tinyint(255) NOT NULL auto_increment,
   date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   type varchar(4) NOT NULL,
   sujet text NOT NULL,
   message text NOT NULL,
   PRIMARY KEY (id)
);";
  
  if(!mysql_db_query($db,$sql)) 
    echo MYSQL_ERROR();
  else
    echo "OK";
  
  
  echo "<LI> - ".$tableconfig.": ";
  $sql = "CREATE TABLE ".$tableconfig." 
 (
   id tinyint(4) DEFAULT '1' NOT NULL,
   nomnews varchar(255) NOT NULL,
   hebergeur varchar(255) NOT NULL,
   fromc varchar(255) NOT NULL,
   fromonline varchar(255) NOT NULL,
   limitconf tinyint(2) DEFAULT '3' NOT NULL,
   host varchar(255) NOT NULL,
   user varchar(255) NOT NULL,
   passwd varchar(255) NOT NULL,
   db varchar(255) NOT NULL,
   tablenews varchar(255) NOT NULL,
   tabletemp varchar(255) NOT NULL,
   tablelog varchar(255) NOT NULL,
   tableconfig varchar(255) NOT NULL,
   admin_pass varchar(255) NOT NULL,
   limitlog tinyint(2) DEFAULT '10' NOT NULL,
   url varchar(255) NOT NULL,
   pathtopmn varchar(255) NOT NULL,
   langfile varchar(255) NOT NULL,
   welcome_subj varchar(255) NOT NULL,
   welcome_msg text NOT NULL,
   sub_msg text NOT NULL,
   pied tinytext NOT NULL,
   validation tinyint(1) DEFAULT '1' NOT NULL
);";

  if(!mysql_db_query($db,$sql)) 
    echo MYSQL_ERROR();
  else
    echo "OK";

  mysql_close($link);
  
  echo "</center>";
}






echo "<p align=center><b>".translate("Mise à jour de la configuration effectuée").".</b></p>"; 
/*********** Création du fichier de conf  **************/	
$configfile="<? // phpMyNewsletter config file";
$configfile.="\n$"."f_host=\"".$host."\";";
$configfile.="\n$"."f_user=\"".$user."\";";
$configfile.="\n$"."f_passwd=\"".$passwd."\";";	
$configfile.="\n$"."f_db=\"".$db."\";";
$configfile.="\n$"."f_tableconfig=\"".$tableconfig."\";";
$configfile.="\n?>";

if(is_writable("./"))
{
  $fc = fopen("config.inc.php", "w");
  $w = fwrite ($fc, $configfile ); 
}
else echo "<center>".translate("Créé le fichier include/config.inc.php, puis Collez les lignes suivantes dans ce fichier.")."<BR><textarea rows=7 cols=40 readonly>$configfile</textarea></center>";

$welcome_subj = addslashes($welcome_subj);
$sub_msg = addslashes($sub_msg);
$pied = addslashes($pied);
$validation = addslashes($validation);


$requete = "INSERT INTO $tableconfig VALUES ( '1', '$nomnews', '$hebergeur', '$fromonline@$domaine', '$fromonline', '3', '$host', '$user', '$passwd', '$db', '$tablenews', '$tabletemp', '$tablelog', '$tableconfig', '$admin_pass', '3', '$url', '$pathtopmn', '$langfile', '$welcome_subj', '$welcome_msg', '$sub_msg', '$pied', '$validation');";

$mysql_link =  @MYSQL_CONNECT($host,$user,$passwd) OR print MYSQL_ERROR();
@mysql_select_db($db ,$mysql_link ) or print MYSQL_ERROR();
$mysql_result = mysql_db_query( $db ,$requete) OR print MYSQL_ERROR();
mysql_close($mysql_link);

echo "<br><br><div align=\"center\">[ <a href=\"../admin.php\">OK</a> ]</div>";




?>

