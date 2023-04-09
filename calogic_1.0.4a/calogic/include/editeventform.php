<?php

function editeventform($cuser,$evid) {
    global $timear,$timeara,$curcalcfg,$monthtext,$monthtextl,$langcfg;

//prepare some field output
    $daypostxt[1] = "First";
    $daypostxt[2] = "Second";
    $daypostxt[3] = "Third";
    $daypostxt[4] = "Fourth";
    $daypostxt[5] = "Last";

    $wdaytxt[1] = $langcfg["wdnl1"];
    $wdaytxt[2] = $langcfg["wdnl2"];
    $wdaytxt[3] = $langcfg["wdnl3"];
    $wdaytxt[4] = $langcfg["wdnl4"];
    $wdaytxt[5] = $langcfg["wdnl5"];
    $wdaytxt[6] = $langcfg["wdnl6"];
    $wdaytxt[7] = $langcfg["wdnl7"];
    
    $wdaytxt[8] = "Weekday";
    $wdaytxt[9] = "Weekend day";
    $wdaytxt[10] = "Day";
    

$sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_events where uid = '".$cuser->gsv("cuid")."' and (calid = '".$cuser->gsv("curcalid")."' and evid = ".$evid.")";
$query1 = mysql_query($sqlstr) or die("Cannot query Events Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
$evrow = mysql_fetch_array($query1);
@mysql_free_result($query1);
    
    
    $fyear=$evrow["startyear"];
    $fmonth=$evrow["startmonth"];
    $fday=$evrow["startday"];
    $fhour=$evrow["starthour"];
    $fmin=$evrow["startmin"];
    $cuts = mktime($fhour,$fmin,0,$fmonth,$fday,$fyear);
    $zuts = dateadd("yyyy",1,$cuts);
    $zxfdate = getdate($zuts);
    $xfuncdate = getdate($cuts);
    $fdow = $xfuncdate["wday"];
    $xfdow = $fdow;
    $rfdow = $fdow;
    if($fdow==0) {$fdow=7;}
    if($fdow < 6) {$isweekday = 1;} else {$isweekday = 0;}
    $zfcday = 1;                    
    $tuts = mktime(0,0,0,$fmonth,$zfcday,$fyear);
    $zfuncdate = getdate($tuts);
    $weekdaypos = 0;
    $islastpos = 1;
    $weekdayposcnt = 0;
    $islastposcnt = 0;
    
    while(($zfuncdate["mon"] == $xfuncdate["mon"])) {
        if(($zfuncdate["wday"] == $rfdow) && ($zfuncdate["mday"] <= $xfuncdate["mday"])) {
            $weekdaypos++;
            $weekdayposcnt++;
        }
        if($zfuncdate["mday"] > $xfuncdate["mday"]) {
            if($zfuncdate["wday"] == $rfdow) {
                $islastpos = 0;
                $islastposcnt++;
            }
        }

        $zfcday++;
        $tuts = mktime(0,0,0,$fmonth,$zfcday,$fyear);
        $zfuncdate = getdate($tuts);
    }
    if($islastpos == 1) {
        $weekdaypos=5;
    }
?>

<HTML>
<HEAD>
<TITLE>CaLogic Edit Event</TITLE>
<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--

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

function rbday_onclick() {
divday.style.display="inline";
divweek.style.display="none";
divmonth.style.display="none";
divyear.style.display="none";

}

function rbmonth_onclick() {
divday.style.display="none";
divweek.style.display="none";
divmonth.style.display="inline";
divyear.style.display="none";

}

function rbweek_onclick() {
divday.style.display="none";
divweek.style.display="inline";
divmonth.style.display="none";
divyear.style.display="none";

}

function rbyear_onclick() {
divday.style.display="none";
divweek.style.display="none";
divmonth.style.display="none";
divyear.style.display="inline";

}

function eventrepeat_onclick() {
	if (cevent.eventrepeat.checked==true) {
		cevent.rbday.disabled=false;
		cevent.rbweek.disabled=false;
		cevent.rbmonth.disabled=false;
		cevent.rbyear.disabled=false;
		cevent.rbday.checked=true;
		divseriesevent.style.display="inline";
		divday.style.display="inline";
		divsend.style.display="inline";
		divweek.style.display="none";
		divmonth.style.display="none";
		divyear.style.display="none";
	} else {
		cevent.rbday.checked=false;
		cevent.rbweek.checked=false;
		cevent.rbmonth.checked=false;
		cevent.rbyear.checked=false;
		cevent.rbday.disabled=true;
		cevent.rbweek.disabled=true;
		cevent.rbmonth.disabled=true;
		cevent.rbyear.disabled=true;
		divseriesevent.style.display="none";
		divsend.style.display="none";
		divday.style.display="none";
		divweek.style.display="none";
		divmonth.style.display="none";
		divyear.style.display="none";
	}
}

function sendreminder_onclick() {
	if (cevent.sendreminder.checked==true) {
        reminderbox.style.display="inline";
	} else {
        reminderbox.style.display="none";
	}

}

function allcontacts_ondblclick() {
    var nrl;
    for (i=0; i<cevent.allcontacts.options.length; i++) {
        if(cevent.allcontacts.options(i).selected) {
            nrl = document.createElement("OPTION");
            nrl.text=cevent.allcontacts.options(i).text;
            nrl.value=cevent.allcontacts.options(i).value;
            document.all.cevent.remindercontacts.add(nrl);
            cevent.allcontacts.options.remove(i);
        }
    }
}

function remindercontacts_ondblclick() {
    var drl;
    for (i=0; i<cevent.remindercontacts.options.length; i++) {
        if(cevent.remindercontacts.options(i).selected) {
            drl = document.createElement("OPTION");
            drl.text=cevent.remindercontacts.options(i).text;
            drl.value=cevent.remindercontacts.options(i).value;
            document.all.cevent.allcontacts.add(drl);
            cevent.remindercontacts.options.remove(i);
        }
    }
}

function addalllist_onclick() {
    var narl;
    for (i=0; i<cevent.allcontacts.options.length; i++) {
        narl = document.createElement("OPTION");
        narl.text=cevent.allcontacts.options(i).text;
        narl.value=cevent.allcontacts.options(i).value;
        document.all.cevent.remindercontacts.add(narl);
    }
    do
    {
        cevent.allcontacts.options.remove(0);
    }
    while(cevent.allcontacts.options.length > 0) 
}

function removealllist_onclick() {
    var rarl;
    for (i=0; i<cevent.remindercontacts.options.length; i++) {
        rarl = document.createElement("OPTION");
        rarl.text=cevent.remindercontacts.options(i).text;
        rarl.value=cevent.remindercontacts.options(i).value;
        document.all.cevent.allcontacts.add(rarl);
    }
    do
    {
        cevent.remindercontacts.options.remove(0);
    }
    while(cevent.remindercontacts.options.length > 0) 
}

function window_onload() {

}

function eventstarttimehour_onchange() {
    if(cevent.eventstarttimehour.selectedIndex == 0) {
        if(confirm("Do you want to make this event an all day event?")) {
            cevent.eventstarttimemin.selectedIndex = 0;
            cevent.eventendtimehour.selectedIndex = 0;
            cevent.eventendtimemin.selectedIndex = 0;
            cevent.alldayevent.value = "1";
        } else {
            return false;
        }
    } else {
		if(cevent.alldayevent.value == "1") {
            cevent.alldayevent.value = "0";
            cevent.eventstarttimemin.selectedIndex = 1;
            cevent.eventendtimehour.selectedIndex = cevent.eventstarttimehour.selectedIndex;
            cevent.eventendtimemin.selectedIndex = cevent.eventstarttimemin.selectedIndex;
		} else {
			if(cevent.eventendtimehour.selectedIndex < cevent.eventstarttimehour.selectedIndex) {
				cevent.eventendtimehour.selectedIndex = cevent.eventstarttimehour.selectedIndex;
			}
			if (cevent.eventendtimehour.selectedIndex == cevent.eventstarttimehour.selectedIndex && cevent.eventendtimemin.selectedIndex < cevent.eventstarttimemin.selectedIndex) {
				cevent.eventendtimemin.selectedIndex = cevent.eventstarttimemin.selectedIndex;
			}
		}
    }
}

function eventstarttimemin_onchange() {
    if(cevent.eventstarttimemin.selectedIndex == 0) {
        if(confirm("Do you want to make this event an all day event?")) {
            cevent.eventstarttimehour.selectedIndex = 0;
            cevent.eventendtimehour.selectedIndex = 0;
            cevent.eventendtimemin.selectedIndex = 0;
            cevent.alldayevent.value = "1";
        } else {
            return false;
        }
    } else {
		if(cevent.alldayevent.value == "1") {
            cevent.alldayevent.value = "0";
            cevent.eventstarttimehour.selectedIndex = 1;
            cevent.eventendtimehour.selectedIndex = cevent.eventstarttimehour.selectedIndex;
            cevent.eventendtimemin.selectedIndex = cevent.eventstarttimemin.selectedIndex;
		} else {
			if (cevent.eventendtimehour.selectedIndex == cevent.eventstarttimehour.selectedIndex && cevent.eventendtimemin.selectedIndex < cevent.eventstarttimemin.selectedIndex) {
				cevent.eventendtimemin.selectedIndex = cevent.eventstarttimemin.selectedIndex;
			}
		}
    }
}

function eventendtimehour_onchange() {
    if(cevent.eventendtimehour.selectedIndex == 0) {
        if(confirm("Do you want to make this event an all day event?")) {
            cevent.eventstarttimehour.selectedIndex = 0;
            cevent.eventstarttimemin.selectedIndex = 0;
            cevent.eventendtimemin.selectedIndex = 0;
            cevent.alldayevent.value = "1";
        } else {
            return false;
        }
    } else {
		if(cevent.alldayevent.value == "1") {
            cevent.alldayevent.value = "0";
            cevent.eventendtimemin.selectedIndex = 1;
            cevent.eventstarttimehour.selectedIndex = cevent.eventendtimehour.selectedIndex;
            cevent.eventstarttimemin.selectedIndex = cevent.eventendtimemin.selectedIndex;
		} else {
			if(cevent.eventendtimehour.selectedIndex < cevent.eventstarttimehour.selectedIndex) {
				cevent.eventstarttimehour.selectedIndex = cevent.eventendtimehour.selectedIndex;
			}
			if (cevent.eventendtimehour.selectedIndex == cevent.eventstarttimehour.selectedIndex && cevent.eventendtimemin.selectedIndex < cevent.eventstarttimemin.selectedIndex) {
				cevent.eventstarttimemin.selectedIndex = cevent.eventendtimemin.selectedIndex;
			}
		}
    }
}

function eventendtimemin_onchange() {
    if(cevent.eventendtimemin.selectedIndex == 0) {
        if(confirm("Do you want to make this event an all day event?")) {
            cevent.eventstarttimehour.selectedIndex = 0;
            cevent.eventstarttimemin.selectedIndex = 0;
            cevent.eventendtimehour.selectedIndex = 0;
            cevent.alldayevent.value = "1";
        } else {
            return false;
        }
    } else {
		if(cevent.alldayevent.value == "1") {
            cevent.alldayevent.value = "0";
            cevent.eventendtimehour.selectedIndex = 1;
            cevent.eventstarttimehour.selectedIndex = cevent.eventendtimehour.selectedIndex;
            cevent.eventstarttimemin.selectedIndex = cevent.eventendtimemin.selectedIndex;
		} else {
			if (cevent.eventendtimehour.selectedIndex == cevent.eventstarttimehour.selectedIndex && cevent.eventendtimemin.selectedIndex < cevent.eventstarttimemin.selectedIndex) {
				cevent.eventstarttimemin.selectedIndex = cevent.eventendtimemin.selectedIndex;
			}
		}
    }
}

function cevent_onsubmit() {
    var xnosave = false;
	if(cevent.nosave.value == "0") {
        cevent.eventtitle.value = trim(cevent.eventtitle.value);
        if(cevent.eventtitle.value == "") {
            alert("You must enter a Title!");
            xnosave = true;
        }
		if(cevent.sendreminder.checked==true && cevent.remindercontacts.options.length < 1) {
			alert("At least one contact must be selected\nif you wish a reminder to be sent!");
            xnosave = true;
		}
        if(cevent.srval.value < 1) {
			alert("Invalid reminder interval!");
            xnosave = true;
        }
	}

    if(cevent.eventrepeat.checked == true) {
        if(cevent.rbday.checked == true) {
            if(cevent.eachday.checked == true) {
                if(cevent.eachdaycount.value < 1) {
                    xnosave = true;
                    alert("Invalid number of days!");
                }
            }
        }
        if(cevent.rbweek.checked == true) {
            if(cevent.eachweekcount.value < 1) {
                xnosave = true;
                alert("Invalid number of weeks!");
            }
            if(cevent.weekday1.checked==false && cevent.weekday2.checked==false && cevent.weekday3.checked==false && cevent.weekday4.checked==false && cevent.weekday5.checked==false && cevent.weekday6.checked==false && cevent.weekday7.checked==false) {
                xnosave = true;
                alert("At least one day of the week must be checked!");
            }
        }
        if(cevent.rbmonth.checked == true) {
            if(cevent.dayofmonth1.checked == true) {
                if(cevent.dayofmonthcount.value < 1) {
                    xnosave = true;
                    alert("Invalid number of months!");
                }
            }
            if(cevent.dayofmonth2.checked == true) {
                if(cevent.whichdayofmonthcount.value < 1) {
                    xnosave = true;
                    alert("Invalid number of months!");
                }
            }
        }
        if(cevent.rbyear.checked == true) {
        
        }
        if(cevent.eventend2.checked == true) {
            if(cevent.eventendafter.value < 1) {
                xnosave = true;
                alert("Invalid number of occurances!");
            }
        }
    }

    if(cevent.sendreminder.checked==true) {
        if(cevent.srint.value == 1) {
            if(cevent.srval.value < <?php echo $GLOBALS["rminmin"]; ?> || cevent.srval.value > <?php echo $GLOBALS["rminmax"]; ?>) {
                alert("Invalid number of minutes for reminder!\nPlease enter a value from <?php echo $GLOBALS["rminmin"]; ?> to <?php echo $GLOBALS["rminmax"]; ?>");
                xnosave = true;
            }
        } 
        if(cevent.srint.value == 2) {
            if(cevent.srval.value < <?php echo $GLOBALS["rhourmin"]; ?> || cevent.srval.value > <?php echo $GLOBALS["rhourmax"]; ?>) {
                alert("Invalid number of hours for reminder!\nPlease enter a value from <?php echo $GLOBALS["rhourmin"]; ?> to <?php echo $GLOBALS["rhourmax"]; ?>");
                xnosave = true;
            }
        } 
        if(cevent.srint.value == 3) {
            if(cevent.srval.value < <?php echo $GLOBALS["rdaymin"]; ?> || cevent.srval.value > <?php echo $GLOBALS["rdaymax"]; ?>) {
                alert("Invalid number of days for reminder!\nPlease enter a value from <?php echo $GLOBALS["rdaymin"]; ?> to <?php echo $GLOBALS["rdaymax"]; ?>");
                xnosave = true;
            }
        }
    }
    
    
    if(xnosave == true) {
        return false;
    } else {
		if(cevent.sendreminder.checked==true) {
            var srconcnt = 0;
            for (i=0; i<cevent.remindercontacts.options.length; i++) {
                if(srconcnt > 0) {
                    cevent.srcons.value += '|';
                }
                cevent.srcons.value += cevent.remindercontacts(i).value;
                srconcnt++;
            }
        }
    	return true;
    }
}

function doneevent_onclick() {
    cevent.nosave.value="1";
    cevent.submit();
}

function eventend1_onclick() {
	cevent.eventendday.disabled = true;
	cevent.eventendmonth.disabled = true;
	cevent.eventendyear.disabled = true;
}

function eventend2_onclick() {
	cevent.eventendday.disabled = true;
	cevent.eventendmonth.disabled = true;
	cevent.eventendyear.disabled = true;
}

function eventend3_onclick() {
	cevent.eventendday.disabled = false;
	cevent.eventendmonth.disabled = false;
	cevent.eventendyear.disabled = false;
}

function eventendday_onchange() {
	if(cevent.eventendyear.selectedIndex < cevent.eventyear.selectedIndex) {
		cevent.eventyear.selectedIndex = cevent.eventendyear.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex < cevent.eventmonth.selectedIndex) {
		cevent.eventmonth.selectedIndex = cevent.eventendmonth.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex == cevent.eventmonth.selectedIndex && cevent.eventendday.selectedIndex < cevent.eventday.selectedIndex) {
		cevent.eventday.selectedIndex = cevent.eventendday.selectedIndex;
	}
}

function eventendmonth_onchange() {
	if(cevent.eventendyear.selectedIndex < cevent.eventyear.selectedIndex) {
		cevent.eventyear.selectedIndex = cevent.eventendyear.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex < cevent.eventmonth.selectedIndex) {
		cevent.eventmonth.selectedIndex = cevent.eventendmonth.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex == cevent.eventmonth.selectedIndex && cevent.eventendday.selectedIndex < cevent.eventday.selectedIndex) {
		cevent.eventday.selectedIndex = cevent.eventendday.selectedIndex;
	}
}

function eventendyear_onchange() {
	if(cevent.eventendyear.selectedIndex < cevent.eventyear.selectedIndex) {
		cevent.eventyear.selectedIndex = cevent.eventendyear.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex < cevent.eventmonth.selectedIndex) {
		cevent.eventmonth.selectedIndex = cevent.eventendmonth.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex == cevent.eventmonth.selectedIndex && cevent.eventendday.selectedIndex < cevent.eventday.selectedIndex) {
		cevent.eventday.selectedIndex = cevent.eventendday.selectedIndex;
	}
}

function eventday_onchange() {
	if(cevent.eventendyear.selectedIndex < cevent.eventyear.selectedIndex) {
		cevent.eventendyear.selectedIndex = cevent.eventyear.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex < cevent.eventmonth.selectedIndex) {
		cevent.eventendmonth.selectedIndex = cevent.eventmonth.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex == cevent.eventmonth.selectedIndex && cevent.eventendday.selectedIndex < cevent.eventday.selectedIndex) {
		cevent.eventendday.selectedIndex = cevent.eventday.selectedIndex;
	}
}

function eventmonth_onchange() {
	if(cevent.eventendyear.selectedIndex < cevent.eventyear.selectedIndex) {
		cevent.eventendyear.selectedIndex = cevent.eventyear.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex < cevent.eventmonth.selectedIndex) {
		cevent.eventendmonth.selectedIndex = cevent.eventmonth.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex == cevent.eventmonth.selectedIndex && cevent.eventendday.selectedIndex < cevent.eventday.selectedIndex) {
		cevent.eventendday.selectedIndex = cevent.eventday.selectedIndex;
	}
}

function eventyear_onchange() {
	if(cevent.eventendyear.selectedIndex < cevent.eventyear.selectedIndex) {
		cevent.eventendyear.selectedIndex = cevent.eventyear.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex < cevent.eventmonth.selectedIndex) {
		cevent.eventendmonth.selectedIndex = cevent.eventmonth.selectedIndex;
	}
	if(cevent.eventendyear.selectedIndex == cevent.eventyear.selectedIndex && cevent.eventendmonth.selectedIndex == cevent.eventmonth.selectedIndex && cevent.eventendday.selectedIndex < cevent.eventday.selectedIndex) {
		cevent.eventendday.selectedIndex = cevent.eventday.selectedIndex;
	}
}


//-->
</SCRIPT>
</HEAD>
<BODY background="<?php echo $curcalcfg["gcbgimg"]; ?>" LANGUAGE=javascript onload="return window_onload()">
<?php
//echo $sqlstr;
//exit();
/*
    echo "fyear: ".$fyear." <br>";
    echo "fmonth: ".$fmonth." <br>";
    echo "fday: ".$fday." <br>";
    echo "fhour: ".$fhour." <br>";
    echo "fmin: ".$fmin." <br>";
    echo "cuts: ".$cuts." <br>";
    echo "xfuncdate: ".$xfuncdate." <br>";
    echo "fdow: ".$fdow." <br>";
    echo "xfdow: ".$xfdow." <br>";
    echo "rfdow: ".$rfdow." <br>";
    echo "zfcday: ".$zfcday." <br>";            
    echo "tuts: ".$tuts." <br>";
    echo "zfuncdate: ".$zfuncdate." <br>";
    echo "weekdaypos: ".$weekdaypos." <br>";
    echo "islastpos: ".$islastpos." <br>";
    echo "weekdayposcnt ".$weekdayposcnt." <br>";
    echo "islastposcnt ".$islastposcnt." <br>";

*/
?>
<h1>Edit Event</h1>
<form method="POST" name="cevent" id="cevent" action="<?php echo $GLOBALS["idxfile"]; ?>" LANGUAGE=javascript onsubmit="return cevent_onsubmit()">
<input type="hidden" name="nef[nosave]" id="nosave" value="0" />
<input type="hidden" name="nef[alldayevent]" id="alldayevent" value="<?php echo $evrow["isallday"]; ?>" />
<input type="hidden" name="nef[srcons]" id="srcons" value="" />
<input type="hidden" name="edevid" id="edevid" value="<?php echo $evid; ?>" />
<table border="1" cellspacing="2" cellpadding="1" width="100%">
  <tr>
    <td width="30%">
<div title="Enter the Title of the event here. It will appear on the different Calendar views.">
    <b>Title:</b>
    <input value="<?php echo ($evrow["title"]); ?>" title="Enter the Title of the event here. It will appear on the different Calendar views." name="nef[eventtitle]" size="32" id="eventtitle" maxLength="50">
</div>
    </td>
    <td width="70%">
    
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
          <td width="35%">
          
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
              <tr>
                <td width="33%" nowrap>
<div title="Select the day on which the event occurs" >
                <b>Day</b>
</div>                
                </td>
                <td width="33%" nowrap>
<div title="Select the month in which the event occurs" >
                <b>Month</b>
</div>                
                </td>
                <td width="34%" nowrap>
<div title="Select the year in which the event occurs" >
                <b>Year</b>
</div>                
                </td>
              </tr>
              <tr>
                <td width="33%" nowrap>
<div title="Select the day on which the event occurs" >
                <select size="1" id="eventday" style="WIDTH: 47px" name="nef[eventday]" LANGUAGE=javascript onchange="return eventday_onchange()">
<?php
    for($lc=1;$lc<=31;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["startday"]==$mlc) {
            echo "selected ";
        }
        echo "value = \"".$mlc."\" >".$mlc."</option>\n";
     }
    ?>                
                </select>
</div>                
                </td>
                <td width="33%" nowrap>
<div title="Select the month in which the event occurs" >
                <select size="1" id="eventmonth" style="WIDTH: 65px" name="nef[eventmonth]" LANGUAGE=javascript onchange="return eventmonth_onchange()">
<?php
    for($lc=1;$lc<=12;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["startmonth"]==$mlc) {
            echo "selected ";
        }
        echo "value = \"".$mlc."\" >".$monthtext[$lc]."</option>\n";
     }
    ?>          
                </select>
