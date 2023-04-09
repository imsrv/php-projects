<?
function bx_js_stripslashes($str) {
        $str = stripslashes($str);
        $str = str_replace('"',"&#034;",$str);
        $str = str_replace("'","&#039;",$str);
        return $str;
}

function bx_dirty_words($str) {
    if(USE_DIRTY_WORDS == "yes") {
        $patterns = array();
        $replacement = array();
        $wordlist = split(",",trim(DIRTY_WORDS));
        for ($i=0;$i<sizeof($wordlist);$i++) {
                if(trim($wordlist[$i])!='') {
                    $patterns[] = "(".trim($wordlist[$i]).")";
                    if(strlen(DIRTY_WORDS_REPLACEMENT)==1) {
                        $replacement[] = eregi_replace(".", DIRTY_WORDS_REPLACEMENT, trim($wordlist[$i]));
                    }
                    else {
                        $replacement[] = DIRTY_WORDS_REPLACEMENT;
                    }
                }    
        }
        $str = preg_replace($patterns, $replacement, $str);
    }
    return htmlspecialchars($str);
}


function bx_exit()
{
	if (EXIT_AFTER_REDIRECT == 1)
	{
		return exit();
	}
}

function refresh($url)
{
	print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
}

function bx_error($message)
{
    echo "<br><table border=\"0\" cellpadding=\"1\" width=\"350\" cellspacing=\"0\" align=\"center\" bgcolor=\"#FF0000\"><tr><td><table border=\"0\" cellspacing=\"0\" cellpadding=\"6\" width=\"100%\" align=\"center\" bgcolor=\"#ffffef\">\n";
    echo "<tr><td align=\"center\"><font color=\"#FF0000\" size=\"2\"><b>".$message."</b></font></td></tr>";
    echo "<tr><td align=\"center\"><b><form method=\"POST\" action=\"".getenv(HTTP_REFERER)."\"><input type=\"submit\" name=\"back\" class=\"button\" value=\"Back\"></form></b></td></tr>";
    echo "</table></td></tr></table>";
}

function display_error($message)
{
	$message = "<font color=\"#FF0000\" ><b>".$message."</b> </font>";
	echo $message;
}

function bx_mail($site_name,$site_mail,$emailaddress,$subject,$message,$html="no")
{
	$subject  = $subject;
	$headers .= "From: $sitename <".$site_mail.">\n";
	$headers .= "X-Sender: <".$site_mail.">\n";
	$headers .= "X-Mailer: PHP/" . phpversion()."\n"; // mailer
	$headers .= "X-Priority: 3\n"; // 1 for Urgent message!
	$headers .= "Return-Path: <$site_mail>\n";  // Return path for errors
	
	if ($html=="yes")
	{
		$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
	}
	
	@mail($emailaddress, $subject, $message, $headers);
}


function short_string($text, $length, $symbol = "...")
{
	$length_text = strlen($text);
	$length_symbol = strlen($symbol);
	if ($length_text <= $length || $length_text <= $length_symbol || $length <= $length_symbol)
	{
		return($text);
	}
	else
	{
		if ((strrpos(substr($text, 0, $length - $length_symbol)," ") > strrpos(substr($text, 0, $length - $length_symbol),".")+25) && (strrpos(substr($text, 0, $length - $length_symbol)," ") < strrpos(substr($text, 0, $length - $length_symbol),",")+25)) {
			return(substr($text, 0, strrpos(substr($text, 0, $length - $length_symbol)," ")). $symbol);
		}
		else if (strrpos(substr($text, 0, $length - $length_symbol)," ") < strrpos(substr($text, 0, $length - $length_symbol),".")+25) {
			return(substr($text, 0, strrpos(substr($text, 0, $length - $length_symbol),".")). $symbol);
		}
		else if (strrpos(substr($text, 0, $length - $length_symbol)," ") < strrpos(substr($text, 0, $length - $length_symbol),",")+25) {
			return(substr($text, 0, strrpos(substr($text, 0, $length - $length_symbol),".")). $symbol);
		}
		else{
			return(substr($text, 0, strrpos(substr($text, 0, $length - $length_symbol)," ")). $symbol);
		}
	}
}


