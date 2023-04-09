<?

include "logincheck.php";
function main()
{?>
 <font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
All the Software and information relating to this member will be deleted. Do you really 
want to delete this member ? </font></p> 
<form name="form2" method="post" action="deleteconfirmmember.php">
                <input name="id" type="hidden" id="id" value="<? echo $_REQUEST["id"];?>">
  <input type="hidden" name="pg" value="<? echo $_REQUEST["pg"];?>">
  <input type="hidden" name="pgenable" value="<? echo $_REQUEST["pgenable"];?>">
  <input type="button" name="no" value="No" onClick="javascript:window.history.go(-1);" >
  &nbsp;&nbsp;&nbsp; 
  <input type="submit" name="yes" value="Yes" >
              </form>

<?
} //end of main
include "template.php";?>
