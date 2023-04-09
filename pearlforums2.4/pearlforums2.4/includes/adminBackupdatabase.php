<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminBackupdatabase.php - Process all actions related to 
//                  database backups.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminBackupdatabase.php");
$Document[contentWidth]=400;
$action=$VARS['action']==""?"entry":$VARS['action'];

$exe="{$action}Database";
$exe();	

//  Backup database
function backupDatabase(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$tableNames=array();
	$keys=array();
	$lf="\r\n";

	printDownloadHeader	();
	
	$sql="show table status from $Global_DBName";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData)){
		if (stristr(substr($dataSet[Name], 0, strlen($Global_DBPrefix)), $Global_DBPrefix))
			 array_push($tableNames,$dataSet[Name]);
	}
	foreach($tableNames as $table){
		$fieldsList=array();
		$contents = "# Structure for table $table$lf";
		$contents .= "drop table if exists $table;$lf";
		$contents .= "create table $table($lf";
		
		//get columns definitions
		$sql="show columns from $table";   
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		while($dataSet=mysql_fetch_array($fetchedData)){
			$null=$dataSet['Null']?"":" Not null";
			$default=$dataSet['Default']==""?"":" Default '$dataSet[Default]'"; 
			$autoIncrement=$dataSet['Extra']=="auto_increment"?" auto_increment":"";
			$contents .= "\t$dataSet[Field] $dataSet[Type]$null$default$autoIncrement,$lf";
			array_push($fieldsList,$dataSet[Field]);
		}
		
		//get keys and indexes
		$keys=array();
		$sql="show keys from $table"; 
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		while($dataSet=mysql_fetch_array($fetchedData)){
			$dataSet['Key_name']=="PRIMARY" && $dataSet['Non_unique']==0?array_push($keys,"\tPRIMARY KEY($dataSet[Column_name])"):array_push($keys,"\tIndex $dataSet[Key_name]($dataSet[Column_name])");			
		}
		$contents .= implode(",$lf", $keys);
		$contents .= "$lf);$lf";
		$contents .= $lf;	

		 //get data
		if($backupType=="data"){
			$insertLines="";
			$fields=implode($fieldsList,",");
			$sql="select $fields from $table";
			$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
			if(mysql_num_rows($fetchedData)){			
				$contents .= $extended?"insert into $table ($fields) values$lf":"";
				while($dataSet=mysql_fetch_array($fetchedData)){
					$line=array();
					foreach($fieldsList as $field){
						array_push($line,str_replace("\"","\\\"",$dataSet[$field]));
					}
					$dataLine=implode($line,"\",\"");
					$insertLines .=$extended?"(\"$dataLine\"),$lf":"insert into $table ($fields) values (\"$dataLine\");$lf";
				}		
				$contents .= ereg_replace(",$lf$", ";", $insertLines);
				$contents .= "$lf$lf";			
			}
		}
		print $contents;
	}
	print "$lf$lf# End";
	exit;
}//backupDatabase

//  Get entry form
function entryDatabase(){	
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	//database size
	$sql="show table status from $Global_DBName";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData)){
		if (stristr(substr($dataSet[Name], 0, strlen($Global_DBPrefix)), $Global_DBPrefix))
			$stat[dbSize] += $dataSet[Data_length] + $dataSet[Index_length];		
	}
	$stat[dbSize] = number_format($stat[dbSize]/1024,1);
	
	$Document['contents'] .= getFormHTML($stat);
}//entryDatabase
 
function printDownloadHeader(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	
	$currentTime = date("F j, Y, g:i a");
	$outputFile = $Global_DBName . "_" . date("F_j_Y") . ".sql";
//	header("Content-Encoding: ");
	header("Content-type: application/octetstream");
	header("Content-disposition: filename=" . $outputFile);

	$header =<<<EOF
# ========================================	
# Pearl $Global_pearlVersion
# http://www.pearlinger.com
# Database: $Global_DBName
# $currentTime
# ========================================


EOF;
	print $header;
}
?>