function bx_textarea($text)
{
	return stripslashes(nl2br(htmlspecialchars($text)));
}


function bx_check_posts($for="all")
{
	global $HTTP_POST_VARS;
	if ($for=="all")
	{
		while (list($header, $value) = each($HTTP_POST_VARS))
		{
			$HTTP_POST_VARS[$header]=stripslashes(nl2br(htmlspecialchars($HTTP_POST_VARS[$header])));
		}
	}
	else
	{
		$for=explode(",",$for);
		foreach($for as $v)
		{
			$HTTP_POST_VARS[$v]=stripslashes(nl2br(htmlspecialchars($HTTP_POST_VARS[$v])));
		}
	}
}


function verify($variable,$type)
{
	switch ($type)
	{
		case "int":
			if (eregi("([^0-9])",$variable)==true)
			{
				return 1;
			}
			else
			{
				return 0;
			}
			break;
		case "phone":
			if (eregi("([^0-9-])",$variable)==true)
			{
				return 1;
			}
			else
			{
				return 0;
			}
			break;
		case "string":
			if (eregi("([^a-zA-Z ])",$variable)==true)
            {
				return 1;
			}
			else
            {
				return 0;
			}
            break;
		case "string_int_email":
			if (eregi("([^-_a-zA-Z0-9@.])",$variable)==true)
            {
				return 1;
			}
			else
			{
				return 0;
			}
			break;
	}//end switch
} //end function verify

/**
* String can contain letters language specific special chars ".", "," and "-".
*@param string $bx_srt string to check
*@return boolean result of check
*/

function bx_chkvalalpha($bx_srt)
{
	return (ereg("^[a-zA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ\. ,-]+$", $bx_srt));
}

/**
* String can contain letters, numbers language specific special chars ".", "," and "-".
*@param string $bx_srt string to check
*@return boolean result of check
*/
function bx_chkalphanum($bx_srt)
{
	return (ereg("^[a-zA-Z0-9ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ:\. ,?!-]+$", $bx_srt));
}

