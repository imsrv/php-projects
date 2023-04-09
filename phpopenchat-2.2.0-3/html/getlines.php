<?// -*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */


/**
 * Include default values
 */
include ("defaults_inc.php");

/**
 * Open a database connection
 *
 * This include returns a database identifier '$db_handle'
 * used by some database querys.
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;
}


//output frame must be loaded first else parent.output.document has no properties
if ($init==1){
  sleep(1);
}else{
  $result       = mysql_query("SELECT zeile FROM channels WHERE Name = '$channel'",$db_handle);
  $lastRowDB    = mysql_result($result,0,"zeile");
  mysql_free_result($result);
  
  if($lastRowDB==$lastRow){
    if($BROWSER_NAME=='nn'){echo ' ';}//to prevent a no data message in netscape 4.x browsers
    exit;
  }
}

if(!@session_is_registered('pruef')){

  /**
   * Check for access permissions of this page
   *
   * compare the given and the calculated checksum, 
   * if they don't match the user has no permissions 
   * and the script ends by printing a status header of 204 
   * (no content change by client browser)
   */
  if($Nick && !check_permissions($Nick,$pruef)){
    
    //the user has no access permission for this page
    exit;
  }
  
  /**
   * Check for access permissions for the current channel
   *
   * compare the given and the calculated checksum, 
   * if they don't match the user has no permissions 
   * and the script ends.
   */
  if($Nick && (Crypt($channel,$salt_channels)!=$chanpruef) && ($channel!=$ENTRYCHANNELNAME)){
    exit;
  }
}

/**
 * Import some data of the active channel and
 * initialize default values
 */
include ("channels_inc.php");

/**
 * Prints in defined periods messages in the chat
 *
 * @param integer $db_handle
 * @global $Nick,$MODERATOR_NAME,$channickcolor
 * @author Michael Oertel <Michael@ortelius.de>
 */
function Moderator ($db_handle){
  $zufall  = srand(date("s",time()));
  $zufall  = Rand()%10;
  $result  = mysql_query("SELECT Message_$zufall AS Feld FROM chat_messages",$db_handle);
  $message = mysql_result($result,0,"Feld");
  mysql_free_result($result);
  global $Nick;
  $result  = mysql_query("SELECT Quassel FROM chat WHERE Nick='$Nick'",$db_handle);
  $privat  = @mysql_result($result,0,"Quassel");
  mysql_free_result($result);

  if (!$privat){
    global $MODERATOR_NAME,$channickcolor;
    echo 'parent.output.document.write(\'<b><font color="'.$channickcolor.'">'.$MODERATOR_NAME.':<\/font><\/b><font> Hey '.$Nick.'! '.$message.'<\/font><BR>\');';
    flush();
  }
}

/**
 * Completes a line with a link to select a chatter
 *
 * @author Michael Oertel <Michael@ortelius.de>
 * @global $INSTALL_DIR,$FILE_EXTENSION,$channel,$privat,$no_gruentxt,$Nick,$pruef,$chanpruef,$scroll,$ENABLE_SESSION
 * @param string $line call by reference
 * @þaram string $from_chatter
 * @þaram integer $line_is_enabled
 * @þaram integer $usergroup 1=godfathers, ...
 */
function complete_line ($line,$from_chatter,$line_is_enabled,$usergroup){
  global $channel,$is_vip,$is_moderator_for,$channickcolor;

  // clean the line from status comment ( <!-- $to_chatter|$from_chatter|0|0|0|--> )
  $line = substr($line,strpos($line,'-->')+3,strlen($line));

  if($line_is_enabled){
    $tmp_line = '<STRONG>'.$line.'<\/STRONG>';
  }else{
    $tmp_line = $line;
  }

  if($is_vip||$is_moderator_for){
    $line  = '<font COLOR="'.$channickcolor.'"><STRONG><U>'.$from_chatter.'<\/U><\/STRONG><\/font>'.$tmp_line;
    return '';
  }
  $line  = '<a href="dummy.html#" target="dummy" onClick="select(\''.$from_chatter.'\')" onMouseOver="window.status=\'select '.$from_chatter.'\';return true" onMouseout="window.status=\'\';"><b>';
  
  if($usergroup==1){
    //group of chat's godfathers
    global $PATEN_COLOR;
    $line .= '<font color="'.$PATEN_COLOR.'">';
  }else{
    $line .= '<font>';
  }
  $line .= $from_chatter.'<\/font><\/b><\/a>'.$tmp_line;
}

