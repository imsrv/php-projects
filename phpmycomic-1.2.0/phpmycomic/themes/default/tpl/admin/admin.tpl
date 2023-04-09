<html>
<head>
<title>PhpMyComic Admin</title>
<link rel=stylesheet href="themes/{theme}/style.css" type=text/css>

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

</head>

<body topmargin="0" bottommargin="0" rightmargin="0" leftmargin="0" marginwidth="0" marginheight="0" scroll="yes">

<table border="0" align="center" cellpadding="0" cellspacing="0" class="body">
  <tr><td align="left" valign="top">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="menubar" width="10%"><img src="{imgfolder}/admin.jpg"><br></td>
    <td class="menubar" width="90%" nowrap="nowrap" valign="top">
    
    <ul id="dmenu">       
		<li><a href="admin.php">{lang_menu_home}</a></li>
		<li><a href="admin.php">{lang_menu_pref}</a>
			<ul>
				<li><a href="admin.php?action=index">{lang_menu_index}</a></li>
				<li><a href="admin.php?action=system">{lang_menu_setup}</a></li>
				<li><a href="admin.php?action=personal">{lang_menu_personal}</a></li>
			</ul>
		</li>
		<li><a href="admin.php">{lang_menu_user}</a>
     		<ul>
     			<li><a href="admin.php?action=users">{lang_menu_users}</a></li>
		    	<li><a href="admin.php?action=adduser">{lang_menu_newuser}</a></li>
		    </ul>
		</li>
		<li><a href="admin.php?action=backup">{lang_menu_backup}</a></li>
    	<li><a href="admin.php">{lang_menu_manage}</a>
    		<ul>
    			<li><a href="admin.php?action=images">{lang_menu_images}</a></li>
		    	<li><a href="admin.php?action=artist&type=type">{lang_menu_options}</a></li>
    			<li><a href="admin.php?action=loans">{lang_menu_loans}</a></li>
    			<li><a href="admin.php?action=favs">{lang_menu_favs}</a></li>
    		</ul>
    	</li>
    	<li><a href="index.php">{lang_menu_exit}</a></li>
    </ul>        
    
    </td>
  </tr>
</table>

  <table width="100%" height="100%" cellpadding="15" cellspacing="0" border="0" class="mainpage">
    <tr><td valign="top">

    <!-- INCLUDE BLOCK : adminpage -->

    </td></tr>
  </table>

  </td></tr>
</table>

</body>
</html>