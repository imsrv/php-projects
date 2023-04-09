<script language="JavaScript">
<!--
function findObj(n, d) {
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=findObj(n,d.layers[i].document); return x;
}
function swapImage() {
  var i,j=0,x,a=swapImage.arguments; document.sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=findObj(a[i]))!=null){document.sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function swapImgRestore() {
  var i,x,a=document.sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function preloadImages() {
 var d=document; if(d.images){ if(!d.p) d.p=new Array();
   var i,j=d.p.length,a=preloadImages.arguments; for(i=0; i<a.length; i++)
   if (a[i].indexOf("#")!=0){ d.p[j]=new Image; d.p[j++].src=a[i];}}
}

//-->
</script>
<table border="0" cellpadding="0" cellspacing="0" align="left">
	<tr><td align="left" valign="middle"><img src="images/menu_isaret.gif" width="9" height="18" align="left"></td><td align="left" valign="middle" height="15"><a href="hosting.php?menu=hosting">Web Hosting</a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="15"><a href="hosting.php?menu=hosting&paket=kucuk" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_host_kucuk','','images/menu_host_ust_kucuk.gif',1);return true"><img name="menu_host_kucuk" src="images/menu_host_kucuk.gif" width="90" height="11" align="center" border="0"></a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="15"><a href="hosting.php?menu=hosting&paket=midi" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_host_midi','','images/menu_host_ust_midi.gif',1);return true"><img name="menu_host_midi" src="images/menu_host_midi.gif" width="90" height="11" align="center" border="0"></a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="15"><a href="hosting.php?menu=hosting&paket=buyuk" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_host_buyuk','','images/menu_host_ust_buyuk.gif',1);return true"><img name="menu_host_buyuk" src="images/menu_host_buyuk.gif" width="90" height="11" align="center" border="0"></a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="15"><a href="hosting.php?menu=hosting&paket=pro" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_host_pro','','images/menu_host_ust_pro.gif',1);return true"><img name="menu_host_pro" src="images/menu_host_pro.gif" width="90" height="11" align="center" border="0"></a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="30"><a href="hosting.php?menu=hosting&paket=ozel" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_host_ozel','','images/menu_host_ust_ozel.gif',1);return true"><img name="menu_host_ozel" src="images/menu_host_ozel.gif" width="90" height="11" align="center" border="0"></a></td></tr>
	<tr><td align="left" valign="middle"><img src="images/menu_isaret.gif" width="9" height="18" align="left"></td><td align="left" valign="middle" height="15"><a href="design.php?menu=design">Web Design</a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="15"><a href="design.php?menu=design&paket=kisisel" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_design_kisisel','','images/menu_design_ust_kisisel.gif',1);return true"><img name="menu_design_kisisel" src="images/menu_design_kisisel.gif" width="105" height="11" align="center" border="0"></a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="15"><a href="design.php?menu=design&paket=katalog" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_design_katalog','','images/menu_design_ust_katalog.gif',1);return true"><img name="menu_design_katalog" src="images/menu_design_katalog.gif" width="105" height="11" align="center" border="0"></a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="15"><a href="design.php?menu=design&paket=sirket" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_design_sirket','','images/menu_design_ust_sirket.gif',1);return true"><img name="menu_design_sirket" src="images/menu_design_sirket.gif" width="105" height="11" align="center" border="0"></a></td></tr>
	<tr><td align="left"></td><td align="left" valign="top" height="30"><a href="design.php?menu=design&paket=ozel" onMouseOut="swapImgRestore();"  onMouseOver="swapImage('menu_design_ozel','','images/menu_design_ust_ozel.gif',1);return true"><img name="menu_design_ozel" src="images/menu_design_ozel.gif" width="105" height="11" align="center" border="0"></a></td></tr>

<tr><td align="left" valign="middle"><img src="images/menu_isaret.gif" width="9" height="18" align="left"></td><td align="left" valign="middle" height="15"><a href="alan_adi.php?menu=alan_adi">Alan Adý</a></td></tr>
<tr><td align="left"></td><td align="left" valign="top" height="30"></td></tr>
<tr><td align="left" valign="middle"><img src="images/menu_isaret.gif" width="9" height="18" align="left"></td><td align="left" valign="middle" height="15"><a href="iletisim.php">Ýletiþim</a></td></tr>
<tr><td align="left"></td><td align="left" valign="top"><hr align="center" noshade width="80%" color="#E0E0E0"></td></tr>
<tr><td align="left"></td><td align="left" valign="top" height="60"></td></tr>
</table><br>