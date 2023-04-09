<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> Invoice printing </title>
</head>
 
<frameset rows="70,*" frameborder=0>
	<frame src="printit_head.php" name="phead">
	<frame src="<?HTTP_SERVER?>print.php?joke_id=<?=$HTTP_GET_VARS['joke_id']?>&cat_id=<?=$HTTP_GET_VARS['cat_id']?>&p=1" name="pbody">
</frameset>
</html>