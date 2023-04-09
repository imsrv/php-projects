<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File: 	install.php - Configure settings, create database and 
//                  administrator access, setup system for use.
// -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

error_reporting (E_ALL ^ E_NOTICE); //report all, except for E_NOTICE

include("settings.php");	
$Document['width']=600;
$step=$HTTP_POST_VARS[step]==""?"One":$HTTP_POST_VARS[step];
$exe="step{$step}";

$Document[contents] = tableFormatHTML("header");
$exe($msg);	
$Document[contents] .= tableFormatHTML("footer");

include("templates/master.php");	

function stepOne($msg){
	Global $GlobalSettings,$Document,$HTTP_POST_VARS;
	extract($HTTP_POST_VARS,EXTR_OVERWRITE);
	$DBServer=$DBServer==""?"localhost":$DBServer;
	$DBPrefix=$DBPrefix==""?"PF":$DBPrefix;	
	$status=stepStatus(1);
	$phpVersion=phpversion();
	
	$accessTypes=array(0=>"<SPAN CLASS=ERROR>not writable</SPAN>",1=>"<FONT COLOR=BLUE>writable</FONT>");
	$settingsWritable=$accessTypes[1];
	$smileysWritable=$accessTypes[1];
	$spamguardWritable=$accessTypes[1];
	
	if($phpVersion < "4.0"){
		$phpVersion="<FONT COLOR=RED>$phpVersion</FONT>";
		$isError=true;	
	}
	
	if(!is_writable("settings.php")){
		$settingsWritable=$accessTypes[0];
		$isError=true;
	}
	if(!is_writable("smileys/smileys.js")){
		$smileysWritable=$accessTypes[0];
		$isError=true;
	}

	if(!is_writable($GlobalSettings['SpamGuardFolder'])){
		$spamguardWritable=$accessTypes[0];
		$isError=true;
	}
	
	if(function_exists("mysql_connect")){
		$mysql="<FONT COLOR=BLUE>Running</FONT>";
	}
	else{
		$isError=true;
		$mysql="<FONT COLOR=RED>Unavailable</FONT>";
	}

	if($isError){
		$msg .="<BR/><SPAN CLASS=ERROR>Installation cannot continue.<BR>Please check the Pre-Installation messages for any item that appear in red.</SPAN><BR/>";
		$disabled = " disabled";		
	}
 	
	$Document[contents] .=<<<EOF
<TABLE WIDTH="$Document[width]">
<TR>
	<TD CLASS="TDPlain" VALIGN="TOP">
		Installation
	</TD>
	<TD CLASS="TDPlain" ALIGN="RIGHT">
		$status
	</TD>
</TR>
<TR>
	<TD CLASS="TDPlain" COLSPAN="2" ALIGN="CENTER">
 		<TABLE WIDTH="200" STYLE="border: black 1px dotted;background-color: #EEEEEE">
		<TR>
			<TD COLSPAN="2" ALIGN="CENTER"><strong>Pre-Installation Check</strong></TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain" VALIGN="TOP">
				PHP Version:
			</TD>
			<TD CLASS="TDPlain">
				<FONT COLOR=BLUE>$phpVersion</FONT>
			</TD>
		</TR>	
		<TR>
			<TD CLASS="TDPlain" VALIGN="TOP">
				MySQL:
			</TD>
			<TD CLASS="TDPlain">
				$mysql
			</TD>
		</TR>	
		<TR>
			<TD CLASS="TDPlain" COLSPAN="2" ALIGN="CENTER"><BR>
				File/Folder Permissions
			</TD>
		</TR>			
		<TR>
			<TD CLASS="TDPlain" VALIGN="TOP">
				settings.php:
			</TD>
			<TD CLASS="TDPlain">
				$settingsWritable
			</TD>
		</TR>	
		<TR>
			<TD CLASS="TDPlain" VALIGN="TOP">
				$GlobalSettings[SpamGuardFolder]:
			</TD>
			<TD CLASS="TDPlain">
				$spamguardWritable
			</TD>
		</TR>		
		<TR>
			<TD CLASS="TDPlain" VALIGN="TOP">
				smileys/smileys.js:
			</TD>
			<TD CLASS="TDPlain">
				$smileysWritable
			</TD>
		</TR>		
		</TABLE>
		<BR/>				
		$msg
		<FORM ACTION="install.php" METHOD="POST">
		<INPUT TYPE="HIDDEN" NAME="step" VALUE="two">
		<TABLE ALIGN="CENTER">
		<TR>
			<TD COLSPAN="2" CLASS="TDPlain" ALIGN="CENTER"><BR />
				<B><U>Database Settings</U></B>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				Server:
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBServer" VALUE="$DBServer" SIZE="20">
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				Database Name:
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBName" VALUE="$DBName" SIZE="20">
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				Table Name Prefix:
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBPrefix" VALUE="$DBPrefix" SIZE="20">
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				Username:
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBUser" VALUE="$DBUser" SIZE="20">
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				Password:
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="PASSWORD" NAME="DBPassword" VALUE="$DBPassword" SIZE="20">
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				&nbsp;
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="SUBMIT" VALUE="next" CLASS="SubmitButtons"$disabled>
			</TD>
		</TR>
		</TABLE>
		</FORM>
	</TD>
</TR>
</TABLE>
EOF;
}//stepOne

