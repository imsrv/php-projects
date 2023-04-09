<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"
	"http://www.w3.org/TR/REC-html40/loose.dtd">
<HTML>
 <HEAD>
  <TITLE><?php echo $GLOBALS["CONFIG"]["fullname"]; ?> - Calendar of Events</TITLE>
<?php if( isSet( $GLOBALS["CONFIG"]["stylesheet"] ) ) {
	echo( "<LINK REL=\"stylesheet\" TYPE=\"text/css\" TITLE=\"style1\"" .
		"HREF=\"" . $GLOBALS["CONFIG"]["stylesheet"] . "\">\n" );
}
?>
 </HEAD>

 <BODY BGCOLOR="#FFFFFF" TEXT="#000066" LINK="#000099" VLINK="#0000CC">
  <CENTER>
   <TABLE WIDTH=640>
    <TR>
     <TD>
      <A HREF="<?php echo $GLOBALS["CONFIG"]["homepage"]; ?>">
       <IMG SRC="<?php echo $GLOBALS["CONFIG"]["homepage_image"]; ?>" BORDER=0 ALIGN=left
        ALT="<?php echo $GLOBALS["CONFIG"]["fullname"]; ?>">
      </A>
     </TD>

     <TD>
      <A HREF="index.php3">
       <IMG SRC="<?php echo $GLOBALS["CONFIG"]["calendar_image"] ?>" BORDER=0
        ALIGN=right ALT="Calendar">
      </A>
     </TD>
    </TR>
   </TABLE>
