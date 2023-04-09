/* ------------------------------------------------------------------------------- 
	10/15/02 - nettles
	Global VARs  
------------------------------------------------------------------------------- */
var NS = (navigator.appName == "Netscape");

/* ------------------------------------------------------------------------------- 
	10/15/02 - nettles
	Base window opening function
	Functions below override certain properties. This function will open
	a default window with default parameters.
		internalURL  -> if none passed function will exit as it has nowhere to go
		internalName -> defaults to popupWin if none specified
		internalArgs -> string of defaults for window attributes
------------------------------------------------------------------------------- */
function openWindow(thisURL,thisName,thisArgs) {
	internalURL = thisURL;
	internalName = thisName;
	internalArgs = thisArgs;
	if (internalURL == '') {
		exit;
	}
	if (internalName == '') {
		internalName = 'popupWin';
	}
	if (internalArgs == '') {
		internalArgs = 'scrollbars,resizable,toolbar,status,width=640,height=480,left=50,top=50';
	}
	popupWin = window.open(internalURL,internalName,internalArgs);
 	popupWin.focus();
}

/*
	Overrides openWindow with different name attribute
*/
function openWindow640(thisURL) {
	openWindow(thisURL,'popupWin640','');
}

/*
	Overrides openWindow with the width/height passed in
*/
function openWindowWH(thisURL,thisW,thisH) {
	internalArgs = 'scrollbars,resizable,toolbar,status,left=50,top=50,width=' + thisW + ',height=' + thisH;
	openWindow(thisURL,'popupWinWH',internalArgs);
}

/*
	Overrides openWindow with the standard demo window args
*/
function openWindowDemo(thisURL) {
	internalName = 'popupWinDemo';
	internalArgs = 'scrollbars,resizable,toolbar,status,left=50,top=50,width=475,height=570';
  openWindow(thisURL,internalName,internalArgs);
}

/*
	Overrides openWindow with the small demo window args
*/
function openWindowDemoSmall(thisURL) {
	internalName = 'popupWinDemo';
	internalArgs = 'scrollbars,resizable,toolbar,status,left=50,top=50,width=250,height=250';
  openWindow(thisURL,internalName,internalArgs);
}

function openWindowATC(thisURL,thisType,thisWidth,thisHeight,thisArgs,thisName) {
	if (thisType != '') {
		switch (thisType) {
			case 'demo':
				openWindowDemo(thisURL);
				break;
			case 'demosmall':
				openWindowDemo(thisURL);
				break;
			case '640':
				openWindow640(thisURL);
				break;
		}
	} else {
		if ((thisWidth != '') && (thisHeight != '')) {
			openWindowWH(thisURL,thisWidth,thisHeight);
		} else {
			openWindow(thisURL,thisName,thisArgs);
		}
	}
}

/* ------------------------------------------------------------------------------- 
	Window naming function to establish unique names
------------------------------------------------------------------------------- */
function windowNamer(thisURL) {
	var tmp = thisURL;
	var tmpArray = tmp.split('/');
	var idx = ((tmpArray.length) - 1);
	tmp = 'popupWin' + tmpArray[idx];
	return(tmp);
}

function writeWindow(inURL,inType,inWidth,inHeight,inArgs) {
	var tmpName = windowNamer(inURL);
	var linkStr = "<a href=\"#\" onclick=\"javascript:openWindowATC('" + inURL + "','" + inType + "','" + inWidth + "','" + inHeight + "','" + inArgs + "','" + tmpName + "');\">";
	document.write(linkStr);
}



/* ------------------------------------------------------------------------------- 
	10/15/02 - nettles
	This function iterates through the checkboxes on a page and toggles them from 
	on to off.
	WARNING: this function assumes one form per page
		dowhat -> if dowhat is on, it checks all boxes, else it unchecks all
------------------------------------------------------------------------------- */
function ToggleBoxes(dowhat) {
	for (i=0; i<document.forms[0].elements.length; i++) {
		if (document.forms[0].elements[i].type == 'checkbox') {
			if (dowhat == 'on') {
				document.forms[0].elements[i].checked = true;
			} else {
				document.forms[0].elements[i].checked = false;
			}
		}
	}
}

/* ------------------------------------------------------------------------------- 
	10/15/02 - nettles
	Function used to call the print command
	Netscape -> if NS tests to true, all that needs to happen is a call to the 
		print command
	IE -> if IE, then the particular print object is inserted on the page, thank 
		you M$
------------------------------------------------------------------------------- */
function printit(){
	window.print();
}
	
	/* 
	02/18/03
	old crap until i find out why the object is failing
	
	if (NS) {
		window.print();
	}	else {
		var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
		document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
		WebBrowser1.ExecWB(6, 2);
		WebBrowser1.outerHTML = "";
	} 
	*/

/* ------------------------------------------------------------------------------- 
	10/15/02 - nettles
	Here begins the help stuff
	Documentation to come!
------------------------------------------------------------------------------- */
var scrX = screen.availWidth;
var scrY = screen.availHeight;
var tgtX = 240;
var win1 = new Array (0, 0, (scrX - tgtX), scrY); 
var win2 = new Array ((scrX - tgtX), 0, tgtX, scrY);
var balloonFlag = -1;
var winTracker;

function ContextOpenHelp(whichPage) {
	//if (!winTracker) {
		window.resizeTo(win1[2],win1[3]);
		window.moveTo(win1[0],win1[1]);
		var winHandle;
		winHandle = window.open('/cgi-bin/webscr?cmd=p/hlp/context/index-outside&page=' + whichPage ,'popHelp','scrollbars=no,resizable=no,menubar=no,location=no,personalbar=no,titlebar=no,toolbar=no,status=yes');
		winHandle.resizeTo(win2[2],win2[3]);
		winHandle.moveTo(win2[0],win2[1]);
		self.focus();
		winHandle.focus();
		winTracker = winHandle;
	/* } else {
		winTracker.focus();
	} */
}

function ContextShowHideHelp (whichDiv) {
	if (balloonFlag > 0) {
		var thisDiv = eval("document.all." + whichDiv);
		var thisX = window.event.x;
		var thisY = window.event.y;
		if (thisDiv.style.visibility == 'hidden') {
			thisDiv.style.visibility = 'visible';
			thisDiv.style.top = thisY;
			thisDiv.style.left = (thisX + 10);
		} else {
			thisDiv.style.visibility = 'hidden';
		}
	}
}

self.name = "superDaddy";