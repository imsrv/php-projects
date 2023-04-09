<?php
session_start();
if(!isset($_SESSION["auid"]) || $_SESSION["auid"]<=0)
{
        header("Location: index.php"); exit;
}
else $auid=$_SESSION["auid"];


require_once("../include/db.php");
require_once("../include/vars.php");
require_once("../include/functions.php");
$err=array();

$mime_types=array("application/EDI-Consent","application/EDI-X12","application/EDIFACT","application/activemessage","application/andrew-inset","application/applefile","application/atomicmail","application/batch-SMTP","application/beep+xml","application/cals-1840","application/commonground","application/cybercash","application/dca-rft","application/dec-dx","application/dvcs","application/eshop","application/http","application/hyperstudio","application/iges","application/index","application/index.cmd","application/index.obj","application/index.response","application/index.vnd","application/iotp","application/ipp","application/isup","application/font-tdpfr","application/mac-binhex40","application/mac-compactpro","application/macwriteii","application/marc","application/mathematica","application/mathematica-old","application/msword","application/news-message-id","application/news-transmission","application/ocsp-request","application/ocsp-response","application/octet-stream","application/oda","application/parityfec","application/pdf","application/pgp-encrypted","application/pgp-keys","application/pgp-signature","application/pkcs10","application/pkcs7-mime","application/pkcs7-signature","application/pkix-cert","application/pkix-crl","application/pkixcmp","application/postscript","application/qsig","application/remote-printing","application/riscos","application/rtf","application/sdp","application/sgml","application/sgml-open-catalog","application/sieve","application/slate","application/smil","application/timestamp-query","application/timestamp-reply","application/vemmi","application/whoispp-query","application/whoispp-response","application/wita","application/wordperfect5.1","application/x-bcpio","application/x-cdlink","application/x-chess-pgn","application/x-compress","application/x-cpio","application/x-csh","application/x-director","application/x-dvi","application/x-futuresplash","application/x-gtar","application/x-gzip","application/x-hdf","application/x-javascript","application/x-koan","application/x-latex","application/x-netcdf","application/x-sh","application/x-shar","application/x-shockwave-flash","application/x-stuffit","application/x-sv4cpio","application/x-sv4crc","application/x-tar","application/x-tcl","application/x-tex","application/x-texinfo","application/x-troff","application/x-troff-man","application/x-troff-me","application/x-troff-ms","application/x-ustar","application/x-wais-source","application/x400-bp","application/xhtml+xml","application/xml","application/xml-dtd","application/zip","audio/32kadpcm","audio/basic","audio/g.722.1","audio/l16","audio/midi","audio/mp4a-latm","audio/mpa-robust","audio/mpeg","audio/parityfec","audio/prs.sid","audio/telephone-event","audio/tone","audio/x-aiff","audio/x-mpegurl","audio/x-pn-realaudio","audio/x-pn-realaudio-plugin","audio/x-realaudio","audio/x-wav","chemical/x-pdb","chemical/x-xyz","image/bmp","image/cgm","image/g3fax","image/gif","image/ief","image/jpeg","image/pjpeg","image/naplps","image/png","image/prs.btif","image/prs.pti","image/tiff","image/x-cmu-raster","image/x-portable-anymap","image/x-portable-bitmap","image/x-portable-graymap","image/x-portable-pixmap","image/x-rgb","image/x-xbitmap","image/x-xpixmap","image/x-xwindowdump","message/delivery-status","message/disposition-notification","message/external-body","message/http","message/news","message/partial","message/rfc822","message/s-http","model/iges","model/mesh","model/vrml","multipart/alternative","multipart/appledouble","multipart/byteranges","multipart/digest","multipart/encrypted","multipart/form-data","multipart/header-set","multipart/mixed","multipart/parallel","multipart/related","multipart/report","multipart/signed","multipart/voice-message","text/calendar","text/css","text/directory","text/enriched","text/html","text/parityfec","text/plain","text/prs.lines.tag","text/rfc822-headers","text/richtext","text/rtf","text/sgml","text/tab-separated-values","text/t140","text/uri-list","text/x-setext","text/xml","video/mp4v-es","video/mpeg","video/parityfec","video/pointer","video/quicktime","video/x-msvideo","video/x-sgi-movie","x-conference/x-cooltalk");


