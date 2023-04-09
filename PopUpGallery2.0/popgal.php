<?php

# PopUp! Gallery, a basic and configurable PHP script
# to display javascript pop-up picture galleries on the web.
# - By Matthew Blake (http://www.darkhighway.net)
# - Download source at http://www.darkhighway.net/PopUpGallery/
#####################################################################

echo "<!--BEGIN PopUp Gallery -->"."\n";
$i =1;
$files = array ();
$myDirectory = opendir("imgs/thumbs");
echo "\n";
echo "<table class='poptable'>"."\n";
echo "<tr>"."\n";
while ($file = readdir($myDirectory)) {

if (($file != ".") && ($file != "..") && ($file != "index.php") && !(is_dir("imgs/$file")) )
{
$files[] = $file;
if (is_int($i / $cols)) {
list($width, $height) = getimagesize("imgs/$file");   
echo "<td>";?><a href="#" onclick="popupgalimage('<?php echo $file;?>', <?php echo "$width";?>, <?php echo "$height";?>); return false"><? echo "<img src='imgs/thumbs/$file' class='popthumb' alt='$file' /></a></td>"."\n";
echo "</tr><tr>"."\n";
}
else
{
list($width, $height, $type, $attr) = getimagesize("imgs/$file");   
echo "<td>";?><a href="#" onclick="popupgalimage('<?php echo $file;?>', <?php echo "$width";?>, <?php echo "$height";?>); return false"><? echo "<img src='imgs/thumbs/$file' class='popthumb' alt='$file' /></a></td>"."\n";
}
$i++;
}
}
echo "</tr>"."\n";
echo "</table>"."\n";
echo "<!--END PopUp Gallery -->"."\n";
closedir($myDirectory);
?>