</div>                
                </td>
                <td width="34%" nowrap>
<div title="Select the year in which the event occurs" >
                <select size="1" id="eventyear" style="WIDTH: 70px" name="nef[eventyear]" LANGUAGE=javascript onchange="return eventyear_onchange()">
<?php
    for($lc=($evrow["startyear"]-1);$lc<=($evrow["startyear"]+4);$lc++) {
		echo "        <option ";
        if($evrow["startyear"]==$lc) {
            echo "selected ";
        }
        echo "value = \"".$lc."\" >".$lc."</option>\n";
     }
    ?>                        
                </select>
</div>                
                </td>
              </tr>
            </table>
            
          </td>
          <td width="65%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
              <tr>
                <td width="33%" align="center" nowrap>
<div title="Select the event starting time. Leave the time fields blank for an All Day Event.">
                <b>Start Time</b>
</div>
                </td>
                <td width="33%" align="center" nowrap>
<div title="Select the event ending time. Leave the time fields blank for an All Day Event.">
                <b>End Time</b>
</div>
                </td>
                <td width="34%" nowrap>
&nbsp;<!--                
<div title="Use the Durration field to help calculate the end of the event.">
                <b>Duration</b>
</div>
-->                </td>
              </tr>
              <tr>
                <td width="33%" align="center" nowrap>
                <!--
		<select size="1" name="eventstarttimehour" style="WIDTH: 70px" id="eventstarttimehour"></select>
                -->
