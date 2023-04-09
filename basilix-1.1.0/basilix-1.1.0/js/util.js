function split(string, tok) {
	return string.split(tok);
}

function inset(t, c) {
	t.className = 'butover';
	// t.style.borderStyle = "inset";
	// t.style.borderWidth = c;
}
function outset(t, c) {
	t.className = 'button';
	// t.style.borderStyle = "outset";
	// t.style.borderWidth = c;
}
function myclk(id) {
	id.click();
}

// function butOver(t) {
//	t.className = 'butover';
// }
// function butDown(t) {
//	t.className = 'butdown';
// }
// function butOut(t) {
//	t.className = 'button';
// }

function ask_confirm(msg, url) {
    ret = confirm(msg);
    if(ret == true) {
	self.document.location = url;
    }
}

function findObj(n, d) {
	var p, i, x;  
	if(!d) d = document; 
	if((p = n.indexOf("?")) > 0 && parent.frames.length) {
		d = parent.frames[n.substring(p+1)].document; 
		n = n.substring(0,p);
	}
	if(!(x = d[n]) && d.all) x = d.all[n]; 
	for(i = 0; !x && i < d.forms.length ; i++) 
		x = d.forms[i][n];
	for(i = 0 ; !x && d.layers && i < d.layers.length ; i++) x = findObj(n, d.layers[i].document);
	if(!x && d.getElementById) 
		x = d.getElementById(n); 
	return x;
}
