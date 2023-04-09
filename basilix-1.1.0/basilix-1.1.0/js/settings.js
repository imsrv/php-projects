// derived from SSG's code.
// http://ssg.sourtimes.org
function previewTheme(u, t) {
	var i = t.options[t.selectedIndex].value;
	var f = u + "/css/" + bsxThemes[i];

	if(is_nav4up) {
		f = f + "/ns.css";
	}
	// FIX ME!! 
	if(is_ie4up) {
		f = f + "/ie.css";
		var l = document.styleSheets.length;

	        if(l < 2) document.createStyleSheet(f);
	        else document.styleSheets[1].href = f;
	}
}
function showHide(o, p, v) {
	var obj = null;
	if((obj = findObj(o)) != null) {
		if(obj.style) { 
			obj = obj.style; 
			v = (v == 'show') ? 'visible' : (v == 'hide') ? 'hidden' : v; 
			p = (p == 'rel') ? 'relative' : (p == 'abs') ? 'absolute' : p;
		}
		obj.position = p;
		obj.visibility = v; 
	}
}

function toggleView(myfol) {
	if(canshow == false) {
		showHide(myfol, 'rel', 'show');
		canshow = true;
	} else {
		showHide(myfol, 'abs', 'hide');
		canshow = false;
	}
}