function stepTwo($msg){
	Global $Document,$HTTP_POST_VARS;
	extract($HTTP_POST_VARS,EXTR_OVERWRITE);
	$delimeter=";";
	
	mysql_connect($DBServer, $DBUser, $DBPassword) or die(mysql_error());
	mysql_query("create database if not exists $DBName");
	if(mysql_select_db($DBName) or stepOne("Unable to create or access database $DBName")){	
		$index=0;
		$inserts=array();
		$fd = fopen ("tables.sql", "r");
		while (!feof ($fd)) {		
    		$line = fgets($fd, 4096);
			if(!ereg('^#', $line) && trim($line)){ //skip comments, blank lines
				$line = str_replace("[Prefix]",$DBPrefix ,$line);
				if(ereg("$delimeter\r\n$", $line)){//end of insert line
					$sql .= str_replace("$delimeter","",$line);
					array_push($inserts,$sql);			
					$sql="";
				}
				else{
					$sql .= $line;
				}
			}		
		}
		fclose ($fd);  

		foreach ($inserts as $line){					
			if(!mysql_query($line)){						
				stepOne("Error creating records: $line<BR>" . mysql_error());
				$isError=true;
				break;
			}
		}

		
		if(!is_writable("settings.php")){
			stepOne("Unable to write to settings.php.  Please verify.");
			$isError=true;
		}
		if(!$isError){
			$fd = fopen ("settings.php", "r");
			$dbContents =<<<EOF

//  Database:begin					
\$GlobalSettings['DBServer']                  = "$DBServer";
\$GlobalSettings['DBName']                    = "$DBName";
\$GlobalSettings['DBUser']                    = "$DBUser"; 
\$GlobalSettings['DBPassword']                = "$DBPassword"; 
\$GlobalSettings['DBPrefix']                  = "$DBPrefix";	

EOF;
			$feed=true;
			while (!feof ($fd)) {		
    			$line = fgets($fd, 4096);
			 	if(ereg("//  Database:begin",$line)){
					$feed=false;				
					$contents .= $dbContents;
				}
				else if(ereg("//  Database:end",$line))
					$feed=true;
				if($feed){
					$contents .= $line;
				}
			}
			
			fclose ($fd);  
			$fp = fopen ("settings.php", "w"); 
			fputs ($fp,$contents); 
			fclose ($fp); 

			stepTwoHTML($msg);			
			include_once("settings.php");
			generateSmileyFile();
		}		
	}
}//stepTwo

