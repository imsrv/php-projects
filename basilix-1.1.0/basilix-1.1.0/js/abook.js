function addValidate() {
        add = document.addrAddEdt;
	nick = add.elements["add_nick"].value;
	email = add.elements["add_email"].value;

	// check nick
	if(nick == "") {
		alert(no_nick);
                add.add_nick.focus();
                return false;
        }

	// email
	if(email == "") {
		alert(no_email);
		add.add_email.focus();
		return false;
	}
	return true;
}

function moveItem(direction) {
	var objfrom = findObj("items");
	var objto = findObj("grpitems");
	var objlist = findObj("memberlist");
	if(objfrom == null || objto == null || objlist == null) return;
	
	var flag = false;
	var skip = false;
	var fromlen = objfrom.length;
	var tolen = objto.length;
	if(direction) {
		// adding to the group
		for(var i = 0 ; i < fromlen ; i++) {
			var opt = objfrom.options[i];
			if(opt.selected && skip == false) {
				flag = true;
			
				for(var j = 0 ; j < tolen ; j++) {
					var myopt = objto.options[j];
					if(myopt.value == opt.value) {
						flag = false;
					}
				}
				if(flag == true) {
					objto.options[objto.options.length] = new Option(opt.text, opt.value, 0, 0);
					var j = i + 1;
					if(j < fromlen) {
						objfrom.selectedIndex = j;
						skip = true;
					}
					// for further use may be
					// --
					// for(j = 0 ; j < fromlen ; j++) {
					//	var myopt = objfrom.options[j];
					//	if(myopt.selected) {
					//		objfrom.options[j] = null;
					//	}
					// }
				}
			}
		}
	} else {
		// removing from the group
		for(var i = tolen - 1 ; i >= 0 ; i--) {
			var opt = objto.options[i];
			if(opt.selected) {
				objto.options[i] = null;
				// for further use may be
				// objfrom.options[objfrom.options.length] = new Option(opt.text, opt.value, 0, 0);
			}
		}
	}
	// fill the hidden var memberlist
	newarr = Array();
	for(var i = 0 ; i < objto.length ; i++) {
		newarr[i] = objto.options[i].value;
	}
	objlist.value = newarr.join();
}

function upDownItem(direction) {
	var objto = findObj("grpitems");
	var objlist = findObj("memberlist");
	if(objto == null || objlist == null) return;

	var pval = null;
	var nval = null;
	var ptext = null;
	var ntext = null;
	var len = objto.length;

	var flag = false;
	for(var i = 0 ; i < len ; i++) {
		var opt = objto.options[i];
		if(opt.selected) {
			if(direction) {
				var j = i + 1;
				if(j < len && flag == false) {
					var nopt = objto.options[j];
					var tmpval = nopt.value;
					var tmptext = nopt.text;
					nopt.value = opt.value;
					nopt.text = opt.text;
					opt.value = tmpval;
					opt.text = tmptext;
					objto.selectedIndex = j;
					flag = true;
				}
			} else {
				if(i > 0) {
					var j = i - 1;
					var popt = objto.options[j];
					var tmpval = pval;
					var tmptext = ptext;
					popt.value = opt.value;
					popt.text = opt.text;
					opt.value = tmpval;
					opt.text = tmptext;
					objto.selectedIndex = j;
					flag = true;
				}
			}
		} else {
			pval = opt.value;
			ptext = opt.text;
		}
	}
	if(flag == true) {
		newarr = Array();
		for(var i = 0 ; i < objto.length ; i++) {
			newarr[i] = objto.options[i].value;
		}
		objlist.value = newarr.join();
	}
}
