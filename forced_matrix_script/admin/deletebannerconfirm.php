<?
/* nulled by [GTT] :) */ 

@session_start();

if(session_is_registered("admin"))

{



include ("functions.php");
include ('header.php');

db_connect();

  $delete=mysql_query("delete from banner_index where name='".$delete."'");



?>

<?admin_menu();?>

<table width="420" align="center">

            <tr>

              <td width="100%">

<p><br><b>Delete Banner</b><p>



Banner <b><? echo "$delete"; ?></b> has been deleted from the database.

<p><b>Click Below To Add Banners</b><p>

<p><form action=addbanner.php method=post>

<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>

<input type=hidden name=admpass value=<? echo "$admpass"; ?>>

<input type="submit" value="Add Banners">

</form><br><br><br><br><br><br></td>

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