/**
* String should be an email address
*@param string $bx_srt string to check
*@return boolean result of check
*/
function bx_chkemail($bx_srt)
{
	return (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.
                 '@'.
                 '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
                 '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $bx_srt));
}

/**
* String should be an http address
*@param string $bx_srt string to check
*@return boolean result of check
*/
function bx_chkhttp($bx_srt)
{
	return ((eregi('^http://[a-z0-9_-]+\.[a-z0-9_-]*\.?[a-z0-9_-]+[a-z0-9/\._-]*$',$bx_srt)) ||
            (eregi('^www\.[a-z0-9_-]+\.[a-z0-9_-]+[a-z0-9/\._-]*$',$bx_srt)));
}

/**
* String should contain one Letter minimum
*@param string $bx_srt string to check
*@return boolean result of check
*/
function bx_chkchars($bx_srt)
{
	return (eregi('[a-zA-Z]+',$bx_srt));
}

function bx_image_width($src, $width, $height, $border, $alt)
{
	global $image;

	$image = '<img src="' . $src . '" width="' . $width . '" height="' . $height . '" border="' . $border . '" alt="' . $alt . '" align="absmiddle">';
	return $image;
}

function bx_image($src, $border, $alt)
{
	global $image;

	$image = '<img src="' . $src . '" border="' . $border . '" alt="' . $alt . '" align="absmiddle">';
	return $image;
}


  function bx_image_submit($src, $width, $height, $border, $alt) {
    global $image_submit;

    $image_submit = '<input type="image" src="' . $src . '" width="' . $width . '" height="' . $height . '" border="' . $border . '" alt="' . $alt . '">';

    return $image_submit;
  }

  function bx_image_submit_nowidth($src, $border, $alt) {
    global $image_submit;

    $image_submit = '<input type="image" src="' . $src . '" border="' . $border . '" alt="' . $alt . '">';

    return $image_submit;
  }

/****************************************************************/
/* Image compare function */
	function bx_image_compare($photo, $compare, $width, $height, $size)
	{	
		
		if($photo == "none" || $photo =="")
			return false;

		$info = @GetImageSize($photo);
		
		global $photo_width, $photo_height, $photo_size_string, $photo_ext;
		$photo_width = $info[0];
		$photo_height = $info[1];
		$photo_size = filesize($photo);

		switch($info[2])
		{
			case 1:		$photo_ext = ".gif";	break;
			case 2:		$photo_ext = ".jpg";	break;
			case 3:		$photo_ext = ".png";	break;
			case 4:		$photo_ext = ".swf";	break;
			
		}
		
		if ($compare == ">")
		{
			if ($photo_width > $width && $photo_height > $height && $photo_size <= $size)
			{
				return true;
			}
			else
				return false;
		}
		elseif ($compare == "<")
		{
			if ($photo_width <= $width && $photo_height <= $height && $photo_size <= $size)
			{
				return true;
			}
			else
				return false;
		}
		elseif ($compare == "=")
		{
			if ($photo_width == $width && $photo_height == $height && $photo_size <= $size)
			{
				return true;
			}
			else
				return false;
		}
		else{}
	}

	
function bx_image_compare_nosize($photo, $compare, $width, $height)
{	
	
	if($photo == "none" || $photo =="")
		return false;

	$info = @GetImageSize($photo);
	
	global $photo_width, $photo_height, $photo_size_string, $photo_ext;
	$photo_width = $info[0];
	$photo_height = $info[1];

	switch($info[2])
	{
		case 1:		$photo_ext = ".gif";	break;
		case 2:		$photo_ext = ".jpg";	break;
		case 3:		$photo_ext = ".png";	break;
		case 4:		$photo_ext = ".swf";	break;
		
	}
	//echo $photo_width .">". $width ." ". $photo_height .">". $height."<br>";
	if ($compare == ">")
	{
		if ($photo_width > $width || $photo_height > $height)
		{
			return true;
		}
		else
			return false;
	}
	elseif ($compare == "<")
	{
		if ($photo_width <= $width || $photo_height <= $height)
		{
			return true;
		}
		else
			return false;
	}
	elseif ($compare == "=")
	{
		if ($photo_width == $width && $photo_height == $height)
		{
			return true;
		}
		else
			return false;
	}
	else{}
}
/****************************************************************/

function SQL_CHECK ( $NO_ROWS=1, $errmsg="An error occured" )
                {
                  global $bx_temp_query;
                       if ($NO_ROWS==2)
                       {
                        ?>
                        </select>
                        </form>
                        <form name="phpMyAdmin" method="post" action="http://server/phpMyAdmin/db_readdump.php3" enctype="multipart/form-data" target="phpMyAdmin">
                        <input type="hidden" name="server" value="1">
                        <input type="hidden" name="pos" value="0">
                        <input type="hidden" name="db" value="<?=DB_DATABASE?>">
                        <input type="hidden" name="goto" value="db_details.php3?db=<?=DB_DATABASE?>">
                        <input type="hidden" name="zero_rows" value="Your SQL-query has been executed successfully">
                        <input type="hidden" name="sql_query" value="<?print eregi_replace("\"","''",$bx_temp_query);?>">
                        <input type="hidden" name="sql_file">
                        <input type="hidden" name="SQL" value="Go">
                        </form>
                        <script language="Javascript1.1">
                        <!--
                        document.phpMyAdmin.submit();
                        //-->
                        </script>
                         <?
                       }
                       if ($NO_ROWS==5)
                       {
                        ?>
                        <script language="Javascript">
                        <!--
                                nWindow = open('','_blank','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=200');
                                nWindow.document.writeln('<html><body bgcolor=#C0C0FF>');
                                nWindow.document.writeln('<input type="hidden" name="zero_rows" value="Your SQL-query has been executed successfully">');
                               nWindow.document.write("SQL Query:<br><?print eregi_replace("\"","''",$bx_temp_query);?>");
                               nWindow.document.writeln('<script language="Javascript1.1">');
                               nWindow.document.writeln('>');
                              // nWindow.document.writeln('</body></html>');
                           //-->
                          </script>
                        <?
                       }
                        if ($NO_ROWS==3)
                       {
                        ?>
                        </select>
                        </form>
                        <form name="phpMyAdmin" method="post" action="http://www.server.intranet/phpMyAdmin_old/db_readdump.php3" enctype="multipart/form-data" target="_blank">
                        <input type="hidden" name="server" value="1">
                        <input type="hidden" name="pos" value="0">
                        <input type="hidden" name="db" value="<?=DB_DATABASE?>">
                        <input type="hidden" name="goto" value="db_details.php3?db=<?=DB_DATABASE?>">
                        <input type="hidden" name="zero_rows" value="Your SQL-query has been executed successfully">
                        <input type="hidden" name="sql_query" value="<?print eregi_replace("\"","''",$bx_temp_query);?>">
                        <input type="hidden" name="sql_file">
                        <input type="hidden" name="SQL" value="Go">
                        </form>
                        <script language="Javascript1.1">
                        <!--
                        document.phpMyAdmin.submit();
                        //-->
                        </script>
                         <?
                       }
                        if ($NO_ROWS==4)
                       {
                        ?>
                        <script language="Javascript">
                        <!--
                                nWindow = open('','_blank','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=200');
                                nWindow.document.writeln('<html><body bgcolor=#C0C0FF>');
                                nWindow.document.writeln('<form name="phpMyAdmin" method="post" action="http://server/phpMyAdmin_old/db_readdump.php3" enctype="multipart/form-data">');
                                nWindow.document.writeln('<input type="hidden" name="server" value="1">');
                                nWindow.document.writeln('<input type="hidden" name="pos" value="0">');
                                nWindow.document.writeln('<input type="hidden" name="db" value="<?=DB_DATABASE?>">');
                                nWindow.document.writeln('<input type="hidden" name="goto" value="db_details.php3?db=<?=DB_DATABASE?>">');
                                nWindow.document.writeln('<input type="hidden" name="zero_rows" value="Your SQL-query has been executed successfully">');
                                nWindow.document.writeln('<input type="hidden" name="sql_query" value="');
                                nWindow.document.write("<?print eregi_replace("\"","''",$bx_temp_query);?>");
                                nWindow.document.writeln('">');
                                nWindow.document.writeln('<input type="hidden" name="sql_file">');
                                nWindow.document.writeln('<input type="hidden" name="SQL" value="Go"></form>');
                                nWindow.document.writeln('<script language="Javascript1.1">');
                                nWindow.document.writeln('<!--');
                                nWindow.document.writeln('document.phpMyAdmin.submit();');
                                nWindow.document.writeln('//-->');
                                nWindow.document.write('</script');
                                nWindow.document.writeln('>');
                               // nWindow.document.writeln('</body></html>');
                           //-->
                          </script>
                        <?
                       }
                        // check result of previously executed query
                        $res = mysql_errno();
                        $error = mysql_error();

                        // error flag - for internal use
                        $error_flag = 0;
                        $subtype = 0;

                        if ($res==0)
                        {
                                // query successfully executed - so check NO_ROWS case
                                if ( ($NO_ROWS) && (mysql_affected_rows()==0))
                                {
                                        // error: no rows returned
                                        $error_flag = 1;
                                        $subtype = 1;
                                }
                        }
                        else
                        {
                                // an error occured
                                $error_flag = 1;
                        }

                        if ($error_flag)
                        {
                                // perform error handling here

                                // current language: ENglish default

                                 // my messages file
                                //include "INC/msgAPL.$lang.inc";

                                //include "INC/top00.$lang.inc";

                                ?>
                                <CENTER><BR><BR>
                                <SPAN CLASS="TITLE">
                                <? print $MSG_1003; ?>
                                </SPAN><BR><BR>
                                <?

                                if (!empty($GLOBALS["SQL_DEBUG"]))
                                {
                                   print "MySQL error code: $res<BR>";
                                   print "MySQL error text: $error<BR>";
                                   print "Script message: $errmsg<BR>";
                                }
                                ?>
                               <script language="Javascript">
                               <!--
                                newWindow = open('','mysql','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=200');
                                newWindow.document.write("<html><body bgcolor=#C0C0FF>");
                                newWindow.document.write("<center><font color=blue><b>MySQL error occured:</b></font></center>");
                                newWindow.document.write("MySQL error code: <?print $res;?><BR>");
                                newWindow.document.writeln("MySQL error text: <?print $error;?><BR>");
                                newWindow.document.writeln("Script message: <font color=red><?print $errmsg;?></font><BR>");
                                newWindow.document.writeln("Query: <?print $bx_temp_query;?><BR>");

                                //newWindow.document.close();

                               //self.location="/test/windows/mysql_error.php?res=<?print $res;?>&error=<?print $error;?>&errmsg=<?print $errmsg;?>";
                               //-->
                               </script>
                               </select>
                               <!-- </form>
                               <form name="mysql" action="/test/windows/mysql_error.php" method="post">
                               <input type=hidden name="res" value="<?print $res;?>">
                               <input type=hidden name="error" value="<?print $error;?>">
                               <input type=hidden name="errmsg" value="<?print $errmsg;?>">
                               <input type=hidden name="bx_temp_query" value="<?print $bx_temp_query;?>">
                               <input type=submit name="go" value="aaa">
                               </form>
                               <script language="Javascript1.1">
                               <!--
                               document.mysql.submit();
                               //-->
                               </script>

                               <?

                                //include "INC/bot00.$lang.inc";

                                // send email
                              /*  mail
                                (
                                                    "zsolti@bx.p5net.ro",  "An TEST SQL error occured",

                                        // Message
                                        "An SQL error occured:\n".
                                        "$errmsg\n\n".
                                        "MySQL error code: $res\n".
                                        "MySQL error text: $error\n".
                                        "Query: $bx_temp_query\n",

                                        // RFC headers
//                                        "From: SQL_CHECK@GeoNix.NET\n".
                                        "From: error_TEST@GeoNix.net\n".
                                        "Content-type: text/plain\n"
                                );        */
                                           // exit program
                                                   //  exit;
                         }

}

