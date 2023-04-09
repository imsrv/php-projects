<?
/////////////////////////////////////////////////////////
//	
//	include/read_message_print.inc
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
		Actual code that displays message body part in "source/read_message.php"
	PRE-CONDITIONS:
		There's a bunch.  Look in "source/read_message.php"
	COMMENTS:
		Yeah, I know it's messy.

********************************************************/


				/* figure out the body part's type */
					
					$typestring=iml_GetPartTypeString($structure, $part);
					list($type, $subtype) = explode("/", $typestring);
				
				/* fetch body part */
					$body=iil_C_FetchPartBody($conn, $folder, $id, $part);

				/* decode body part */
					$encoding=iml_GetPartEncodingCode($structure, $part);
					if ($encoding == 3 ) $body=base64_decode($body);
					else if ($encoding == 4) $body=quoted_printable_decode($body);					

				/* run through character encoding engine */
					$body=LangConvert($body, $my_charset);

				/* dump! */
					echo "<p>";
					if (strcasecmp($subtype, "html")==0){
						if (!$my_prefs["html_in_frame"]){
							$body=strip_tags($body, '<a><b><i><u><p><br><font><div>');
						}
						echo $body;
					}else{
						/* quote colorization */
                        $process = (($my_prefs["colorize_quotes"]==1) || ($my_prefs["detect_links"]==1));
                        if ($process){
                            $color=$my_colors["quotes"];
                            if (empty($color)) $color="blue";
                            
                            $lines=explode("\n", $body);
                            while (list($key, $line)=each($lines)){
                                $line = trim(chop($line));
                                if ($my_prefs["colorize_quotes"]==1){
                                    //colorize quotes
                                    if (($line[0]==">")&&(!$quoteLN)){
                                        $quoteLN=true;
                                        echo "<font color=$color>";
                                    }
                                    if (($line[0]!=">")&&($quoteLN)){
                                        $quoteLN=false;
                                        echo "</font>";
                                    }
                                }
                                $line = htmlspecialchars($line);
                                if ($my_prefs["detect_links"]==1){
                                    //detect URL
                                    if (strpos($line, "http://")===false){
                                    }else{
                                        $la = explode(" ", $line);
                                        $nw = count($la);
                                        for ($j=0;$j<$nw;$j++){
                                            $pos = strpos($la[$j], "http://");
                                            if (!($pos===false)){
                                                $url = $la[$j];
                                                if ($pos > 0) $url = substr($url, $pos);
                                                $url = str_replace("&gt;", "", $url);
                                                $url = chop($url, ").");
                                                $la[$j]="<a href=\"$url\" target=_blank>".$la[$j]."</a>";
                                            }
                                        }
                                        $line = implode(" ", $la);
                                    }
                                }
                                echo $line."<br>\n"; flush();
                            }
						}else{
							echo "<p>".nl2br(htmlspecialchars($body));
						}
					}

					flush();
					
?>
