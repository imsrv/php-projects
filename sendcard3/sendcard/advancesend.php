<?php
include ("./sendcard_setup.php");
include ("./include/".$dbfile);
include ("./include/template.inc");
include ("./functions.php");

        $time = time();
        $time = $time + 21600; // sends any cards which will be sent in the next 6 hours
	   $time .= "000";
        $sql = "SELECT * from $tbl_name where id < $time AND emailsent = 0";
echo ($sql);
		$db = New DB_Sendcard;
		$db2 = New DB_Sendcard;
        $db->query($sql);
 //               include("sendcard_setup.php");
echo ($db->num_rows() . " cards will be sent");

while($db->next_record()) {
	$image = $db->f("image");
	$caption = stripslashes($db->f("caption"));
	$bgcolor = $db->f("bgcolor");
	$to = stripslashes( $db->f("towho") ) ;
	$to_email = $db->f("to_email");
	$from = stripslashes($db->f("fromwho"));
	$from_email = $db->f("from_email");
	$message = stripslashes($db->f("message"));
	$fontface = $db->f("fontface");
	$fontcolor = $db->f("fontcolor");
	$template = $db->f("template");
	$music = $db->f("music");
	$notify = $db->f("notify");
	$des = $db->f("des");
	$img_width = $db->f("img_width");
	$img_height = $db->f("img_height");
	$applet_name = $db->f("applet_name");
	$id = $db->f("id");

	$youhavecard_subject_p = subst_placeholders($youhavecard_subject, $to[$i], $to_email[$i], $id);
	$youhavecard_p = subst_placeholders($youhavecard, $to[$i], $to_email[$i], $id);
	@mail ("$to_email", "$youhavecard_subject_p", "$youhavecard_p", "From: $from_email\r\nX-Mailer:sendcard $sc_version - PHP/" . phpversion());


        $query = "UPDATE $tbl_name SET emailsent = '1' WHERE id = ".$id;
        $db2->query($query);
        }

?>