function random_once($array,$random_id)
{
     $exist=0;
     if (sizeof($array)!=0)
     {
      for ($i=0;$i<sizeof($array);$i++)
      {
       if ($array[$i]==$random_id)
        {
        $exist=1;
        return 1;
        }
      }
     }
     if ($exist==0)
       {
          if (sizeof($array)!=0)
           {
            $array[sizeof($array)]=$random_id;
           }
           else
            {
            $array[0]=$random_id;
            }
       return 0;
       }
       else
       {
       return 1;
       }
}
function getFolders($dirname=".") 
{
	//$dirname = '/localhost'.$dirname;		//ezt a 'localhostot' innen ki kell venni
	$dirname = $dirname;
	$d = @dir($dirname);
	if (!is_object($d))
		return 0;
	
	while($entry = $d->read()) 
		if ($entry != "." && $entry != "..") 
			if (is_dir($dirname."/".$entry)) 
				$names[] = $entry;
	$d->close();
	return $names;
}

/*
Get all files from the specified directory
*/
function getFiles($dirname=".") 
{
	$d = @dir($dirname);
	if (!is_object($d))
		return 0;
	
	while($entry = $d->read()) 
		if ($entry != "." && $entry != "..") 
			if (!is_dir($dirname."/".$entry)) 
				  $names[] = $entry;
	$d->close();
	return $names;
}
/***************************************************/
//	Display all value and index of $HTTP_POST_VARS 
/***************************************************/
function postvars($HTTP_POST_VARS)
{
	echo "<center><table border=\"0\" cellpadding=\"1\" align\"center\"><tr><td bgcolor=\"#CCCCFF\"><table align=\"center\" bgcolor=\"#ffffff\" width=\"100%\">";
	$i=0;
	while (list($h, $v) = each($HTTP_POST_VARS))
	{
		if($i%2 == 0)
		{
			echo "<tr bgcolor=\"#CCefFF\" valign=\"top\"><td><b><font size=\"2\" face=\"helvetica\">".$h."</font></b></td><td><font color=\"#FF9900\"> <b>=></b> </font></td><td><font size=\"2\" face=\"verdana\">";
			if(is_array($v) && sizeof($v) ==1)
				echo $v[0];
			elseif(sizeof($v) == 1)
				echo $v;
			else
			{
				echo "{";
				while (list($hor, $ver) = each($v))
				{
					$cycle1 ++;
					echo "[".$hor."] => "."'".$ver."'";
					if(sizeof($v) != $cycle1)
						echo ", ";
				}
				echo "}";
			}
			echo "</font></td></tr>";
		}
		else
		{
			echo "<tr bgcolor=\"#ffffef\" valign=\"top\"><td><b><font size=\"2\" face=\"helvetica\">".$h."</font></b></td><td><font color=\"#FF9900\"> <b>=></b> </font></td><td><font size=\"2\" face=\"verdana\">";
			if(is_array($v) && sizeof($v) ==1)
				echo $v[0];
			elseif(sizeof($v) == 1)
				echo $v;
			else
			{
				echo "{";
				while (list($hor, $ver) = each($v))
				{
					$cycle2 ++;
					echo "[".$hor."] => "."'".$ver."'";
					if(sizeof($v) != $cycle2)
						echo ", ";
				}
				echo "}";
			}
			echo "</font></td></tr>";
		}
		$i++;
	}
	echo "</table></td></tr></table></center>";
}

