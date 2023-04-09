<?php
function calsetup($firstsetup=0,$section="cg",$uobj) {
    global $curcalcfg,$timear,$timeara,$lstyle;
    global $langcfg,$csectcnt;
    $rowcolor1="#DDDDDD";
    $rowcolor2="#CCCCCC";
    
    if($uobj->gsv("curcalowner") <> 1) {
        $disablebuts = 1;
    } else {
        $disablebuts = 0;
    }
    ?>
    <html>
    <head>
<?php    
    include("./include/style.php");
?>
    <SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
    <!--
    var curfeld = "";
    var aclr = "";

    <?php
    if($section=="cg") {
        ?>
        function submit_onclick() {
            document.setupform.calname.value=trim(document.setupform.calname.value);
            document.setupform.caltitle.value=trim(document.setupform.caltitle.value);
            if(document.setupform.calname.value == "") {
                alert("<?php echo $langcfg["alcn"]; ?>");
                document.setupform.calname.focus();
                return false;
            }
            if(document.setupform.caltitle.value == "") {
                alert("<?php echo $langcfg["alct"]; ?>");
                document.setupform.caltitle.focus();
                return false;
            }
            
            if(document.setupform.dayendhour.value < document.setupform.daybeginhour.value) {
                alert("<?php echo $langcfg["alts"]; ?>");
                document.setupform.daybeginhour.focus();
                return false;
            }
            
        }
        function timetype_onchange() {
            if(document.setupform.timetype.value==0) {
        <?php
            for($lc=0;$lc<=47;$lc++) {
        		echo "        document.setupform.daybeginhour.item(".$lc.").innerHTML=\"".$timeara[$lc]."\";\n";
            }
        
            for($lc=0;$lc<=47;$lc++) {
        		echo "        document.setupform.dayendhour.item(".$lc.").innerHTML=\"".$timeara[$lc]."\";\n";
            }
            ?>
        	} else {
        <?php
            for($lc=0;$lc<=47;$lc++) {
        		echo "        document.setupform.daybeginhour.item(".$lc.").innerHTML=\"".substr($timear[$lc],0,2).":".substr($timear[$lc],2,2)."\";\n";
            }
        
            for($lc=0;$lc<=47;$lc++) {
        		echo "        document.setupform.dayendhour.item(".$lc.").innerHTML=\"".substr($timear[$lc],0,2).":".substr($timear[$lc],2,2)."\";\n";
            }
            ?>  
            }
        }
    <?php
    } else {
        echo "function submit_onclick() {\n";
        echo "}\n";
    }
    ?>
    function trim(value) {
     startpos=0;
     while((value.charAt(startpos)==" ")&&(startpos<value.length)) {
       startpos++;
     }
     if(startpos==value.length) {
       value="";
     } else {
       value=value.substring(startpos,value.length);
       endpos=(value.length)-1;
       while(value.charAt(endpos)==" ") {
         endpos--;
       }
       value=value.substring(0,endpos+1);
     }
     return(value);
    }
    
    function calselect_onchange() {
        if(document.setupform.calselect.value == 0) {
            document.setupform.mstdcal.checked = false;
            document.setupform.mstdcal.disabled = true;
            document.setupform.gocalselect.disabled = true;
            document.setupform.prefgodc.disabled = true;
        } else {
        
            document.setupform.gocalselect.disabled = false;
            document.setupform.prefgodc.disabled = false;
            if(document.setupform.calselect.value == document.setupform.xscalid.value) {
                document.setupform.mstdcal.checked = true;
                document.setupform.mstdcal.disabled = true;
            } else {
                document.setupform.mstdcal.checked = false;
                document.setupform.mstdcal.disabled = false;
            }
/*            
            if(document.setupform.xccalid.value == document.setupform.calselect.value) {
                document.setupform.gocalselect.disabled = true;
            } else {
                document.setupform.gocalselect.disabled = false;
            }
*/
            if(document.setupform.calselect.value == 'bd7a1090c632079b9f6e8e30a2156b27') {
                document.setupform.prefgodc.disabled = true;
            }
        }
    }    

    function mnc_onclick() {
        if(confirm("<?php echo $langcfg["alncc"]; ?> "+document.setupform.calselect.item(document.setupform.calselect.selectedIndex).innerText + " ?")) {
            return true;
        } else {
            alert("<?php echo $langcfg["funcan"]; ?>");
            return false;
        }
    }
    
    function mnoc_onclick() {
        if(confirm("<?php echo $langcfg["alncc"]; ?> "+document.setupform.ocalselect.item(document.setupform.ocalselect.selectedIndex).innerText + " ?")) {
            return true;
        } else {
            alert("<?php echo $langcfg["funcan"]; ?>");
            return false;
        }
    }
    

    function ddc_onclick() {
        if(confirm("<?php echo $langcfg["aldel1"]; ?> "+document.setupform.calselect.item(document.setupform.calselect.selectedIndex).innerText + " <?php echo $langcfg["calword"]; ?>?")) {
            if(confirm("<?php echo $langcfg["aldel2"]; ?> "+document.setupform.calselect.item(document.setupform.calselect.selectedIndex).innerText + " <?php echo $langcfg["aldel3"]; ?>")) {        
                return true;
            } else {
                return false;
            }
        } else {
            alert("<?php echo $langcfg["funcan"]; ?>");
            return false;
        }
    }

    function mnl_onclick() {
    
    }
    
    function ddl_onclick() {
    
    }

    function window_onload() {
        calselect_onchange();
        
    }

    function setcolor_ondblclick(cname) {
//    	alert(cname);
        setupform.item(curfeld).value = cname;
        ikey = "ifld_" + curfeld.substring(4);
        document.all(ikey).bgColor = cname;

    }

    function cfld_onfocus(cfield) {
        curfeld = cfield;
        nkey = "nfld_" + cfield.substring(4);
        aclr = document.all(nkey).bgColor;
        document.all(nkey).bgColor = "<?php echo $curcalcfg["gccssc"]; ?>";
	}

    function cfld_onfocusout(nfield) {
        document.all(nkey).bgColor = aclr;
	}
            
    function setupform_onreset() {
        for(i=0; i<document.all.length; i++) {
            xkey = document.all(i).id;
            tkey = xkey.substring(0,5);
            if(tkey == "ifld_") {
                zkey = "prev_" + xkey.substring(5);
                document.all(i).bgColor = setupform.item(zkey).value;
            }
        }
	}


    //-->
    </SCRIPT>
    
    
    <title><?php echo $GLOBALS["sitetitle"]; ?> - <?php echo $langcfg["calword"]; ?> <?php echo $langcfg["prefl"]; ?></title>
    </head>
    
    <body background="<?php echo $GLOBALS["standardbgimg"]; ?>" LANGUAGE=javascript onload="return window_onload()">
    <form method="POST" name="setupform" id="setupform" action="<?php echo $GLOBALS["idxfile"]; ?>" LANGUAGE=javascript onreset="return setupform_onreset()">
    <table border="1" width="100%">
      <tr>
        <td width="100%" colspan="7" align="center">
          <b><?php echo $GLOBALS["sitetitle"]; ?> - <?php echo $langcfg["calword"]; ?> <?php echo $langcfg["prefl"]; ?> - <?php echo $curcalcfg["calname"]; ?><br>
          <?php 
          
          if($firstsetup==0) {
              echo $langcfg["calownerword"]; ?>: <a href="mailto:<?php
              $sqlstr="select fname,lname,email from ".$GLOBALS["tabpre"]."_user_reg where uid=".$curcalcfg["userid"];
              $query = mysql_query($sqlstr) or die("Cannot query User Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
              $row = mysql_fetch_array($query) or die("Cannot query User Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr);
              echo $row["email"]."\">".$row["fname"]." ".$row["lname"]."</a>";
          } else {
              echo $langcfg["ffcaltxt"];          
          }
          ?></b>
        </td>
      </tr>
      <tr>
        <td width="14%" align="center" <?php if($section=="cg") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["scgbut"]; ?>" name="prefgocg" <?php if($firstsetup==1 || $disablebuts == 1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
        <td width="14%" align="center" <?php if($section=="gc") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["sgcbut"]; ?>" name="prefgogc" <?php if($firstsetup==1 || $disablebuts == 1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
        <td width="14%" align="center" <?php if($section=="mc") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["smcbut"]; ?>" name="prefgomc" <?php if($firstsetup==1 || $disablebuts == 1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
        <td width="14%" align="center" <?php if($section=="yv") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["syvbut"]; ?>" name="prefgoyv" <?php if($firstsetup==1 || $disablebuts == 1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
        <td width="14%" align="center" <?php if($section=="mv") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["smvbut"]; ?>" name="prefgomv" <?php if($firstsetup==1 || $disablebuts == 1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
        <td width="14%" align="center" <?php if($section=="wv") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["swvbut"]; ?>" name="prefgowv" <?php if($firstsetup==1 || $disablebuts == 1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
        <td width="14%" align="center" <?php if($section=="dv") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["sdvbut"]; ?>" name="prefgodv" <?php if($firstsetup==1 || $disablebuts == 1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
      </tr>
      <tr>
        <td width="14%" align="center" <?php if($section=="gr") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["srvbut"]; ?>" name="gogroupprefs" <?php if($firstsetup==1 || $disablebuts == 1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
        <td width="14%" align="center">&nbsp;</td>
        <td width="14%" align="center">&nbsp;</td>
<?php
/*
        <td width="14%" align="center" <?php if($section=="gu") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["ssvbut"]; ?>" name="gouserprefs" <?php if($firstsetup==1  || $disablebuts == 1) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
        <td width="14%" align="center" <?php if($section=="cc") {echo "class=\"gccssc\"";} ?>><input type="submit" value="<?php echo $langcfg["scabut"]; ?>" name="gocatprefs" <?php if($firstsetup==1 ) {echo "disabled";} ?> LANGUAGE=javascript onclick="return submit_onclick()"></td>
*/
?>
        <td colspan="4" nowrap align="center" <?php if($section=="cs") {echo "class=\"gccssc\"";} ?>>

        <?php echo $langcfg["mycword"]; ?> <select size="1" <?php if($firstsetup==1) {echo "disabled";} ?> id="calselect" name="calselect" style="WIDTH: 120px" LANGUAGE=javascript onchange="return calselect_onchange()">
        <?php if($firstsetup <> 1) {
                 $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_ini where userid = ".$uobj->gsv("cuid")." or calid='0'";
                 $query1 = mysql_query($sqlstr) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                 while($row = mysql_fetch_array($query1)) {
                     echo "<option ";
                     if($uobj->gsv("curcalid") == $row["calid"]) {
                         echo " selected ";
                     }
                     echo "value=\"".$row["calid"]."\">".($row["calname"])."</option>\n";
                 }
                mysql_free_result($query1);
             }
        ?>
    </select>&nbsp;<input type="submit" value="<?php echo $langcfg["butgo"]; ?>" name="gocalselect" <?php if($firstsetup==1) {echo "disabled";}elseif($uobj->gsv("curcalid") == $uobj->gsv("startcalid")) {echo "disabled";} ?>>
    <INPUT id=mstdcal type=checkbox name=mstdcal <?php if($firstsetup==1) {echo "disabled checked";}elseif($uobj->gsv("curcalid") == $uobj->gsv("startcalid")) {echo "disabled checked";} ?>><LABEL for=mstdcal><?php echo $langcfg["mkst"]; ?></LABEL>
    &nbsp;<input type="submit" value=" <?php echo $langcfg["butnew"]; ?> " name="prefgonc" <?php if($firstsetup==1) {echo "disabled";} ?> LANGUAGE=javascript onclick="return mnc_onclick()">
    &nbsp;<input type="submit" value="<?php echo $langcfg["butdel"]; ?>" name="prefgodc" <?php if($firstsetup==1) {echo "disabled";} ?> LANGUAGE=javascript onclick="return ddc_onclick()">
    <INPUT type=hidden id="xccalid" name=xccalid value="<?php echo $uobj->gsv("curcalid"); ?>">
    <INPUT type=hidden id="xscalid" name=xscalid value="<?php echo $uobj->gsv("startcalid"); ?>">
            
        
        </td>
        </tr>

      <tr>
    <td colspan="3" nowrap align="center" <?php if($section=="ls") {echo "class=\"gccssc\"";} ?>>&nbsp;

    <?php if($uobj->gsv("isadmin")=="1") {?>

    <?php echo $langcfg["edlang"]; ?> <select size="1" <?php if($firstsetup==1) {echo "disabled";} ?> name="seledlang" style="WIDTH: 120px">
        <?php if($firstsetup <> 1) {
                $sqlstr = "select * from ".$GLOBALS["tabpre"]."_languages order by uid";
                $query1 = mysql_query($sqlstr) or die("Cannot query Global Language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                while($row = mysql_fetch_array($query1)) {
                    echo "<option ";
                    if($uobj->gsv("langsel") == $row["uid"]) {
                        echo " selected ";
                    }
                    echo "value=\"".$row["name"]."\">".$row["name"]."</option>\n";
                }
                mysql_free_result($query1);
             }
        ?>
        </select>&nbsp;<input type="submit" value="<?php echo $langcfg["butgo"]; ?>" name="golangeditor" <?php if($firstsetup==1) {echo "disabled";} ?>>
    &nbsp;<input type="submit" value=" <?php echo $langcfg["butnew"]; ?> " name="prefgonl" <?php if($firstsetup==1) {echo "disabled";} ?> LANGUAGE=javascript onclick="return mnl_onclick()">
    &nbsp;<input type="submit" value="<?php echo $langcfg["butdel"]; ?>" name="prefgodl" <?php if($firstsetup==1) {echo "disabled";} ?> LANGUAGE=javascript onclick="return ddl_onclick()">
<?php } ?>
        </td>
        <td colspan="4" align="center" >
        <?php echo $langcfg["opcalword"]; ?> <select size="1" <?php if($firstsetup==1) {echo "disabled";} ?> id="ocalselect" name="ocalselect" style="WIDTH: 120px">
        <?php if($firstsetup <> 1) {
                 $haveothercals = 0;
                 $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_ini where userid <> ".$uobj->gsv("cuid")." and caltype < 2 and calid <> '0'";
                 $query1 = mysql_query($sqlstr) or die("Cannot query Calendar Config Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                 while($row = mysql_fetch_array($query1)) {
                     $haveothercals = 1;
                     echo "<option ";
                     if($uobj->gsv("curcalid") == $row["calid"]) {
                         echo " selected ";
                     }
                     echo "value=\"".$row["calid"]."\">".($row["calname"])."</option>\n";
                 }

                mysql_free_result($query1);
             }
        ?>
    </select>&nbsp;<input type="submit" value="<?php echo $langcfg["butgo"]; ?>" name="goocalselect" <?php if($firstsetup==1 || $haveothercals==0) {echo "disabled";} ?>>
             &nbsp;<input type="submit" value="<?php echo $langcfg["butnew"]; ?>" name="prefgoonc" <?php if($firstsetup==1 || $haveothercals==0) {echo "disabled";} ?> LANGUAGE=javascript onclick="return mnoc_onclick()">        
        </td>
      </tr>  

    <?php 
//    }
?>
    </table> 

<?php    
    if($section=="cg") {?>

<table border="1" width="100%">
  <tr>
    <th width="15%"><?php echo $langcfg["urfh"]; ?></th>
    <th width="20%"><?php echo $langcfg["entry"]; ?></th>
    <th width="65%">
      <p align="left"><?php echo $langcfg["urrh"]; ?></p></th>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["calname"]; ?></td>
    <td width="20%" valign="top" align="center"><input id="calname" name="fields[calname]" size="30" <?php if($firstsetup==0) {echo "value=\"".$curcalcfg["calname"]."\"";} ?>>
    <input type="hidden" id="pcalname" name="prev[calname]" value="<?php if($firstsetup==0) {echo $curcalcfg["calname"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["fcalname"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["caltitle"]; ?></td>
    <td width="20%" valign="top" align="center"><input id="caltitle" name="fields[caltitle]" size="30" <?php if($firstsetup==0) {echo "value=\"".$curcalcfg["caltitle"]."\"";} ?>>
    <input type="hidden" id="pcaltitle" name="prev[caltitle]" value="<?php if($firstsetup==0) {echo $curcalcfg["caltitle"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["fcaltitle"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["caltype"]; ?></td>
    <td width="20%" valign="top" align="center">
    <select size="1" id="caltype" name="fields[caltype]" style="WIDTH: 136px">
        <option <?php if($firstsetup==1) {echo "selected";}elseif($curcalcfg["caltype"]=="0") {echo "selected";} ?> value="0"><?php echo $langcfg["opcw"]; ?></option>
        <option <?php if($firstsetup==0 && $curcalcfg["caltype"]=="1") {echo "selected";} ?> value="1"><?php echo $langcfg["pucw"]; ?></option>
        <option <?php if($firstsetup==0 && $curcalcfg["caltype"]=="2") {echo "selected";} ?> value="2"><?php echo $langcfg["prcw"]; ?></option>
    </select>
    <input type="hidden" id="pcaltype" name="prev[caltype]" value="<?php if($firstsetup==0) {echo $curcalcfg["caltype"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["fcaltype"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["showweek"]; ?></td>
    <td width="20%" valign="top" align="center">
    <select size="1" id="showweek" name="fields[showweek]" style="WIDTH: 139px">
        <option <?php if($firstsetup==1) {echo "selected";}elseif($curcalcfg["showweek"]=="1") {echo "selected";} ?> value="1"><?php echo $langcfg["wfyes"]; ?></option>
        <option <?php if($firstsetup==0 && $curcalcfg["showweek"]=="0") {echo "selected";} ?> value="0"><?php echo $langcfg["wfno"]; ?></option>
    </select>
    <input type="hidden" id="pshowweek" name="prev[showweek]" value="<?php if($firstsetup==0) {echo $curcalcfg["showweek"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["fshowweek"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["preferedview"]; ?></td>
    <td width="20%" valign="top" align="center">
    <select size="1" id="preferedview" name="fields[preferedview]" style="WIDTH: 139px">
        <option <?php if($firstsetup==0 && $curcalcfg["preferedview"]=="Year") {echo "selected";} ?> value="Year"><?php echo $langcfg["ynl"]; ?></option>
        <option <?php if($firstsetup==1) {echo "selected";}elseif($curcalcfg["preferedview"]=="Month") {echo "selected";} ?>  value="Month"><?php echo $langcfg["mnl"]; ?></option>
        <option <?php if($firstsetup==0 && $curcalcfg["preferedview"]=="Week") {echo "selected";} ?> value="Week"><?php echo $langcfg["wnl"]; ?></option>
        <option <?php if($firstsetup==0 && $curcalcfg["preferedview"]=="Day") {echo "selected";} ?> value="Day"><?php echo $langcfg["dnl"]; ?></option>
    </select>
    <input type="hidden" id="ppreferedview" name="prev[preferedview]" value="<?php if($firstsetup==0) {echo $curcalcfg["preferedview"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["fpreview"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["weekstartonmonday"]; ?></td>
    <td width="20%" valign="top" align="center">
    <input type="radio" id="weekstartonmonday1" name="fields[weekstartonmonday]" value="1" <?php if($firstsetup==1) {echo "checked";}elseif($curcalcfg["weekstartonmonday"]=="1") {echo "checked";} ?> ><label for="weekstartonmonday1"><?php echo $langcfg["fmondays"]; ?></label>&nbsp;&nbsp;
    <input type="radio" id="weekstartonmonday0" name="fields[weekstartonmonday]" value="0" <?php if($firstsetup==0 && $curcalcfg["weekstartonmonday"]=="0") {echo "checked";} ?> ><label for="weekstartonmonday0"><?php echo $langcfg["fsundays"]; ?></label>
    <input type="hidden" id="pweekstartonmonday" name="prev[weekstartonmonday]" value="<?php if($firstsetup==0) {echo $curcalcfg["weekstartonmonday"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["fwson"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["weekselreact"]; ?></td>
    <td width="20%" valign="top" align="center">
    <select size="1" id="weekselreact" name="fields[weekselreact]" style="WIDTH: 139px">
        <option <?php if($firstsetup==1) {echo "selected";}elseif($curcalcfg["weekselreact"]=="1") {echo "selected";} ?> value="1"><?php echo $langcfg["wftype1"]; ?></option>
        <option <?php if($firstsetup==0 && $curcalcfg["weekselreact"]=="0") {echo "selected";} ?> value="0"><?php echo $langcfg["wftype2"]; ?></option>
    </select>
    <input type="hidden" id="pweekselreact" name="prev[weekselreact]" value="<?php if($firstsetup==0) {echo $curcalcfg["weekselreact"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["ftype"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["timetype"]; ?></td>
    <td width="20%" valign="top" align="center">
    <select size="1" id="timetype" name="fields[timetype]" style="WIDTH: 139px" LANGUAGE=javascript onchange="timetype_onchange()">
        <option <?php if($firstsetup==0 && $curcalcfg["timetype"]=="0") {echo "selected";} ?> value="0"><?php echo $langcfg["wf12"]; ?></option>
        <option <?php if($firstsetup==1) {echo "selected";}elseif($curcalcfg["timetype"]=="1") {echo "selected";} ?> value="1"><?php echo $langcfg["wf24"]; ?></option>
    </select>
    <input type="hidden" id="ptimetype" name="prev[timetype]" value="<?php if($firstsetup==0) {echo $curcalcfg["timetype"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["ftimetype"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["daybeginhour"]; ?></td>
    <td width="20%" valign="top" align="center">
    <select size="1" id="daybeginhour" name="fields[daybeginhour]" style="WIDTH: 139px">
<?php
    for($lc=0;$lc<=47;$lc++) {
		echo "        <option ";
        if($firstsetup==1 && $timear[$lc]=="0730" ) {
            echo "selected ";
        } elseif($curcalcfg["daybeginhour"]==$timear[$lc]) {
            echo "selected ";
        }
        echo "value = \"".$timear[$lc]."\">".substr($timear[$lc],0,2).":".substr($timear[$lc],2,2)."</option>\n";
     }
    ?>  
    </select>
    <input type="hidden" id="pdaybeginhour" name="prev[daybeginhour]" value="<?php if($firstsetup==0) {echo $curcalcfg["daybeginhour"];} ?>">
    </td>
    <td width="65%"><?php echo $langcfg["fdayst"]; ?></td>
  </tr>
  <tr>
    <td width="15%" valign="top" align="right" nowrap><?php echo $langcfg["dayendhour"]; ?></td>
    <td width="20%" valign="top" align="center">
    <select size="1" id="dayendhour" name="fields[dayendhour]" style="WIDTH: 139px">
<?php
    for($lc=0;$lc<=47;$lc++) {
		echo "        <option ";
        if($firstsetup==1 && $timear[$lc]=="1730" ) {
            echo "selected ";
        } elseif($curcalcfg["dayendhour"]==$timear[$lc]) {
            echo "selected ";
        }
        echo "value = \"".$timear[$lc]."\">".substr($timear[$lc],0,2).":".substr($timear[$lc],2,2)."</option>\n";
     }
    ?>  
     </select>
    <input type="hidden" id="pdayendhour" name="prev[dayendhour]" value="<?php if($firstsetup==0) {echo $curcalcfg["dayendhour"];} ?>">
     </td>
    <td width="65%"><?php echo $langcfg["fdayen"]; ?></td>
  </tr>
</table>

    <?php if($firstsetup==1) { ?>    
    <table border="1" width="100%">
      <tr>
        <td width="20%" align="center">
            <input type="submit" value="<?php echo $langcfg["subut"]; ?>" name="submitsetup" LANGUAGE=javascript onclick="return submit_onclick()">
        </td>
        <td width="80%">&nbsp;
           <b><?php echo $langcfg["ffcaltxt"]; ?></b>
        </td>
    <?php } else { ?>
    <table border="0" width="100%">
    <tr>
    <td width="100%" align="right">
    <table border="1" width="65%">
      <tr>
        <td width="21%" align="center">
            <input <?php if($disablebuts == 1 ) {echo "disabled";} ?> type="submit" value="<?php echo $langcfg["butsavech"]; ?>" name="submitgeneral" LANGUAGE=javascript onclick="return submit_onclick()">
        </td>
        <td width="21%" align="center">
            <INPUT type="reset" value="<?php echo $langcfg["butpv"]; ?>" id=reset1 name=reset1>     
        </td>
        <td width="21%" align="center">
            <INPUT type="submit" value="<?php echo $langcfg["butgoc"]; ?>" id=canpref name="canpref">     
        </td>
      </tr>
    </table>
    <?php } ?>
    </td></tr></table>

<?php

} else {
//    gensect($section,&$uobj)

echo "<center><br>To use the color picker, click in the input field you wish to change, then double click on the color you want.<br></center>\n";
    $rowcolor1="#DDDDDD";
    $rowcolor2="#CCCCCC";
    
    echo "<table border=\"1\" width=\"100%\">\n";
    echo "<tr>\n";
    echo "<th width=\"33%\" bgcolor=\"#D3DCE3\">".$langcfg["descword"]."</th>\n";
    echo "<th width=\"34%\" bgcolor=\"#D3DCE3\">".$langcfg["entry"]."</th>\n";
    echo "<th width=\"33%\" bgcolor=\"#D3DCE3\">Color Picker</th>\n";
    echo "</tr>\n";
    
    $rcnt=1;
    $cscnt = $csectcnt[$section];
    $splh = $cscnt*30;
    
    foreach($curcalcfg as $ckey => $cval) {
        if(substr($ckey,0,2) == $section) {
            $bgcolor = ($rcnt % 2) ? $rowcolor1 : $rowcolor2;
            echo "<tr>\n";
            echo "<td ";
            if(!stristr($ckey,"style")) {
                echo "id=\"nfld_".$ckey."\" width=\"33%\" align=\"left\" valign=\"top\" bgcolor=\"$bgcolor\">\n";
            } else {
                echo "width=\"33%\" align=\"left\" valign=\"top\" bgcolor=\"$bgcolor\">\n";
            }
//            echo translate($ckey,$uobj->gsv("langsel"));
            echo $langcfg["$ckey"];
            echo "</td>\n";
            echo "<td ";
            if(!stristr($ckey,"style")) {
//                echo "id=\"ifld_".$ckey."\" width=\"34%\" valign=\"top\" align=\"left\" bgcolor=\"$bgcolor\">\n";
                echo "id=\"ifld_".$ckey."\" width=\"34%\" valign=\"top\" align=\"left\" bgcolor=\"".$curcalcfg["$ckey"]."\">\n";
            } else {
                echo "width=\"34%\" valign=\"top\" align=\"left\" bgcolor=\"$bgcolor\">\n";
            }
            
            if(stristr($ckey,"style")) {
                
               echo "<SELECT name=\"fields[".$ckey."]\" style=\"WIDTH: 139px\">\n";
               echo "<OPTION ";
               if($curcalcfg[$ckey]=="none") {echo "selected ";}
               echo "value=\"none\">".$langcfg["fnword"]."</OPTION>\n";
               echo "<OPTION ";
               if($curcalcfg[$ckey]=="underline") {echo "selected ";}
               echo "value=\"underline\">".$langcfg["funword"]."</OPTION>\n";
               echo "<OPTION ";
               if($curcalcfg[$ckey]=="overline") {echo "selected ";}
               echo "value=\"overline\">".$langcfg["folword"]."</OPTION>\n";
               echo "<OPTION ";
               if($curcalcfg[$ckey]=="underline overline") {echo "selected ";}
               echo "value=\"underline overline\">".$langcfg["funolword"]."</OPTION>\n";
               echo "<OPTION ";
               if($curcalcfg[$ckey]=="line-through") {echo "selected ";}
               echo "value=\"line-through\">".$langcfg["fstword"]."</OPTION>\n";
               echo "</SELECT>\n";
                
                echo "<input type=\"hidden\" name=\"prev[".$ckey."]\" size=\"30\" value=\"".$curcalcfg["$ckey"]."\">\n";
                
            } else {
                echo "<input id=\"chc_".$ckey."\" name=\"fields[".$ckey."]\" size=\"30\" value=\"".$curcalcfg["$ckey"]."\"  LANGUAGE=javascript onfocus=\"return cfld_onfocus('chc_".$ckey."')\" onfocusout=\"return cfld_onfocusout('nfld_".$ckey."')\">\n";
                echo "<input type=\"hidden\" id=\"prev_".$ckey."\" name=\"prev[".$ckey."]\" size=\"30\" value=\"".$curcalcfg["$ckey"]."\">\n";
            }        
            echo "</td>";
            if($rcnt == 1) {
                echo "<td width=\"33%\" rowspan=\"".$cscnt."\">";
                echo "\n<span id=\"esp\" style=\"width: 250; height: ".$splh."; overflow: auto\">\n";
                
                echo "<table border=\"1\" width=\"100%\">";
                $csqlstr = "SELECT  * FROM ".$GLOBALS["tabpre"]."_color_table group by nicename,rgbplus order by cnum,rgbplus";
                $cquery = mysql_query($csqlstr) or die("Cannot query color Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$csqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
                
                while($crow=mysql_fetch_array($cquery)) { 
                    echo"<tr>\n";
                    echo"<td width=\"10%\">".$crow["cname"]."</td>\n";
                    echo"<td id=\"".$crow["id"]."\" bgcolor=\"".$crow["cname"]."\"  LANGUAGE=javascript ondblclick=\"return setcolor_ondblclick('".$crow["cname"]."')\">&nbsp;</td>\n";
                    echo"</tr>\n";
                }
                echo "</table></span></td>";
            }
            
            echo "</tr>\n";  
            $rcnt++;   
        }
    }
    echo "</table>\n";
    echo "<table border=\"0\" width=\"60%\">\n";
    echo "<tr>\n";
    echo "<td width=\"100%\" align=\"right\">\n";
    echo "<table border=\"1\" width=\"65%\">\n";
    echo "<tr>\n";
    echo "<td width=\"21%\" align=\"center\">\n";
    echo "<input type=\"submit\" value=\"".$langcfg["butsavech"]."\" name=\"submitprefs\" ";
    if($disablebuts == 1 ) {echo "disabled";}
    echo " LANGUAGE=javascript onclick=\"return submit_onclick()\">\n";
    echo "</td>\n";
    echo "<td width=\"21%\" align=\"center\">\n";
    echo "<INPUT type=\"reset\" value=\"".$langcfg["butpv"]."\" id=reset1 name=reset1>   \n";  
    echo "</td>\n";
    echo "<td width=\"21%\" align=\"center\">\n";
    echo "<INPUT type=\"submit\" value=\"".$langcfg["butgoc"]."\" id=canpref name=\"canpref\"> \n";    
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</td></tr></table>\n";
}
?>
<input type="hidden" value="<?php echo $section; ?>" name="csection">
</form>
<?php
echo "<br><br>";
include_once("./include/footer.php");
exit();
}?>