<html>
<head>
<?
/**********************************************************************
**              Copyright Info - http://scott.ysebert.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of Project MX which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
// gothread.php
if (!isset($threadID)) {
echo "No Thread Specified";
exit();
} else {
include('./db.php');
// Connect to database
$link = dbConnect();
//let's get the forumID from threadID
$query = "SELECT forumID FROM forumThreads WHERE threadID = $threadID";
// Execute the query
$result = @mysql_query($query);
$forum = mysql_fetch_array($result);
$forumID = $forum['forumID'];
}
//if skin is set, make sure they go to the right place
if(isset($userdetails[3])){
$location = "$installDirectory".$userdetails[3]."/";
}else{
$location = "$installDirectory"."default/";
}
?>
<script language="JavaScript">
function submitForm()
{
document.form1.submit();
}
</script>
</head>
<body onLoad="submitForm();">
<form name="form1" method="POST" action="<? echo $location; ?>">
<input type="hidden" name="f" value="<? echo $forumID; ?>">
<input type="hidden" name="t" value="<? echo $threadID; ?>">
</form>
</body>
</html>