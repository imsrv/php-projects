<?php 

function handleupload() 
{
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) 
{
$realname = $_FILES['userfile']['name'];


if ($_FILES['userfile']['size']>60000)
{
echo "Uploaded files must be less than 60k. Please close this window and try again" . " ]  ";
}
else
{

echo $realname . ", size: ". $_FILES['userfile']['size'] . " [ ";

switch($_FILES['userfile']['error'])
{ case 0: $mess = "Ok";
  break;
  case 1:
  case 2: $mess = "Error : File size more than 512000 bytes";
  break;
  case 3: $mess = "Error : File partially uploaded";
  break;
  case 4: $mess = "Error : No File Uploaded";
  break;
}
echo $mess . " ]  ";


// check whether the file exists beforehand, if yes use randomvar in front of filename
srand();
$randvar =  mt_rand(1,1000000);
settype($randvar,"string");

$newfilename = dirname($_SERVER["SCRIPT_FILENAME"])."/uploadedfiles/" . $randvar. str_replace(" ","_",$realname);
echo $newfilename;
$shortfname = $randvar. str_replace(" ","_",$realname);
while ( file_exists($newfilename) != FALSE )
{
$randvar =  mt_rand(1,100000);
settype($randvar,"string");
$newfilename = dirname($_SERVER["SCRIPT_FILENAME"])."/uploadedfiles/" . $randvar. str_replace(" ","_",$realname);
$shortfname =  $randvar. str_replace(" ","_",$realname);
}
//////////////////////
copy($_FILES['userfile']['tmp_name'], $newfilename);

echo "<script language=\"JavaScript\">";
echo "fname = '" . $shortfname . "'";
echo "</script>";

}// Else fr more than 60k
} 
else 
{
echo "<font face='verdana,arial' color=#dd0000 size=2><div align=center>Error : File Not Uploaded. Check Size & Try Again.<br><a href=\" javascript: onclick=history.go(-1);\">Go Back</a></div></font>";
$dontshowfinish = 1;
}
}
?>

<html>
<head><title>Upload Image File Status</title>
<Script Language="JavaScript">
function closewin(fname)
{
window.opener.document.form123.<?php echo $_REQUEST["box"];?>.value=fname
window.close()
}
</script>
</head>

<body>

<table bgcolor="#FFCCCC">
<tr><td width="299">
<strong><font color="navy" size="3" face="Arial, Helvetica, sans-serif">Image 
    Uploader </font></strong>
</td></tr>
<tr><td width="299"><hr>
</td></tr>
<tr><td width="299">
    <strong><font color="#CC3300" size="3" face="Arial, Helvetica, sans-serif">
	<?php handleupload(); ?></font></strong>
</td></tr>
<tr><td width="299">&nbsp;
</td></tr>
<tr><td width="299"><hr>
</td></tr>
<tr><td width="299" align=center>
    <strong><font color="#CC3300" size="3" face="Arial, Helvetica, sans-serif">
	<a href="javascript:onclick=closewin(fname)">FINISH</a></font></strong>
</td></tr>
</table>
</body>
</html>