function stepThree(){
	Global $GlobalSettings,$HTTP_POST_VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");	
	extract($HTTP_POST_VARS,EXTR_OVERWRITE);
	$isError=false;
	if(trim($name=="")){ //full name is required
		$isError=true;
		$errorFields['name']= "&laquo; required";
	}
	if(!validateLoginName($loginName)){//validate login name
			$isError=true;
			$errorFields['loginName']= "&laquo; invalid";
			if(trim($loginName==""))
				$errorFields['loginName']= "&laquo; required";
	}
	if(strcmp ($passwd, $confirmPassword)<>0){ //passwords match?
		$isError=true;
		$errorFields['confirmPassword']= "&laquo; doesn't match";
	}		
	if(strlen($passwd) < 3 || strlen($passwd) > 20){ //password length 20<>3 chars
		$isError=true;
		$errorFields['confirmPassword'] = "&laquo; invalid [3><20 chars]";
	}	
	if($isError){
		$errorFields[msg]="Required fields incomplete.  Please verify:";
		stepTwoHTML($errorFields);
	}
	else{
		$now=time();
		$encryptedPassword = md5($passwd);
		if(mysql_connect($Global_DBServer, $Global_DBUser, $Global_DBPassword) or displayError()){
			if(mysql_select_db($Global_DBName) or displayError()){
				$resultData=mysql_query("insert into {$Global_DBPrefix}Members (groupId,accessLevelId,name,loginName,passwd,securityCode,email,url,hideEmail,dateJoined,lastLogin,notifyAnnouncements,ip,avatarId,totalPosts,locked) values (0,1,\"$name\",\"$loginName\",\"$encryptedPassword\",\"\",\"\",\"\",0,$now,$now,0,\"\",1,0,0)");
				if(mysql_affected_rows())
					finalNotes();
				else
					displayError();
			}
		}				
	}
}//stepThree

function finalNotes(){
	GLOBAL $Document,$HTTP_POST_VARS;
	$Document[contents] .= <<<EOF
	<TABLE ALIGN="CENTER">
	<TR>
		<TD CLASS="TDPlain"><BR/><BR/>
			Installation complete.  Thank you for choosing Pearl!<BR/><BR/>
		
			Please login to create your boards/forums and adjust other settings.<BR/><BR/>
			<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0"><FORM NAME="login" ACTION="index.php" METHOD="POST">
			<TR>
			<TD CLASS="TDPlain"><INPUT TYPE="HIDDEN" NAME="mode" VALUE="login"><INPUT TYPE="HIDDEN" NAME="case" VALUE="login" /><INPUT TYPE="HIDDEN" NAME="sessionDuration" VALUE="$Document[sessionDuration]" />
				Login:<INPUT TYPE="TEXT" NAME="loginName" VALUE="$HTTP_POST_VARS[loginName]" SIZE="8" CLASS="InputForms" /><INPUT TYPE="PASSWORD" NAME="passwd" VALUE="$HTTP_POST_VARS[passwd]" SIZE="8" CLASS="InputForms" /><INPUT TYPE="SUBMIT" VALUE="GO" CLASS="GoButton" />
			</TD>
			</TR></FORM>
			</TABLE>
			<BR/><BR/><BR/><BR/>
		</TD>
	</TR>
	</TABLE>
EOF;
}//finalNotes