<div title="Select the event starting time. Leave the time fields blank for an All Day Event.">
                <select size="1" name="nef[eventstarttimehour]" style="WIDTH: 60px" id="eventstarttimehour" LANGUAGE=javascript onchange="return eventstarttimehour_onchange()">
                <option <?php if($evrow["isallday"]==1) {echo "selected";} ?> value = ""></option>
<?php
    for($lc=0;$lc<47;$lc++) {
		echo "        <option ";
        if($evrow["starthour"]==substr($timear[$lc],0,2) && $evrow["isallday"]!=1) {
            echo "selected ";
        }
        echo "value = \"".substr($timear[$lc],0,2)."\" >";
        if($curcalcfg["timetype"]==1) {
            echo substr($timear[$lc],0,2)."</option>\n";
        } else {
            if(strpos($timeara[$lc],":")==1) {
                echo substr($timeara[$lc],0,1)." ".substr($timeara[$lc],5,2)."</option>\n";
            } else {
                echo substr($timeara[$lc],0,2)." ".substr($timeara[$lc],6,2)."</option>\n";
            }
        }
        $lc++;
     }
    ?>
      
                </select> :
                <select size="1" name="nef[eventstarttimemin]" style="WIDTH: 60px" id="eventstarttimemin" LANGUAGE=javascript onchange="return eventstarttimemin_onchange()">
                <option <?php if($evrow["isallday"]==1) {echo "selected";} ?> value = ""></option>
