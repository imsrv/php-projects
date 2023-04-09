<?php
include('../lang/admin.php');
include('../modules/list.inc.php');
$mod_count=count($modules);
?>
	var NoOffFirstLineMenus=5; //set number of main menu items
	var LowBgColor='#F2F2F2';
	var HighBgColor='#D1D1E9';
	var FontLowColor='black';
	var FontHighColor='black';
	var BorderColor='black';
	var BorderWidth=1;
	var BorderBtwnElmnts=1;
	var FontFamily="verdana"
	var FontSize=8;
	var FontBold=0;
	var FontItalic=0;
	var MenuTextCentered=0;
	var MenuCentered='left';
	var MenuVerticalCentered='top';
	var ChildOverlap=.1;
	var ChildVerticalOverlap=.1;
	var StartTop=0; //set vertical offset
	var StartLeft=10; //set horizontal offset
	var VerCorrect=0;
	var HorCorrect=0;
	var LeftPaddng=3;
	var TopPaddng=2;
	var FirstLineHorizontal=1; //set menu layout (1=horizontal, 0=vertical)
	var MenuFramesVertical=1;
	var DissapearDelay=500;
	var TakeOverBgColor=1;
	var FirstLineFrame='navig';
	var SecLineFrame='space';
	var DocTargetFrame='space';
	var WebMasterCheck=0;
	

Menu1=new Array("<?php print $lang[1]?>","",2,18,150);	
	Menu1_1=new Array("<?php print $lang[3]?>","",2,18,150);
	Menu1_1_1=new Array("<?php print $lang[14]?>","index.php?cmd=open_group&action=members&ac=<?php print crypt(time());?>",0,18,150);
	Menu1_1_2=new Array("<?php print $lang[37]?>","index.php?cmd=list_groups&action=members&ac=<?php print crypt(time());?>",0,18,150);	
	Menu1_2=new Array("<?php print $lang[2]?>","",2,18,150);
	Menu1_2_1=new Array("<?php print $lang[14]?>","index.php?cmd=open_user&action=members&ac=<?php print crypt(time());?>",0,18,150);
	Menu1_2_2=new Array("<?php print $lang[37]?>","index.php?cmd=list_members&action=members&ac=<?php print crypt(time());?>",0,18,150);

Menu2=new Array("<?php print $lang[4]?>","",3,18,150);	
	Menu2_1=new Array("<?php print $lang[5]?>","",2,18,150);
	Menu2_1_1=new Array("<?php print $lang[52]?>","index.php?cmd=open&pid=1&action=pages&ac=<?php print crypt(time());?>",0,18,150);
	Menu2_1_2=new Array("<?php print $lang[53]?>","index.php?cmd=update_structure&action=pages&ac=<?php print crypt(time());?>",0,18,150);	
	Menu2_2=new Array("<?php print $lang[6]?>","",2,18,150);
	Menu2_2_1=new Array("<?php print $lang[14]?>","index.php?cmd=open_template&action=templates&ac=<?php print crypt(time());?>",0,18,150);
	Menu2_2_2=new Array("<?php print $lang[37]?>","index.php?cmd=list_template&action=templates&ac=<?php print crypt(time());?>",0,18,150);	
	Menu2_3=new Array("<?php print $lang[7]?>","",<?php print $mod_count?>,18,150);
	<?php
		$i=1;
		while(list($key,$val)=each($modules)) {
			?>Menu2_3_<?php print $i?>=new Array("<?php print $key?>","index.php?cmd=&action=modules&mod_name=<?php print $val?>&ac=<?php print crypt(time());?>",0,18,150);<?php
		}
	?>

		
Menu3=new Array("<?php print $lang[8]?>","",0,18,150);	

Menu4=new Array("<?php print $lang[9]?>","",0,18,150);

Menu5=new Array("<?php print $lang[10]?>","",0,18,150);
	