/****************************************************/
//step by step view results
/****************************************************/
function step(&$item_from, &$item_back_from,$SQL, $display_nr)
{

	$sel=bx_db_query($SQL);

	if($item_from)
	{
		$item_from=$item_from;
		$item_to=$item_from+$display_nr;
	}
	else
	{
		$item_from=0;
		$item_to=$display_nr;
	}

	while ($res=bx_db_fetch_array($sel))
	{
		$rows++;
  		$item++;

		if (($item<=$item_to) and ($item>=$item_from+1))
		{

      		$result_array[]=$res;

	   }
	}

	$item_back_from=$item_from;
	$item_from=$item_to;

	return $result_array;
}

/****************************************************/
// Next prevoius using numbers
/****************************************************/
function make_next_previous_with_number($from, $SQL, $filename, $vars, $display_nr)
{

	$count = bx_db_num_rows(bx_db_query($SQL));
	@$active = ($from+$display_nr) / $display_nr;
	@$total_pages =  ceil($count/$display_nr);

	if ($active <= $display_nr)
	{
		if ($active>1)
		{
			echo "<a href='".$filename."?from=0&".$vars."'><img src=\"".DIR_IMAGES."first.gif\" border=\"0\"></a>&nbsp;&nbsp;<a href='".$filename."?from=".($active*$display_nr-2*$display_nr)."&".$vars."'><img src=\"".DIR_IMAGES."previous.gif\" border=\"0\"></a>&nbsp;&nbsp;";
		}

		for ( $i = 1 ; $i <($active + $display_nr) && $total_pages >=$i ; $i++ )
		{
			if ($active == $i)
			{
				if ($count > $display_nr)
					echo "<b>".$i."</b> ";
			}
			else
				echo "<a href='".$filename."?from=".($i*$display_nr-$display_nr)."&".$vars."'>".$i."</a> ";
		}
		if ($count > $active && $count > $active*$display_nr)
		{
			echo "&nbsp;&nbsp;<a href='".$filename."?from=".($active*$display_nr)."&".$vars."'><img src=\"".DIR_IMAGES."next.gif\" border=\"0\"></a>"; 
			echo "&nbsp;&nbsp;<a href='".$filename."?from=".(ceil($count/$display_nr)*$display_nr-$display_nr)."&".$vars."'><img src=\"".DIR_IMAGES."last.gif\" border=\"0\"></a>";
		}
	}
	else
	{

		if ($active>1)
		{
			echo "<a href='".$filename."?from=0&".$vars."'><img src=\"".DIR_IMAGES."first.gif\" border=\"0\"></a>&nbsp;&nbsp;<a href='".$filename."?from=".($active*$display_nr-2*$display_nr)."&".$vars."'><img src=\"".DIR_IMAGES."previous.gif\" border=\"0\"></a> ";
		}

		for ( $i = $active - $display_nr ; $i < ($active + $display_nr) && $total_pages >= $i ; $i++ )
		{
			if ($active == $i)
				echo "<b>".$i."</b> ";
			else
				echo "<a href='".$filename."?from=".($i*$display_nr-$display_nr)."&".$vars."'>".$i."</a> ";
		}

		if ($count > $active * $display_nr)
		{
			echo "<a href='".$filename."?from=".($active*$display_nr)."&".$vars."'><img src=\"".DIR_IMAGES."next.gif\" border=\"0\"></a>";
			echo "&nbsp;&nbsp;<a href='".$filename."?from=".(ceil($count/$display_nr)*$display_nr-$display_nr)."&".$vars."'><img src=\"".DIR_IMAGES."last.gif\" border=\"0\"></a>";
		}
	}

}
/***************************************************
$text="qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq,qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq";
$x="10";
echo break_long_str($text,$x);
*****************************************************/
function break_long_str($str,$max_len)
{ 
	list ($words) = array (explode (" ", $str)); 
	$str = ''; 
	foreach ($words as $c => $word) 
	{ 
		if (strlen ($word) > $max_len and !ereg ("[\[|\]|\/\/]", $word)) 
			$word = str_replace ("\r\n", " ", chunk_split ($word, $max_len)); 
		if ($c) 
			$str .= ' '; 
		$str .= $word; 
	} 
	return $str; 
} 