<?php
    for($lc=0;$lc<=59;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["startmin"]==$mlc && $evrow["isallday"]!=1) {
            echo "selected ";
        }
        echo "value = \"".$mlc."\" >".$mlc."</option>\n";
     }
    ?>                
                </select>
</div>
                </td>
                <td width="33%" align="center" nowrap>
                <!--
		<select size="1" name="eventendtime" style="WIDTH: 70px" id="eventendtime"></select>
                -->
<div title="Select the event ending time. Leave the time fields blank for an All Day Event.">
                <select size="1" name="nef[eventendtimehour]" style="WIDTH: 60px" id="eventendtimehour" LANGUAGE=javascript onchange="return eventendtimehour_onchange()">
                <option <?php if($evrow["isallday"]==1) {echo "selected";} ?> value=""></option>
<?php
    for($lc=0;$lc<47;$lc++) {
		echo "        <option ";
        if($evrow["endhour"]==substr($timear[$lc],0,2) && $evrow["isallday"]!=1) {
            echo "selected ";
        }
        echo "value = \"".substr($timear[$lc],0,2)."\" >";
        if($curcalcfg["timetype"]==1) {
            echo substr($timear[$lc],0,2)."</option>\n";
        } else {
            if(strpos($timeara[$lc],":")==1) {
                echo substr($timeara[$lc],0,1)." ".substr($timeara[$lc],5,2)."</option>\n";
            } else {
                echo substr($timeara[$lc],0,2)." ".substr($timeara[$lc],6,2)."</option>\n";
            }
        }
        $lc++;
     }
    ?>                
                </select> :
                <select size="1" name="nef[eventendtimemin]" style="WIDTH: 60px" id="eventendtimemin" LANGUAGE=javascript onchange="return eventendtimemin_onchange()">
                <option <?php if($evrow["isallday"]==1) {echo "selected";} ?> value=""></option>
<?php
    for($lc=0;$lc<=59;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["endmin"]==$mlc && $evrow["isallday"]!=1) {
            echo "selected ";
        }
        echo "value = \"".$mlc."\" >".$mlc."</option>\n";
     }
    ?>                
                </select>
</div>
                </td>
                <td width="34%" nowrap>&nbsp;
<!--
<div title="Use the Durration field to help calculate the end of the event.">
		<select size="1" name="nef[eventlength]" style="WIDTH: 90px" id="eventlength"></select>
</div>
-->                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <!--
    <td width="24%">&nbsp;</td>
    -->
  </tr>
  <tr>
    <td width="30%" valign="top">
      <table border="0" cellspacing="2" cellpadding="1" width="100%">
        <tr>
          <td width="100%" valign="top" align="left">
<div title="Enter a description for the event. This description also gets sent with reminder mails.">
          &nbsp;<b>Description:</b>
</div>
          </td>
        </tr>
        <tr>
          <td width="100%">
<TEXTAREA title="Enter a description for the event. This description also gets sent with reminder mails." id="desc" style="WIDTH: 272px; HEIGHT: 117px" name="nef[desc]" rows="6" cols="31"><?php echo $evrow["description"]; ?></TEXTAREA>
          </td>
        </tr>
        <tr>
          <td width="100%">
<div title="Select a categroy for the event.">
          <b>Category:</b>
        <select size="1" name="nef[cat]" style="WIDTH: 195px" id="cat">
        <option <?php if($evrow["catid"]==0) {echo "selected";} ?> value="0">none</option>
<?php
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_user_cat where uid = '".$cuser->gsv("cuid")."' and (calid = '".$cuser->gsv("curcalid")."' or calid = '0')";
    $query1 = mysql_query($sqlstr) or die("Cannot query User Category Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
		echo "        <option ";
        if($evrow["catid"]==$row["catid"]) {echo " selected ";} 
        echo "value = \"".$row["catid"]."\">".$row["catname"]."</option>\n";
     }
     mysql_free_result($query1);
    ?>        
        </select> 
