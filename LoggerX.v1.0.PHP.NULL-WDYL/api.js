var menuOff = new Array(5)
var menuOn = new Array(5)
var currentMenuChoice = 2
var TimeoutId 

function menuRoll(which,status)
	{	
	if (status)
		{	currentMenuChoice = which
			show("submenu" + currentMenuChoice)
			TimeoutId=setTimeout("checkMenu()",100)
		}
	}

function init()
{
	if (nscp) { document.captureEvents(Event.MOUSEMOVE) }
	document.onmousemove = checkIt
	checkMenu()

}

function checkIt(evt)
	{
		x1 = (nscp) ? evt.pageX : event.clientX
		y1 = (nscp) ? evt.pageY : event.clientY

		if (((x1 > 320) || (x1 < 10)) || ((y1 > 480) || (y1 < 100)))
		{	
			currentMenuChoice = -1
			clearTimeout(TimeoutId)
			checkMenu()
		}
	}

function checkMenu()
	{
		r=0;
		if(r != currentMenuChoice)
			{
			hide("submenu" + r)
			}
	}



var ismc = (navigator.appVersion.indexOf("Mac") != -1)
var nscp = (navigator.appName == "Netscape")
var vers = parseFloat(navigator.appVersion.substring(22,25))
var nscp6 = (!document.all && document.getElementById) 

function show(layr)
{	
	obj = getObj(layr)
	if (nscp6) {obj.style.visibility = "visible"; } else obj.visibility = "visible";
}

function hide(layr)
{
	obj = getObj(layr)
	if (nscp6) {obj.style.visibility = "hidden"; } else obj.visibility = "hidden";
}

function getObj(obj)
{	

if (nscp6) {compLayr = document.getElementById(obj);} else

if ((nscp) && (!nscp6))	{compLayr = document.layers[obj]; }

else {compLayr = eval("document.all." + obj + ".style") }

return compLayr
}

function screenWidth()
{	avail = (nscp) ? window.innerWidth : document.body.clientWidth
	return avail
}