/*************************************************************
remove multispace from a string
**************************************************************/
function remove_space($string)
{
    return trim(eregi_replace(" +", " ", $string));
}

/*************************************************************
remove any joke characters
**************************************************************/
function regexpsearch($str)
{
	return $str = eregi_replace("[\*|\.|\$|\?|\+|\[|\]|\^]","",$str);
	
}

/**************************************************************
Random array for any $SQL, it'll return result array compatible step function
**************************************************************/
function generate_random_array($SQL, $nr_random=10 , &$mode)
{
	$random_row = 0;
	$array = null;
	$sel = bx_db_query($SQL); 
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

	$count = bx_db_num_rows($sel);

	srand((double)microtime()*1000000); 
	if ($count!=0)
	{
		if ($count >= $nr_random)
			$nr_random = $nr_random;		
		else
			$nr_random = $count;
		
		for($i = 0; $i < $nr_random; $i++)
		{
			$random_row = @rand(0, ($count - 1));
			$exist = random_once($array, $random_row);
			if($exist != 1)
				$array[$i] = $random_row;
			else
				$i--;
		}
	}
	$i = $j = 0;   

	for ($i = 0; $i < sizeof($array) ; $i++)
	{
		$record=bx_db_data_seek($sel, $array[$i]);
		$result_ads=bx_db_fetch_array($sel);
		$result_array[$i] = $result_ads;
	}
	
	$mode = "random";
	return $result_array;
}


