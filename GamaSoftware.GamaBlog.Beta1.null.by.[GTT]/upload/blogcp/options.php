<?php
/* Nullified by GTT */
error_reporting(7);
chdir("../includes");
require("./cpglobal.php");

blogcphead();

if ($action=="add" or $action=="edit") {

	$optionid=intval($optionid);
	if ($optionid > 0) {
		$optiondata=$DB_site->query_first("SELECT * FROM blog_options WHERE id='$optionid'");
		$doaction="update";
	} else {
		$doaction="insert";
	}

	blogtablehead("Add/Modify Option","$doaction","Add a new Option or modify an existing one here.");
	bloghidden("optionid",$optionid);
	blogtextbox("Name","The name of the variable to call your template. This may not contain any spaces or odd characters.","name",$optiondata['name'],45,100);
	if($optiondata[type] != ""){
		if($optiondata[type]==1)
			$select1="selected";
		if($optiondata[type]==2)
			$select2="selected";
		if($optiondata[type]==3)
			$select3="selected";
		if($optiondata[type]==4)
			$select4="selected";
	}else{
		$selectnone="selected";
	}
	echo "<tr><td><strong>Type<br></strong><font size=\"-1\">The type of field the data is.</font></td>
			<td align=\"right\"><select name=\"type\">
			<option $selectnone>Choose a Type</option>
			<option value=\"1\" $select1>text</option>
			<option value=\"2\" $select2>textarea</option>
			<option value=\"3\" $select3>yesno</option>
			<option value=\"4\" $select4>password</option></select></td></tr>";
	if($optiondata[type]=="" || $optiondata[type]=="1")
		blogtextbox("Value","","value",$optiondata['value'],45,100);
	if($optiondata[type]=="2")
		blogtextarea("Value","","value",$optiondata['value'],45,15);
	if($optiondata[type]=="3")
		blogyesno("Value","","value",$optiondata['value']);
	if($optiondata[type]=="4")
		blogpassword("Value","","value",$optiondata['value'],45,100);
	if($optiondata[type]=="5")
		bloghidden("value",$optiondata['value']);
	blogtablefoot();

}

if ($action=="insert") {
	$DB_site->query("INSERT INTO blog_options (id,name,value,type) VALUES (NULL,'".addslashes($name)."','".addslashes($value)."','".$type."')");

	echo "Added!";
	$action="list";
}

if ($action=="update") {
	if (!$optionid) {
		echo "No option ID specified";
		exit;
	}
	if($optionid<="3"){
		$DB_site->query("UPDATE blog_options SET value='".addslashes($value)."' WHERE id='$optionid'");
	}else{
		$DB_site->query("UPDATE blog_options SET name='".addslashes($name)."',value='".addslashes($value)."',type='".$type."' WHERE id='$optionid'");
	}
	echo "Updated!<br><br>";
	$action="list";
}

if ($action=="delete") {
	if (!$optionid) {
		echo "No option ID specified";
		exit;
	}
	$DB_site->query("DELETE FROM blog_options WHERE id='$optionid'");

	echo "Deleted!<br><br>";
	$action="list";
}

if($action=="massupadate"){
	echo "This feature is not in the beta yet.";
	$action="list";
}

if ($action=="list") {
	echo "<form action=\"options.php?action=massupdate\" method=\"post\"><table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
		<tr align=\"center\" valign=\"middle\" bgcolor=\"#000000\"> 
		<td colspan=\"3\"><strong><font color=\"#FFFFFF\">Options<br>
        <font size=\"-1\">Configure the options here.</font></font></strong></td>
		</tr>";

	$alloptions=$DB_site->query("SELECT * FROM blog_options ORDER BY id LIMIT 100");
		$i=0;
	while ($option=$DB_site->fetch_array($alloptions)) {
		if($option[id]<=3){
			if($option[type]=="" || $option[type]=="1")
				blogtextbox("$option[name]","","value[$i]",$option['value'],45,100,2);
			if($option[type]=="2")
				blogtextarea("$option[name]","","value[$i]",$option['value'],45,15,2);
			if($option[type]=="3")
				blogyesno("$option[name]","","value[$i]",$option['value'],2);
			if($option[type]=="4")
				blogpassword("$option[name]","","value[$i]",$option['value'],45,100,2);
			if($option[type]=="5")
				bloghidden("value[$i]",$option['value']);
		}else{
			if($option[type]=="" || $option[type]=="1")
				blogtextbox("$option[name]","","value[$i]",$option['value'],45,100,1);
			if($option[type]=="2")
				blogtextarea("$option[name]","","value[$i]",$option['value'],45,15,1);
			if($option[type]=="3")
				blogyesno("$option[name]","","value[$i]",$option['value'],1);
			if($option[type]=="4")
				blogpassword("$option[name]","","value[$i]",$option['value'],45,100,1);
			if($option[type]=="5")
				bloghidden("value[$i]",$option['value']);
		}
		$i++;
	}
	blogtablefoot(0,1);
}


blogcpfoot();
?>
