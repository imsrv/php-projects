<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?

if ($_POST['edit'])
{
  $posterr = 0;
  
  // Check password
  if (strlen($_POST['password']) > 1){
#     errform('Please enter a password.'); // #err
#    $_POST['password'] = $data->password;
  }
  if (!preg_match("/^[\\w\\-]{1,16}$/i", $_POST['password']))
  {
    errform('The password should consist of letters and digits only.'); // #err
    $_POST['password'] = $data->password;
  }
  
	// Check email
	if (!email_check($_POST['email']) ){
		errform('You have entered an invalid email address.'); // #err
		$_POST['email'] = $data->email;
	}

  // Check profile
  if (strlen($_POST['profile']) > 5000)
  {
    errform("Your profile should be no longer than a maximum of $max_comment_len characters."); // #err
    $_POST['profile'] = substr($_POST['profile'], 0, $max_comment_len);
  }

  // Check image
  if( ($_FILES['logo']['name']) && ($use_images && !$_FILES['logo']['error']) )
  {
    if (strtolower(substr($_FILES['logo']['name'], -4)) != ".jpg")
      errform("File must have the .JPG extension", "img");
    elseif ($_FILES['logo']['size'] > 120 * 1024)
      errform("Your logo file is too large", "img");
    else
      $img = 1;
  }
  else
    $img = 0;
}
else
{
	// Fill with current data
	$_POST['password'] = $data->password;
	$_POST['email'] = $data->email;
	$_POST['name'] = $data->name;
	$_POST['regnum'] = $data->regnum;
	$_POST['notify'] = $data->notify;
	$_POST['profile'] = $data->profile;
	$_POST['address'] = $data->address;
	$_POST['city'] = $data->city;
	$_POST['zipcode'] = $data->zipcode;
	$_POST['country'] = $data->country;
	$_POST['state'] = $data->state;
	$_POST['phone'] = $data->phone1;
	$_POST['fax'] = $data->fax;
}

