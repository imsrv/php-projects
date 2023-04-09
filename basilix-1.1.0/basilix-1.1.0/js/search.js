function checkAllMboxes(t) {
  var dml = document.findMail;
  var len = dml.elements.length;

  for(var i = 0 ; i < len ; i++) {
      var e = dml.elements[i];
      if((e.type == 'checkbox'))
	  e.checked = t;
  }
  if(t == false) 
	document.findMail.elements["search_mbox[0]"].checked = true;
}