/**
 * filters every new text line
 *
 * it is determined, who can see the respective line in the chat
 *
 * @param string $line
 * @global $Nick,$privat,$no_gruentxt,$pruef,$channel,$chanpruef,$scroll,$is_vip,$is_moderator_for,$channel_is_moderated,$MODERATOR_MESSAGE,$vip,$READING_MSG,$WISPERS_TO,$SAYS_TO,$is_como,$EDIT,$INSTALL_DIR,$FILE_EXTENSION,$PATEN_COLOR,$VIP_COLOR,$MODERATOR_COLOR,$channickcolor,$pass_phrase,$salt_nick,$MAX_NICK_LENGTH
 * @author Michael Oertel <Michael@ortelius.de>
 */
function Filter ($line){

  /** 
   * informations about the text line 
   *
   * every text line contains information about his self in a leading html comment string.
   * Format: <!--<nickname>|<nickname>|<integer>|<integer>|<integer>-->
   * The nickname on the first place is the nick which receives the text line.
   * The second is the nick which transmitted the text line.
   * The number on third place describes whether it was whispered (value = 1) or the text line contains a mail text (value = 2)
   * The fourth number determines whether the line was sent by a godfather of chat (german: Pate)
   * The fifth number determines whether the line is public in case the channel is moderated
   *
   * @var string $str The first 35 chars of the leading HTML comment string in every chat line.
   */
  global $MAX_NICK_LENGTH;
  $str  = substr($line,5,($MAX_NICK_LENGTH*2)+8);

  /**
   * The nick which receives the text line.
   *
   * @var string $to_chatter 
   */
  $to_chatter_default=strtok($str,'|');
  $to_chatter = strtolower($to_chatter_default);

  /**
   * The nick which transmitted the text line.
   *
   * @var string $from_chatter 
   */
  $from_chatter_default = strtok('|');
  $from_chatter         = strtolower($from_chatter_default);
  
  /**
   * if it was whispered $wispered = 1 
   * if the text line was spoken $wispered = 2
   * otherwise $wispered = 0
   *
   * @var integer $wispered 
   */
  $wispered=strtok('|');
  
  /**
   * User groups
   *
   * If is set to '1', if the line comes from a godfather 
   *
   * @var integer $pate 
   */
  $usergroup=strtok('|');

  /**
   * moderator flag
   *
   * If is set, the line is enabled by the moderator 
   *
   * @var integer $line_is_enabled
   */
  $line_is_enabled=strtok('|');
  global $Nick,$init,$chanchange;
  if(strtolower($Nick)==$from_chatter && !$init && !$chanchange && !$line_is_enabled){
    $line = '';
    return ''; 
  }
  
  global $INSTALL_DIR,$FILE_EXTENSION,$channel,$no_gruentxt,$pruef,$chanpruef,$scroll;
  global $channel_is_moderated;
  if($channel_is_moderated){
    global $EDIT,$is_moderator_for,$is_como,$vip,$is_vip,$moderator;
    
    if($is_moderator_for){
      //the chatter is a moderator for the current channel
      //he has to moderate all the lines
      
      //no moderation for wispered lines between normal users
      if(($wispered==2)||($to_chatter != strtolower($Nick) &&
                          $to_chatter != $vip &&
                          $wispered)){
        $line = '';
        return ''; 
      }

      //append a link to edit and to enable the line by a moderator
      if($from_chatter && !$line_is_enabled && !($wispered && $to_chatter==strtolower($Nick))){
        global $ENABLE_SESSION;
        if($ENABLE_SESSION){
          global $SESSION_NAME,$$SESSION_NAME;
          $line_tmp  = '<a href="edit.'.$FILE_EXTENSION.'?'.$SESSION_NAME.'='.$$SESSION_NAME;
          $line_tmp .= '&channel='.urlencode($channel);
        }else{
          $line_tmp  = '<a href="edit.'.$FILE_EXTENSION.'?Nick='.urlencode($Nick);
          $line_tmp .= '&pruef='.$pruef.'&channel='.urlencode($channel);
        }
        $line_tmp .= '&line='.urlencode($line).'" target="moderate">&nbsp;'.$EDIT.'<\/A>';
        $line .= $line_tmp;
      }
      complete_line(&$line,$from_chatter_default,$line_is_enabled,$usergroup);
      $line .= '<BR>';
      return ''; 
      
    }elseif($is_como){
      //the user is a comoderator, he has to get all the lines
      complete_line(&$line,$from_chatter_default,0,$usergroup);
      global $OPENED_TO_PUB;
      if($line_is_enabled){$line .= ' <font>('.$OPENED_TO_PUB. ')<\/font>';}
      $line .= '<BR>';
      return ''; 
    }elseif($line_is_enabled){
      //the moderator and the vip can wisper enabled lines only
      if($wispered && strtolower($Nick)!=$vip && strtolower($Nick)!=$moderator){
        $line = '';
        return ''; 	
      }
      
      //the line is already moderated
      complete_line(&$line,$from_chatter_default,0,$usergroup);
      $line .= '<BR>';
      return '';
    }elseif($Nick && $from_chatter==strtolower($Nick) && !$wispered){
      //a wispered line to an normal user will be not moderated
      //in case of a not wispered line the user gets a message like 'the line was send to the moderator'
      global $MODERATOR_MESSAGE;
      echo 'parent.output.document.write(\'';
      echo '<font>'.$MODERATOR_MESSAGE.': <STRONG>'.$from_chatter.'<\/STRONG> '.$line.'<\/font><BR>';
      echo '\');';
      flush();
      $line = '';
      return '';
    }elseif($wispered && $to_chatter != $vip && ($from_chatter == strtolower($Nick) || $to_chatter == strtolower($Nick))){
      complete_line(&$line,$from_chatter_default,0,$usergroup);
      $line .= '<BR>';
      return ''; 
    }else{
      $line = '';
      return ''; 
    }
    
  }else{
    //channel is not moderated


    if(strtolower($from_chatter) == strtolower($Nick) ||
       strtolower($to_chatter)   ==  strtolower($Nick)){

      
      //highlite the nickname
      global $SAYS_TO,$WISPERS_TO;
      $line=str_replace("<EM>$SAYS_TO $Nick: <\/EM>","<STRONG>$SAYS_TO $Nick<BLINK>!<\/BLINK>:<\/STRONG> ",$line);
      $line=str_replace("<EM>$WISPERS_TO $Nick: <\/EM>","<STRONG>$WISPERS_TO $Nick<MARQUEE width=5 direction=\"right\" scrolldelay=500><BLINK>!   <\/BLINK><\/MARQUEE>:<\/STRONG> ",$line);
      complete_line(&$line,$from_chatter_default,0,$usergroup);
      $line .= '<br>';
      return '';
    }else{
      //the line is not from or to me spoken
      global $privat,$WISPERS_TO;
      if($wispered || $privat){
		//the line is wispered or it is a message
		//or the user don't want to see all the spoken lines 
		//($privat=1 means the user has switched on his 'Twaddel-Filter')
		if(!$privat && !$no_gruentxt && $wispered==1){
		  global $WISPERS_TO;
		  echo 'wrt(\'<font>'.$from_chatter_default.' '.$WISPERS_TO.' '.$to_chatter_default,'<\/font><br>\');';
		  flush();
		}
		
		$line='';
		return '';
	      }else{
		//the line is not wispered so the user can get it
		complete_line(&$line,$from_chatter_default,0,$usergroup);
		$line .= '<br>';
		return '';
      }
    }
  }
}

