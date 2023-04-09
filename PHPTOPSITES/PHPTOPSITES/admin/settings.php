<?
include "../config.php";
include "header.php";
?>
<FORM ACTION="settings.php" method="post">
<table align=center width=90% border=1 cellpadding=3 cellspacing=0><tr><td>
MySQL Username:
</td><td>
<input type=text name=user value="<? echo $user?>"><BR>
</td></tr><tr><td>
MySQL Password:
</td><td>
<input type=text name=pass value="<? echo $pass?>"><BR>
</td></tr><tr><td>
MySQL Database Name:
</td><td>
<input type=text name=dbname value="<? echo $dbname?>"><BR>
</td></tr><tr><td>
MySQL Database Host:
</td><td>
<input type=text name=dbhost value="<? echo $dbhost?>"><BR>
</td></tr><tr><td>
Number of sites per page:
</td><td>
<input type=text name=t_step value="<? echo $t_step?>"><BR>
</td></tr><tr><td>
Number of Last xx Submitted Sites:
</td><td>
<input type=text name=last_ssites value="<? echo $last_ssites?>"><BR>


</td></tr></table>
</form>
<?
include "footer.php";
?>