var url_atchs = false;
function cmpsValidate() {
	cmps = document.composeMail;
	to = cmps.elements["cmps_to"].value;
	cc = cmps.elements["cmps_cc"].value;
	bcc = cmps.elements["cmps_bcc"].value;
	body = cmps.elements["cmps_body"].value;
	
	if(url_atchs == true) return true;

	// check rcpts
	if(to == "" && cc == "" && bcc == "") {
		alert(no_rcpt);
		cmps.cmps_to.focus();
		return false;
	}

	// and check body
	if(body == "") {
		alert(no_body);
		cmps.cmps_body.focus();
		return false;
	}

	return true;
}

function cmps_abook_add(fname) {
	var item = document.composeMail.abook_item;
	var grpitem = document.composeMail.abook_grpitem;
	var itemsel = item.options[item.selectedIndex].value;
	var grpitemsel = grpitem.options[grpitem.selectedIndex].value;

	if(itemsel < 1 && grpitemsel < 1) return;

	var oldval = document.composeMail.elements[fname].value;

	if(itemsel > 0) {
		var addstr = addrItems[itemsel];
	}
	if(grpitemsel > 0) {
		var addstr = addrGrpItems[grpitemsel];
	}
	if(oldval == "") {
		document.composeMail.elements[fname].value = addstr;
	} else {
		document.composeMail.elements[fname].value = oldval + ',' + addstr;
	}
	return;
}
function resetSelected(which) {
	if(which == 0) {
		document.composeMail.abook_grpitem.selectedIndex = 0;
	} else {
		document.composeMail.abook_item.selectedIndex = 0;
	}
}

