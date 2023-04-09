<?
require_once("functions.php");
include ('header.php');
@session_start();
if(session_is_registered("admin"))
{
if ($namex&&$banner_urlx&&$link_urlx)
{
         $sql = mysql_query("insert into banner_index values ('','".$namex."','".$banner_urlx."','".$link_urlx."')");
}
?>
<? admin_menu(); 

//$banners=db_result_to_array("select id, name, link_url, banner_url from banner_index");
?>
<table width="420"  cellspacing="1" cellpadding="2" align="center">
            <tr>
              <td width="100%" align=center>
<p><b>Delete Banners</b>
<table cellpadding=5><tr><td>
<form method="POST" action="deletebanner.php">
<input type="submit" value="Delete Banners"></form>
</table>

<br><b>Add A Banner</b><p>

<font size=2 face=verdana>Add a banner and link to your banner rotation.<p>


<form method="POST" action="addbanner.php">
<table cellpadding=5><tr><td colspan=2><b>Banner Info</b><p></td></tr>

  <tr>
    <td width="22%">Banner Name:</td>
    <td width="78%"><input type="text" name="namex" size="50" value="Choose a Unique Name"></td>
  </tr>
  <tr>
    <td width="22%">Clicked banner destination URL:</td>
    <td width="78%"><input type="text" name="banner_urlx" size="50" value="http://"></td></td>
  </tr>
  <tr>
    <td width="22%">Banner display link URL :</td>
    <td width="78%"><input type="text" name="link_urlx" size="50" value="http://"></td>
  </tr>
  <tr>

<tr><td colspan=2>
<br><input type="submit" value=" Add Banner " name="submit">
      <input type="reset" value=" Reset Form "></table></form>


                  </td>
                </tr>
              </table></td>
            </tr>
          </table>
          </center>
        </div>
      </td>
  <center>
      <td width="1%" bgcolor="#000000"><IMG height=1 src="emailadvertising_files/borderright.gif"
    width=8></td>
    </tr>
  </table>
  <form method="post" action="adminlogin.php">
  <input type="submit" name="Submit" value="Click here to return to Main Menu">
</form>
<?}
 else echo "You are not logged in";
 ?>
