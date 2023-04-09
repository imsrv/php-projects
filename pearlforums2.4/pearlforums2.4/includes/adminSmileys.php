<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminSmileys.php - Process all actions related to 
//                  smileys in Admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

include_once("$GlobalSettings[templatesDirectory]/adminSmileys.php");
$Document[contentWidth]="80%";
$action=$VARS['action']==""?"list":$VARS['action'];

$exe="{$action}Smiley";
$exe();	

//  Update smiley
function updateSmiley(){
	global $Language,$AdminLanguage,$Document,$GlobalSettings,$HTTP_POST_VARS,$userfile,$userfile_name;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");		
	extract($HTTP_POST_VARS,EXTR_OVERWRITE);
	$isError=false;	
	if(trim($name)==""){
		$isError=true;
		$errorMsg="$Language[Name] $Language[isblank]. ";
	}
	if(is_uploaded_file($userfile)) { //if file uploaded
		$fileUpload=true;
		list($filename,$ext)=preg_split("/\./",$userfile_name);		
		if(strtolower($ext)!="gif"){//GIF only
			$isError=true;
			$errorMsg .= "$AdminLanguage[GIFonly]. ";
		}  
	}

	if($isError){
		$Document['msg'] .= $errorMsg;
	}
	else{
		if($fileUpload) {
			$oldFile="$Global_smileysPath/$fileName";	
			if(file_exists($oldFile)){				
				unlink("$oldFile");
			}		
			copy($userfile, "$Global_smileysPath/$userfile_name");		
			$addSql=", fileName=\"$userfile_name\" ";
			$Document['msg'] = "$Language[Recordupdated].";						
		}
		$name=htmlspecialchars($name);
		$sql="update {$Global_DBPrefix}Smileys set name=\"$name\" $addSql where smileyId=$smileyId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$Document['msg'] .= "  $Language[Recordupdated].";
		generateSmileyFile();
	}
	editSmiley();
}//updateSmiley

//  Edit smiley
function editSmiley(){
	global $Document,$GlobalSettings,$HTTP_GET_VARS,$HTTP_POST_VARS,$Language,$AdminLanguage;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	$HTTP_POST_VARS=array_merge($HTTP_POST_VARS,$HTTP_GET_VARS);
	$sql="select smileyId, name,fileName,status from {$Global_DBPrefix}Smileys where smileyId=$HTTP_POST_VARS[smileyId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	$dataSet = mysql_fetch_array($fetchedData);
	if($dataSet[smileyId]){
		$HTTP_POST_VARS=$dataSet;
		$Document['contents'] .= getSmileyFormHTML("$Language[Edit] $AdminLanguage[Smiley]","Update");	
	}
	else{
		$Document['contents'] .= commonDisplayError("Editing Smiley","Retrieving record failed.");
	}		
}//editSmiley

//  Delete smiley
function deleteSmiley(){
	global $Document,$GlobalSettings,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	
	$sql="delete from {$Global_DBPrefix}Smileys where smileyId=$VARS[smileyId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	if(mysql_affected_rows()>0){
		$Document['msg']="$Language[Recordremoved]";
		$file="$Global_smileysPath/$VARS[fileName]";	
		if(file_exists($file)){
			unlink($file);
		}
		generateSmileyFile(); 
	}	
	else{
		$Document['msg']="$Language[Deletingfailed]";	
	}
	listSmiley();
}//deleteSmiley

//  Create new smiley
function createSmiley(){	
	global $GlobalSettings,$Member,$Document,$Language,$AdminLanguage,$HTTP_POST_VARS,$userfile,$userfile_name;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($HTTP_POST_VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($name)==""){
		$isError=true;
		$errorMsg="$Language[Name] $Language[isblank]. ";
	}
	if(is_uploaded_file($userfile)) { //if file uploaded
		list($filename,$ext)=preg_split("/\./",$userfile_name);		
		if(strtolower($ext)!="gif"){//GIF only
			$isError=true;
			$errorMsg .= "$AdminLanguage[GIFonly]. ";
		}  
		if(file_exists("$Global_smileysPath/$userfile_name")){				
			$isError=true;
			$errorMsg .= "$userfile_name $Language[alreadyexist]";
		}
	}
	else{
		$isError=true;
		$errorMsg .= "GIF $Language[required]. ";	
	}	
	if($isError){
		$Document['msg'] = $errorMsg;
		$Document['contents'] .= getSmileyFormHTML("$AdminLanguage[CreateNewEntry]","Create");	
	}
	else{
		$sql="insert into {$Global_DBPrefix}Smileys (name,fileName,status) VALUES (\"$name\",\"$userfile_name\",1)";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		if(mysql_affected_rows()){
			$Document['msg']="$name created";
			$file="$Global_smileysPath/$userfile_name";					
			copy($userfile, $file);		
			generateSmileyFile();	
			listSmiley();
		}
		else{
			$Document['msg']= $Language[Insertfailed];
			$Document['contents'] .= getSmileyFormHTML("$AdminLanguage[CreateNewEntry]","Create");			
		}
	}
}//createSmiley