/**
 * shows the link to reload text
 *
 * @global $Nick,$channel,$pruef,$chanpruef,$UPDATE_TEXT,$INSTALL_DIR,$FILE_EXTENSION
 */
function Reload_text(){
  global $Nick,$channel,$pruef,$chanpruef,$UPDATE_TEXT,$INSTALL_DIR,$FILE_EXTENSION;
  echo 'parent.output.document.write(\'';
  echo "<P STYLE=\"margin-top: 5px; margin-bottom: 0px;\">";
  echo "<A onMouseover=\"window.status='$UPDATE_TEXT'; return true;\" HREF=\"$INSTALL_DIR/getlines.$FILE_EXTENSION";
  echo "?Nick=$Nick&channel=$channel&pruef=$pruef&chanpruef=$chanpruef&init=1&".session_name()."=".session_id()."\">$UPDATE_TEXT<\/A>";
  echo "<\/P>";
  echo '\');';
}

function getUserStatus ($Nick,$channel,$db_handle){

  //Set the VIP if exists for this channel
  $result=mysql_query("SELECT Nick,Moderator FROM vip WHERE Channel='$channel' LIMIT 1",$db_handle);
  if(mysql_num_rows($result)>0){
    global $vip,$moderator;
    $vip       = strtolower(mysql_result($result,0,"Nick"));
    $moderator = strtolower(mysql_result($result,0,"Moderator"));
  }
  mysql_free_result($result);
  
  if($ENABLED_SESSION){
    //Check if the user the VIP
    $result=mysql_query("SELECT Nick FROM vip WHERE Nick='$Nick' LIMIT 1",$db_handle);
    if(@mysql_num_rows($result)>0){
      global $is_vip;
      $is_vip=strtolower(mysql_result($result,0,"Nick"));
    }
    mysql_free_result($result);
  }
  
  //Check if the user a Co-Moderator
  $result=mysql_query("SELECT Nick FROM comoderators WHERE Nick='$Nick' LIMIT 1",$db_handle);
  if(@mysql_num_rows($result)>0){
    global $is_como;
    $is_como=strtolower(mysql_result($result,0,"Nick"));
  }
  mysql_free_result($result);
  
  //Check if the user a Moderator
  $result=mysql_query("SELECT Nick FROM vip WHERE Moderator='$Nick' LIMIT 1",$db_handle);
  if(@mysql_num_rows($result)>0){
    global $is_moderator_for;
    $is_moderator_for=strtolower(mysql_result($result,0,"Nick"));
  }
  mysql_free_result($result);  
}


