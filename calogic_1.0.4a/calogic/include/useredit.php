<?php
function edituser($cuser) {
    global $langcfg;
    global $curcalcfg, $monthtext;

$xregtime = $cuser->gsv("regtime") + $cuser->gsv("caltzadj");
$xconftime = $cuser->gsv("conftime") + $cuser->gsv("caltzadj");

if($curcalcfg["timetype"] == 1) {
    $uregtime = date("d",$xregtime)." ".$monthtext[date("n",$xregtime)]." ".date("Y",$xregtime)." ".date("H",$xregtime).":".date("i",$xregtime);
    $uconftime = date("d",$xconftime)." ".$monthtext[date("n",$xconftime)]." ".date("Y",$xconftime)." ".date("H",$xconftime).":".date("i",$xconftime);
} else {
    $uregtime = date("d",$xregtime)." ".$monthtext[date("n",$xregtime)]." ".date("Y",$xregtime)." ".date("g",$xregtime).":".date("i",$xregtime).date("A",$xregtime);
    $uconftime = date("d",$xconftime)." ".$monthtext[date("n",$xconftime)]." ".date("Y",$xconftime)." ".date("g",$xconftime).":".date("i",$xconftime).date("A",$xconftime);
}

?>

<html>

<head>
<title>User Settings</title>
<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--

function useredit_onsubmit() {
	if(useredit.submitnocheck.value=="1") {
		return true;
	}
	
    useredit.username.value=trim(useredit.username.value);
    useredit.firstname.value=trim(useredit.firstname.value);
    useredit.lastname.value=trim(useredit.lastname.value);
    useredit.useremail.value=trim(useredit.useremail.value);
    useredit.userpw.value=trim(useredit.userpw.value);
    useredit.newuserpw.value=trim(useredit.newuserpw.value);
    useredit.newuserpw2.value=trim(useredit.newuserpw2.value);

    if(useredit.username.value == "") {
        alert("None of the fields may be blank.");
        useredit.username.focus();
        return false;
    }
    if(useredit.firstname.value == "") {
        alert("None of the fields may be blank.");
        useredit.firstname.focus();
        return false;
    }
    if(useredit.lastname.value == "") {
        alert("None of the fields may be blank.");
        useredit.lastname.focus();
        return false;
    }
    if(useredit.useremail.value == "") {
        alert("None of the fields may be blank.");
        useredit.useremail.focus();
        return false;
    }
	
    if(useredit.userpw.value != "") {
	    if(useredit.newuserpw.value == "" || useredit.newuserpw2.value == "") {
	        alert("You entered your password, which means you wish to change it.\nHowever, one or both of the new password fields is blank.");
		    useredit.userpw.value="";
			useredit.newuserpw.value ="";
			useredit.newuserpw2.value ="";
		    useredit.userpw.focus();
	        return false;
	    }
		if(useredit.newuserpw.value != useredit.newuserpw2.value) {
		    alert("The new password fields do not match.");
		    useredit.userpw.value="";
			useredit.newuserpw.value ="";
			useredit.newuserpw2.value ="";
		    useredit.userpw.focus();
		    return false;
		}
    }
    
	useredit.deluserok.value="0";
    return true;
}

<?php
if ($cuser->gsv("isadmin") == 1) {
?>
function userlist_onchange() {
	var curuserval = useredit.userlist.options(useredit.userlist.selectedIndex).value;
	var curuserset = curuserval.split("|");
	useredit.ccxid.value = curuserset[0];
	useredit.username.value = curuserset[1];
	useredit.firstname.value = curuserset[2];
	useredit.lastname.value = curuserset[3];
	useredit.useremail.value = curuserset[4];

	useredit.pusername.value = curuserset[1];
	useredit.pfirstname.value = curuserset[2];
	useredit.plastname.value = curuserset[3];
	useredit.puseremail.value = curuserset[4];

	useredit.usertzos.value = curuserset[10];
	useredit.userregon.value = curuserset[11];
	useredit.userconfon.value = curuserset[12];

	if(useredit.ccxid.value != useredit.currentuser.value) {
		useredit.userpw.disabled = true;	
		useredit.newuserpw.disabled = true;	
		useredit.newuserpw2.disabled = true;	
	} else {
		useredit.userpw.disabled = false;	
		useredit.newuserpw.disabled = false;	
		useredit.newuserpw2.disabled = false;	
	}
	
	for(i=0;i<useredit.userlangsel.length;i++) {
		if(useredit.userlangsel.options(i).value == curuserset[11]) {
			useredit.userlangsel.selectedIndex = i;
			useredit.puserlangsel.value = useredit.userlangsel.options(i).value;
		}
	}

	for(i=0;i<useredit.usercalsel.length;i++) {
		if(useredit.usercalsel.options(i).value == curuserset[8]) {
			useredit.usercalsel.selectedIndex = i;
			useredit.pusercalsel.value = useredit.usercalsel.options(i).value;
		}
	}
	
	useredit.userisadmin.selectedIndex = curuserset[5];
    useredit.puserisadmin.value = curuserset[5];
}
<?php
}
?>

function checkuser_onclick() {
    useredit.username.value=trim(useredit.username.value);
    if(useredit.username.value == "") {
        alert("None of the fields may be blank.");
        useredit.username.focus();
        return false;
    }

	xurl="checkuser.php?username=" + useredit.username.value;
	window.open(xurl,null,"height=200,width=400,status=no,toolbar=no,menubar=no,location=no",true);
}

function checkemail_onclick() {
    useredit.useremail.value=trim(useredit.useremail.value);
    if(useredit.useremail.value == "") {
        alert("None of the fields may be blank.");
        useredit.useremail.focus();
        return false;
    }

	xurl="checkemail.php?useremail=" + useredit.useremail.value;
	window.open(xurl,null,"height=200,width=400,status=no,toolbar=no,menubar=no,location=no",true);
}

function deleteuser_onclick() {

<?php
if ($cuser->gsv("isadmin") == 1) {
?>

	if(useredit.userlist.selectedIndex < 0) {
		alert("You must first select a user!");
		return false;
	}
	var curuserval = useredit.userlist.options(useredit.userlist.selectedIndex).value;
	var curuserset = curuserval.split("|");
	if(curuserset[0] == useredit.currentuser.value) {
    
<?php
}
?>	
		if(confirm("Are you sure you want to delete yourself?\nEverything associated with your user name will also be deleted, including\nyour Calendars, Events and Contacts.") == true) {
			useredit.submitnocheck.value="1";
			useredit.deluserok.value="1";
			useredit.submit();
		}
		
<?php
if ($cuser->gsv("isadmin") == 1) {
?>
		
	} else {
		if(confirm("Are you sure you wish to delete the selected user?\nEverything associated with this user name will also be deleted, including\nCalendars, Events and Contacts.") == true) {
    		if(confirm("Would you like to inform the user of the deletion per email?") == true) {
                useredit.senddelmail.value = "1";
            }
			useredit.submitnocheck.value="1";
			useredit.deluserok.value="1";
			useredit.submit();
		}
	}
	
<?php
}
?>
}

function doneuser_onclick() {
	useredit.submitnocheck.value="1";
	useredit.deluserok.value="0";
	return true;
}

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
    

//-->
</SCRIPT>
</head>

<body background="<?php echo $GLOBALS["standardbgimg"]; ?>">

<h1>User Settings</h1>
<?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "<center><b>The demo user cannot be changed</b></center>";} ?>
<form method="POST" name="useredit" id="useredit" action="<?php echo $GLOBALS["idxfile"]; ?>" LANGUAGE=javascript onsubmit="return useredit_onsubmit()">
<INPUT type="hidden" id="deluserok" name="deluserok" value="0">
<INPUT type="hidden" id="senddelmail" name="senddelmail" value="0">
<INPUT type="hidden" id="currentuser" name="currentuser" value="<?php echo $cuser->gsv("cuid"); ?>">
<?php
if($cuser->gsv("isadmin") == 1) {
?>
<INPUT type="hidden" id="ccxid" name="ccxid" value="">
<?php
}
?>
<INPUT type="hidden" id="submitnocheck" name="submitnocheck" value="0">
<table border="1" width="100%">
    <tr>
      <td width="<?php if($cuser->gsv("isadmin") == 1) { echo "15%"; } else { echo "0%"; } ?>" valign="top" align="center" nowrap>
      <?php if($cuser->gsv("isadmin") == 1) { ?>
        <u>User List</u><br>
        <select size="20" tabindex="1" name="userlist" id="userlist" style="width: 250" LANGUAGE=javascript onchange="return userlist_onchange()">
<?php
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_reg ";
    $query1 = mysql_query($sqlstr) or die("Cannot query User Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
		echo "        <option ";
        if($cuser->gsv("cuid") == $row["uid"]) {
            echo "selected ";
        }

        $zregtime = $row["regtime"]+$row["tzos"];
        $zconftime = $row["conftime"]+$row["tzos"];
        
        if($curcalcfg["timetype"] == 1) {
            $cregtime = date("d",$zregtime)." ".$monthtext[date("n",$zregtime)]." ".date("Y",$zregtime)." ".date("H",$zregtime).":".date("i",$zregtime);
            $cconftime = date("d",$zconftime)." ".$monthtext[date("n",$zconftime)]." ".date("Y",$zconftime)." ".date("H",$zconftime).":".date("i",$zconftime);
        } else {
            $cregtime = date("d",$zregtime)." ".$monthtext[date("n",$zregtime)]." ".date("Y",$zregtime)." ".date("g",$zregtime).":".date("i",$zregtime).date("A",$zregtime);
            $cconftime = date("d",$zconftime)." ".$monthtext[date("n",$zconftime)]." ".date("Y",$zconftime)." ".date("g",$zconftime).":".date("i",$zconftime).date("A",$zconftime);
        }
        if($row["tzos"] != 0) {
            $xtzos = abs($row["tzos"]) / 60 / 60;
        } else {
            $xtzos = 0;
        }
        if($row["tzos"] < 0) {
            $xtzos = "-" + $xtzos;
        } else {
            $xtzos = "+" + $xtzos;
        }
        echo "value = \"".$row["uid"]."|".($row["uname"])."|".($row["fname"])."|".($row["lname"])."|".($row["email"])."|".$row["isadmin"]."|".$row["langid"]."|".$row["language"]."|".$row["startcalid"]."|".($row["startcalname"])."|".$xtzos."|".$cregtime."|".$cconftime."\">".($row["uname"]).", ".($row["fname"])." ".($row["lname"])."</option>\n";
     }
     mysql_free_result($query1);
?>
        </select>
      <?php
      } else {
        echo "&nbsp;";
      }
      ?>
      </td>
      <td width="<?php if($cuser->gsv("isadmin") == 1) { echo "55%"; } else { echo "100%"; } ?>" valign="top" align="left" nowrap>
        <table border="1" width="100%">
          <tr>
            <td width="20%" valign="top" align="left" nowrap>User Name:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input type="text" tabindex="2" name="fields[username]" id="username" style="width: 250" maxlength="10" value="<?php echo $cuser->gsv("uname"); ?>">&nbsp;
            <input type="hidden" name="prev_fields[username]" id="pusername" value="<?php echo $cuser->gsv("uname"); ?>">            
            </td>
            <td width="70%" valign="top" align="left">
                <input type="button" tabindex="3" value="Check" name="checkuser" id="checkuser" LANGUAGE=javascript onclick="return checkuser_onclick()">&nbsp;
                The User Name must be unique.
            </td>
          </tr>

          <tr>
            <td width="20%" valign="top" align="left" nowrap>First Name:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input type="text" tabindex="4" name="fields[firstname]" id="firstname" style="width: 250" maxlength="20" value="<?php echo $cuser->gsv("fname"); ?>">&nbsp;
            <input type="hidden" name="prev_fields[firstname]" id="pfirstname" value="<?php echo $cuser->gsv("fname"); ?>">
		  </td>
            <td width="70%" valign="top" align="left">&nbsp;
            </td>
          </tr>

          <tr>
            <td width="20%" valign="top" align="left" nowrap>Last Name:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input type="text" tabindex="5" name="fields[lastname]" id="lastname" style="width: 250" maxlength="20" value="<?php echo $cuser->gsv("lname"); ?>">&nbsp;
            <input type="hidden" name="prev_fields[lastname]" id="plastname" value="<?php echo $cuser->gsv("lname"); ?>">
            </td>
            <td width="70%" valign="top" align="left">&nbsp;
            </td>
          </tr>

          <tr>
            <td width="20%" valign="top" align="left" nowrap>E-Mail:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input type="text" tabindex="6" name="fields[useremail]" id="useremail" style="width: 250" maxlength="50" value="<?php echo $cuser->gsv("email"); ?>">&nbsp;
            <input type="hidden" name="prev_fields[useremail]" id="puseremail" value="<?php echo $cuser->gsv("email"); ?>">
            </td>
            <td width="70%" valign="top" align="left">
            <input type="button" tabindex="7" value="Check" name="checkemail" id="checkemail" LANGUAGE=javascript onclick="return checkemail_onclick()">&nbsp;
            The E-Mail must be unique.
            </td>
          </tr>
          <tr>
            <td width="20%" valign="top" align="left" nowrap>Password:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input <?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "disabled";} ?> type="password" tabindex="8" name="userpw" id="userpw" style="width: 250">
            </td>
            <td width="70%" valign="top" align="left">
            Enter your current password here if you intend to change it.
            <?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "<br>The demo password cannot be changed";} ?> 
            </td>
          </tr>
          <tr>
            <td width="20%" valign="top" align="left" nowrap>New Password:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input <?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "disabled";} ?> type="password" tabindex="9" name="newuserpw" id="newuserpw" style="width: 250">
            </td>
            <td width="70%" valign="top" align="left">
            Enter your new password here.
            <?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "<br>The demo password cannot be changed";} ?>
            </td>
          </tr>
          <tr>
            <td width="20%" valign="top" align="left" nowrap>New Password Repeat:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input <?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "disabled";} ?> type="password" tabindex="10" name="newuserpw2" id="newuserpw2" style="width: 250">
            </td>
            <td width="70%" valign="top" align="left">
            Confirm your new password here.
            <?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "<br>The demo password cannot be changed";} ?>
            </td>
          </tr>

          <tr>
            <td width="20%" valign="top" align="left" nowrap>Language:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <select size="1" tabindex="11" name="fields[userlangsel]" id="userlangsel" style="width: 250">
