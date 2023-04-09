<?

@session_start();

if(session_is_registered("admin"))

{

include ("functions.php");
include ('header.php');

db_connect();



?>

<?admin_menu();?>

<table width="420" align="center">

            <tr>

              <td width="100%">

<p><br><b>Delete A Banner</b><p>



<font size=2 face=verdana>Click any banner name you wish to delete from the rotation and the changes take effect immediately.<p>





<form method="POST" action=deletebannerconfirm.php>

<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>

<input type=hidden name=admpass value=<? echo "$admpass"; ?>>



<table cellpadding=5><tr><td><b>Current Banners</b><p></td></tr>



<?

  $accounts = mysql_query("select * from banner_index where id >= '1' order by name asc");

  $total_found=mysql_num_rows($accounts);

  while ($get_rows=@mysql_fetch_array($accounts)) {

    $banner_url=$get_rows[banner_url];

    $link_url=$get_rows[link_url];

    $name=$get_rows[name];

    echo "

  <tr><td><img src=$banner_url></td></tr>

  <tr><td>Link: $link_url</td></tr>

  <tr><td>Click Below Button to Delete!</td></tr>

  <tr><td><input type=submit value=\"$name\" name=delete></td></tr>

  <tr><td> </td></tr>

         "; }

?>



</table>

</form></td>

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