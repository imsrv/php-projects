// JavaScript Document
function isValidData(val,valid,minl,maxl,fieldname,msg)
{
	if(Trim(val,' ')=="")
	{
		alert(fieldname + " is empty.");
		return false;
	}
	else if(val.length<minl || val.length>maxl)
	{
		alert(fieldname + " must be " + minl + " to " + maxl + " chars long")
		return false;
	}
	else
	{
		for (var i=0, len=val.length; i<len ; i++) 
		{
			if (valid.indexOf(val.substring(i,i+1)) == -1) 
			{
				var wrong = i*1+1;
				alert(msg + ' ' + fieldname + '. Check character no ' + wrong + '.');
				return false;
			}
		}
	}
	return true;
}

function isEmail(val)
{
	if(Trim(val,' ') == "")
	{
		alert("You must type in a mailaddress!");
		return false;
	}
	else if (!(val.indexOf('\@') > -1))
	{
		alert("Mailaddress must contain a \@");
		return false;
	}
	else if (!(val.indexOf('.') > -1))
	{
		alert("Mailaddress must contain a '.' (dot)");
		return false;
	}
	else if (val.indexOf('\@') == (val.indexOf('.')-1))
	{
		alert("Mailaddress can't contain a \@ and '.' side by side");
		return false;
	}
	else if (val.indexOf('.') == (val.length-1))
	{
		alert("Mailaddress can't contain a '.' (dot) at the end");
		return false;
	}
	return true;
}

function Trim(inputString, removeChar) 
{
	var returnString = inputString;
	if (removeChar.length)
	{
	  while(''+returnString.charAt(0)==removeChar)
		{
		  returnString=returnString.substring(1,returnString.length);
		}
		while(''+returnString.charAt(returnString.length-1)==removeChar)
	  {
	    returnString=returnString.substring(0,returnString.length-1);
	  }
	}
	return returnString;
}

function isUpFormOk(frm)
{
	if(!isEmail(frm.emailto.value))
	{
		frm.emailto.focus();
		return false;
	}
	else if(Trim(frm.upfile.value,' ')=="")
	{
		alert("Please select a file to upload.");
		frm.upfile.focus();
		return false;
	}
	else if(Trim(frm.emailfrom.value,' ')!="")
	{
		if(!isEmail(frm.emailfrom.value))
		{
			frm.emailfrom.focus();
			return false;
		}	
	}
	toggleBox('table1');
	toggleBox('table2');
	return true;
}

function isLoginFormOk(frm)
{
	if(Trim(frm.uname.value,' ')=="")
	{
		alert("Please specify username.");
		frm.uname.focus();
		return false;
	}
	else if(Trim(frm.pwd.value,' ')=="")
	{
		alert("Please specify password.");
		frm.pwd.focus();
		return false;	
	}
	return true;
}

function isProfileFormOk(frm)
{
	if(Trim(frm.uname.value,' ')=="")
	{
		alert("Please specify username.");
		frm.uname.focus();
		return false;
	}
	else if(Trim(frm.pwd.value,' ')=="")
	{
		alert("Please specify password.");
		frm.pwd.focus();
		return false;	
	}
	else if(!isEmail(frm.email.value))
	{
		frm.email.focus();
		return false;
	}
	return true;
}

function isSendPwdFormOk(frm)
{
	if(!isEmail(frm.email.value))
	{
		frm.email.focus();
		return false;
	}
	return true;
}


function toggleBox(szDivID) {
  if (document.layers) { // NN4+
    if (document.layers[szDivID].visibility == 'visible') {
      document.layers[szDivID].visibility = "hide";
      document.layers[szDivID].display = "none";
      document.layers[szDivID+"SD"].fontWeight = "normal";
    } else {
      document.layers[szDivID].visibility = "show";
      document.layers[szDivID].display = "inline";
      document.layers[szDivID+"SD"].fontWeight = "bold";
    }
  } else if (document.getElementById) { // gecko(NN6) + IE 5+
    var obj = document.getElementById(szDivID);
    var objSD = document.getElementById(szDivID+"SD");

    if (obj.style.visibility == 'visible') {
      obj.style.visibility = "hidden";
      obj.style.display = "none";
      objSD.style.fontWeight = "normal";
    } else {
      obj.style.visibility = "visible";
      obj.style.display = "inline";
      objSD.style.fontWeight = "bold";
    }
  } else if (document.all) { // IE 4
    if (document.all[szDivID].style.visibility == 'visible') {
      document.all[szDivID].style.visibility = "hidden";
      document.all[szDivID].style.display = "none";
      document.all[szDivID+"SD"].style.fontWeight = "normal";
    } else {
      document.all[szDivID].style.visibility = "visible";
      document.all[szDivID].style.display = "inline";
      document.all[szDivID+"SD"].style.fontWeight = "bold";
    }
  }
}

function Toggle()
{
	toggleBox('table1');
	toggleBox('table2');
}

function onConfChange(frm)
{
	frm.conf_disptxt.value=frm.conf_val.options[frm.conf_val.selectedIndex].text;
}


/*function PUSH(frm)
{
	var i=frm.types.selectedIndex;
	if(i==-1) 
	{
		alert("Select any type first.");
		frm.types.focus();
		return;
	}	
	else
	{
		
		for(var j=0; j<frm.conf_val.length; j++)
		{
			if(frm.types.options[i].text==frm.conf_val.options[j].text)
			{
				alert("This mime type already exists.");
				frm.types.focus();
				return;
			}
		}
		//var newElem=document.createElement("OPTIONS");		
		//newElem.text=;
		//newElem.value=;
		frm.conf_val.options[j]=new Option(frm.types.options[i].text,frm.types.options[i].text,false,false);
		return;	
	}
}



function POP(frm)
{
	var i=frm.conf_val.selectedIndex;
	if(i==-1) 
	{
		alert("Select any type first.");
		frm.conf_val.focus();
		return;
	}	
	else
	{
		frm.conf_val.options[i]=null;
		return;	
	}
}

function SelectAllList(frm)
{
	for(i=0;i<frm.conf_val.length;i++)
	frm.conf_val.options[i].selected=true;
	return true;
}

function isMimeFormOk(frm)
{
	if(frm.conf_val.length==0)
	{
		alert("Set at least one mime type.");
		frm.conf_val.focus();
		return false;	
	}
	SelectAllList(frm);
	return true;
}*/


function isMimeFormOk(frm)
{
	if(frm.opt[1].checked)
	{
		if(Trim(frm.conf_val.value," ")=="")
		{
			
			alert("Set at least one mime type.");
			frm.conf_val.focus();
			return false;	
		}
	}	
	return true;
}


function isOtherFormOk(frm)
{
	if(Trim(frm.conf_disptxt.value,' ')=="")
	{
		alert("Please specify display text.");
		frm.conf_disptxt.focus();
		return false;
	}
	return true;
}