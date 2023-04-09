<?php
	$file = "stats";
	if(!($fp = fopen($file , "r"))) 
		die ("Could not open the requested file!  You may need to CHMOD 777 it!");
	$count = trim(fgets($fp));
	$selection = trim(fgets($fp));
	
	fclose($fp);
if(!isset($_POST['submit'])){
// Welcome Message
print '<h2>Tizag Counter Install Guide</h2>';
print '<p><b>NOTE:</b> Before you attempt to install the counter, please be sure that you have'.
		'CHMOD 777 the file "stats" that is located in the same directory as this file</p>';
print '<p>If you do not CHMOD then this counter will not work properly</p>';

?>

<table border=1>
<tr>
<td colspan="2">
<form action="<?php echo $PHP_SELF; ?>" method="post">
Starting Value for Counter
</td>
<td><input type="text" name="init" value="<?php echo $count ?>"></td>
</tr>
<tr>
<td colspan="2">
Copy & Paste this code onto your web page
</td>
<td><input type="text" name="nothing" value="&lt;?php counter.php ?&gt;"></td>
<td></td>
</tr>
<tr>
<td align="center" colspan="3"><b>Choose Counter Style Below</b></td>
</tr>
<?php

$d = opendir('images') or die($php_errormsg);
while (false !==($f = readdir($d))){
 	if (is_dir ("images/$f") && $f !="." && $f !=".." ){
		print '<tr>';
		print '<td><b>'.$f.'</b></td>'."\n";
		if($f == $selection)
			print '<td><input type="radio" name="selection" value="'.$f.'" checked> </td>';
		else
			print '<td><input type="radio" name="selection" value="'.$f.'"> </td>';
		print '<td>';
		$e = opendir("images/".$f) or die($php_errormsg);
		for($i = 0; $i < 10; $i++){
			print '<img src=images/'.$f.'/'.$i.'.gif />';
		}
		print '</td>';
 	}
}
?>

<tr>

<td colspan="3">
<input type="submit" value="Install / Update" name="submit"> </form></td>
</tr>
</table>



<?php
// Instructions to  chmod or to use a mysql database

// Radio button selections

// Automatically display all counter images in the images folder

// Form submission will 

}else{
	print 'Thank you for your update';
	$selection = $_POST['selection'];
	$init = $_POST['init'];
	$file = "stats";
	if(!($fp = fopen($file , "w"))) 
		die ("Could not open the requested file!  You may need to CHMOD 777 it!");
	fwrite($fp, $init);
	fwrite($fp, "\n");
	fwrite($fp, $selection);
	fclose($fp);
}
?>