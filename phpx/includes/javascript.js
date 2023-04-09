//$Id: javascript.js,v 1.4 2003/08/18 21:03:46 ryan Exp $
function changeAvatarImage(form) {
    var imgName = form.av_id.options[form.av_id.selectedIndex].value;
    document.avatarImage.src = 'images/avatars/' + imgName;
}

function displaySubs(the_sub){
    document.getElementById(the_sub).style.display = "";
}

function displaySubs1(the_sub){
    document.getElementById(the_sub).style.display = "none";
}

function isEmailAddr(email){
    var result = false;
    var theStr = new String(email);
    var index = theStr.indexOf("@");
    if (index > 0){
        var pindex = theStr.indexOf(".",index);
        if ((pindex > index+1) && (theStr.length > pindex+1))
	    result = true;
    }
    return result;
}


function allDigits(str){
    return inValidCharSet(str,"0123456789");
}

function inValidCharSet(str,charset){
    var result = true;
    for (var i=0;i<str.length;i++)
        if (charset.indexOf(str.substr(i,1))<0){
            result = false;
            break;
        }
    return result;
}


function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function actionText(whch){
    samp = forumActions[whch];

    if(document.all){
        document.all["actionName"].innerText = samp;
    }
}

function goToURL(URL) { window.location = URL; }

function goToURLNew(URL){ window.open(URL); }

function textCounter(field, countfield, maxlimit) {
    if (field.value.length > maxlimit){ field.value = field.value.substring(0, maxlimit); }
    else { countfield.value = maxlimit - field.value.length; }
}

function reportPost(post){
    displaySubs(post);
    window.location = 'forums.php?action=report&post_id=' + post;
}

function CheckAll(){
    for (var i=0;i<document.pm.elements.length;i++){
         var e = document.pm.elements[i];
         if (e.name != "allbox")
             e.checked = document.pm.allbox.checked;
    }
}

function submitAvatar(av_id){
    document.avatar.av_id.value = av_id;
    document.avatar.submit();
}







