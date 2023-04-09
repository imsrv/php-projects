document.write('<div id="sakir" class="sabit">');
function AyarlaBakim()
{
			if( document.body) 
			{
			var mColTags; 
			mColTags = document.all;
			if( mColTags) 
				{
				 var mintWidth; 
				 mintWidth = document.body.clientWidth; 
				 if (mintWidth > 860)
					{
					 mColTags.sakir.style.display = "";
					}
					else
					{
						mColTags.sakir.style.display = "none";
					}
				 }
			}
}
AyarlaBakim();

 function kayma_miktari() {
  var  scr = 0;
  if( typeof( window.pageYOffset ) == "number" ) {
    //Netscape uyumlu
    scr = window.pageYOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM uyumlu
    scr = document.body.scrollTop;
  } else if( document.documentElement &&
      ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 ve standart uyumlu
    scr = document.documentElement.scrollTop;
  }
  return scr;
}
 function kaydir(){
	document.getElementById("sakir").style.top=kayma_miktari()+2+"px";
	a=setTimeout("kaydir('sakir')",1);
}
document.write('<script language="JavaScript" type="text/javascript" for="window" event="onresize">');
document.write('AyarlaBakim();');
document.write('</script>');
document.write('<a href="http://www.kalbimden.net/?ref=sdmp3" target="_blank">');
document.write('<img src="http://www.sademp3.com/img/kalbimden.gif" border="0" width="117" height="287" /></a></div>');