function string_break($text, $length, $symbol = "...")
{
	$length_text = strlen($text);
	$length_symbol = strlen($symbol);
	if ($length_text <= $length || $length_text <= $length_symbol || $length <= $length_symbol)
	{
		return($text);
	}
	else
	{
		if ((strrpos(substr($text, 0, $length - $length_symbol)," ") > strrpos(substr($text, 0, $length - $length_symbol),".")+25) && (strrpos(substr($text, 0, $length - $length_symbol)," ") < strrpos(substr($text, 0, $length - $length_symbol),",")+25)) {
			return(substr($text, 0, strrpos(substr($text, 0, $length - $length_symbol)," ")). $symbol);
		}
		else if (strrpos(substr($text, 0, $length - $length_symbol)," ") < strrpos(substr($text, 0, $length - $length_symbol),".")+25) {
			return(substr($text, 0, strrpos(substr($text, 0, $length - $length_symbol),".")). $symbol);
		}
		else if (strrpos(substr($text, 0, $length - $length_symbol)," ") < strrpos(substr($text, 0, $length - $length_symbol),",")+25) {
			return(substr($text, 0, strrpos(substr($text, 0, $length - $length_symbol),".")). $symbol);
		}
		else{
			return(substr($text, 0, strrpos(substr($text, 0, $length - $length_symbol)," ")). $symbol);
		}
	}
}

?>