if(count($_POST)>0)
{
        $conf_id=$_REQUEST['conf_id'];
        $conf_val=$_REQUEST['conf_val'];
        $conf_disptxt=$_REQUEST['conf_disptxt'];
        
        switch($conf_id)
        {
                case "MIME_TYPES":
                        /*if(is_array($conf_val) && count($conf_val)>0) 
                        {
                                asort($conf_val);
                                $conf_val=implode(",",$conf_val);                                
                        }        
                        else 
                        {
                                $err[]="Sorry! Error occured";
                                break;
                        }*/
                        $opt=isset($_REQUEST["opt"])?$_REQUEST["opt"]:"";
                        if($opt=="all") $conf_val="";
                        elseif($opt=="some") $conf_val=trim($_REQUEST['conf_val']);
                        else 
                        {
                                $err[]="Sorry! Error occured";
                                break;
                        }                        
                case "MAX_TIME":
                        break;
                case "MAX_COUNT":
                        break;
                case "MAX_SIZE":
                        break;
                case "AUTO_FILE_DELETE":
                        break;
                case "DAILY_TRANSFER":
                        if(empty($conf_val)) $conf_val="0";
                        $conf_disptxt=date("d-m-Y");
                        break;
                default:
                                $err[]="Sorry! Unknown configuration id.";
                        break;                
        }
        if(count($err)==0)
        {
                $qry="UPDATE ".$db->tb("configuration")." SET conf_value='$conf_val',conf_optional='$conf_disptxt' WHERE conf_name='$conf_id'";
                //print $qry;
                $db->query($qry);
                if($db->getaffectedrows()==0) $err[]="Nothing altered! Try again to modify $conf_id.";
                else  $err[]="$conf_id updated successfully.";
        }
}
$qry="SELECT conf_value FROM ".$db->tb("configuration")." WHERE conf_name='MIME_TYPES'";
$db->query($qry);
$row=$db->getrow();
//$mimearr=explode(",",$row[0]);
//asort($mimearr);
$mimearr=$row[0];

$qry="SELECT conf_value, conf_optional FROM ".$db->tb("configuration")." WHERE conf_name='MAX_TIME'";
$db->query($qry);
$row=$db->getrow();
$max_time=$row[0];
$max_time_disptxt=$row[1];

$qry="SELECT conf_value, conf_optional FROM ".$db->tb("configuration")." WHERE conf_name='MAX_COUNT'";
$db->query($qry);
$row=$db->getrow();
$max_count=$row[0];
$max_count_disptxt=$row[1];


$qry="SELECT conf_value, conf_optional FROM ".$db->tb("configuration")." WHERE conf_name='MAX_SIZE'";
$db->query($qry);
$row=$db->getrow();
$max_size=$row[0];
$max_size_disptxt=$row[1];

$qry="SELECT conf_value FROM ".$db->tb("configuration")." WHERE conf_name='AUTO_FILE_DELETE'";
$db->query($qry);
$row=$db->getrow();
$auto_delete=$row[0];

$qry="SELECT conf_value FROM ".$db->tb("configuration")." WHERE conf_name='DAILY_TRANSFER'";
$db->query($qry);
$row=$db->getrow();
$daily_transfer=$row[0];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=SITE_NAME?> (Admin Panel)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../script.js"></script>
</head>

