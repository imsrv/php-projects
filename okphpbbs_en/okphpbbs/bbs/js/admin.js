
function CheckAll() {
  for (var i = 0; i < document.itemslist.elements.length; i++) {
    if(document.itemslist.elements[i].type == 'checkbox'){
      document.itemslist.elements[i].checked =         !(document.itemslist.elements[i].checked);
    }
  }
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}


function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function navbarOver(src,clrOver,clrOverBorder) { if (!src.contains(event.fromElement)){ src.style.cursor = 'hand'; src.bgColor = clrOver; src.borderColor = clrOverBorder; }}

function navbarOut(src,clrIn,clrInBorder) { if (!src.contains(event.toElement)) { src.style.cursor = 'default'; src.bgColor = clrIn; src.borderColor = clrInBorder;}}
