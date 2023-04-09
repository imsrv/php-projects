<?
/**********************************************************************
**              Copyright Info - http://www.mxprojects.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of MX Projects which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
//look for the skin in the cookie
if (isset($userdetails[3])){
header("Location: "."$userdetails[3]");
}else{
header("Location: "."default");
}
echo "<center><font size=1>I'm working on fixing the board if it's not working for you (it's not working for me)</font></center>";
?>