if ($_POST['edit'] && !$posterr)
{


	$_POST['notify'] = ($_POST['notify'] ? 1 : 0);
	// Update database
	$query = "UPDATE epay_users SET name='".addslashes($_POST['name'])."',regnum='".addslashes($_POST['regnum'])."',password='{$_POST['password']}',notify={$_POST['notify']},address='".addslashes($_POST['address'])."',country='".addslashes($_POST['country'])."',state='".addslashes($_POST['state'])."',city='".addslashes($_POST['city'])."',phone1='".addslashes($_POST['phone'])."',fax='".addslashes($_POST['fax'])."',zipcode='".addslashes($_POST['zipcode'])."',profile='".addslashes($_POST['profile'])."' WHERE id=$user";
	mysql_query($query) or die( mysql_error() );
  
  // Copy logo
  if ($img)
    copy($_FILES['logo']['tmp_name'], $att_path.$data->username.".jpg");
  if ($_POST['delimg'])
    unlink($att_path.$data->username.".jpg");

  if ($_POST['email'] != $data->email)
  {
    $uid = substr( md5(time()), 8, 16 );
    mysql_query("INSERT INTO epay_signups VALUES('$uid','{$_POST['email']}','$data->username','$data->type',DATE_ADD(NOW(),INTERVAL 3 DAY),NULL)");

    mail($_POST['email'], "Confirm E-mail for $sitename", 
      $emailtop.gettemplate("email_edit", "$siteurl/epay/admin/confirm.php?id=$uid").$emailbottom, 
    $defaultmail);
    prpage("html_edit");
  }
  else
  {
    // Go to account
    $action = 'account';
    $data = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE id=$user"));
    include('src/a_account.php');
  }
}
else
{
?>
<SCRIPT LANGUAGE="JavaScript">
<?
	while (list($key) = @each($country_values)) {
		if ($key == "0"){continue;}
?>
		var <?=$key?>_array  =  new Array(
<?
		$states = $state_values[$key];
		$total = sizeof($states);
		$i = 0;
		while ( list($key, $val) = @each($states) ) {
			$i++;
			echo "\"$key:$val\"";
			if($i < $total) {
				echo ",\n";
			}
		} 
		echo ");\n";
	}
?>
function populate(selected) {
	document.form1.elements['state'].selectedIndex = 0;
	var mychoice = "<?=$_POST['state']?>";
	var nochoice = 1;
	if ( eval(selected+"_array") ){
		var selectedArray = eval(selected+"_array");
		while (selectedArray.length < document.form1.elements['state'].options.length) {
			document.form1.elements['state'].options[(document.form1.elements['state'].options.length - 1)] = null;
		}
		eval("document.form1.elements['state'].options[0]=" + "new Option('--')");
		document.form1.elements['state'].options[0].value="0";
		for (var i=1; i < selectedArray.length; i++) {
			var id = selectedArray[i].substring(0,selectedArray[i].indexOf(":"));
			var val = selectedArray[i].substring(selectedArray[i].indexOf(":")+1, selectedArray[i].length);
			document.form1.elements['state'].options[i]=new Option(val);
			document.form1.elements['state'].options[i].value=id;
			if (id == mychoice){
				document.form1.elements['state'].selectedIndex = i;
				nochoice = 0;
			}
		}
	}else{
		document.form1.elements['state'].options[(document.form1.elements['state'].options.length - 1)] = null;
		eval("document.form1.elements['state'].options[0]=" + "new Option('--')");
		document.form1.elements['state'].options[0].value="0";
	}
	if (nochoice){
		document.form1.elements['state'].selectedIndex = 0;
	}
}
</script>
<BR>
<CENTER>
<TABLE class=design cellspacing=0>
	<FORM method=post enctype='multipart/form-data' name="form1">
<TR><TH colspan=2>Edit your information</TH></TR>
<TR><TD>Password:</TD>
	<TD><INPUT type=password name=password size=16 maxLength=16 value="<?=$_POST['password']?>"></TD></TR>
<TR><TD>Email address:<BR>
      <DIV class=small>(<a href=index.php?read=privacy.htm&<?=$id?>brand=<?$brand?>>Privacy Policy</a>)</DIV></TD>
	<TD><INPUT type=text name=email size=30 value="<?=$_POST['email']?>"></TD></TR>
<TR><TD>Name/Company:<BR>
      <DIV class=small>(This name will be displayed to others)</DIV>
	<TD><INPUT type=text name=name size=40 maxLength=40 value="<?=htmlspecialchars($_POST['name'])?>"></TD></TR>
<TR><TD>Company Registration Number:<BR>
	<TD><INPUT type=text name=regnum size=40 maxLength=40 value="<?=htmlspecialchars($_POST['regnum'])?>"></TD></TR>
<TR><TD>Address:<BR></TD>
	<TD><input type=text name=address size=40 maxLength=40 value="<?=htmlspecialchars($_POST['address'])?>"></TD></TR>
<TR><TD>City:<BR></TD>
	<TD><input type=text name=city size=40 maxLength=40 value="<?=htmlspecialchars($_POST['city'])?>"></TD></TR>
<TR><TD>Country:<BR></TD>
	<TD><? WriteCombo($country_values, "country", $_POST['country'], 0,"onChange=\"populate(document.form1.country.options[document.form1.country.selectedIndex].value)\"");?></TD></TR>
<TR><TD>State:<BR></TD>
<?
	if ($_POST['country']){
		$state_array = $state_values[ $_POST['country'] ];
	}
	if (!$state_array){
		$state_array = $state_values;
	}
?>
	<TD><? WriteCombo($state_array, "state", $_POST['state'], 0);?></TD></TR>
<TR><TD>Postal Code:<BR></TD>
	<TD><input type=text name=zipcode size=40 maxLength=40 value="<?=htmlspecialchars($_POST['zipcode'])?>"></TD></TR>
<TR><TD>Phone:<BR></TD>
	<TD><input type=text name=phone size=40 maxLength=40 value="<?=htmlspecialchars($_POST['phone'])?>"></TD></TR>
<TR><TD>Fax:<BR></TD>
	<TD><input type=text name=fax size=40 maxLength=40 value="<?=htmlspecialchars($_POST['fax'])?>"></TD></TR>
<TR><TD>Your profile:<BR>
	<DIV class=small>(Optional)</DIV>
	<TD><TEXTAREA cols=50 rows=8 name=profile><?=htmlspecialchars($_POST['profile'])?></TEXTAREA>
<? if ($use_images) { ?>
<TR><TD>Upload your logo:<BR>
      <DIV class=small>(Optional; JPG of size <?=$image_x?>x<?=$image_y?>)</DIV></TD>
  <TD><INPUT type=file name=logo>
  <? if (file_exists($att_path.$data->username.".jpg")) echo "&nbsp; <input type=checkbox class=checkbox name=delimg value=1> Delete logo (<a href='",str_replace('.', '/epay', str_replace('\\', '/', $att_path)).$data->username.".jpg","' target=_blank>See current</a>)"; ?>
  </TD>
<? } ?>
<TR><TH colspan=2 class=submit><INPUT type=submit class=button name=edit value='Change info >>'></TH></TR>
  <?=$id_post?>
</FORM>
</TABLE>
</CENTER>

<?
}
?>
