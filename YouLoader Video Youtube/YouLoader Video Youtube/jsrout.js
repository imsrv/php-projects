<!--
///////////////////////////////////////
//All YouLoader JS Routines
///////////////////////////////////////

function stopErrors() {
return true;
}
window.onerror = stopErrors;

function getObject(obj) {
  var theObj;
  if(document.all) {
    if(typeof obj=="string") {
      return document.all(obj);
    } else {
      return obj.style;
    }
  }
  if(document.getElementById) {
    if(typeof obj=="string") {
      return document.getElementById(obj);
    } else {
      return obj.style;
    }
  }
  return null;
}

//Count char.
function CharCoun(entr,selec,txt,chrs) {
  var entrObj=getObject(entr);
  var selecObj=getObject(selec);
  var line=chrs - entrObj.value.length;
  if(line <= 0) {
    line=0;
    texto='<span class="dis"> '+txt+' </span>';
    entrObj.value=entrObj.value.substr(0,chrs);
  }
  selecObj.innerHTML = txt.replace("{CHAR}",line);
}

//Pop window
function open_window(theURL,winName,features, myWidth, myHeight, isCenter){
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
 window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
}

//Check delete
function del_me(del){
	if (del == 1){
		if(confirm("You are about to delete this entry from the system.\nAre you sure you want to continue?")){
			return (true)
		}
	return (false)
	}
}
//-->