if ($init==1 || $chanchange==1){
  //Is this a password protected channel?
  include "login_inc.php";
  $channel_login_form=channel_login($Nick,$channel,$db_handle);
  
  getUserStatus($Nick,$channel,$db_handle);
  
  $now = gmdate("D, d M Y H:i:s")." GMT";
  Header("Date: $now");
  Header("Expires: $now");
  Header("Last-Modified: $now");
  Header("Pragma: no-cache");
  Header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
  Header("Content-Type: text/html");
  echo '<html><head>
<script type="text/javascript">';
  if(!$ENABLED_SESSION){
    echo '
//store user status for the current channel
parent.vip=\''.$vip.'\';
parent.moderator=\''.$moderator.'\';
parent.is_vip=\''.$is_vip.'\';
parent.is_como=\''.$is_como.'\';
parent.is_moderator_for=\''.$is_moderator_for.'\';
';
  }
  echo '
function wrt(line){
 parent.output.document.write(line);
}
parent.init=0;
parent.chanchange=0;
parent.flag=0;
';

  /*
   * output last $ROW_BUFFER_SIZE chat lines
   */
  $linesToWrite     = $ROW_BUFFER_SIZE;
  $result           = mysql_query("SELECT zeile,moderiert,UNIX_TIMESTAMP(starts_at) AS start, UNIX_TIMESTAMP(stops_at) AS stop FROM channels WHERE Name = '$channel'",$db_handle);
  $lastRowDB        = mysql_result($result,0,"zeile");
  $channel_is_moderated = mysql_result($result,0,"moderiert");
  $output_starts_at = ($lastRowDB + 1) % $ROW_BUFFER_SIZE;
  $lastRow          = $lastRowDB;//save the number of lines, those were aleady read
  mysql_free_result($result);
    
  /*
   * output html-header
   */
  if($chanchange==0&&!$form){
?>
wrt('<html><head>');
wrt('<meta name="robots" content="noindex">');
wrt('<style type="text/css">');
wrt('font{font-size: <?=$CHAT_TEXT_SIZE?>;}');
wrt('//body {scrollbar-face-color: #284628; scrollbar-shadow-color: #000000; scrollbar-highlight-color: #339553; scrollbar-3dlight-color: #66B886; scrollbar-darkshadow-color: #000000; scrollbar-track-color: #284628; scrollbar-arrow-color: #66B886;}');
wrt('<\/style>');
wrt('<link rel="stylesheet" type="text/css" href="<?=$INSTALL_DIR?>/style.css">');
wrt('<script type="text/javascript">');
wrt('function opensat(url){window.open(url,"","width=520,height=250,status=no,toolbar=no,menubar=no,resizable=no,scrollbars=no,location=no,directories=no,copyhistory=no,screenX=50,screenY=120")}');
wrt('function select(nick){parent.input.document.input.say_to_nick.value=nick}');
wrt('<\/script><\/head>');
wrt('<body bgcolor="<?=$chanbgcolor?>" text="#66B886" link="<?=$channickcolor?>" vlink="<?=$channickcolor?>" leftmargin="3" topmargin="0" marginheight="0" marginwidth="0">');
wrt('<p style="margin-top:5px;margin-bottom:30px;">PHPOpenChat v<?=$VERSION_NUMBER?><BR>For more information visit <A HREF="http://www.ortelius.de/phpopenchat/" target="_new">http://www.ortelius.de/phpopenchat/<\/a><\/p>');
wrt('<b><?=$Nick?><\/b> <i><font>* <?=$JOINING_IN?> *<\/font><\/i><br>');
<?
  flush();
  }
  
  if($chanchange){
    echo 'parent.output.document.bgColor=\''.$chanbgcolor.'\';';
    echo 'parent.output.document.vlink=\''.$channickcolor.'\';';
    echo 'parent.output.document.link=\''.$channickcolor.'\';';
  }
  
  // Request to give a password for this channel, if for the channel still no access authorization exists.
  if($channel_login_form){
    //echo $channel_login_form;
    if(!$form){
      echo 'wrt(\''.$channel_login_form.'\');<\/script><\/head><\/html>';
    }else{
      echo '</script></head></html>';
    }
    exit;
  }

}else{
  /*
   * output all new chat lines
   */
  $result       = mysql_query("SELECT zeile,moderiert,UNIX_TIMESTAMP(starts_at) AS start, UNIX_TIMESTAMP(stops_at) AS stop FROM channels WHERE Name = '$channel'",$db_handle);
  $lastRowDB    = mysql_result($result,0,"zeile");
  $channel_is_moderated = mysql_result($result,0,"moderiert");
  mysql_free_result($result);
  
  $now = gmdate("D, d M Y H:i:s")." GMT";
  Header("Date: $now");
  Header("Expires: $now");
  Header("Last-Modified: $now");
  Header("Pragma: no-cache");
  Header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
  Header("Content-Type: text/html");
  echo '<html><head><script type="text/javascript">
function wrt(line){
 parent.output.document.write(line);
}
parent.flag=0;
';
  $linesToWrite = abs($lastRowDB - $lastRow);
  if($lastRowDB < $lastRow){
    $linesToWrite = $ROW_BUFFER_SIZE - $linesToWrite;
  }
  if($linesToWrite>$ROW_BUFFER_SIZE){
    echo 'wrt(\'Buffer overflow by '.$linesToWrite.' rows of text.<BR>Current Buffer size is '.$ROW_BUFFER_SIZE.'<br>\');';
    $linesToWrite=$ROW_BUFFER_SIZE;
  }
  $output_starts_at = ($lastRow + 1) % $ROW_BUFFER_SIZE;
  $lastRow = $lastRowDB;//save the number of lines, those were aleady read  
}