</div>
        </td>
        </tr>
        <tr>
          <td width="100%" align="center">

<?php
if($GLOBALS["allowreminders"] == 1) {
?>
          <hr size="1" />
          <INPUT <?php if($evrow["sendreminder"]==1) {echo "checked";} ?> title="Check this box to send a reminder for this event." type="checkbox" id="sendreminder" name="nef[sendreminder]" LANGUAGE=javascript onclick="return sendreminder_onclick()">
          <label title="Check this box to send a reminder for this event." for="sendreminder"><b>Send Reminder</b></label>
<div style="display: <?php if($evrow["sendreminder"]==1) {echo "inline";} else {echo "none";} ?> " id="reminderbox">
      <table border="0" cellspacing="1" cellpadding="0" width="100%">
        <tr>
          <td width="45%" valign="top" align="center">
<div style="display: inline" title="Add contacts to the reminder list by double clicking the entry.">
            Contacts List<br>
            <SELECT style="WIDTH: 130px" id="allcontacts" size="5" name="nef[allcontacts]" LANGUAGE=javascript ondblclick="return allcontacts_ondblclick()">
<?php
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where uid = ".$cuser->gsv("cuid")." and calid = '".$cuser->gsv("curcalid")."' and evid=".$evid." and contyp='M' and conid=".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query Event Reminders Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    $numrows = @mysql_num_rows($query1);
    if($numrows != 1) {
        echo "<option value=\"M0\" text=\"Myself\">Myself</option>";
    }
    @mysql_free_result($query1);
?>
                         
<?php
    $sqlstr = "select congpid,gpname from ".$GLOBALS["tabpre"]."_user_con_grp where uid = ".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query User Contact Group Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
        $sqlstr2 = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where uid = ".$cuser->gsv("cuid")." and calid = '".$cuser->gsv("curcalid")."' and evid=".$evid." and contyp='G' and conid=".$row["congpid"];
        $query2 = mysql_query($sqlstr2) or die("Cannot query Event Reminders Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr2."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $numrows = @mysql_num_rows($query2);
        if($numrows != 1) {
    		echo "        <option ";
            echo "value = \"G".$row["congpid"]."\" text=\"G ".$row["gpname"]."\">G ".$row["gpname"]."</option>\n";
        }
        @mysql_free_result($query2);
     }
     mysql_free_result($query1);
     
    $sqlstr = "select conid,fname,lname from ".$GLOBALS["tabpre"]."_user_con where uid = ".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query User Contact Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {

        $sqlstr2 = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where uid = ".$cuser->gsv("cuid")." and calid = '".$cuser->gsv("curcalid")."' and evid=".$evid." and contyp='C' and conid=".$row["conid"];
        $query2 = mysql_query($sqlstr2) or die("Cannot query Event Reminders Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr2."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $numrows = @mysql_num_rows($query2);
        if($numrows != 1) {
    		echo "        <option ";
            echo "value = \"C".$row["conid"]."\" text=\"C ".$row["fname"]." ".$row["lname"]."\">C ".$row["fname"]." ".$row["lname"]."</option>\n";
        }
        @mysql_free_result($query2);
     }
     mysql_free_result($query1);
?>
            </SELECT>
</div>
          </td>
          <td width="45%" valign="top" align="center">
<div style="display: inline" title="Remove contacts from the reminder list by double clicking the entry.">
            To List<br>
            <SELECT style="WIDTH: 130px" id="remindercontacts" size="5" name="nef[remindercontacts]" LANGUAGE=javascript ondblclick="return remindercontacts_ondblclick()"> 

<?php
    $sqlstr = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where uid = ".$cuser->gsv("cuid")." and calid = '".$cuser->gsv("curcalid")."' and evid=".$evid." and contyp='M' and conid=".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query Event Reminders Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    $numrows = @mysql_num_rows($query1);
    if($numrows == 1) {
        echo "<option value=\"M0\" text=\"Myself\">Myself</option>";
    }
    @mysql_free_result($query1);
?>
                         
<?php
    $sqlstr = "select congpid,gpname from ".$GLOBALS["tabpre"]."_user_con_grp where uid = ".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query User Contact Group Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {
        $sqlstr2 = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where uid = ".$cuser->gsv("cuid")." and calid = '".$cuser->gsv("curcalid")."' and evid=".$evid." and contyp='G' and conid=".$row["congpid"];
        $query2 = mysql_query($sqlstr2) or die("Cannot query Event Reminders Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr2."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $numrows = @mysql_num_rows($query2);
        if($numrows == 1) {
    		echo "        <option ";
            echo "value = \"G".$row["congpid"]."\" text=\"G ".$row["gpname"]."\">G ".$row["gpname"]."</option>\n";
        }
        @mysql_free_result($query2);
     }
     mysql_free_result($query1);
     
    $sqlstr = "select conid,fname,lname from ".$GLOBALS["tabpre"]."_user_con where uid = ".$cuser->gsv("cuid");
    $query1 = mysql_query($sqlstr) or die("Cannot query User Contact Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
    
    while($row = @mysql_fetch_array($query1)) {

        $sqlstr2 = "select * from ".$GLOBALS["tabpre"]."_cal_event_rems where uid = ".$cuser->gsv("cuid")." and calid = '".$cuser->gsv("curcalid")."' and evid=".$evid." and contyp='C' and conid=".$row["conid"];
        $query2 = mysql_query($sqlstr2) or die("Cannot query Event Reminders Table<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr2."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);
        $numrows = @mysql_num_rows($query2);
        if($numrows == 1) {
    		echo "        <option ";
            echo "value = \"C".$row["conid"]."\" text=\"C ".$row["fname"]." ".$row["lname"]."\">C ".$row["fname"]." ".$row["lname"]."</option>\n";
        }
        @mysql_free_result($query2);
     }
     mysql_free_result($query1);
?>            


            </SELECT>
</div>
          </td>
        </tr>
        <tr>
        <td colspan="2" align="center" valign="top">
        (double click list entry to add or remove)<br />
          <button title="Click this button to add all contacts to the reminder list." style="WIDTH: 130px;" LANGUAGE=javascript onclick="return addalllist_onclick()">->&nbsp;Add All&nbsp;-></button><br />
          <button title="Click this button to remove all contacts from the reminder list." style="WIDTH: 130px;" LANGUAGE=javascript onclick="return removealllist_onclick()"><-&nbsp;Remove All&nbsp;<-</button>
        </td>
        </tr>
        <tr>
        <td colspan="2" align="center" valign="top">
        Send Reminder<br><input id="srval" name="nef[srval]" type="text" style="WIDTH: 30px" value="<?php if($evrow["sendreminder"]==1) {echo $evrow["srval"];} else {echo "3";} ?>">
        <SELECT style="WIDTH: 100px" id="srint" size="1" name="nef[srint]">

        
<?php
if($GLOBALS["rinterval"] == 1) {
?>
        <option <?php if($evrow["sendreminder"]==1 && $evrow["srint"] == 1) {echo "selected";} ?> value="1">Minutes</option>

        <option <?php if($evrow["sendreminder"]==1 && $evrow["srint"] == 2) {echo "selected";} ?> value="2">Hours</option>

        <option <?php if($evrow["sendreminder"]==1 && $evrow["srint"] == 3) {
                         echo "selected";
                      } elseif($evrow["sendreminder"] != 1) {
                         echo "selected";
                      }
        ?> value="3">days</option>

<?php
} elseif($GLOBALS["rinterval"] == 2) {
?>
        <option <?php if($evrow["sendreminder"]==1 && $evrow["srint"] == 2) {echo "selected";} ?> value="2">Hours</option>

        <option <?php if($evrow["sendreminder"]==1 && $evrow["srint"] == 3) {
                         echo "selected";
                      } elseif($evrow["sendreminder"] != 1) {
                         echo "selected";
                      }
        ?> value="3">days</option>

        
<?php
} elseif($GLOBALS["rinterval"] == 3) {
?>
        <option <?php if($evrow["sendreminder"]==1 && $evrow["srint"] == 3) {
                         echo "selected";
                      } elseif($evrow["sendreminder"] != 1) {
                         echo "selected";
                      }
        ?> value="3">days</option>

<?php
}
?>        
        
        </select>
        <br>before event takes place<br>
        Reminders get checked every <?php echo $GLOBALS["rfrequency"]." ".$GLOBALS["rfrtval"]; ?> 
        </td>
        </tr>
        </table>          
</div>

<?php
} else {
    echo "&nbsp;";
}
?>        </td>
      </table>
    </td>
    <td width="70%" align="left" valign="top">
      <INPUT <?php if($evrow["iseventseries"]==1) {echo "checked";} ?> title="Check this box to create an Event Series" type="checkbox" id="eventrepeat" name="nef[eventrepeat]" LANGUAGE=javascript onclick="return eventrepeat_onclick()">
      <LABEL for="eventrepeat" title="Check this box to create an Event Series"><b>Event Series</b></LABEL>

<div id="divseriesevent" style="display: <?php if($evrow["iseventseries"]==1) {echo "inline";} else {echo "none";} ?> ">

      <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
        <!--
          <td width="100%" colspan="2">
        </td>
        -->
        </tr>
        <tr>
          <td width="15%" valign="top"><b>&nbsp;Type:</b>
        <hr size="1">
        <input type="radio" value="1" <?php if($evrow["estype"]==1 || $evrow["iseventseries"]!=1 ) {echo "checked";} ?> title="Select this for a Daily Event." name="nef[estype]" id="rbday" maxLength=0 LANGUAGE="javascript"  onclick="return rbday_onclick()">
        <label title="Select this for a Daily Event." for="rbday">Daily</label><br>
        <input type="radio" value="2" <?php if($evrow["estype"]==2) {echo "checked";} ?> title="Select this for a Weekly Event." name="nef[estype]" id="rbweek" maxLength=0 LANGUAGE="javascript"  onclick="return rbweek_onclick()">
        <label title="Select this for a Weekly Event." for="rbweek">Weekly</label><br>
        <input type="radio" value="3" <?php if($evrow["estype"]==3) {echo "checked";} ?> title="Select this for a Monthly Event." name="nef[estype]" id="rbmonth" maxLength=0 LANGUAGE="javascript"  onclick="return rbmonth_onclick()">
        <label title="Select this for a Monthly Event." for="rbmonth">Monthly</label><br>
        <input type="radio" value="4" <?php if($evrow["estype"]==4) {echo "checked";} ?> title="Select this for a Yearly Event." name="nef[estype]" id="rbyear" maxLength=0 LANGUAGE="javascript"  onclick="return rbyear_onclick()">
        <label title="Select this for a Yearly Event." for="rbyear">Yearly</label>
            </td>
          <td width="85%" valign="top"><b>&nbsp;Occurance:</b>
        <hr size="1">
      <DIV title="Configure your Daily Event." style="DISPLAY: <?php if($evrow["estype"]==1) {echo "inline";} else {echo "none";} ?> " id="divday">
      
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
	<TR>
		<TD NOWRAP width="100%">
			<input title="Select this for an event that occurs every so many days." <?php if($evrow["estd"]==1 || $evrow["estd"]==0) {echo "checked";} ?> type="radio" name="nef[daytype]" value="1" id="eachday">
			<label title="Select this for an event that occurs every so many days."for="eachday">Every</label>&nbsp; 
            <input title="Enter the interval in days." type="text" id="eachdaycount" name="nef[eachdaycount]" value="<?php if($evrow["estd"]==1 ) {echo $evrow["estdint"];} else { echo "1";} ?>" size="5">&nbsp;Day(s)
		</TD>
	</TR>
	<TR>
		<TD NOWRAP width="100%">
			<input <?php if($evrow["estd"]==2) {echo "checked";} ?> title="Select this for an event that occurs every weekday." type="radio" name="nef[daytype]" value="2" id="eachweekday">
			<label title="Select this for an event that occurs every weekday." for="eachweekday">Every&nbsp;Weekday</label>
		</TD>
	</TR>
</TABLE>

      </DIV>
      <DIV title="Configure your Weekly Event." style="DISPLAY: <?php if($evrow["estype"]==2) {echo "inline";} else {echo "none";} ?> " id="divweek">
      
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
	<TR>
		<TD NOWRAP colspan="4" width="100%">Every&nbsp; 
        <input title="Enter the weekly interval." type="text" id="eachweekcount" name="nef[eachweekcount]" value="<?php if($evrow["estype"]==2) {echo $evrow["estwint"];} else {echo "1";} ?>" size="5">&nbsp;Week(s)&nbsp;on
		</TD>
	</TR>
        <?php
        if($evrow["estype"]==2) {
        ?>
	<TR>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Mondays." type="checkbox" <?php if(substr($evrow["estwd"],0,1)==1) {echo "checked"; } ?> value="1" name="nef[weekday1]" id="weekday1">
			<label title="Check this if the event occurs on Mondays." for="weekday1">Monday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Tuesdays." type="checkbox" <?php if(substr($evrow["estwd"],1,1)==1) {echo "checked"; } ?>  value="2" name="nef[weekday2]" id="weekday2">
			<label title="Check this if the event occurs on Tuesdays." for="weekday2">Tuesday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Wednesdays." type="checkbox" <?php if(substr($evrow["estwd"],2,1)==1) {echo "checked"; } ?>  value="3" name="nef[weekday3]" id="weekday3">
			<label title="Check this if the event occurs on Wednesdays." for="weekday3">Wednesday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Thursdays." type="checkbox" <?php if(substr($evrow["estwd"],3,1)==1) {echo "checked"; } ?>  value="4" name="nef[weekday4]" id="weekday4">
			<label title="Check this if the event occurs on Thursdays." for="weekday4">Thursday</label>
		</TD>
	</TR>
	<TR>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Fridays." type="checkbox" <?php if(substr($evrow["estwd"],4,1)==1) {echo "checked"; } ?>  value="5" name="nef[weekday5]" id="weekday5">
			<label title="Check this if the event occurs on Fridays." for="weekday5">Friday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Saturdays." type="checkbox" <?php if(substr($evrow["estwd"],5,1)==1) {echo "checked"; } ?>  value="6" name="nef[weekday6]" id="weekday6">
			<label title="Check this if the event occurs on Saturdays." for="weekday6">Saturday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Sundays." type="checkbox" <?php if(substr($evrow["estwd"],6,1)==1) {echo "checked"; } ?>  value="7" name="nef[weekday7]" id="weekday7">
			<label title="Check this if the event occurs on Sundays." for="weekday7">Sunday</label>
		</TD>
		<TD NOWRAP width="25%">&nbsp;</TD>
	</TR>
        <?php
        } else {
        ?>
	<TR>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Mondays." type="checkbox" <?php if($fdow==1) {echo "checked"; } ?> value="1" name="nef[weekday1]" id="weekday1">
			<label title="Check this if the event occurs on Mondays." for="weekday1">Monday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Tuesdays." type="checkbox" <?php if($fdow==2) {echo "checked"; } ?> value="2" name="nef[weekday2]" id="weekday2">
			<label title="Check this if the event occurs on Tuesdays." for="weekday2">Tuesday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Wednesdays." type="checkbox" <?php if($fdow==3) {echo "checked"; } ?> value="3" name="nef[weekday3]" id="weekday3">
			<label title="Check this if the event occurs on Wednesdays." for="weekday3">Wednesday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Thursdays." type="checkbox" <?php if($fdow==4) {echo "checked"; } ?> value="4" name="nef[weekday4]" id="weekday4">
			<label title="Check this if the event occurs on Thursdays." for="weekday4">Thursday</label>
		</TD>
	</TR>
	<TR>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Fridays." type="checkbox" <?php if($fdow==5) {echo "checked"; } ?> value="5" name="nef[weekday5]" id="weekday5">
			<label title="Check this if the event occurs on Fridays." for="weekday5">Friday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Saturdays." type="checkbox" <?php if($fdow==6) {echo "checked"; } ?> value="6" name="nef[weekday6]" id="weekday6">
			<label title="Check this if the event occurs on Saturdays." for="weekday6">Saturday</label>
		</TD>
		<TD NOWRAP width="25%">
			<input title="Check this if the event occurs on Sundays." type="checkbox" <?php if($fdow==7) {echo "checked"; } ?> value="7" name="nef[weekday7]" id="weekday7">
			<label title="Check this if the event occurs on Sundays." for="weekday7">Sunday</label>
		</TD>
		<TD NOWRAP width="25%">&nbsp;</TD>
	</TR>
        <?php
        }
        ?>

</TABLE>

      </DIV>
      <DIV title="Configure your Monthly Event." style="DISPLAY: <?php if($evrow["estype"]==3) {echo "inline";} else {echo "none";} ?> " id="divmonth">
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
	<TR>
		<TD NOWRAP width="100%">
			<input title="Select this for an event that occurs on the same day of every so many months." <?php if($evrow["estm"]==1 || $evrow["estm"]==0) {echo "checked"; } ?> type="radio" name="nef[dayofmonth]" value="1" id="dayofmonth1">
			<label title="Select this for an event that occurs on the same day of every so many months." for="dayofmonth1">On&nbsp;the</label>&nbsp;
<div style="display:inline" title="Select the day of the month on which the event occurs." >
            <select size="1" id="dayofmonthday" style="WIDTH: 47px" name="nef[dayofmonthday]">
<?php
    for($lc=1;$lc<=31;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["estm1d"]==$mlc || ($evrow["estm"]!=1 && $evrow["startday"]==$mlc) ) {
            echo "selected ";
        }
        echo "value = \"".$mlc."\" >".$mlc."</option>\n";
     }
    ?>                
            
            </select>
</div>                
            &nbsp;Day,&nbsp;Every&nbsp;
            <input title="Enter the interval in months" type="text" id="dayofmonthcount" name="nef[dayofmonthcount]" value="<?php if($evrow["estm"]==1) {echo $evrow["estm1int"];} else {echo "1";} ?>" size="5">&nbsp;Month(s)
		</TD>
	</TR>
	<TR>
		<TD NOWRAP width="100%">
			<input title="Select this for an event that occurs on a certain day of every so many months." <?php if($evrow["estm"]==2) {echo "checked"; } ?> type="radio" name="nef[dayofmonth]" value="2" id="dayofmonth2">
			<label title="Select this for an event that occurs on a certain day of every so many months." for="dayofmonth2">On&nbsp;the</label>&nbsp; 
<div style="display:inline" title="Select which day the event occurs." >
            <select size="1" id="whichdayofmonth" name="nef[whichdayofmonth]" style="width: 93; height: 23">
<?php
    for($lc=1;$lc<=5;$lc++) {
		echo "        <option ";
        if($evrow["estm2dp"]==$lc || ($evrow["estm"]!=2 && $weekdaypos==$lc)) {
            echo "selected ";
        }
        echo "value = \"".$lc."\" >".$daypostxt[$lc]."</option>\n";
     }
    ?>            
            </select>&nbsp;
</div>
<div style="display:inline" title="Select the day on which the event occurs." >
			<select size="1" id="whichdayofmonthday" name="nef[whichdayofmonthday]" style="width: 92; height: 23">
<?php
    for($lc=1;$lc<=10;$lc++) {
		echo "        <option ";
        if($evrow["estm2wd"]==$lc || ($evrow["estm"]!=2 && $fdow==$lc)) {
            echo "selected ";
        }
        echo "value = \"".$lc."\" >".$wdaytxt[$lc]."</option>\n";
     }
    ?>                    
            </select>,&nbsp;Every&nbsp;
</div>
            <input type="text" title="Enter the interval in months." id="whichdayofmonthcount" name="nef[whichdayofmonthcount]" value="<?php if($evrow["estm"]==2) {echo $evrow["estm2int"];} else {echo "1";} ?>" size="5">&nbsp;Month(s)
		</TD>
	</TR>
</TABLE>

      </DIV>
      <DIV title="Configure your Yearly Event." style="DISPLAY: <?php if($evrow["estype"]==4) {echo "inline";} else {echo "none";} ?> " id="divyear">
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
	<TR>
		<TD NOWRAP width="100%">
			<input <?php if($evrow["esty"]==1 || $evrow["esty"]==0) {echo "checked"; } ?> title="Select this for an event that occurs on the same day every year." type="radio" checked name="nef[dayofmonthyear]" value="1" id="dayofmonthyear1">
			<label title="Select this for an event that occurs on the same day every year." for="dayofmonthyear1">Every</label>&nbsp;&nbsp;&nbsp; 
<div style="display:inline" title="Select the day on which the event occurs." >
			<select size="1" id="dayofmonthyearday" name="nef[dayofmonthyearday]" style="WIDTH: 47px">
<?php
    for($lc=1;$lc<=31;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["esty1d"]==$mlc || ($evrow["esty"]!=1 && $fday==$mlc)) {
            echo "selected ";
        }
        echo "value = \"".$mlc."\" >".$mlc."</option>\n";
     }
    ?>                
            </select>&nbsp;Day&nbsp;of&nbsp;
</div>
<div style="display:inline" title="Select the month in which the event occurs." >
            <select size="1" id="dayofmonthyearmonth" name="nef[dayofmonthyearmonth]" style="width: 89; height: 23">
<?php
    for($lc=1;$lc<=12;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["esty1m"]==$lc || ($evrow["esty"]!=1 && $xfuncdate["mon"]==$lc)) {
            echo "selected ";
        }
        echo "value = \"".$mlc."\" >".$monthtextl[$lc]."</option>\n";
     }
    ?>                
            
            </select>
