<?
/////////////////////////////////////////////////////////
//	
//	include/read_message_tools.inc
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	PURPOSE:
		See "source/read_message.php"
	PRE-CONDITIONS:
		See "source/read_message.php"
	COMMENTS:
		Basically exiled into an include because it was an obnoxious block of code
		that messed up code-aesthetics beyond reason.
		
********************************************************/

				$folder_url = urlencode($folder);
				$target="scr".$user.$folder_url.$id;
				echo "<table border=0 width=\"100%\"><tr><td>";
				echo "<table bgcolor=\"$hilitec\"><tr><td>";
				//echo "[<a href=\"main.php?user=$user&folder=$folder_url&index=$index\">".$rmStrings[0]."</a>]";
				echo "[<a href=\"compose.php?user=$user&replyto=1&folder=$folder_url&id=$id&part=$part\" target=\"$target\">".$rmStrings[1]."</a>]";
				echo "[<a href=\"compose.php?user=$user&replyto=1&replyto_all=1&folder=$folder_url&id=$id&part=$part\" target=\"$target\">".$rmStrings[14]."</a>]";
				echo "[<a href=\"compose.php?user=$user&forward=1&folder=$folder_url&id=$id&part=$part\" target=\"$target\">".$rmStrings[2]."</a>]";
				if ($header->deleted) echo "[<a href=\"read_message.php?user=$user&folder=$folder_url&id=$id&undelete=1\">".$rmStrings[3]."</a>]";
 				else {
 				    echo "\n<script type=text/javascript language=JavaScript1.2>\n ";
					echo "if (window.name!='list2') window.name=\"$target\";\n";
 				    echo "function deletemsg() {\n var url=\"main.php?user=$user&folder=$folder_url&checkboxes[]=$id&submit=Delete\";\n if (opener) { opener.parent.list2.location=url; window.close();} else location=url;\n}\n";
 				    echo "document.write(\"[<a href='javascript:deletemsg();'>".$rmStrings[4]."</a>]\");</script>\n";
 				    echo "<noscript>[<a href=\"main.php?user=$user&folder=$folder_url&checkboxes[]=$id&submit=Delete\">".$rmStrings[4]."</a>]</noscript>\n";
 				}
				//else echo "[<a href=\"main.php?user=$user&folder=$folder_url&checkboxes[]=$id&submit=Delete\">".$rmStrings[4]."</a>]";
				echo "[<a href=\"main.php?user=$user&folder=$folder_url&checkboxes[]=$id&submit=Unread\">".$rmStrings[11]."</a>]";
				echo "</td></tr></table>\n";
				echo "</td><td align=\"right\" valign=\"top\">";
					echo "<!--\n";
                    if ($id > 1)
                        echo "[<a href=\"read_message.php?user=$user&folder=$folder_url&id=".($id-1)."&num_msgs=$num_msgs\">&lt;&lt;</a>]";
                    if ($id < $num_msgs)
                        echo "[<a href=\"read_message.php?user=$user&folder=$folder_url&id=".($id+1)."&num_msgs=$num_msgs\">&gt;&gt;</a>]";
					echo "\n//-->\n";
				echo "</td></tr></table>";
				flush();
?>