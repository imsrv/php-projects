<?
include ('../includes/global.php');

//connecting DB
$link=dbconnect();

if($t == "edit")
{

    $query= <<<SQL
    SELECT * from advt_email where ad_id='$adid' and type='paid'
SQL;
    if($res=mysql_query($query))
    {
        $res=mysql_fetch_array($res);
    }
}
elseif($t == "delete")
{
    if(mysql_query("delete from advt_email where ad_id='$adid' and type='paid' "))
    {
         print <<<HTM
         <b><font color=red>Data successfully Deleted</font></b>
HTM;
    }
    else
         print "<b><font color=red>Invalid Id provided</font></b>";
}
elseif( $t == "save" && $s == "new")
{
     $adid=date(dmy).time();
     $query= <<<SQL
        INSERT advt_email (ad_id,email_id, name, url,amt_perclick,clicks_recd,title,info,type) values
        ('$adid','$email','$name','$url1',$amtpclick,'$clickrecd','$title','$info','paid')
SQL;
      if(mysql_query($query))
          print "<center><b><font color=red>Data successfully Inserted</font></b></center>";
}
elseif($t == "save")
{
    $query=<<<SQL
    UPDATE advt_email set email_id='$email', name='$name', url='$url1', amt_perclick=$amtpclick,
       clicks_recd='$clickrecd',title='$title',info='$info'  where ad_id='$adid' and type='paid'
SQL;
    if(mysql_query($query) or die(mysql_error()))
        print "<center><b><font color=red>Data successfully Updated</font></b></center>";
}


?>
    <table border="1">
    <tr>
    <td>
    <font face="arial" size="3"><b><center>Paid-Email Adder</center></b></font>
    <font color="red"><b>Editing Link:</b></font><br>
    <form action="<?=$admin_url?>/pe.php?t=save&adid=<?=$adid?>&s=<?=$s?>" method="POST">
     <font face="arial" size="2">Please use the following URL in any of your mailings,to send out the Paid-Email:<br>
	 <b><?=$site_url?>/petrack.php?adid=<?=$adid?>&action=done&email=_EMAIL_</b><br><br>

     Email Address of the Advertiser:<br>
    <font size="2"><b></b></font>
    <input type="text" name="email" value="<?=$res[1]?>"><br><br>
    Money the users Earn per Click <br>
    <input type="text" name="amtpclick" value="<?=$res[5]?>"><br>
    <font size="2"><b>(How much the users make per click. In cents 5 cents would look like 5)</b></font>
    <br><br>
	    Total Clicks Received<br>
    <?=$res[6]?><br>
    <font size="2"></font>
    <br><br>
    Site URL: (You must not include the http://)<br>
    <input type="text" name="url1" value="<?=$res[4]?>">
    <br><br>
    Site Title: <br>
    <input type="text" name="title" value="<?=$res[3]?>">
    <br><br>
    <input type="submit" value="Add/Edit Email"></font>
    </form></td>
<?

$query="select ad_id,email_id from advt_email where type='paid' ";
?>
	<td valign="top">
	<font face="arial" size="3"><b><center>Paid-Email List - PLEASE NOTE: You MUST first click the link below when creating a new paid email</center></b></font>
	<font face="arial" size="2">
	<font color="red"><b></b></font><br>
	<a href="<?=$admin_url?>/pe.php?s=new" target="_top">Make a New Link</a><br>
	For the link to insert into your e-mails, please click "Edit" next to the paid-email of your choice, below.
	<ol type=1></font>
<?   
if($re=mysql_query($query))
{
   while($res=mysql_fetch_array($re))
   {
?>        <li><?=$res[0]?> [<a href="<?=$admin_url?>/pe.php?t=delete&adid=<?=$res[0]?>&refresh=yes" target="_top">Delete</a> | <a
href="<?=$admin_url?>/pe.php?t=edit&adid=<?=$res[0]?>" target="_top">Edit</a>]
<?
   }
}

dbclose($link);
?>
          </ol></td></tr></table>
          
<?
print  <<<HTM
<br><br><pre>Click the link. <a href="$admin_url/admin.php" target="_top">Go to Admin Index Page</a></pre>
HTM;
?>