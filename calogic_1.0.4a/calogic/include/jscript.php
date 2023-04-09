
<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--
var evwid;

function weeksel_onchange() {
//xurl = "selview.php?viewdate=" + weeksel.value + "&viewtype=Week";
//location.href=xurl;
selweek.submit;
}

function monthsel_onchange() {
//xurl = "selview.php?viewdate=" + monthsel.value + "&viewtype=Month";
//location.href=xurl;
selmonth.submit;
}

function yearsel_onchange() {
//xurl = "selview.php?viewdate=" + yearsel.value + "&viewtype=Year";
//location.href=xurl;
selyear.submit;
}

function window_onload() {
<?php
if ($viewtype != "Day") {
?>
try {
    if(cvtab.clientWidth > document.body.clientWidth) {
        evwid = Math.round(document.body.clientWidth / 7) - 10; 
    } else {
        evwid = Math.round(cvtab.clientWidth / 7) - 10; 
    }
    if(evwid < 112) {
        evwid = 112;
    }
    for(i=0;i<esp.length;i++) {
        esp[i].style.width = evwid;
    }
}
catch(e) {

}

<?php
} else {
?>    
/*
try {
    if(cvtab.clientWidth > document.body.clientWidth) {
        evwid = Math.round(document.body.clientWidth) - 100; 
    } else {
        evwid = Math.round(cvtab.clientWidth) - 100; 
    }
    if(evwid < 112) {
        evwid = 112;
    }
    for(i=0;i<esp.length;i++) {
        esp[i].style.width = evwid;
    }
}
catch(e) {

}
*/
<?php
}
?>    

}

function window_onresize() {
<?php
if ($viewtype != "Day") {
?>
try {

    if(cvtab.clientWidth > document.body.clientWidth) {
        evwid = Math.round(document.body.clientWidth / 7) - 10; 
    } else {
        evwid = Math.round(cvtab.clientWidth / 7) - 10; 
    }
    if(evwid < 112) {
        evwid = 112;
    }
    for(i=0;i<esp.length;i++) {
        esp[i].style.width = evwid;
    }
}
catch(e) {

}
    
<?php
} else {
?>
/*
try {

    if(cvtab.clientWidth > document.body.clientWidth) {
        evwid = Math.round(document.body.clientWidth) - 100; 
    } else {
        evwid = Math.round(cvtab.clientWidth) - 100; 
    }
    if(evwid < 112) {
        evwid = 112;
    }
    for(i=0;i<esp.length;i++) {
        esp[i].style.width = evwid;
    }
}
catch(e) {

}
*/
<?php
}
?>

    
}

function cvtab_onresize() {
<?php
if ($viewtype != "Day") {
?>
try {
    if(cvtab.clientWidth > document.body.clientWidth) {
        evwid = Math.round(document.body.clientWidth / 7) - 10; 
    } else {
        evwid = Math.round(cvtab.clientWidth / 7) - 10; 
    }
    if(evwid < 112) {
        evwid = 112;
    }
    for(i=0;i<esp.length;i++) {
        esp[i].style.width = evwid;
    }
}
catch(e) {

}
    
<?php
} else {
?>    
/*
try {
    if(cvtab.clientWidth > document.body.clientWidth) {
        evwid = Math.round(document.body.clientWidth) - 100; 
    } else {
        evwid = Math.round(cvtab.clientWidth) - 100; 
    }
    if(evwid < 112) {
        evwid = 112;
    }
    for(i=0;i<esp.length;i++) {
        esp[i].style.width = evwid;
    }
}
catch(e) {

}

*/

<?php
}
?>    

}


//-->
</SCRIPT>

