function checkAll() {
  var dml = document.messageList;
  var len = dml.elements.length;

  for(var i = 0 ; i < len ; i++) {
      var e = dml.elements[i];
      if((e.type == 'checkbox') && (e.name != 'checkall'))
 	  e.checked = dml.checkall.checked;
  }
}

function checkCtrl() {
  var dml = document.messageList;
  var len = dml.elements.length;
  var totboxes = 0;
  var toton = 0;

  for(var i = 0 ; i < len ; i++) {  
      var e = dml.elements[i];
      if((e.type == 'checkbox') && (e.name != 'checkall')) {
	  totboxes++;
          if(e.checked) {
	     toton++;
          }
      }
  }
  if(totboxes == toton) {
     dml.checkall.checked = true;
  } else {
     dml.checkall.checked = false;
  }
}