function stepTwoHTML($errorFields){
	global $Document,$HTTP_POST_VARS;
	extract($HTTP_POST_VARS,EXTR_OVERWRITE);
	
	$status=stepStatus(2);
	$loginName=$loginName==""?"admin":$loginName;
	$Document[contents] .=<<<EOF
<TABLE WIDTH="$Document[width]">
<TR>
	<TD CLASS="TDPlain" VALIGN="TOP">
		Installation
	</TD>
	<TD CLASS="TDPlain" ALIGN="RIGHT">
		$status
	</TD>
</TR>
<TR>
	<TD CLASS="TDPlain" COLSPAN="2" ALIGN="CENTER"><BR/><BR/>	
	
		<SPAN CLASS="ERROR">$errorFields[msg]</SPAN>
		<FORM ACTION="install.php" METHOD="POST">
		<INPUT TYPE="HIDDEN" NAME="step" VALUE="three">
		<TABLE ALIGN="CENTER">
		<TR>
			<TD CLASS="TDStyle" COLSPAN="2" ALIGN="CENTER">
			<STRONG><U>Administrator Details</U></STRONG>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				Administrator Name:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="name" SIZE="20" VALUE="$name" MAXLENGTH="40" /> <SPAN CLASS="Error"> $errorFields[name]</SPAN>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				Login Name:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="loginName" SIZE="20" VALUE="$loginName" MAXLENGTH="20" /> <SPAN CLASS="Error">$errorFields[loginName]</SPAN>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain" WIDTH="124">
				Password:
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="PASSWORD" NAME="passwd" SIZE="20" VALUE="$passwd" MAXLENGTH="20" /> 
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				Confirm Password:
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="PASSWORD" NAME="confirmPassword" SIZE="20" VALUE="$confirmPassword" MAXLENGTH="20" /> <SPAN CLASS="Error">$errorFields[confirmPassword]</SPAN>
			</TD>
		</TR>					
		<TR>
			<TD CLASS="TDPlain">
				&nbsp;
			</TD>
			<TD CLASS="TDPlain">
				<INPUT TYPE="SUBMIT" VALUE="done" CLASS="SubmitButtons">
			</TD>
		</TR>
		</TABLE>
		</FORM>
	</TD>
</TR>
</TABLE>
EOF;
}//stepTwoHTML

function displayError(){
	Global $Document;
	$error=mysql_error();
		$Document[contents] .= <<<EOF
<TABLE ALIGN="CENTER" CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR>
	<TD CLASS="TDStyle">
		Unable to create administrator record.  Please run installation
		again. <BR>
		<BR/><BR/>
		[$error]
	</TD>
</TR>
</TABLE>
EOF;

}//displayError

function tableFormatHTML($type){ 
	if($type=="header"){
		$contents = <<<EOF
<TABLE CLASS="OuterTableStyle" WIDTH="600" ALIGN="CENTER" CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR>
	<TD>
		<TABLE CLASS="OuterTableStyle" WIDTH="100%" CELLSPACING="1" CELLPADDING="5" BORDER="0">
		<TR>
			<TD CLASS="MainTR" ALIGN="CENTER">
				<TABLE CLASS="OuterTableStyle" WIDTH="200" CELLSPACING="1" CELLPADDING="5" BORDER="0">
				<TR>
					<TD CLASS="TDStyle" ALIGN="CENTER">
						Pearl Forums 2.4
					</TD>
				</TR>
				</TABLE>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
EOF;
	}
	else if($type=="footer"){
		$contents = <<<EOF
			</TD>
		</TR>
		</TABLE>
	</TD>
</TR>
</TABLE>
EOF;
	}
	return $contents;
}//tableFormatHTML
	
function stepStatus($steps){
	$totalSteps=2;
	$tableWidth=160;
	$contents="<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0><TR><TD ALIGN=CENTER CLASS=TDPlain><TABLE BGCOLOR=#CCCCFF WIDTH=$tableWidth HEIGHT=10><TR>";
	for($i=0;$i<$steps; $i++)
		$contents .= "<TD BGCOLOR=#58577D WIDTH=$width></TD>";
	while($i<$totalSteps){
		$contents .= "<TD BGCOLOR=#CCCCFF WIDTH=$width></TD>";
		$i++;
	}
	$contents .= "</TR></TABLE></TD></TR><TR><TD CLASS=TDPlain>Step $steps of $totalSteps</TD></TR></TABLE>";	
	return $contents;
}

function validateLoginName($loginName){
	if(!ereg("^[a-z,0-9]*$", $loginName) || strlen($loginName) > 20 || strlen($loginName)<1)
		return false;
	else
		return true;
}//validateLoginName

function generateSmileyFile(){
	global $GlobalSettings,$Document,$Language,$HTTP_GET_VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$sql="select name,fileName from {$Global_DBPrefix}Smileys order by name";
	$fetchedData=mysql_query($sql);
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