</div>
		</TD>
	</TR>
	<TR>
		<TD NOWRAP width="100%">
			<input <?php if($evrow["esty"]==2) {echo "checked"; } ?> title="Select this for an event that occurs on a certain day of a certain month of every year." type="radio" name="nef[dayofmonthyear]" value="2" id="dayofmonthyear2">
			<label title="Select this for an event that occurs on a certain day of a certain month of every year." for="dayofmonthyear2">On&nbsp;the</label>&nbsp; 
<div style="display:inline" title="Select which day the event occurs." >
            <select size="1" id="whichdayofmonthyear" name="nef[whichdayofmonthyear]" style="width: 94; height: 23">
<?php
    for($lc=1;$lc<=5;$lc++) {
		echo "        <option ";
        if($evrow["esty2dp"]==$lc || ($evrow["esty"]!=2 && $weekdaypos==$lc)) {
            echo "selected ";
        }
        echo "value = \"".$lc."\" >".$daypostxt[$lc]."</option>\n";
     }
    ?>            
            </select>&nbsp;
</div>
<div style="display:inline" title="Select the day on which the event occurs." >
			<select size="1" id="whichdayofmonthyearday" name="nef[whichdayofmonthyearday]" style="width: 90; height: 23">
<?php
    for($lc=1;$lc<=10;$lc++) {
		echo "        <option ";
        if($evrow["esty2wd"]==$lc || ($evrow["esty"]!=2 && $fdow==$lc)) {
            echo "selected ";
        }
        echo "value = \"".$lc."\" >".$wdaytxt[$lc]."</option>\n";
     }
    ?>            
            </select>&nbsp;in&nbsp;