<body>
<table width="740" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #999999">
  <tr>
    <td><?php
        require_once("header.php");
        ?></td>
  </tr>
  <tr>
    <td valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="90%" align="center" cellpadding="2" cellspacing="0" class="table" style="border: 1px solid #9cab93">
        <tr bgcolor="#305b01"> 
          <td width="100%" align="center" nowrap bgcolor="#FFFFFF" class="nav"><strong>Configure 
            Parameters </strong></td>
        </tr>
        <?
                  if(count($err)>0)
                  {
                  ?>
        <tr> 
          <td colspan="2" align="center" nowrap class="ltxt"><font color="#FF0000"> 
            <?php 
                                                  foreach($err as $errmsg)
                                                print "<li>$errmsg</li>";
                                                ?>
            </font></td>
        </tr>
        <?
                  }
                  ?>
        <tr> 
          <td nowrap class="ltxt"><br> <table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" style="border: 1px solid #9cab93">
              <form action="" method="post" onSubmit="return isMimeFormOk(this)">
                <tr> 
                  <td colspan="2" class="ltxt"><strong>Update MIME_TYPES of File:</strong></td>
                </tr>
                <tr> 
                  <td> 
                    <!-- <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <td rowspan="2"><select name="types" size="5" multiple class="lstbox" id="types">
                            <?php
                                                  //foreach($mime_types as $val) print "<option>$val</option>";
                                                  ?>
                          </select></td>
                        <td valign="top"> <input name="push" type="button" class="button" id="push" value="&gt;&gt;" title="Click to insert new types" onClick="javascript:return PUSH(this.form)"> 
                        </td>
                        <td rowspan="2"><select name="conf_val[]" size="5" multiple class="lstbox" id="conf_val">
                            <?php
                                                  //foreach($mimearr as $val) print "<option>$val</option>";
                                                  ?>
                          </select></td>
                      </tr>
                      <tr> 
                        <td valign="bottom"> <input name="pop" type="button" class="button" id="pop" value="&lt;&lt;" title="Click to remove types" onClick="javascript:return POP(this.form)"> 
                        </td>
                      </tr>
                    </table> -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <td width="20%" rowspan="2" class="stxt"><strong>Supported 
                          Types:</strong></td>
                        <td width="10" class="ltxt"> <input name="opt" type="radio" class="chkbox" value="all" checked> 
                        </td>
                        <td class="ltxt"> <strong> All Types (Except web scripts 
                          and pages)</strong></td>
                      </tr>
                      <tr> 
                        <td valign="top"> <input name="opt" type="radio" class="chkbox" value="some"<?php if(!empty($mimearr)) print " checked"?>> 
                        </td>
                        <td><textarea name="conf_val" rows="4" class="txtarea" id="conf_val"><?=$mimearr?></textarea></td>
                      </tr>
                    </table></td>
                  <td width="20%" valign="bottom"> <input name="Submit2" type="submit" class="button" value="Update"> 
                    <input name="conf_disptxt" type="hidden" id="conf_disptxt" value=""> 
                    <input name="conf_id" type="hidden" id="conf_id" value="MIME_TYPES"> 
                  </td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td nowrap class="ltxt"><br> <table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" style="border: 1px solid #9cab93">
              <form action="" method="post" onSubmit="return isOtherFormOk(this)">
                <tr> 
                  <td colspan="2" class="ltxt"><strong>Update MAX_TIME to Expire:</strong></td>
                </tr>
                <tr> 
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <td width="20%" class="stxt"><strong>Value:</strong></td>
                        <td><select name="conf_val" class="lstbox" id="conf_val" onChange="onConfChange(this.form)">
                            <?php
                                                  for($i=1 ; $i<=360; $i++) 
                                                if($max_time==$i)        print "<option value='$i' selected>$i Days</option>";
                                                else print "<option value='$i'>$i Days</option>";
                                                  ?>
                          </select></td>
                      </tr>
                      <tr> 
                        <td class="stxt"><strong>Dispay Text:</strong></td>
                        <td><input name="conf_disptxt" type="text" class="txtbox" maxlength="250" id="conf_disptxt" value="<?=$max_time_disptxt?>"></td>
                      </tr>
                    </table></td>
                  <td width="20%" valign="bottom"> <input name="Submit22" type="submit" class="button" value="Update"> 
                    <input name="conf_id" type="hidden" id="conf_id" value="MAX_TIME"> 
                  </td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td nowrap class="ltxt"><br> <table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" style="border: 1px solid #9cab93">
              <form action="" method="post" onSubmit="return isOtherFormOk(this)">
                <tr> 
                  <td colspan="2" class="ltxt"><strong>Update MAX_COUNT of Download:</strong></td>
                </tr>
                <tr> 
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <td width="20%" class="stxt"><strong>Value:</strong></td>
                        <td><select name="conf_val" class="lstbox" id="conf_val" onChange="onConfChange(this.form)">
                            <?php
                                                  for($i=1 ; $i<=100; $i++) 
                                                if($max_count==$i)   print "<option value='$i' selected>$i Times</option>";
                                                else print "<option value='$i'>$i Times</option>";
                                                
                                                  ?>
                          </select></td>
                      </tr>
                      <tr> 
                        <td class="stxt"><strong>Display Text:</strong></td>
                        <td><input name="conf_disptxt" type="text" class="txtbox" id="conf_disptxt" maxlength="250" value="<?=$max_count_disptxt?>"></td>
                      </tr>
                    </table></td>
                  <td width="20%" valign="bottom"> <input name="Submit222" type="submit" class="button" value="Update"> 
                    <input name="conf_id" type="hidden" id="conf_id" value="MAX_COUNT"> 
                  </td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td nowrap class="ltxt"><br> <table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" style="border: 1px solid #9cab93">
              <form action="" method="post" onSubmit="return isOtherFormOk(this)">
                <tr> 
                  <td colspan="2" class="ltxt"><strong>Update MAX_SIZE of File:</strong></td>
                </tr>
                <tr> 
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <td width="20%" class="stxt"><strong>Value:</strong></td>
                        <td><select name="conf_val" class="lstbox" id="conf_val" onChange="onConfChange(this.form)">
                            <option value="1024">1 MB</option>
                            <?php
                                                  for($i=10 ; $i<=990; $i+=10) 
                                                if($max_size==(1024*$i))  print "<option value=".(1024*$i)." selected>$i MB</option>";
                                                else print "<option value=".(1024*$i).">$i MB</option>";                        
                                  ?>
                            <option value="1024000"<?php if($max_size==1024000) print " selected";?>>1 
                            GB</option>
                          </select></td>
                      </tr>
                      <tr> 
                        <td class="stxt"><strong>Display Text:</strong></td>
                        <td><input name="conf_disptxt" type="text" class="txtbox" id="conf_disptxt" maxlength="250" value="<?=$max_size_disptxt?>"></td>
                      </tr>
                    </table></td>
                  <td width="20%" valign="bottom"> <input name="Submit2222" type="submit" class="button" value="Update"> 
                    <input name="conf_id" type="hidden" id="conf_id" value="MAX_SIZE"> 
                  </td>
                </tr>
              </form>
            </table>
            
          </td>
        </tr>
        <tr> 
          <td nowrap class="ltxt"><br>
            <table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" style="border: 1px solid #9cab93">
              <form action="" method="post">
                <tr> 
                  <td colspan="2" class="ltxt"><strong>Update AUTO_FILE_DELETE:</strong></td>
                </tr>
                <tr> 
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <td width="20%" class="stxt"><strong>Value:</strong></td>
                        <td><select name="conf_val" class="lstbox" id="conf_val">
                            <option value="Yes">Yes</option>
                            <option value="No"<?php if($auto_delete=="No") print " selected";?>>No</option>
                          </select></td>
                      </tr>
                    </table></td>
                  <td width="20%" valign="bottom"> <input name="Submit22222" type="submit" class="button" value="Update"> 
                    <input name="conf_id" type="hidden" id="conf_id" value="AUTO_FILE_DELETE">
                    <input name="conf_disptxt" type="hidden" id="conf_disptxt" value=""></td>
                </tr>
              </form>
            </table> </td>
        </tr>
        <tr>
          <td nowrap class="ltxt"><br>
            <table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" style="border: 1px solid #9cab93">
              <form action="" method="post">
                <tr> 
                  <td colspan="2" class="ltxt"><strong>Reset or Update DAILY_TRANSFER:</strong></td>
                </tr>
                <tr> 
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <td width="20%" class="stxt"><strong>Value:</strong></td>
                        <td><input name="conf_val" type="text" class="txtbox" id="conf_val" value="<?=$daily_transfer?>"></td>
                      </tr>
                    </table></td>
                  <td width="20%" valign="bottom"> <input name="Submit22223" type="submit" class="button" value="Update"> 
                    <input name="conf_id" type="hidden" id="conf_id" value="DAILY_TRANSFER">
                    <input name="conf_disptxt" type="hidden" id="conf_disptxt" value=""> 
                  </td>
                </tr>
              </form>
            </table> </td>
        </tr>
      </table>
      <br>
      &nbsp;
    </td>
  </tr>
  <tr>
    <td>
        <?php
        require_once("footer.php");
        ?>
        </td>
  </tr>
</table>  
</body>
</html>
