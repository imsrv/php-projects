<?
/**********************************************************************
**              Copyright Info - http://scott.ysebert.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of Project MX which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
header('Content-type: application/x-www-urlform-encoded');

$now = time();
$lifeTime = $now + (365 * 86400);

setcookie("userdetails[3]", $skinLocation, $lifeTime);
setcookie("goThreadID", "");
setcookie("goForumID", "");
?>