</div>
<div style="display:inline" title="Select the month in which the event occurs." >
            <select size="1" id="whichdayofmonthyearmonth" name="nef[whichdayofmonthyearmonth]" style="width: 82; height: 23">
<?php
    for($lc=1;$lc<=12;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["esty2m"]==$lc || ($evrow["esty"]!=2 && $xfuncdate["mon"]==$lc)) {
            echo "selected ";
        }
        echo "value = \"".$mlc."\" >".$monthtextl[$lc]."</option>\n";
     }
    ?>            
            </select>
</div>
		</TD>
	</TR>
</TABLE>
      </DIV>
      
</td>
        </tr>
        <tr>
        
          <td width="100%" colspan="2">

<DIV style="DISPLAY: <?php if($evrow["iseventseries"] == 1) {echo "inline";} else {echo "none";} ?> " id="divsend">
        <hr size="1">

            <table border="0" cellspacing="0" cellpadding="0" width="100%">
              <tr>
                <td width="15%">
    <b>Series&nbsp;End:</b></td>
                <td width="85%" colspan="2">
    <input <?php if($evrow["ese"]==0) {echo "checked"; } ?> title="Select this if the event has no end date." type="radio" name="nef[eventend]" checked value="0" id="eventend1" LANGUAGE=javascript onclick="return eventend1_onclick()">
    <label title="Select this if the event has no end date." for="eventend1">Never</label></td>
              </tr>
              <tr>
                <td width="15%">&nbsp;</td>
                <td width="85%" colspan="2">
                <input <?php if($evrow["ese"]==1) {echo "checked"; } ?> title="Select this if the event ends after so many occurances." type="radio" name="nef[eventend]" value="1" id="eventend2" LANGUAGE=javascript onclick="return eventend2_onclick()">
                <label title="Select this if the event ends after so many occurances." for="eventend2">End After</label>&nbsp;
                <input title="Enter the number of events to add." type="text" id="eventendafter" name="nef[eventendafter]" value="<?php if($evrow["ese"] == 1) {echo $evrow["eseaoint"];} else {echo "10";} ?>" size="5">&nbsp;occurances</td>
              </tr>
              <tr>
                <td width="15%">&nbsp;</td>
                <td width="15%">
                <input <?php if($evrow["ese"]==2) {echo "checked"; } ?> title="Select this if the event ends after a certain date." type="radio" name="nef[eventend]" value="2" id="eventend3" LANGUAGE=javascript onclick="return eventend3_onclick()">
                <label title="Select this if the event ends after a certain date." for="eventend3">End on:
          </label>
                </td>
                <td width="70%" align="left">
                  <table border="0" cellspacing="0" cellpadding="0" width="60%">
                    <tr>
                      <td width="20%">