<?php
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_languages ";
    $query1 = mysql_query($sqlstr) or die("Cannot query Global Language Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
		echo "        <option ";
        if($cuser->gsv("langsel") == $row["uid"]) {
            echo "selected ";
        }
        echo "value = \"".$row["uid"]."\">".$row["name"]."</option>\n";
     }
     mysql_free_result($query1);
?>            </select>
            <input type="hidden" name="prev_fields[userlangsel]" id="puserlangsel" value="<?php echo $cuser->gsv("langsel"); ?>">
            </td>
            <td width="70%" valign="top" align="left">&nbsp;
            </td>
          </tr>
          <tr>
            <td width="20%" valign="top" align="left" nowrap>Main Calendar:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <select size="1" tabindex="12" name="fields[usercalsel]" id="usercalsel" style="width: 250">
<?php
    if($cuser->gsv("isadmin") == 1) {
        $sqlstr = "select calid,calname,userid,username,caltype from ".$GLOBALS["tabpre"]."_cal_ini where calid <> '0'";
    } else {
        $sqlstr = "select calid,calname,userid,username,caltype from ".$GLOBALS["tabpre"]."_cal_ini where userid = ".$cuser->gsv("cuid")." or (caltype < 2 and calid <> '0')";
    }
    $query1 = mysql_query($sqlstr) or die("Cannot query Calendar Ini Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = mysql_fetch_array($query1)) {
        $sqlstr2 = "select * from ".$GLOBALS["tabpre"]."_user_reg where uid = ".$row["userid"];
        $query2 = mysql_query($sqlstr2) or die("Cannot query user Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr2."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $row2 = mysql_fetch_array($query2);
		echo "        <option ";
        if($cuser->gsv("startcalid") == $row["calid"]) {
            echo "selected ";
        }
        echo "value = \"".$row["calid"]."\">";
        if($row["caltype"] == 0) {
            echo "OP ";
        } elseif($row["caltype"] == 1) {
            echo "PU ";
        } elseif($row["caltype"] == 2) {
            echo "PR ";
        }
        echo "\"".$row["calname"]."\" Owner: ".$row2["fname"]." ".$row2["lname"]."</option>\n";
         mysql_free_result($query2);
     }
     mysql_free_result($query1);
?>
            </select>
            <input type="hidden" name="prev_fields[usercalsel]" id="pusercalsel" value="<?php echo $cuser->gsv("startcalid"); ?>">
            </td>
            <td width="70%" valign="top" align="left">"PR" = Private, "PU" = Public, "OP" = Open
            </td>
          </tr>

          <tr>
            <td width="20%" valign="top" align="left" nowrap>TimeZone Offset:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input type="text" name="usertzos" id="usertzos" style="width: 250" readOnly value="<?php echo $cuser->gsv("caltzadj") / 60 / 60; ?>">
            </td>
            <td width="70%" valign="top" align="left">Read only. This is the TimeZone Offset in hours from the Server, not GMT.
            </td>
          </tr>

          <tr>
            <td width="20%" valign="top" align="left" nowrap>Registered on:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input type="text" name="userregon" id="userregon" style="width: 250" readOnly value="<?php echo $uregtime; ?>">
            </td>
            <td width="70%" valign="top" align="left">Read only.
            </td>
          </tr>

          <tr>
            <td width="20%" valign="top" align="left" nowrap>Confirmed on:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <input type="text" name="userconfon" id="userconfon" style="width: 250" readOnly value="<?php echo $uconftime; ?>">
            </td>
            <td width="70%" valign="top" align="left">Read only.
            </td>
          </tr>
<?php
if($cuser->gsv("isadmin") == 1) {
?>
          <tr>
            <td width="20%" valign="top" align="left" nowrap>Admin:</td>
            <td width="30%" valign="top" align="left" nowrap>
            <select size="1" tabindex="13" name="fields[userisadmin]" id="userisadmin" style="width: 250">
            <option value="0">No</option>     
            <option selected value="1">Yes</option>     
            </select>
            <input type="hidden" name="prev_fields[userisadmin]" id="puserisadmin" value="<?php echo $cuser->gsv("isadmin"); ?>">
            </td>
            <td width="70%" valign="top" align="left">Use cautiously!
            </td>
            
          </tr>
<?php
}
?>
        </table>
        <br>
			<table border="1" width="100%">
			  <tr>
			    <td width="33%" valign="middle" align="center" nowrap>
                <input <?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "disabled";} ?> type="submit" tabindex="14" value="Save" name="saveuser" id="saveuser">
                </td>
			    <td width="34%" valign="middle" align="center" nowrap>
                <input <?php if($cuser->gsv("regkey") == "15dda2f7c424e971a5002a5c16523585") {echo "disabled";} ?> type="button" tabindex="15" value="Delete" name="deleteuser" id="deleteuser" LANGUAGE=javascript onclick="return deleteuser_onclick()">
                </td>
			    <td width="33%" valign="middle" align="center" nowrap>
                <input type="submit" tabindex="16" value="Done" name="doneuser" id="doneuser" LANGUAGE=javascript onclick="return doneuser_onclick()">
                </td>
			  </tr>
			</table>
      </td>
    </tr>
  </table>
</form>
<?php
echo "<br><br>";
include_once("./include/footer.php");
exit();
}?>