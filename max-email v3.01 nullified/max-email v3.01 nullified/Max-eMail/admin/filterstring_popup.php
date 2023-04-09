<HTML>
<TITLE>Filter String Builder</TITLE>
<HEAD>
<style type="text/css">
   .inputfields{border-style:box;border-width:1;font-size:12;background-color:#FFFFF4}
   .admintext{font-size:12; text-decoration:none; color:black}
</style>
</HEAD>
<BODY bgcolor="#B0C0D0">
<CENTER>


<script language="JavaScript">

	function AddFilter(){
			document.FilterString.finished.value=document.FilterString.finished.value+document.FilterString.relation.value+document.FilterString.Field.value+document.FilterString.Condition.value+document.FilterString.Equals.value;
	}

	function InsertFilter(){
		window.opener.document.MemberSearch.FilterString.value=document.FilterString.finished.value;
	}
	
	function InsertFilterClose(){
		window.opener.document.MemberSearch.FilterString.value=document.FilterString.finished.value;
		window.close();
	}
	
</script>

<?

include "../config.inc.php";

echo '<form name="FilterString"><span class="admintext">

<B>:: Your filter string ::</B><P>
<input name="finished" type=text size=80 class="inputfields">
<P>
<input type="button" value="Insert Filter String" class="inputfields" onClick="InsertFilter()"> &nbsp;&nbsp; <input type="button" value="Insert Filter String and Close" class="inputfields" onClick="InsertFilterClose()">
<P>

<TABLE width="90%" cellspacing="0" cellpadding="4" bgcolor="#efefef">
 </td><td></td></tr>
<tr><td colspan="2"><span class="admintext"><B><center>:: Build a section ::</B></center></span><P></td></tr>

<tr><td width=30><span class="admintext">Relation:</td><td> <Select name="relation"class="inputfields">
<option value="">NONE</option>
<option value=" && ">AND</option>
<option value=" OR ">OR</option>
</select></td></tr>

<tr><td><span class="admintext">Where: </span></td><td><Select name="Field" class="inputfields">
<option value="">:: Basic Fields</option>
<option value="x-email">X-Email</option>
<option value="x-receiving">X-Receiving</option>
<option value="x-format">X-Format</option>
<option value="x-unique">X-Unique</option>';
$lists=mysql_query("SELECT * FROM lists");
while($l=mysql_fetch_array($lists)){
	if(CanPerformAction("view|members|".$l[ListID])){
	echo '<option value="">:: '.$l[ListName].' fields</option>';
		$fields=list_fields($l[ListID]);
			foreach($fields as $f){
				echo '<option value="'.$f.'">'.$f.'</option>';
			}
	}
}
echo '</select>
</td></tr>

<tr><td><span class="admintext">Condition: </td><td>
<select name="Condition" class="inputfields">
<option value=" == ">Equals</option>
<option value=" != ">Doesnt Equal</option>
<option value=" > ">Is greater than</option>
<option value=" < ">Is less than</option>
</select>
</td></tr>

<tr><td><span class="admintext">Value:</td><td>
 <input type=text name="Equals" class="inputfields"></td></tr>
 
<tr><td></td><td><input class="inputfields" type="button" onClick="AddFilter()" value="Add it to the filter string"></td></tr>
';



echo '</span>';





?>
</TABLE></CENTER>
</BODY>
</HTML>