<div style="display:inline" title="Select the day after which the event ends" >
                      <b>Day</b>
</div>                      
                      </td>
                      <td width="20%">
<div style="display:inline" title="Select the month after which the event ends" >
                      <b>Month</b>
</div>                      
                      </td>
                      <td width="20%">
<div style="display:inline" title="Select the year after which the event ends" >
                      <b>Year</b>
</div>                      
                      </td>
                    </tr>
                    <tr>
                      <td width="20%">
<div style="display:inline" title="Select the day after which the event ends" >
                      <select <?php if($evrow["ese"] != 2) {echo "disabled";} ?> size="1" id="eventendday" style="WIDTH: 47px" name="nef[eventendday]" LANGUAGE=javascript onchange="return eventendday_onchange()">
<?php
    for($lc=1;$lc<=31;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["ese"] != 2) {
            if($evrow["startday"]==$lc) {
                echo "selected ";
            }
        } else {
            if($evrow["esed"]==$lc) {
                echo "selected ";
            }
        }
        echo "value = \"".$mlc."\" >".$mlc."</option>\n";
     }
    ?>                       
                      </select>
</div>                      
                      </td>
                      <td width="20%">
<div style="display:inline" title="Select the month after which the event ends" >
                      <select <?php if($evrow["ese"] != 2) {echo "disabled";} ?> size="1" id="eventendmonth" style="WIDTH: 65px" name="nef[eventendmonth]" LANGUAGE=javascript onchange="return eventendmonth_onchange()">
    <?php
    for($lc=1;$lc<=12;$lc++) {
        if($lc < 10) {$mlc = "0".$lc;} else {$mlc=$lc;}
		echo "        <option ";
        if($evrow["ese"] != 2) {
            if($evrow["startmonth"]==$lc) {
                echo "selected ";
            }
        } else {
            if($evrow["esem"]==$lc) {
                echo "selected ";
            }
        }
        echo "value = \"".$mlc."\" >".$monthtext[$lc]."</option>\n";
     }
    ?>                       
                      </select>
</div>                      
                      </td>
                      <td width="20%">
<div style="display:inline" title="Select the year after which the event ends" >
                      <select <?php if($evrow["ese"] != 2) {echo "disabled";} ?> size="1" id="eventendyear" style="WIDTH: 70px" name="nef[eventendyear]" LANGUAGE=javascript onchange="return eventendyear_onchange()">
    <?php
    for($lc=($evrow["startyear"]-1);$lc<=($evrow["startyear"]+4);$lc++) {
		echo "        <option ";
        if($evrow["ese"] != 2) {
            if($evrow["startyear"]==$lc) {
                echo "selected ";
            }
        } else {
            if($evrow["esey"]==$lc) {
                echo "selected ";
            }
        }
        echo "value = \"".$lc."\" >".$lc."</option>\n";
     }
    ?>                      
                      </select>
</div>                      
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
</div>
          </td>
        </tr>
      </table>
      
</div>      
      
    </td>
    <!--
    <td width="24%">&nbsp;</td>
    -->
  </tr>
<!--
  <tr>
    <td width="26%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
    <td width="24%">&nbsp;</td>
  </tr>
  <tr>
    <td width="26%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
    <td width="24%">&nbsp;</td>
  </tr>
-->
</table>
  <table border="0" width="60%">
  <tr>
    <td width="15%" align="middle">
    <INPUT type="submit" value="Save" id="saveevent" name="saveevent">
    </td>
    <td width="15%" align="middle">
    <INPUT type="button" value="Go to Calendar" id="doneevent" name="doneevent" LANGUAGE=javascript onclick="return doneevent_onclick()">
    </td>
    <td width="15%" align="middle">&nbsp;
    </td>
    <td width="15%" align="middle">&nbsp;
    </td>
  </tr>
</table>

</form>
<?php
echo "<br><br>";
include_once("./include/footer.php");
exit();
}
?>