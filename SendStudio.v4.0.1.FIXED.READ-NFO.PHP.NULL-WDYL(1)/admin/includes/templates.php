<?php

	// Needed to find the correct path during installation
	if($ROOTURL == "")
	{
		$x1 = strpos(@$_SERVER["REQUEST_URI"], "/", 0);
		$x2 = strpos(@$_SERVER["REQUEST_URI"], "/", 1);
		$RPath = substr(@$_SERVER["REQUEST_URI"], $x1, $x2 - $x1 + 1);
		$ROOTURL = "http://" . @$_SERVER["SERVER_NAME"] . $RPath;
	}

	function OutputPageHeader($ShowButtons = true)
	{
		global $ROOTURL;
		global $IsSetup;
		global $CURRENTADMIN;
		global $TABLEPREFIX;

		if($IsSetup == 0)
			$ShowButtons = false;

		// Can this user create a list?
		if($CURRENTADMIN["Root"] == 1 && $CURRENTADMIN["Manager"] == 1)
		{
			$canCreateList = true;
		}
		else
		{
			$lists = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists INNER JOIN allow_lists ON lists.ListID = allow_lists.ListID WHERE allow_lists.AdminID = " . $CURRENTADMIN["AdminID"] . " ORDER BY lists.ListName DESC");

			$maxLists = $CURRENTADMIN["MaxLists"];
			$numLists = @mysql_num_rows($lists);
			$numListsLeft = (int)$maxLists - (int)$numLists;

			if($numListsLeft > 0 || $maxLists == 0)
				$canCreateList = true;
			else
				$canCreateList = false;
		}
	
	?>
		<html>
		<head>
		<meta http-equiv="Content-Language" content="en-us">
		<?php OutputStyleSheet(); ?>
	<?php if($ShowButtons != false) { ?>
		<script language="JavaScript" type="text/javascript" src="<?php echo $ROOTURL; ?>admin/menu/mm_menu.js"></script>
		<script language=JavaScript>

			window.onerror = function() { return true; }
			
			function mmLoadMenus()
			{
			  window.mm_menu_lists = new Menu("root",105,20,"Tahoma, Verdana, Arial, Helvetica, sans-serif",11,"#000000","#FFFFFF","#F7FFBD","#CE0000","left","middle",3,0,200,-5,7,true,true,true,0,true,true);

			   mm_menu_lists.hideOnMouseOut=true;
			   mm_menu_lists.bgColor='#CE0000';
			   mm_menu_lists.menuBorder=1;
			   mm_menu_lists.menuLiteBgColor='#CE0000';
			   mm_menu_lists.menuBorderBgColor='';

			  <?php if(AllowSection(2)) { ?>
				mm_menu_lists.addMenuItem("Manage&nbsp;Lists","location='<?php echo MakeAdminLink("lists"); ?>'");
			  <?php } if(AllowSection(2) && $canCreateList) { ?>
				mm_menu_lists.addMenuItem("Create&nbsp;Mailing&nbsp;List","location='<?php echo MakeAdminLink("lists?Action=Add"); ?>'");
			  <?php } ?>

			  window.mm_menu_subscriber = new Menu("root",125,20,"Tahoma, Verdana, Arial, Helvetica, sans-serif",11,"#000000","#FFFFFF","#F7FFBD","#CE0000","left","middle",3,0,200,-5,7,true,true,true,0,true,true);
			  
			  <?php if(AllowSection(1)) { ?>
				mm_menu_subscriber.addMenuItem("Manage&nbsp;Subscribers","location='<?php echo MakeAdminLink("members"); ?>'");
			  <?php } ?>

			  <?php if(AllowSection(6)) { ?>
				mm_menu_subscriber.addMenuItem("Banned&nbsp;Subscribers","location='<?php echo MakeAdminLink("banned"); ?>'");
			  <?php } ?>
			  
			  <?php if(AllowSection(4)) { ?>
				mm_menu_subscriber.addMenuItem("Import&nbsp;Subscribers","location='<?php echo MakeAdminLink("import"); ?>'");
			  <?php } ?>

			  <?php if(AllowSection(16)) { ?>
				mm_menu_subscriber.addMenuItem("Add&nbsp;Subscriber&nbsp;via&nbsp;Form","location='<?php echo MakeAdminLink("addsub"); ?>'");
			  <?php } ?>
			  
			  <?php if(AllowSection(5)) { ?>			  
				mm_menu_subscriber.addMenuItem("Export&nbsp;Subscribers","location='<?php echo MakeAdminLink("export"); ?>'");
			  <?php } ?>
			  
			   mm_menu_subscriber.hideOnMouseOut=true;
			   mm_menu_subscriber.bgColor='#CE0000';
			   mm_menu_subscriber.menuBorder=1;
			   mm_menu_subscriber.menuLiteBgColor='#CE0000';
			   mm_menu_subscriber.menuBorderBgColor='';

			  window.mm_menu_newsletter = new Menu("root",130,20,"Tahoma, Verdana, Arial, Helvetica, sans-serif",11,"#000000","#FFFFFF","#F7FFBD","#CE0000","left","middle",3,0,200,-5,7,true,true,true,0,true,true);

			  <?php if(AllowSection(11)) { ?>
				mm_menu_newsletter.addMenuItem("Manage&nbsp;Newsletters","location='<?php echo MakeAdminLink("compose"); ?>'");
			  mm_menu_newsletter.addMenuItem("Create&nbsp;Newsletter","location='<?php echo MakeAdminLink("compose?Action=Add"); ?>'");
			  <?php } ?>

			  <?php if(AllowSection(12)) { ?>
				mm_menu_newsletter.addMenuItem("Send&nbsp;Newsletter","location='<?php echo MakeAdminLink("send"); ?>'");
			  <?php } ?>

			  <?php if(AllowSection(8)) { ?>
				mm_menu_newsletter.addMenuItem("Custom&nbsp;Subscriber&nbsp;Fields","location='<?php echo MakeAdminLink("customfields"); ?>'");
			  <?php } ?>

			  <?php if(AllowSection(15)) { ?>
				mm_menu_newsletter.addMenuItem("Image&nbsp;Manager","location='<?php echo MakeAdminLink("images"); ?>'");
			  <?php } ?>

			  <?php if(AllowSection(9)) { ?>
				mm_menu_newsletter.addMenuItem("Link&nbsp;Manager","location='<?php echo MakeAdminLink("links"); ?>'");
			  <?php } ?>

			   mm_menu_newsletter.hideOnMouseOut=true;
			   mm_menu_newsletter.bgColor='#CE0000';
			   mm_menu_newsletter.menuBorder=1;
			   mm_menu_newsletter.menuLiteBgColor='#CE0000';
			   mm_menu_newsletter.menuBorderBgColor='';

			  window.mm_menu_templates = new Menu("root",105,20,"Tahoma, Verdana, Arial, Helvetica, sans-serif",11,"#000000","#FFFFFF","#F7FFBD","#CE0000","left","middle",3,0,200,-5,7,true,true,true,0,true,true);

			   mm_menu_templates.hideOnMouseOut=true;
			   mm_menu_templates.bgColor='#CE0000';
			   mm_menu_templates.menuBorder=1;
			   mm_menu_templates.menuLiteBgColor='#CE0000';
			   mm_menu_templates.menuBorderBgColor='';

			  <?php if(AllowSection(10)) { ?>
				mm_menu_templates.addMenuItem("Manage&nbsp;Templates","location='<?php echo MakeAdminLink("templates"); ?>'");
			  <?php } if(AllowSection(10)) { ?>
				mm_menu_templates.addMenuItem("Create&nbsp;Template","location='<?php echo MakeAdminLink("templates?Action=Add"); ?>'");
			  <?php } ?>

			  window.mm_menu_autores = new Menu("root",130,20,"Tahoma, Verdana, Arial, Helvetica, sans-serif",11,"#000000","#FFFFFF","#F7FFBD","#CE0000","left","middle",3,0,200,-5,7,true,true,true,0,true,true);

			   mm_menu_autores.hideOnMouseOut=true;
			   mm_menu_autores.bgColor='#CE0000';
			   mm_menu_autores.menuBorder=1;
			   mm_menu_autores.menuLiteBgColor='#CE0000';
			   mm_menu_autores.menuBorderBgColor='';

			  <?php if(AllowSection(13)) { ?>
				mm_menu_autores.addMenuItem("Manage&nbsp;Autoresponders","location='<?php echo MakeAdminLink("autoresponders"); ?>'");
			  <?php } if(AllowSection(13)) { ?>
				mm_menu_autores.addMenuItem("Create&nbsp;Autoresponder","location='<?php echo MakeAdminLink("autoresponders"); ?>'");
			  <?php } ?>

			  window.mm_menu_forms = new Menu("root",80,20,"Tahoma, Verdana, Arial, Helvetica, sans-serif",11,"#000000","#FFFFFF","#F7FFBD","#CE0000","left","middle",3,0,200,-5,7,true,true,true,0,true,true);

			   mm_menu_forms.hideOnMouseOut=true;
			   mm_menu_forms.bgColor='#CE0000';
			   mm_menu_forms.menuBorder=1;
			   mm_menu_forms.menuLiteBgColor='#CE0000';
			   mm_menu_forms.menuBorderBgColor='';

			  <?php if(AllowSection(7)) { ?>
				mm_menu_forms.addMenuItem("Manage&nbsp;Forms","location='<?php echo MakeAdminLink("forms"); ?>'");
			  <?php } if(AllowSection(7)) { ?>
				mm_menu_forms.addMenuItem("Create&nbsp;Form","location='<?php echo MakeAdminLink("forms?Action=Add"); ?>'");
			  <?php } ?>

			writeMenus();

			}
		</script>
	<?php } ?>

		<script language="JavaScript">
		
			function ShowHelp(div, title, desc)
			{
				div.style.display = 'inline';
				div.style.position = 'absolute';
				div.style.width = '170';
				div.style.backgroundColor = 'lightyellow';
				div.style.border = 'dashed 1px black';
				div.style.padding = '10px';
				div.innerHTML = '<b>' + title + '</b><br><div style="padding-left:10; padding-top:5; padding-right:5">' + desc + '</div>';
			}

			function HideHelp(div)
			{
				div.style.display = 'none';
			}

		</script>

		<title>Control Panel</title>
		</head>

		<body topmargin="0" leftmargin="0" rightmargin="0">
	<?php if($ShowButtons != false) { ?>
		<script language="JavaScript1.2" type="text/javascript">mmLoadMenus();</script>
	<?php } ?>
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<table height=100% border=0 width=100% cellpadding=0 cellspacing=0><tr><td height=1 valign=top>

					<!-- end table tag -->

						<table cellspacing=0 cellpadding=0 width=100% valign=bottom align=center border=0>
						  <tr>
							<td valign=center class=menutop><a href="<?php echo MakeAdminLink("index"); ?>"><img src="<?php echo $ROOTURL; ?>admin/images/logo.gif" width=294 height=59 border=0></a></td>
							<td valign=center class=menutop align="right" class="top">
							<?php if(@$CURRENTADMIN["AdminID"] != "") { ?>
								<br><br><a class="topLink" href="<?echo MakeAdminLink("index");?>">Home</a> | <font class="topLink">NULL BY WDYL</font><?php if(AllowSection(3)) { ?> | <a class="topLink" href="<?echo MakeAdminLink("admins");?>">Users</a><?php } if($CURRENTADMIN["Root"] == 1) { ?> | <a class="topLink" href="<?echo MakeAdminLink("index?Page=Settings");?>">Settings</a><?php } ?> | <a class="topLink" href="<?echo MakeAdminLink("index?Page=Logout");?>">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;
							<?php } ?>
							</td>
						  </tr>
						</table>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td class=top1 width="100%" height="5"></td>
							</tr>
							<tr>
								<td class=top width="100%" height="60" valign="top" align=right>
								<p style="margin-right:15">
								<?php if($ShowButtons) { ?>
									<img src="<?php echo $ROOTURL; ?>admin/images/blank.gif" width="15" height="10"><?php
									
									if(AllowSection(2))
									{
										?><a href="<?echo MakeAdminLink("lists");?>"><img title="Create, manage and delete your mailing lists." id="link3" name="link3" onmouseover="MM_showMenu(window.mm_menu_lists,15,29,null,'link3')" onmouseout="MM_startTimeout();" width="67" height="32" border="0" src="<?php echo $ROOTURL; ?>admin/images/list_button.gif"></a><?php
									}
									
									if(AllowSection(1))
										{ ?><a href="<?echo MakeAdminLink("members");?>"><?php
									}
									
									if( AllowSection(1) || AllowSection(4) || AllowSection(5) || AllowSection(6) || AllowSection(16) )
									{
										?><img title="Create, manage and delete subscribers." id="link1" name="link1" onmouseover="MM_showMenu(window.mm_menu_subscriber,15,29,null,'link1')" onmouseout="MM_startTimeout();" width="106" height="32" border="0" src="<?php echo $ROOTURL; ?>admin/images/subscriber_button.gif"><?php
									}
									
									if(AllowSection(1))
									{
										?></a><?php
									}

									if(AllowSection(11))
									{
										?><a href="<?echo MakeAdminLink("compose");?>"><?php
									}
									
									if(AllowSection(8) || AllowSection(9) || AllowSection(11) || AllowSection(12) || AllowSection(15))
									{
										?><img title="Create, send and manage your newsletters." id="link2" name="link2" onmouseover="MM_showMenu(window.mm_menu_newsletter,15,29,null,'link2')" onmouseout="MM_startTimeout();" width="106" height="32" border="0" src="<?php echo $ROOTURL; ?>admin/images/newsletter_button.gif"><?php
									}
									
									if(AllowSection(11))
									{
										?></a><?php
									}
										
									if(AllowSection(10))
									{
										?><a href="<?echo MakeAdminLink("templates");?>"><img title="Create and manage your newsletter templates." id="link4" name="link4" onmouseover="MM_showMenu(window.mm_menu_templates,15,29,null,'link4')" onmouseout="MM_startTimeout();" width="98" height="32" border="0" src="<?php echo $ROOTURL; ?>admin/images/template_button.gif"></a><?php
									}

									if(AllowSection(13))
									{
										?><a href="<?echo MakeAdminLink("autoresponders");?>"><img title="Create and manage your autoresponder emails." id="link5" name="link5" onmouseover="MM_showMenu(window.mm_menu_autores,15,29,null,'link5')" onmouseout="MM_startTimeout();" width="137" height="32" border="0" src="<?php echo $ROOTURL; ?>admin/images/autoresponder_button.gif"></a><?php
									}
									
									if(AllowSection(7))
									{
										?><a href="<?echo MakeAdminLink("forms");?>"><img title="Create and manage subscribe and unsubscribe forms to integrate into your website." id="link6" name="link6" onmouseover="MM_showMenu(window.mm_menu_forms,15,29,null,'link6')" onmouseout="MM_startTimeout();" width="75" height="32" border="0" src="<?php echo $ROOTURL; ?>admin/images/form_button.gif"></a><?php
									}
									
									if(AllowSection(14))
									{
										?><a href="<?echo MakeAdminLink("stats");?>"><img title="View mailing list and newsletter statistics." width="72" height="32" border="0" src="<?php echo $ROOTURL; ?>admin/images/report_button.gif"></a><?php
									}
									
									?><br><br>
								<?php } else { ?>
									<br>&nbsp;
								<?php } ?>
								</td>
							</tr>
						</table>
	<?php
		
		global $ShowInfoTips;
		
		if(sizeof($CURRENTADMIN) > 0 && $ShowInfoTips == 1)
			include_once("includes/infotips.php");
	}

	function OutputPageFooter()
	{
		global $ROOTURL;
	?>
					<br>
				</td>
			</tr>
			<tr>
				<td valign="bottom">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td class="body" class=pagefooter1><img src="<?php echo $ROOTURL; ?>admin/images/1x1.gif" width="1" height="1"></td>
					  </tr>
					  <tr>
						<td class="pagefooter2" align="right">
						  <br>
							  
							  <font class="bodylink">SendStudio v4.0.1 Copyright</font> &copy; <?php echo date("Y"); ?> <font class="bodylink">Interspire&nbsp;&nbsp;<b>[WDYL]</b></font><br>
						  </td>
					  </tr>
					</table>
				</td>
				</tr>
			</table>
		</body>
		</html>
	<?php
	}

	function OutputStyleSheet()
	{
	// Output the SendStudio admin stylesheet
	?>
		<style>
		<!--

			.body
			{
				font-weight: normal;
				font-size: 11px;
				color: #4e4f4f;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: none
			}

			.infoBallon
			{
				background-color: #FFFFE7;
				border: dotted 1px black;
			}

			.pagefooter1
			{
				background-color: #C6C6C4;
			}

			.pagefooter2
			{
				font-weight: normal;
				font-size: 11px;
				color: #4e4f4f;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: none;
				background-color: #F4F4F4;
				border-top: solid 1px #C6C7C6;
			}

			.disabled
			{
				font-size: 11px;
				color: #cacaca;
				font-family: arial, verdana, helvetica, sans-serif;
			}

			.pop
			{
				font-size: 11px;
				color: #808080;
				font-family: arial, verdana, helvetica, sans-serif;
			}

			.bevel4
			{
				padding-left: 5pt;
				background-color: #F7F7F7
			}

			.top
			{
				background-color: #FFFFFF
			}

			.top1
			{
				background-color: #CE0000
			}

			.menutext
			{
				font-family: Tahoma;
				color: #ffffff;
				font-size: 8pt;
				font-weight: bold;
			}

			.blocktop
			{
				background-color: #F7F7F7;
				font-family: Tahoma;
				color: #ffffff;
				font-size: 8pt;
				font-weight: bold;
			}

			.blockplain
			{
				background-color: #F7F7F7;
			}

			.menuheader
			{
				font-family: Tahoma;
				color: #ffffff;
				font-size: 8pt;
				font-weight: bold;
				background-color: #CE0000;
			}

			.infobox
			{
				font-weight: normal;
				font-size: 11px;
				color: #000000;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: none;
				background-color: #F7F7F7;
			}

			.navtext
			{
				font-family: Tahoma;
				color: #ffffff;
				font-size: 8pt;
				font-weight: normal;
				background-color: #CE0000;
				height: 20;
				text-align: right
			}
			
			.headbar
			{
				font-weight: normal;
				font-size: 11px;
				vertical-align: middle;
				color: #ffffff;
				font-family: Verdana, arial,helvetica,sans-serif;
				height: 14pt;
				font-style: italic;
				background-color: #CE0000;
			}

			.navlink
			{
				font-family: Tahoma;
				color: #ffffff;
				font-size: 8pt;
				font-weight: bold;
				text-decoration: underline;
			}

			.rowSelectOn
			{
				background-color: #DDDDDD
			}

			.admintext
			{
				font-weight: normal;
				font-size: 11px;
				color: #000000;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: none
			}

			.heading1
			{
				font-weight: bold;
				font-size: 18px;
				color: #CE0000;
				font-family: arial, helvetica, sans-serif;
				text-decoration: none
			}

			.heading2
			{
				font-weight: bold;
				font-size: 16px;
				color: #CE0000;
				font-family: arial, helvetica, sans-serif;
				text-decoration: none
			}

			.SideHeading
			{
				background-color: #CE0000;
			}

			.SideBody
			{
				background-color: #F4F4F4;
			}

			.headbold
			{
				font-weight: bold;
				font-size: 11px;
				vertical-align: middle;
				color: #ffffff;
				font-family: Verdana, arial,helvetica,sans-serif;
				height: 14pt;
				text-decoration: none
			}

			.bevel5
			{
				padding-left: 3pt;
				vertical-align: middle;
				background-color: #ADAAAD
			}

			table
			{
				font-weight: normal;
				font-size: 11px;
				color: #4e4f4f;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: none
			}

			a
			{
				color: #000000;
			}
			
			/*input
			{
				font-family: Tahoma;
				font-size: 11px;
				width: 250px;
			}*/
			
			button
			{
				font-size: 11px;
				font-family: Tahoma
			}
			
			select
			{
				font-size: 11px;
				font-family: Tahoma;
				width: 250px;
			}
			
			.submit
			{
				font-family: Tahoma;
				font-size: 11px;
				width: 150px;
			}

			.cancel
			{
				font-family: Tahoma;
				font-size: 11px;
				width: 70px;
			}

			.button
			{
				font-family: Tahoma;
				font-size: 11px;
				width: 150px;
			}
			
			.smallbutton
			{
				font-family: Tahoma;
				font-size: 11px;
				width: 50px;
			}
			
			.medbutton
			{
				font-family: Tahoma;
				font-size: 11px;
				width: 130px;
			}

			.pbutton
			{
				font-family: Tahoma;
				font-size: 11px;
				width: 110px;
			}
			
			.req
			{
				font-family: Arial Black;
				font-size: 8pt;
				font-weight: bold;
				color: red;
			}
			
			.sidebarlinks
			{
				font-size:12;
				text-decoration:none;
				color:black;
				font-family:arial
			}
			
			.sidebarlinks:hover
			{
				font-size:12;
				text-decoration:none;
				color:#777777;
				font-family:arial
			}
			
			.adminlink
			{
				font-size:11;
				text-decoration:underline;
				color:#006699;
				font-family:arial
			}
			
			.adminlink:hover
			{
				font-size:11;
				text-decoration:underline;
				color:black;
				font-family:arial
			}
			
			.inputfields
			{
				font-size:11;
				background-color:#FFFFF4;
				font-family:arial
			}

			.smalltext
			{
				font-weight: normal;
				font-size: 8px;
				color: #4e4f4f;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: none
			}

			.admintext
			{
				font-weight: normal;
				font-size: 11px;
				color: #4e4f4f;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: none
			}

			.formtext
			{
				font-weight: normal;
				font-size: 11px;
				color: #4e4f4f;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: none
			}

			.menutop
			{
				background-color: #FE0000;
				color: #ffffff;
				font-size: 11pt;
			}

			.top
			{
				color: #ffffff;
				font-size: 14px;
			}

			.topLink
			{
				font-weight: normal;
				font-size: 10px;
				color: #ffffff;
				font-family: arial, verdana, helvetica, sans-serif;
				text-decoration: underline
			}

		-->
		</style>
	<?php
	}

?>