//  Get new smiley entry form
function newSmiley(){	
	global $Document,$AdminLanguage;		
	$Document['contents'] .= getSmileyFormHTML("$AdminLanguage[CreateNewEntry]","Create");	
}//newSmiley

//  List smileys
function listSmiley(){	
	global $GlobalSettings,$Member,$Document,$AdminLanguage,$Language,$HTTP_GET_VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	if(trim($Document['msg'])){
		$Document['contents'] .= commonEndMessage(0,$Document['msg']);
	}
	if(!is_writable("$GlobalSettings[smileysPath]/smileys.js")){
		$Document['contents'] .= "<BR/><SPAN CLASS=ERROR>$AdminLanguage[WritableWarningSmileys]<STRONG><BR/>";				
	}	

	$page=$VARS['page']==""?1:$VARS['page'];
	$Document['contents'] .= getNewLinkHTML();
	$Document['contents'] .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$Document['contents'] .= getColumnLabelsHTML();
	if(trim($HTTP_GET_VARS[alpha])!=""){
		$addSql = "where name > \"$HTTP_GET_VARS[alpha]\" ";
	}
	if(trim($HTTP_GET_VARS[searchText])!=""){
		$addSql = "where name like \"%$HTTP_GET_VARS[searchText]%\" ";
		$Document['listingsPerPage']=50;
	}	
	$fromNumber=($page -1)* $Document['listingsPerPage'];
	$sql="select smileyId,name,fileName from {$Global_DBPrefix}Smileys $addSql order by name limit $fromNumber, $Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getSmileyRowHTML($dataSet);
		$lastAlpha=$dataSet[name];
	}
	$counts=mysql_num_rows($fetchedData);
	if($counts==0){
		$Document['contents'] .= commonEndMessage(4,"$Language[Norecordsfound]");
	}
	$Document['contents'] .= commonTableFormatHTML("footer","","");
	if($counts==$Document['listingsPerPage']){
		$next="<A HREF=\"$Document[mainScript]?mode=admin&case=smileys&action=list&alpha=$lastAlpha\">$Language[next]</A>";	
	}	
	$Document['contents'] .= commonPreviousNext($Document['contentWidth'],$previous,$next);
	$Document['contents'] .= "<BR /><BR />If your smileys show up as broken images, please update any smiley to have a the file regenerated.";
}//listSmiley
 
//  Generate javascript file for use by the WYSIWYG editor
function generateSmileyFile(){
	global $GlobalSettings,$Member,$Document,$Language,$HTTP_GET_VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select name,fileName from {$Global_DBPrefix}Smileys order by name";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$smileyFiles .= "\"$dataSet[fileName]\",";
		$smileyNames .= "\"$dataSet[name]\",";
	}
	$smileyFiles=substr($smileyFiles, 0, strlen($smileyFiles)-1);
	$smileyNames=substr($smileyNames, 0, strlen($smileyNames)-1);
	$contents=<<<EOF
var imgA = new Array($smileyFiles);
var imgN = new Array($smileyNames);
var refe, refe1;
var htmlstr = "<TR>";
var j=0;
var fill=0;
for( var i=0; i<imgA.length; i++)
{
  	refe = '$Global_boardPath/$Global_smileysPath/' + imgA[i];
  	htmlstr += "<TD CLASS='CursorOver' align=center><img src=" + refe + " title=" + imgN[i] + " onclick=insertSmiley('"+refe+"')></td>"
  	if(++j==4){ htmlstr += "</tr><tr>" ; j=0 ;}
 }
 while(j<4 && j!=0){  
	 htmlstr += "<td></td>"
	 j++
	 fill=1
 }
 if(fill==1){ htmlstr += "</tr>"}
 document.write(htmlstr);

EOF;
		$fp = fopen ("$Global_smileysPath/smileys.js", "w"); 
		fputs ($fp,$contents); 
		fclose ($fp); 

}//generateSmileyFile
?>