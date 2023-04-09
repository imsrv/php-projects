<html>
<head>
<title>{sitetitle}</title>
<base href="{pmcurl}">
<link rel=stylesheet href="themes/{theme}/style.css" type=text/css>
<link rel=stylesheet href="cal/calendar-win2k-1.css" type=text/css>

<SCRIPT LANGUAGE = "JavaScript">
<!-- 
var browser     = '';
var entrance    = '';
var cond        = '';
// BROWSER?
if (browser == ''){
if (navigator.appName.indexOf('Microsoft') != -1)
browser = 'IE'
}
if (browser == 'IE') document.write('<'+'link rel="stylesheet" href="themes/{theme}/menu_ie.css" />');
else document.write('<'+'link rel="stylesheet" href="themes/{theme}/menu.css" />');
// -->
</SCRIPT>

<script type="text/javascript" src="cal/calendar.js"></script>
<script type="text/javascript" src="cal/calendar-en.js"></script>
<script type="text/javascript" src="cal/calendar-setup.js"></script>

<script type="text/javascript">
    startList = function() {
        if (document.all&&document.getElementById) {
            navRoot = document.getElementById("dmenu");
            for (i=0; i<navRoot.childNodes.length; i++) {
                node = navRoot.childNodes[i];
                if (node.nodeName=="LI") {
                    node.onmouseover=function() {
                        this.className+=" over";
                    }
                    node.onmouseout=function() {
                        this.className=this.className.replace(" over", "");
                    }
                }
            }
        }
    }
</script>

<script type="text/javascript">
function togglePartComic() {

	if ( document.getElementById("com_type").options[document.getElementById("com_type").options.selectedIndex].value == "Mini Series" )
          {
               document.getElementById('showhide').style.display = '';
          } else {
               document.getElementById('showhide').style.display = "none";
          }
     }

function toggleEbayInput(i) 
{
	if ( i == 0 ) 
		{
        	document.getElementById('ebayshowhide').style.display = '';
        } else {
        	document.getElementById('ebayshowhide').style.display = "none";
       	}
	}
	
</script>

<script type="text/javascript">    
    function windowOnload()
	{
 		startList();
  		document.getElementById('showhide').style.display = 'none';
  		document.getElementById('ebayshowhide').style.display = 'none';
	}
	
	window.onload = windowOnload;
</script>

<script type="text/javascript">  
	function CoverView(ix,iy)
	{
		window.open( "{pmcurl}coverview.php?image={comic_image}","imageviewer","width="+ix+",height="+iy+",menubar=no,toolbar=no" );
	}
</script>

<script> 
function CheckAll()
{
count = document.formList.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.formList.elements[i].checked == 1)
    	{document.formList.elements[i].checked = 1; }
    else {document.formList.elements[i].checked = 1;}
	}
}
function UncheckAll(){
count = document.formList.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.formList.elements[i].checked == 1)
    	{document.formList.elements[i].checked = 0; }
    else {document.formList.elements[i].checked = 0;}
	}
}
</script>

<script language="javascript1.2">
var form_id;

function confirm_delete(form_id)
{
	var answer = confirm("Are you sure you want to proceed with this action?");
	if(answer)
	{
		document.getElementById(form_id).action = "function.php?cmd=delmore";
		document.getElementById(form_id).submit();		
	}
}
</script>
  
</head>

<body topmargin="0" bottommargin="0" rightmargin="0" leftmargin="0" marginwidth="0" marginheight="0" scroll="yes">
    
<table border="0" align="center" cellpadding="0" cellspacing="0" class="body">
  <tr><td align="left" valign="top">

  <!-- INCLUDE BLOCK : sitemenu -->

  <table width="100%" height="100%" cellpadding="20" cellspacing="0" border="0">
    <tr><td valign="top">

    <!-- INCLUDE BLOCK : content -->

    <!-- INCLUDE BLOCK : footer -->

    </td></tr>
  </table>

  </td></tr>
</table>

</body>
</html>