if(!$ENABLED_SESSION){
  echo 'parent.lastRow='.$lastRow.';
';
}

$result=mysql_query("SELECT zeile_0,zeile_1,zeile_2,zeile_3,zeile_4,zeile_5,zeile_6,zeile_7,zeile_8,zeile_9,zeile_10,zeile_11,zeile_12,zeile_13,zeile_14,zeile_15,zeile_16,zeile_17,zeile_18,zeile_19,zeile_20,zeile_21,zeile_22,zeile_23,zeile_24,zeile_25,zeile_26,zeile_27,zeile_28,zeile_29,zeile_30,zeile_31,zeile_32,zeile_33,zeile_34,zeile_35,zeile_36,zeile_37,zeile_38,zeile_39 FROM channels WHERE Name = '$channel'",$db_handle);
$lines=mysql_fetch_row($result);
mysql_free_result($result);

$result=mysql_query("SELECT Quassel,Gruentext,Ignor FROM chat WHERE Nick='$Nick'",$db_handle);
if($row=@mysql_fetch_object($result)){
  $privat      = $row->Quassel;
  $no_gruentxt = $row->Gruentext;
  $kick        = $row->Ignor;//contains the ignored nicks separated by a | symbol
}else{
  $privat = FALSE;
}
mysql_free_result($result);

//how many chatters are ignored by the user?
if($kick){
  $dummbrote = explode("|",$kick);
  $x = count($dummbrote);
}else{
  $x=0;
}

$i=0;
while($i < $linesToWrite){
  $line = $lines[($output_starts_at + $i) % $ROW_BUFFER_SIZE];

  //Ignore lines of ignored chatter
  $y=1;
  while($x>=$y){
    if($dummbrote[$y]&&(ereg("\|".$dummbrote[$y]."\|",$line))){
      $line='';
    }
    $y++;
  }

  if($line){
    Filter(&$line);
    if($line){
      echo 'wrt(\''.str_replace('\'','\\\'',$line).'\');'.nl;
    }
  }
  $i++;
}
if((intval($ii) % $MODERATOR_RATE)==0){
  //output chat-messages controlled by the admin tool
  Moderator($db_handle);
}
if(!$ENABLE_SESSION){
  echo 'parent.ii++;
';
}else{
  $ii++;
}
?>
parent.flag=1;
</script></head></html>
