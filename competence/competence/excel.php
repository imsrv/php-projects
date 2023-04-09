<?php
/* gestion de session necessite PHP4  */
session_start();
//pour rendre le programe compatible PHP4
$getvar=$_GET;
$postvar=$_POST;
$iform=0;
while (list($key,$value)=each($_POST))
{  $iform=1;
${strval($key)}=$value;}
if ($iform == 0) // on ne cherche que si rien dans la FORM
{
 	 while (list($key,$value)=each($_GET))
	 { 
	 ${strval($key)}=$value;
	 }
}
include("prive/conf.php");
 $langue=$HTTP_SESSION_VARS["langue"];
include("include/${langue}.php");
/*connection à la base de donnée MySQL  paramètres dans conf.php  */
// connection à la base de l entite du user
DBinfo($langue);
$connection = @mysql_connect("$DBHost", "$DBUser", "$DBPass")  
    or die("Couldn't connect."); 

$db = @mysql_select_db($DBName, $connection) 
    or die("Couldn't select database."); 
//Written by Dan Zarrella. Some additional tweaks provided by JP Honeywell
//pear excel package has support for fonts and formulas etc.. more complicated
//this is good for quick table dumps (deliverables)
    $commande= "select $t_evaluation.Id_evaluation,$t_equipe.nom,$t_equipe.prenom, $t_evaluation.Date_evaluation,$t_evaluation.Type";
		$commande.=" from $t_equipe ,$t_evaluation"; 
		$commande.=" where $t_evaluation.ce_equipe=$t_equipe.Id_equipe"; 
		$commande.=" order by $t_equipe.nom,$t_evaluation.Date_evaluation DESC ";
	//echo "***debug sel eva_comp: $commande<br>\n";
	$result = mysql_query ($commande, $connection);
	$line="";
	// "neval nom prénom date Type Phase domaine competence niveau ";
	$header= "numeval\t$mess[6]\t$mess[7]\tdate\tType\t$mess[12]\t$mess[13]\t$mess[14]\t$mess[25]\t";
	$data ="";
while($row = mysql_fetch_row($result)){
   	$neval = $row[0];
  //boucler maintenant sur chaque evaluation
	 $commande= "SELECT A.Phase, B.Domaine,C.competence,D.niveau ";
	 $commande.=" FROM $t_phase A,$t_domaine B , $t_competence C , $t_eva_comp D";
	 $commande.=" where D.ce_competence=C.Id_competence"; 
	 $commande.=" And D.ce_evaluation='$neval'";
	 $commande.=" And C.ce_domaine=B.Id_domaine AND B.ce_phase=A.Id_phase"; 
	 $commande.=" ORDER BY A.Phase, B.Domaine, C.competence";
	 $result2 = mysql_query ($commande, $connection);
	 $linedeb='';
   foreach($row as $value)
  	{
      if(!isset($value) || $value == "")
  		{
        $value = "\t";
      }else{
  # important to escape any quotes to preserve them in the data.
        $value = str_replace('"', '""', $value);
  # needed to encapsulate data in quotes because some data might be multi line.
  # the good news is that numbers remain numbers in Excel even though quoted.
  			$value = '"' . $value . '"' . "\t";
      }
      $linedeb .=$value;
  	}
	 while($row2 = mysql_fetch_row($result2))
	 {
   $line = $linedeb;
        foreach($row2 as $value1)
      	{
          if(!isset($value1) || $value1 == "")
      		{
            $value = "\t";
          }else{
      # important to escape any quotes to preserve them in the data.
            $value1 = str_replace('"', '""', $value1);
      # needed to encapsulate data in quotes because some data might be multi line.
      # the good news is that numbers remain numbers in Excel even though quoted.
      			$value1 = '"' . $value1 . '"' . "\t";
          }
          $line .=$value1;
      	}
  $data .= trim($line)."\n";
	 }
	 $linedeb='';		
}	
# this line is needed because returns embedded in the data have "\r"
# and this looks like a "box character" in Excel
  $data = str_replace("\r", "", $data);


# Nice to let someone know that the search came up empty.
# Otherwise only the column name headers will be output to Excel.
if ($data == "") {
  $data = "\nno matching records found\n";
}

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $header."\n".$data;
?>
