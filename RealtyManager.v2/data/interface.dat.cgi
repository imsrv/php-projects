#!/usr/local/bin/perl
print "Content-type: text/plain\n\nThis is a data file.";
__END__

--- _help.html ---
<HTML><HEAD><TITLE>Help</TITLE></HEAD>
<BODY bgcolor="#FFFFFF" TEXT="#000000" LINK="#000066" VLINK="#000066" alink="#000066" onload="window.focus()">

<table border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td valign=center align=right>
   <img src="../images/help.gif" height=25 width=200 border=0 alt="Help"><br>
   <font face="verdana,arial" size=1><b>
    <a href="$cgiurl$?help_index=1">Help Index</a><br>
   </b></font>
  </td>
 </tr>
</table>

<p><font face="verdana,arial" size=2><b>$title$</b></font>
<p><font face="verdana,arial" size=1>$content$<br><br>

<!-- templatecell : row1 -->
&nbsp;&nbsp;&nbsp;-&nbsp;<a href="$cgiurl$?help=$num$">$title$</a><br>
<!-- /templatecell : row1 -->
<!-- templatecell : row2 -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;<a href="$cgiurl$?help=$num$">$title$</a><br>
<!-- /templatecell : row2 -->

</font>

<p><font face="arial" size=1><b>Realty Manager 2.0<br>
Copyright &copy; 1999 <a href="http://www.interactivetools.com/">interactivetools.com, inc.</a></b></font><br>

</body></html>
--- _homepage_edit.html ---
<input type=hidden name="num" value="$num$">

<script language="JavaScript"><!--

function showPass() { alert(document.forms[0].pw.value); }

// --></script>

   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td>
    <!-- Content Title -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor - Update Homepage</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <!-- /Content Title -->

   <table border=0 cellspacing=0 cellpadding=1 width=100%>
     <tr>
      <td><font size=2 face="arial">&nbsp;Full name </font></td>
      <td><font size=2 face="arial">$name$<font size=3>&nbsp;</font></font></td>
     </tr>
<!-- template insert : $list$ -->
<!-- templatecell : text_field -->
     <tr>
      <td><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td><input type=text name="hfield$fnum$" value="$fvalue$" size=45> </td>
     </tr>
<!-- /templatecell : text_field -->
<!-- templatecell : text_box -->
     <tr>
      <td valign=top><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td><textarea name="hfield$fnum$" cols=40 rows=4 wrap=soft>$fvalue$</textarea></td>
     </tr>
<!-- /templatecell : text_box -->
<!-- templatecell : dropdown -->
     <tr>
      <td><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td>
       <select name="hfield$fnum$">
$foptions$
       </select>
      </td>
     </tr>
<!-- /templatecell : dropdown -->
    <tr><td colspan=2><hr size=1></td></tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Preview Image&nbsp;</font></td>
      <td>
       <select name="himage0">
       <option value="">None
       $ilist0$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #1</font></td>
      <td>
       <select name="himage1">
       <option value="">None
       $ilist1$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #2</font></td>
      <td>
       <select name="himage2">
       <option value="">None
       $ilist2$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #3</font></td>
      <td>
       <select name="himage3">
       <option value="">None
       $ilist3$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #4</font></td>
      <td>
       <select name="himage4">
       <option value="">None
       $ilist4$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #5</font></td>
      <td>
       <select name="himage5">
       <option value="">None
       $ilist5$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #6</font></td>
      <td>
       <select name="himage6">
       <option value="">None
       $ilist6$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #7</font></td>
      <td>
       <select name="himage7">
       <option value="">None
       $ilist7$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #8</font></td>
      <td>
       <select name="himage8">
       <option value="">None
       $ilist8$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #9</font></td>
      <td>
       <select name="himage9">
       <option value="">None
       $ilist9$
       </select>
      </td>
     </tr>
    <tr><td colspan=2><hr size=1></td></tr>
     <tr>
      <td valign=top><font size=2 face="arial">&nbsp;Image Manager&nbsp;</font></td>
      <td>
       <select name="himage10">
       <option value="">Select Image
       $ilist10$
       </select><br>
       <input type=submit name="homepage_iview" value="   View   ">
       <input type=submit name="homepage_iviewall" value="View All">
       <input type=submit name="homepage_iedit" value=" Modify ">
       <input type=submit name="homepage_iconfirm_erase" value="  Erase  ">
       <input type=submit name="homepage_iupload_step1" value="Upload">
      </td>
     </tr>
     <tr>
    <tr><td colspan=2><hr size=1></td></tr>
</table>
</td></tr></table>


--- _homepage_iconfirm_erase.html ---

<input type=hidden name="num" value="$num$">
<input type=hidden name="file" value="$file$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor - Erase Image</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$homepage_url$/images/$file$" target="_blank"><img src="$homepage_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=1 face="ms sans serif">File Name: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Description: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$desc$</font></td>
    </tr>
   </table>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><br>
     <font size=2 face="ms sans serif">Are you sure you want to erase this image?</font>
     </td>
    </tr>
  </table>
</td></tr></table>
</td></tr></table>

--- _homepage_iedit.html ---
<input type=hidden name="num" value="$num$">
<input type=hidden name="file" value="$file$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor - Modify Image</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$homepage_url$/images/$file$" target="_blank"><img src="$homepage_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=1 face="ms sans serif">File Name: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
   </table>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td>
      <font size=1 face="ms sans serif">Short Description of Image &nbsp;<font size=3>&nbsp;</font></font><br>
      <input type=text name="desc" value="$desc$" size=40><br>
     </td>
    </tr>
  </table>
</td></tr></table>
</td></tr></table>
--- _homepage_iupload_step1.html ---
</form>
<form method=post action="$cgiurl$" enctype="multipart/form-data">
<input type=hidden name="num" value="$num$">


<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor - Upload Images</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<p>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image1" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image2" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image3" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image4" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image5" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image6" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image7" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image8" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image9" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image10" size=36></td>
    </tr>
   </table> 
</td></tr></table>

--- _homepage_iupload_step2.html ---
<input type=hidden name="num" value="$num$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor - Upload Images</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<!-- template insert : $list$ -->
<!-- templatecell : row -->
<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$homepage_url$/images/$file$" target="_blank"><img src="$homepage_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td width=30%><font size=1 face="ms sans serif">File Uploaded: &nbsp;</font></td>
     <td width=70%><font size=1 face="ms sans serif">$file_uploaded$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Saved as: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td colspan=2>
      <font size=1 face="ms sans serif">Short Description of Image &nbsp;<font size=3>&nbsp;</font></font><br>
      <input type=text name="$file$" size=40 maxlength=40><br>
     </td>
    </tr>
  </table>
</td></tr></table>
<!-- /templatecell : row -->

<!-- templatecell : invalid_format -->
<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%><img src="$image_url$/spacer.gif" width=150 height=1 border=0></td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td width=30%><font size=1 face="ms sans serif">File Uploaded: &nbsp;</font></td>
     <td width=70%><font size=1 face="ms sans serif">$file_uploaded$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Saved as: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">Not Saved</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td colspan=2>
      <font size=1 face="ms sans serif"><br>
      This image was not saved because it is in an unrecognized image format.
      Only GIF and JPEG images can be viewed over the web.
      Please convert your image to a .gif or .jpg format and try again.
      </font>
     </td>
    </tr>
  </table>
</td></tr></table>
<!-- /templatecell : invalid_format -->

<!-- templatecell : too_large -->
<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%><img src="$image_url$/spacer.gif" width=150 height=1 border=0></td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td width=30%><font size=1 face="ms sans serif">File Uploaded: &nbsp;</font></td>
     <td width=70%><font size=1 face="ms sans serif">$file_uploaded$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Saved as: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">Not Saved</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td colspan=2>
      <font size=1 face="ms sans serif"><br>
      This image was not saved because it was larger than the maximum image size of $upload_maxk$ kbytes.
      Large images can take a long time to download and are not well suited for the web.
      Please reduce the size of your image and try again.
      </font>
     </td>
    </tr>
  </table>
</td></tr></table>
<!-- /templatecell : too_large -->

</td></tr></table>
--- _homepage_iview.html ---
<input type=hidden name="num" value="$num$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor - View Image</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$homepage_url$/images/$file$" target="_blank"><img src="$homepage_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=1 face="ms sans serif">File Name: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Description: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$desc$</font></td>
    </tr>
  </table>
</td></tr></table>
</td></tr></table>

--- _homepage_iviewall.html ---
<input type=hidden name="num" value="$num$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor - View All Images</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=500>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<!-- template insert : $list$ -->
<!-- templatecell : row -->
<table border=0 cellspacing=5 cellpadding=1 width=500>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$homepage_url$/images/$file$" target="_blank"><img src="$homepage_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=1 face="ms sans serif">File Name: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Description: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$desc$</font></td>
    </tr>
  </table>
</td></tr></table>
<!-- /templatecell : row -->
</td></tr></table>
--- _homepage_list.html ---
<input type=hidden name="homepage_list" value=1>

   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor</b></font></td></tr>
    </table>
   <table border=0 width=100% cellspacing=8 cellpadding=0>
     <tr>
      <td>

       <table border=0 cellspacing=0 cellpadding=1>
        <tr>
        <td>
         <font face="ms sans serif" size=1>Search&nbsp;</font><br>
         <select name="search">
         <option value="all">All Users
         <option value="1" $search_1_selected$>New Users
         <option value="2" $search_2_selected$>Regular Users
         <option value="3" $search_3_selected$>Administrators
         <option value="4" $search_4_selected$>Superusers
         <option value="5" $search_5_selected$>Expired Users
         <option value="D" $search_D_selected$>Disabled Users
         </select>
        </td>
        <td>
         <font face="ms sans serif" size=1>for keyword</font><br>
         <input type=text name="keyword" value="$keyword$" size=15><br>
        </td>
        <td valign=bottom>&nbsp;<input type=submit name="homepage_list" value="Go"></td>
       </tr>
      </table>

     </td>
     <td align=center>
 
      <table border=0 cellspacing=0 cellpadding=1>
       <tr><td align=center><font face="ms sans serif" size=1>Found $mcount$ of $rcount$</font></td></tr>
       <tr><td align=center><font face="ms sans serif" size=1><a href="$cgiurl$?homepage_list=1&pagenum=$lpage$" title="Last Page">&lt;&lt;</a> &nbsp;Page $cpage$ of $pcount$&nbsp; <a href="$cgiurl$?homepage_list=1&pagenum=$npage$" title="Next Page">&gt;&gt;</a></font></td></tr>
      </table>
     </td>
    </tr>
   </table>

    <table border=0 cellspacing=1 cellpadding=1>
     <tr>
      <td bgcolor="#CCCCCC" width=240><font size=1 face="ms sans serif"><b>&nbsp;Full Name</b></font></td>
      <td bgcolor="#CCCCCC" width=75><font size=1 face="ms sans serif"><b>&nbsp;Access</b></font></td>
      <td bgcolor="#CCCCCC" width=75><font size=1 face="ms sans serif"><b>&nbsp;Expires</b></font></td>
      <td bgcolor="#CCCCCC" align=center width=90><font face="ms sans serif" size=1><b>Action</b></font></td>
     </tr>
<!-- template insert : $list$ -->
<!-- templatecell : disabled -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;Disabled</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=1><a href="$cgiurl$?homepage_edit=$num$">update</a></font></td>
     </tr>
<!-- /templatecell : disabled -->
<!-- templatecell : newuser -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;New User</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=1><a href="$cgiurl$?homepage_edit=$num$">update</a></font></td>
     </tr>
<!-- /templatecell : newuser -->
<!-- templatecell : regular -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;Regular</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=1><a href="$cgiurl$?homepage_edit=$num$">update</a></font></td>
     </tr>
<!-- /templatecell : regular -->
<!-- templatecell : admin -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;Administrator</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=1><a href="$cgiurl$?homepage_edit=$num$">update</a></font></td>
     </tr>
<!-- /templatecell : admin -->
<!-- templatecell : superuser -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;Superuser</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=1><a href="$cgiurl$?homepage_edit=$num$">update</a></font></td>
     </tr>
<!-- /templatecell : superuser -->
<!-- templatecell : not_found -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=2>&nbsp;Sorry, no records were found.</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=2>&nbsp;</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=2>&nbsp;</font></td>
      <td bgcolor="#EEEEEE" colspan=2><font face="ms sans serif" size=2>&nbsp;</font></td>
     </tr>
<!-- /templatecell : not_found -->
    </table>
    </td></tr></table>


<!-- templatecell : null -->
<font face="ms sans serif" size=2>
<font color="#666666">Language specific text used on this page included below in templatecells:</font><br>
<p>
<!-- /templatecell : null -->

<!-- templatecell : never -->Never<!-- /templatecell : never -->
<!-- templatecell : expired -->Expired<!-- /templatecell : expired -->
<!-- templatecell : mon1 -->Jan<!-- /templatecell : mon1 -->
<!-- templatecell : mon2 -->Feb<!-- /templatecell : mon2 -->
<!-- templatecell : mon3 -->Mar<!-- /templatecell : mon3 -->
<!-- templatecell : mon4 -->Apr<!-- /templatecell : mon4 -->
<!-- templatecell : mon5 -->May<!-- /templatecell : mon5 -->
<!-- templatecell : mon6 -->Jun<!-- /templatecell : mon6 -->
<!-- templatecell : mon7 -->Jul<!-- /templatecell : mon7 -->
<!-- templatecell : mon8 -->Aug<!-- /templatecell : mon8 -->
<!-- templatecell : mon9 -->Sep<!-- /templatecell : mon9 -->
<!-- templatecell : mon10 -->Oct<!-- /templatecell : mon10 -->
<!-- templatecell : mon11 -->Nov<!-- /templatecell : mon11 -->
<!-- templatecell : mon12 -->Dec<!-- /templatecell : mon12 -->

--- _homepage_saved.html ---
<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Editor</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=0 cellpadding=2 width=100%><tr><td align=center>

  <font face="arial" size=2><br><br><br>
    Homepage has been saved<br>
   </font><br><br>

</td></tr></table>
</td></tr></table>
--- _install_rm.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=390><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->

   <font face="ms sans serif, arial" size=2>

   <br>You must run the installation program (install.cgi) before you can continue.
<br><Br>

   </font>
   <!-- /content -->
   </td></tr></table>

  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>

--- _install_step1.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Welcome to Realty Manager 2.0!</b></font>

   <font face="ms sans serif, arial" size=2>

   <p>Realty Manager 2.0 is your complete solution for managing real estate listings
   on your website.  Whether your a single realtor, a realty agency or a internet realty
   network, Realty Manager gives you the tools you need to succeed on the internet.

   <p>This program will guide you through the setup process.
   When you're ready to begin, click <b>Next</b> at the bottom of the page.<br><br>


   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <input type=submit name="" value=" &lt;&lt; Back " disabled>
    <input type=submit name="step2" value=" Next &gt;&gt; "><br>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>

--- _install_step2.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Check File and Directory Permissions</b></font>

   <font face="ms sans serif, arial" size=2>

   <p>In order for Realty Manager to work correctly the program has to have access to
   read and write it's files and directories on the server.  
   Check the following list and make sure everything is "OK".

   <p><table border=0 cellspacing=1 cellpadding=2 width=100%>
    <tr>
     <td bgcolor="#CCCCCC" width=210><font face="ms sans serif,arial" size=2><b>Directory/File</b></font></td>
     <td bgcolor="#CCCCCC"><font face="ms sans serif,arial" size=2><b>Status</b></font></td>
    </tr>
<!-- template insert : $list$ -->
<!-- templatecell : ok -->
    <tr>
     <td bgcolor="#EEEEEE" valign=top><font face="ms sans serif,arial" size=1>$file$</font></td>
     <td bgcolor="#EEEEEE"><font face="ms sans serif,arial" size=1><b>OK</b></font></td>
    </tr>
<!-- /templatecell : ok -->
<!-- templatecell : error -->
    <tr>
     <td bgcolor="#EEEEEE" valign=top><font face="ms sans serif,arial" size=1>$file$</font></td>
     <td bgcolor="#EEEEEE"><font face="ms sans serif,arial" color="#FF0000" size=1><b>$error$</b></font></td>
    </tr>
<!-- /templatecell : error -->
   </table>

   <p>If all files and directories are listed as OK click Next to continue, otherwise
   correct any problems and click <b>Reload</b> to check again.<br><br>


   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr>
      <td><input type=submit name="step2" value="  Reload  "></td>
      <td align=right>
       <input type=submit name="step1" value=" &lt;&lt; Back ">
       <input type=submit name="step3" value=" Next &gt;&gt; "><br>
      </td>
     </tr>
    </table>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>




<!-- templatecell : dir_noexist -->Directory hasn't been created.<br><!-- /templatecell : dir_noexist -->
<!-- templatecell : dir_noread -->Directory isn't readable.<br><!-- /templatecell : dir_noread -->
<!-- templatecell : dir_nowrite -->Directory isn't writable.<br><!-- /templatecell : dir_nowrite -->
<!-- templatecell : dir_noexec -->Directory isn't executable.<br><!-- /templatecell : dir_noexec -->

<!-- templatecell : file_noexist -->File hasn't been uploaded.<br><!-- /templatecell : file_noexist -->
<!-- templatecell : file_noread -->File isn't readable.<br><!-- /templatecell : file_noread -->
<!-- templatecell : file_nowrite -->File isn't writable.<br><!-- /templatecell : file_nowrite -->
<!-- templatecell : file_noexec -->File isn't executable.<br><!-- /templatecell : file_noexec -->


--- _install_step3.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Enter License Information</b></font>

   <font face="ms sans serif, arial" size=2>

   <p>Please enter your company name, the domain name of the website Realty Manager
   will be used on, and the Product ID that came with your software. 

<center>
<!-- template insert : <p>$error$ -->
</center>

   <p><table border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td><font face="tahoma,ms sans serif" size=2>Company Name&nbsp;&nbsp;</font></td>
  <td><input type=text name="company_name" value="$company_name$" size=30></td>
 </tr>
 <tr>
  <td><font face="tahoma,ms sans serif" size=2>Domain Name&nbsp;</font></td>
  <td><input type=text name="domain_name" value="$domain_name$" size=30></td>
 </tr>
 <tr>
  <td><font face="tahoma,ms sans serif" size=2>Product ID&nbsp;</font></td>
  <td><input type=text name="product_id" value="$product_id$" size=30></td>
 </tr>
</table>

<p><font size=1> <b>IMPORTANT NOTICE:</b> Realty Manager is 
licensed for installation and usage on a single website and web 
server. Installing this program on more than one web server, more than 
one website or multiple times on the same website is prohibited unless 
additional licenses are purchased for each installation.  Using or 
allowing your Product ID to be used to install Realty Manager on more 
than one website or web server is a violation of your license 
agreement.  For information on purchasing additional licenses contact 
your vendor. </font>

<p>Once you have entered your license information, click <b>Next</b> to continue.

   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr>
      <td align=right>
       <input type=submit name="step2" value=" &lt;&lt; Back ">
       <input type=submit name="step3_save" value=" Next &gt;&gt; "><br>
      </td>
     </tr>
    </table>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>


<!-- templatecell : no_company -->
<font face="tahoma,ms sans serif" size=2 color="#FF0000">Please enter Company Name!</font><br>
<!-- /templatecell : no_company -->

<!-- templatecell : no_domain -->
<font face="tahoma,ms sans serif" size=2 color="#FF0000">Please enter Domain Name!</font><br>
<!-- /templatecell : no_domain -->

<!-- templatecell : no_product_id -->
<font face="tahoma,ms sans serif" size=2 color="#FF0000">Please enter Product ID!</font><br>
<!-- /templatecell : no_product_id -->

<!-- templatecell : invalid_product_id -->
<font face="tahoma,ms sans serif" size=2 color="#FF0000">Invalid Product ID!</font><br>
<!-- /templatecell : invalid_product_id -->
--- _install_step4.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Setup Image Directory</b></font>

   <font face="ms sans serif, arial" size=2>

<p><table border=0 cellspacing=0 cellpadding=0 align=right>
 <tr><td><a href="../images/sample_image.jpg" target="_blank"><img src="$image_url$/sample_image.jpg" width=139 height=92 border=1 alt="Sample Image"></a></td></tr>
</table>

<p>The image directory is the directory on your server where program
images are stored.  The image URL is the internet URL
(or relative URL) of that directory.

<p>If the image directory and URL are setup correctly you should be 
able to see a picture of a house in the upper right hand corner of the 
page.  If you can't see the picture create a new directory on your 
website named /rm_images/ and re-upload all the program images there 
(don't forget to upload images in binary format!).

<p><font face="tahoma,ms sans serif" size=2>Image URL (example: ../images or http://www.website.com/rm_images)</font><br>
<input type=text name="image_url" value="$image_url$" size=50><br>

<p>
   <font face="ms sans serif, arial" size=2>
   <p>If you can see a picture of a house, click <b>Next</b> to continue, otherwise,
   create a new image directory, change the image URL and click <b>Reload</b> to try again.<br>
   </font>

   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr>
      <td><input type=submit name="step4" value="  Reload  "></td>
      <td align=right>
       <input type=submit name="step3" value=" &lt;&lt; Back ">
       <input type=submit name="step4_save" value=" Next &gt;&gt; "><br>
      </td>
     </tr>
    </table>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>


--- _install_step5.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Setup Listings Directory</b></font>

   <font face="ms sans serif, arial" size=2>

   <p>The listings directory is the directory on your server where HTML files 
will be automatically created and updated for each listing. You can create this 
directory now or specify an existing directory.  

<p>Make sure that whatever directory you specify has a subdirectory named 
"images" for the listing images and that both the listings directory and the 
images directory have read and write permissions.

<center>
<p><font face="tahoma,ms sans serif" size=2 color="#FF0000">$error$</font>
</center>

<p><font face="tahoma,ms sans serif" size=2><b>CGI Directory</b> &nbsp; This is the directory this program is in (no changes required). </font><br>
<input type=text name="" value="$cgidir$" size=50 readonly><br>

<p><font face="tahoma,ms sans serif" size=2>
<b>Listings Directory</b> &nbsp; (example: ../listings or ../../../listings)<br>
The directory path is relative from the CGI directory and is usually one of the two examples above.</font><br>
<input type=text name="listing_dir" value="$listing_dir$" size=50><br>

<p><font face="tahoma,ms sans serif" size=2>
<b>Listings URL</b> &nbsp; (example: http://www.website.com/listings)<br>
The is the website address of the listings directory.</font><br>

<input type=text name="listing_url" value="$listing_url$" size=50><br>


<p>Once you have entered the information, click <b>Next</b> to continue.

   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr>
      <td align=right>
       <input type=submit name="step4" value=" &lt;&lt; Back ">
       <input type=submit name="step5_save" value=" Next &gt;&gt; "><br>
      </td>
     </tr>
    </table>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>


<!-- templatecell : dir_noexist -->Error: Can't find $listing_dir$.<br>You must create the listings directory before you can continue.<br><!-- /templatecell : dir_noexist -->
<!-- templatecell : dir_noread -->Error: $listing_dir$ isn't readable.<br>You must change the directory permissions before you can continue.<br><!-- /templatecell : dir_noread -->
<!-- templatecell : dir_nowrite -->Error: $listing_dir$ isn't writable.<br>You must change the directory permissions before you can continue.<br><!-- /templatecell : dir_nowrite -->
<!-- templatecell : idir_noexist -->Error: Can't find $listing_dir$/images.<br>You must create an /images subdirectory before you can continue.<br><!-- /templatecell : idir_noexist -->
<!-- templatecell : idir_noread -->Error: $listing_dir$/images isn't readable.<br>You must change the directory permissions before you can continue.<br><!-- /templatecell : idir_noread -->
<!-- templatecell : idir_nowrite -->Error: $listing_dir$/images isn't writable.<br>You must change the directory permissions before you can continue.<br><!-- /templatecell : idir_nowrite -->

--- _install_step6.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Setup Homepages Directory</b></font>

   <font face="ms sans serif, arial" size=2>

   <p>The homepages directory is the directory on your server where HTML files 
will be automatically created and updated for each users homepage.  You can create this 
directory now or specify an existing directory.  

<p>Make sure that whatever directory you specify has a subdirectory 
"images" for the homepage images and that both the homepage directory and the 
images directory have read and write permissions.

<center>
<p><font face="tahoma,ms sans serif" size=2 color="#FF0000">$error$</font>
</center>

<p><font face="tahoma,ms sans serif" size=2><b>CGI Directory</b> &nbsp; This is the directory this program is in (no changes required). </font><br>
<input type=text name="" value="$cgidir$" size=50 readonly><br>

<p><font face="tahoma,ms sans serif" size=2>
<b>Homepage Directory</b> &nbsp; (example: ../homepages or ../../../homepages)<br>
The directory path is relative from the CGI directory and is usually one of the two examples above.</font><br>
<input type=text name="homepage_dir" value="$homepage_dir$" size=50><br>

<p><font face="tahoma,ms sans serif" size=2>
<b>Homepage URL</b> &nbsp; (example: http://www.website.com/homepages)<br>
The is the website address of the homepages directory.</font><br>

<input type=text name="homepage_url" value="$homepage_url$" size=50><br>


<p>Once you have entered the information, click <b>Next</b> to continue.

   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr>
      <td align=right>
       <input type=submit name="step5" value=" &lt;&lt; Back ">
       <input type=submit name="step6_save" value=" Next &gt;&gt; "><br>
      </td>
     </tr>
    </table>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>



<!-- templatecell : dir_noexist -->Error: Can't find $homepage_dir$.<br>You must create the homepages directory before you can continue.<br><!-- /templatecell : dir_noexist -->
<!-- templatecell : dir_noread -->Error: $homepage_dir$ isn't readable.<br>You must change the directory permissions before you can continue.<br><!-- /templatecell : dir_noread -->
<!-- templatecell : dir_nowrite -->Error: $homepage_dir$ isn't writable.<br>You must change the directory permissions before you can continue.<br><!-- /templatecell : dir_nowrite -->
<!-- templatecell : idir_noexist -->Error: Can't find $homepage_dir$/images.<br>You must create an /images subdirectory before you can continue.<br><!-- /templatecell : idir_noexist -->
<!-- templatecell : idir_noread -->Error: $homepage_dir$/images isn't readable.<br>You must change the directory permissions before you can continue.<br><!-- /templatecell : idir_noread -->
<!-- templatecell : idir_nowrite -->Error: $homepage_dir$/images isn't writable.<br>You must change the directory permissions before you can continue.<br><!-- /templatecell : idir_nowrite -->



--- _install_step7.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Setup Search Engine URL</b></font>

   <font face="ms sans serif, arial" size=2>

   <p>The search engine URL is the website address of Realty Manager's search engine.

<p><font face="tahoma,ms sans serif" size=2>
<b>Search Engine URL</b> &nbsp; (example: http://www.website.com/rm/exec/search.cgi)</font><br>
<input type=text name="search_url" value="$search_url$" size=50><br>


<p>Once you have entered the information, click <b>Next</b> to continue.

   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr>
      <td align=right>
       <input type=submit name="step6" value=" &lt;&lt; Back ">
       <input type=submit name="step7_save" value=" Next &gt;&gt; "><br>
      </td>
     </tr>
    </table>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>


--- _install_step8.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Upgrade from Realty Manager 1.0</b></font>

   <font face="ms sans serif, arial" size=2>

   <p>If you are upgrading from Realty Manager 1.0 and want to use your previously
entered data you need to tell us where your RM1 data files are.  If your installing
Realty Manager for the first time or you don't want to upgrade your old version just
just click Next.

<!-- template insert : $error$ -->
<!-- templatecell : not_found -->
<p><font face="tahoma,ms sans serif" size=2 color="#FF0000">Error : Couldn't find RM1 data files in specified directory!</font>
<!-- /templatecell : not_found -->
<!-- templatecell : no_exist -->
<p><font face="tahoma,ms sans serif" size=2 color="#FF0000">Error : Specified directory doesn't exist!</font>
<!-- /templatecell : no_exist -->

<p><b>Are you upgrading from Realty Manager 1.0?</b><br>
<input type="radio" name="upgrading" value="1" $upgrading_1_checked$> Yes
<input type="radio" name="upgrading" value="0" $upgrading_0_checked$> No<br>

<p><font face="tahoma,ms sans serif" size=2><b>CGI Directory</b> &nbsp; This is the directory this program is in (no changes required). </font><br>
<input type=text name="" value="$cgidir$" size=50 readonly><br>

<p><font face="tahoma,ms sans serif" size=2>
<b>Realty Manager 1.0 Data Directory</b> &nbsp; (Example: ../data)<br>
Enter the relative directory path from the CGI directory.</font><br>
<input type=text name="rm1data" value="$rm1data$" size=50><br>


<p>Click <b>Next</b> to continue.

   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr>
      <td align=right>
       <input type=submit name="step7" value=" &lt;&lt; Back ">
       <input type=submit name="step8_upgrade" value=" Next &gt;&gt; "><br>
      </td>
     </tr>
    </table>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>


--- _install_step9.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>Welcome to Realty Manager 2.0</title>
 <meta name="robots" content="noindex,nofollow">
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="rm.cgi">
<div align=center>

<table border=0 cellspacing=0 cellpadding=0 width=490><tr><td bgcolor="#000000">
<table border=0 cellspacing=1 cellpadding=3 width=100%>
 <tr>
  <td bgcolor="#0066CC" align=center>
   <font face="ms sans serif, arial" color="#FFFFFF" size=2><b>Realty Manager 2.0 Installation</b></font><br>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF">
   <table border=0 cellspacing=0 cellpadding=8 width=100%><tr><td>
   <!-- content -->
   <font face="ms sans serif, arial" size=3><b>Congratulations</b></font>

   <font face="ms sans serif, arial" size=2>

<p>Congratulations, you have successfully installed Realty Manager 2.0. 

<p>You are now ready to login and start setting up your Realty website! When you 
login for the first time use the username "<b>RM</b>" and password "<b>welcome</b>".
Be sure to change your password to something only you will know after you've logged
in. 

Now your ready to get started...




<p>Click <b>Finish</b> to login.

   </font>
   <!-- /content -->
   </td></tr></table>
   <!-- buttons -->
   <table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td align=right>
    <hr size=1>
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr>
      <td align=right>
       <input type=submit name="" value="   Finish   "><br>
      </td>
     </tr>
    </table>
   </td></tr></table>
   <!-- /buttons -->
  </td>
 </tr>
</table>
</td></tr></table>

</div>
</form>
</body>
</html>


--- _listing_add.html ---
<input type=hidden name="num" value="$num$">

<script language="JavaScript"><!--

function showPass() { alert(document.forms[0].pw.value); }

// --></script>

   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td>
    <!-- Content Title -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - Add Listing</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <!-- /Content Title -->

   <table border=0 cellspacing=0 cellpadding=1 width=100%>
<!-- template insert : $listedby$ -->
<!-- templatecell : listedby_cuser -->
     <tr>
      <td><font size=2 face="arial">&nbsp;Listed by </font></td>
      <td><font size=2 face="arial">$owner$ </font></td>
     </tr>
<!-- /templatecell : listedby_cuser -->
<!-- templatecell : listedby_select -->
     <tr>
      <td><font size=2 face="arial">&nbsp;Listed by </font></td>
      <td>
       <select name="owner">
       $listedby_list$
       </select>
      </td>
     </tr>
<!-- /templatecell : listedby_select -->

<!-- template insert : $list$ -->

<!-- templatecell : text_field -->
     <tr>
      <td><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td><input type=text name="lfield$fnum$" value="$fvalue$" size=45> </td>
     </tr>
<!-- /templatecell : text_field -->
<!-- templatecell : text_box -->
     <tr>
      <td valign=top><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td><textarea name="lfield$fnum$" cols=40 rows=4 wrap=soft>$fvalue$</textarea></td>
     </tr>
<!-- /templatecell : text_box -->
<!-- templatecell : dropdown -->
     <tr>
      <td><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td>
       <select name="lfield$fnum$">
$foptions$
       </select>
      </td>
     </tr>
<!-- /templatecell : dropdown -->
    <tr><td colspan=2><hr size=1></td></tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Preview Image&nbsp;</font></td>
      <td>
       <select name="limage0">
       <option value="">None
       $ilist0$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #1</font></td>
      <td>
       <select name="limage1">
       <option value="">None
       $ilist1$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #2</font></td>
      <td>
       <select name="limage2">
       <option value="">None
       $ilist2$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #3</font></td>
      <td>
       <select name="limage3">
       <option value="">None
       $ilist3$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #4</font></td>
      <td>
       <select name="limage4">
       <option value="">None
       $ilist4$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #5</font></td>
      <td>
       <select name="limage5">
       <option value="">None
       $ilist5$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #6</font></td>
      <td>
       <select name="limage6">
       <option value="">None
       $ilist6$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #7</font></td>
      <td>
       <select name="limage7">
       <option value="">None
       $ilist7$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #8</font></td>
      <td>
       <select name="limage8">
       <option value="">None
       $ilist8$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #9</font></td>
      <td>
       <select name="limage9">
       <option value="">None
       $ilist9$
       </select>
      </td>
     </tr>
    <tr><td colspan=2><hr size=1></td></tr>
     <tr>
      <td valign=top><font size=2 face="arial">&nbsp;Image Manager&nbsp;</font></td>
      <td>
       <select name="limage10">
       <option value="">Select Image
       $ilist10$
       </select><br>
       <input type=submit name="listing_iview" value="   View   ">
       <input type=submit name="listing_iviewall" value="View All">
       <input type=submit name="listing_iedit" value=" Modify ">
       <input type=submit name="listing_iconfirm_erase" value="  Erase  ">
       <input type=submit name="listing_iupload_step1" value="Upload">
      </td>
     </tr>
     <tr>
    <tr><td colspan=2><hr size=1></td></tr>
</table>
</td></tr></table>


--- _listing_confirm_erase.html ---

<input type=hidden name="num" value="$num$">
<input type=hidden name="confirm" value="1">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - Erase Listing</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

  <font face="arial" size=2><br><br>
    Are you sure you want to erase this listing?<br>
    $lfield1$<br>
   </font><br><br>

</td></tr></table>

--- _listing_edit.html ---
<input type=hidden name="num" value="$num$">

<script language="JavaScript"><!--

function showPass() { alert(document.forms[0].pw.value); }

// --></script>

   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td>
    <!-- Content Title -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - Edit Listing</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <!-- /Content Title -->

   <table border=0 cellspacing=0 cellpadding=1 width=100%>
<!-- template insert : $listedby$ -->
<!-- templatecell : listedby_cuser -->
     <tr>
      <td><font size=2 face="arial">&nbsp;Listed by </font></td>
      <td><font size=2 face="arial">$owner$ </font></td>
     </tr>
<!-- /templatecell : listedby_cuser -->
<!-- templatecell : listedby_select -->
     <tr>
      <td><font size=2 face="arial">&nbsp;Listed by </font></td>
      <td>
       <select name="owner">
       $listedby_list$
       </select>
      </td>
     </tr>
<!-- /templatecell : listedby_select -->

<!-- template insert : $list$ -->

<!-- templatecell : text_field -->
     <tr>
      <td><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td><input type=text name="lfield$fnum$" value="$fvalue$" size=45> </td>
     </tr>
<!-- /templatecell : text_field -->
<!-- templatecell : text_box -->
     <tr>
      <td valign=top><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td><textarea name="lfield$fnum$" cols=40 rows=4 wrap=soft>$fvalue$</textarea></td>
     </tr>
<!-- /templatecell : text_box -->
<!-- templatecell : dropdown -->
     <tr>
      <td><font size=2 face="arial">&nbsp;$fname$ </font></td>
      <td>
       <select name="lfield$fnum$">
$foptions$
       </select>
      </td>
     </tr>
<!-- /templatecell : dropdown -->
    <tr><td colspan=2><hr size=1></td></tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Preview Image&nbsp;</font></td>
      <td>
       <select name="limage0">
       <option value="">None
       $ilist0$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #1</font></td>
      <td>
       <select name="limage1">
       <option value="">None
       $ilist1$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #2</font></td>
      <td>
       <select name="limage2">
       <option value="">None
       $ilist2$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #3</font></td>
      <td>
       <select name="limage3">
       <option value="">None
       $ilist3$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #4</font></td>
      <td>
       <select name="limage4">
       <option value="">None
       $ilist4$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #5</font></td>
      <td>
       <select name="limage5">
       <option value="">None
       $ilist5$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #6</font></td>
      <td>
       <select name="limage6">
       <option value="">None
       $ilist6$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #7</font></td>
      <td>
       <select name="limage7">
       <option value="">None
       $ilist7$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #8</font></td>
      <td>
       <select name="limage8">
       <option value="">None
       $ilist8$
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="arial">&nbsp;Image #9</font></td>
      <td>
       <select name="limage9">
       <option value="">None
       $ilist9$
       </select>
      </td>
     </tr>
    <tr><td colspan=2><hr size=1></td></tr>
     <tr>
      <td valign=top><font size=2 face="arial">&nbsp;Image Manager&nbsp;</font></td>
      <td>
       <select name="limage10">
       <option value="">Select Image
       $ilist10$
       </select><br>
       <input type=submit name="listing_iview" value="   View   ">
       <input type=submit name="listing_iviewall" value="View All">
       <input type=submit name="listing_iedit" value=" Modify ">
       <input type=submit name="listing_iconfirm_erase" value="  Erase  ">
       <input type=submit name="listing_iupload_step1" value="Upload">
      </td>
     </tr>
     <tr>
    <tr><td colspan=2><hr size=1></td></tr>
</table>
</td></tr></table>


--- _listing_erased.html ---
<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - Erase Listing</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

  <font face="arial" size=2><br><br><br>
    Listing has been erased.<br>
   </font><br><br>

</td></tr></table>

--- _listing_iconfirm_erase.html ---
<input type=hidden name="num" value="$num$">
<input type=hidden name="file" value="$file$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - Erase Image</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$listing_url$/images/$file$" target="_blank"><img src="$listing_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=1 face="ms sans serif">File Name: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Description: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$desc$</font></td>
    </tr>
   </table>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><br>
     <font size=2 face="ms sans serif">Are you sure you want to erase this image?</font>
     </td>
    </tr>
  </table>
</td></tr></table>
</td></tr></table>

--- _listing_iedit.html ---
<input type=hidden name="num" value="$num$">
<input type=hidden name="file" value="$file$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - Modify Image</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$listing_url$/images/$file$" target="_blank"><img src="$listing_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=1 face="ms sans serif">File Name: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
   </table>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td>
      <font size=1 face="ms sans serif">Short Description of Image &nbsp;<font size=3>&nbsp;</font></font><br>
      <input type=text name="desc" value="$desc$" size=40><br>
     </td>
    </tr>
  </table>
</td></tr></table>
</td></tr></table>
--- _listing_iupload_step1.html ---
</form>
<form method=post action="$cgiurl$" enctype="multipart/form-data">
<input type=hidden name="num" value="$num$">


<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - Upload Images</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<p>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image1" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image2" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image3" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image4" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image5" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image6" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image7" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image8" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image9" size=36></td>
    </tr>
    <tr>
     <td><font size=2 face="arial">&nbsp;Select&nbsp;Image&nbsp;</font></td>
     <td><input type=file name="image10" size=36></td>
    </tr>
   </table> 
</td></tr></table>

--- _listing_iupload_step2.html ---
<input type=hidden name="num" value="$num$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - Upload Images</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<!-- template insert : $list$ -->
<!-- templatecell : row -->
<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$listing_url$/images/$file$" target="_blank"><img src="$listing_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td width=30%><font size=1 face="ms sans serif">File Uploaded: &nbsp;</font></td>
     <td width=70%><font size=1 face="ms sans serif">$file_uploaded$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Saved as: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td colspan=2>
      <font size=1 face="ms sans serif">Short Description of Image &nbsp;<font size=3>&nbsp;</font></font><br>
      <input type=text name="$file$" size=40><br>
     </td>
    </tr>
  </table>
</td></tr></table>
<!-- /templatecell : row -->


<!-- templatecell : invalid_format -->
<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%><img src="$image_url$/spacer.gif" width=150 height=1 border=0></td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td width=30%><font size=1 face="ms sans serif">File Uploaded: &nbsp;</font></td>
     <td width=70%><font size=1 face="ms sans serif">$file_uploaded$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Saved as: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">Not Saved</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td colspan=2>
      <font size=1 face="ms sans serif"><br>
      This image was not saved because it is in an unrecognized image format.
      Only GIF and JPEG images can be viewed over the web.
      Please convert your image to a .gif or .jpg format and try again.
      </font>
     </td>
    </tr>
  </table>
</td></tr></table>
<!-- /templatecell : invalid_format -->

<!-- templatecell : too_large -->
<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%><img src="$image_url$/spacer.gif" width=150 height=1 border=0></td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td width=30%><font size=1 face="ms sans serif">File Uploaded: &nbsp;</font></td>
     <td width=70%><font size=1 face="ms sans serif">$file_uploaded$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">Saved as: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">Not Saved</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td colspan=2>
      <font size=1 face="ms sans serif"><br>
      This image was not saved because it was larger than the maximum image size of $upload_maxk$ kbytes.
      Large images can take a long time to download and are not well suited for the web.
      Please reduce the size of your image and try again.
      </font>
     </td>
    </tr>
  </table>
</td></tr></table>
<!-- /templatecell : too_large -->

</td></tr></table>
--- _listing_iview.html ---
<input type=hidden name="num" value="$num$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - View Image</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<table border=0 cellspacing=5 cellpadding=1 width=100%>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$listing_url$/images/$file$" target="_blank"><img src="$listing_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=1 face="ms sans serif">File Name: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td valign=top><font size=1 face="ms sans serif">Description: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$desc$</font></td>
    </tr>
  </table>
</td></tr></table>
</td></tr></table>

--- _listing_iviewall.html ---
<input type=hidden name="num" value="$num$">

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor - View All Images</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=5 cellpadding=1 width=500>
 <tr>
  <td align=center width=1%>
   <img src="$image_url$/spacer.gif" width=150 height=1 border=0><br>
   <font face="ms sans serif" size=2>Click photo to enlarge</font><br>
  </td>
  <td></td>
 </tr>
</table>

<!-- template insert : $list$ -->
<!-- templatecell : row -->
<table border=0 cellspacing=5 cellpadding=1 width=500>
 <tr>
  <td valign=top width=1%>

   <table border=1 cellspacing=0 cellpadding=0>
    <tr>
     <td><a href="$listing_url$/images/$file$" target="_blank"><img src="$listing_url$/images/$file$" width=150 border=0></a></td>
    </tr>
   </table>

  </td>
  <td valign=top>
   <table border=0 cellspacing=0 cellpadding=1>
    <tr>
     <td><font size=1 face="ms sans serif">File Name: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$file$</font></td>
    </tr>
    <tr>
     <td><font size=1 face="ms sans serif">File Size: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$size$ bytes</font></td>
    </tr>
    <tr>
     <td valign=top><font size=1 face="ms sans serif">Description: &nbsp;</font></td>
     <td><font size=1 face="ms sans serif">$desc$</font></td>
    </tr>
  </table>
</td></tr></table>
<!-- /templatecell : row -->
</td></tr></table>
--- _listing_list.html ---
<input type=hidden name="listing_list" value=1>

   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor</b></font></td></tr>
    </table>
   <table border=0 width=100% cellspacing=8 cellpadding=0>
     <tr>
      <td>

       <table border=0 cellspacing=0 cellpadding=1>
        <tr>
        <td>
         <font face="ms sans serif" size=1>Search&nbsp;</font><br>
         <select name="search">
         <option value="all">All Listings
<!-- templatecell : listedby -->
         <option value="lby" $search_lby_selected$>Listings listed by
<!-- /templatecell : listedby -->
         $search_options$
         </select>
        </td>
        <td>
         <font face="ms sans serif" size=1>for keyword</font><br>
         <input type=text name="keyword" value="$keyword$" size=15><br>
        </td>
        <td valign=bottom>&nbsp;<input type=submit name="listing_list" value="Go"></td>
       </tr>
      </table>

     </td>
     <td align=center>
 
      <table border=0 cellspacing=0 cellpadding=1>
       <tr><td align=center><font face="ms sans serif" size=1>Found $mcount$ of $rcount$</font></td></tr>
       <tr><td align=center><font face="ms sans serif" size=1><a href="$cgiurl$?listing_list=1&pagenum=$lpage$" title="Last Page">&lt;&lt;</a> &nbsp;Page $cpage$ of $pcount$&nbsp; <a href="$cgiurl$?listing_list=1&pagenum=$npage$" title="Next Page">&gt;&gt;</a></font></td></tr>
      </table>
     </td>
    </tr>
   </table>

    <!-- insert error message here -->
    <center>
<!-- template insert : $error$ -->
<!-- templatecell : exceeded_listing_limit -->
      <font face="ms sans serif" size=2 color="#FF0000"><b>Sorry, your account has a maximum limit of $max$ listings.</b></font><br><br>
<!-- /templatecell : exceeded_listing_limit -->
    </center>



    <table border=0 cellspacing=1 cellpadding=1>
<!-- template insert : $list$ -->
<!-- template insert : $list2$ -->
<!-- templatecell : header -->
     <tr>
      <td bgcolor="#CCCCCC" width=255><font size=1 face="ms sans serif"><b>&nbsp;$lfield1_name$</b></font></td>
      <td bgcolor="#CCCCCC" width=135><font size=1 face="ms sans serif"><b>&nbsp;Listed by</b></font></td>
      <td bgcolor="#CCCCCC" align=center width=90 colspan=2><font face="ms sans serif" size=1><b>Action</b></font></td>
     </tr>
<!-- /templatecell : header -->
<!-- templatecell : row -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$lfield1$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$owner$</font></td>
      <td bgcolor="#EEEEEE" align=center width=45><font face="ms sans serif" size=1><a href="$cgiurl$?listing_edit=$num$">modify</a></font></td>
      <td bgcolor="#EEEEEE" align=center width=45><font face="ms sans serif" size=1><a href="$cgiurl$?listing_confirm_erase=$num$">erase</a></font></td>
     </tr>
<!-- /templatecell : row -->

<!-- templatecell : header2 -->
     <tr>
      <td bgcolor="#CCCCCC" colspan=2 width=390><font size=1 face="ms sans serif"><b>&nbsp;$lfield1_name$</b></font></td>
      <td bgcolor="#CCCCCC" align=center width=90 colspan=2><font face="ms sans serif" size=1><b>Action</b></font></td>
     </tr>
<!-- /templatecell : header2 -->
<!-- templatecell : row2 -->
     <tr>
      <td bgcolor="#EEEEEE" colspan=2><font face="ms sans serif" size=1>&nbsp;$lfield1$</font></td>
      <td bgcolor="#EEEEEE" align=center width=45><font face="ms sans serif" size=1><a href="$cgiurl$?listing_edit=$num$">modify</a></font></td>
      <td bgcolor="#EEEEEE" align=center width=45><font face="ms sans serif" size=1><a href="$cgiurl$?listing_confirm_erase=$num$">erase</a></font></td>
     </tr>
<!-- /templatecell : row2 -->
<!-- templatecell : not_found -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=2>&nbsp;Sorry, no records were found.</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=2>&nbsp;</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=2>&nbsp;</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=2>&nbsp;</font></td>
     </tr>
<!-- /templatecell : not_found -->
    </table>
    </td></tr></table>

--- _listing_saved.html ---
<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Editor</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

<table border=0 cellspacing=0 cellpadding=2 width=100%><tr><td align=center>

  <font face="arial" size=2><br><br><br>
    Listing has been saved<br>
   </font><br><br>

</td></tr></table>
</td></tr></table>
--- _rm_about.html ---
<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td>

<p><table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr>
  <td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Welcome to Realty Manager v2.0</b></font></td>
 </tr>
</table>
<font size=2 face="ms sans serif"><br>

<p>Welcome to Realty Manager 2.0!  Realty Manager makes it simple and 
easy to update and manage realty listings online. This is the start page,  your 
starting point when you login.  You can return to this page at any time by 
clicking on the e logo in the upper left hand corner of the screen.  Here is
your current account information:



<p><table border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td><font size=2 face="ms sans serif">Your Name&nbsp;</font></td>
  <td><font size=2 face="ms sans serif">:&nbsp;$name$</font></td>
 </tr>
 <tr>
  <td><font size=2 face="ms sans serif">Access Level&nbsp;</font></td>
  <td><font size=2 face="ms sans serif">:&nbsp;$access$</font></td>
 </tr>
 <tr>
  <td><font size=2 face="ms sans serif">Expiry Date&nbsp;</font></td>
  <td><font size=2 face="ms sans serif">:&nbsp;$expires$</font></td>
 </tr>
 <tr>
  <td><font size=2 face="ms sans serif">Maximum listings&nbsp;</font></td>
  <td><font size=2 face="ms sans serif">:&nbsp;$listings$</font></td>
 </tr>
 <tr>
  <td><font size=2 face="ms sans serif">Homepage Listed&nbsp;</font></td>
  <td><font size=2 face="ms sans serif">:&nbsp;$displayed$</font></td>
 </tr>
 <tr>
  <td><font size=2 face="ms sans serif">Homepage URL&nbsp;</font></td>
  <td><font size=1 face="ms sans serif">:&nbsp;<a href="$homepage$" target="_blank">$homepage$</a></font></td>
 </tr>
</table>

<p>If at any time while using the program your not sure what to do you can 
always click on the (<b>?</b>) icon in the upper right hand corner of the screen 
and a help window will popup with information about the page you are currently 
on.

    </font>
  </td></tr></table>


<!-- templatecell : never -->Never expires<!-- /templatecell : never -->

<!-- templatecell : mon1 -->Jan<!-- /templatecell : mon1 -->
<!-- templatecell : mon2 -->Feb<!-- /templatecell : mon2 -->
<!-- templatecell : mon3 -->Mar<!-- /templatecell : mon3 -->
<!-- templatecell : mon4 -->Apr<!-- /templatecell : mon4 -->
<!-- templatecell : mon5 -->May<!-- /templatecell : mon5 -->
<!-- templatecell : mon6 -->Jun<!-- /templatecell : mon6 -->
<!-- templatecell : mon7 -->Jul<!-- /templatecell : mon7 -->
<!-- templatecell : mon8 -->Aug<!-- /templatecell : mon8 -->
<!-- templatecell : mon9 -->Sep<!-- /templatecell : mon9 -->
<!-- templatecell : mon10 -->Oct<!-- /templatecell : mon10 -->
<!-- templatecell : mon11 -->Nov<!-- /templatecell : mon11 -->
<!-- templatecell : mon12 -->Dec<!-- /templatecell : mon12 -->

<!-- templatecell : access2 -->Regular<!-- /templatecell : access2 -->
<!-- templatecell : access3 -->Administrator<!-- /templatecell : access3 -->
<!-- templatecell : access4 -->Superuser<!-- /templatecell : access4 -->


<!-- templatecell : unlimited -->Unlimited<!-- /templatecell : unlimited -->


<!-- templatecell : yes -->Yes<!-- /templatecell : yes -->
<!-- templatecell : no -->No<!-- /templatecell : no -->


--- _rm_error.html ---
<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td>

<p><table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr>
  <td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Program Error</b></font></td>
 </tr>
</table>
<font size=2 face="ms sans serif"><br>

<p>$error$<br><br><br><br>

    </font>
  </td></tr></table>


--- _rm_login.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>$titlebar$</title>
 <meta name="robots" content="noindex,nofollow">
 <style type="text/css">
  <!--
  a               { text-decoration: none; }
  a:hover         { text-decoration: underline; }
  .menubar        { text-decoration: none; color: #000000; font-size:9pt;  }
  .menubar:hover  { text-decoration: none; color: #0000CC; }
  .menubar:active { text-decoration: none; color: #0000CC; }
  -->
</style>
<script language="Javascript"><!--

function Help(num) {		// Popup a help window
  var win1 = window.open("$cgiurl$?help="+num,"HelpWin","width=240,height=350,toolbar=no,resizable=yes,scrollbars=yes,directories=no");
  }

//--></script>
</head>
<body bgcolor="#003366" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<input type=hidden name="login" value=1>
<center>



<table border="0" cellpadding="0" cellspacing="0" width="404">
  <tr><!-- row 01 -->
   <td rowspan="3" width=1><img src="$image_url$/spacer.gif" width="1" height="1" border="0"></td>
   <td rowspan="2" colspan="1" width=67><img src="$image_url$/splash_nw.gif" width="67" height="44" border="0"></td>
   <td rowspan="1" colspan="1" width=6><img src="$image_url$/splash_nnw.gif" width="6" height="26" border="0"></td>
   <td rowspan="1" colspan="1" width=324>

    <!-- title bar -->
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
     <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
     <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
     <tr>
      <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
       <table border=0 cellspacing=0 cellpadding=0 width=100%>
        <tr>
         <!-- title bar text -->
         <td><font face="MS Sans Serif" color="#FFFFFF" size=1><b>$titlebar$</b></font></td>
         <!-- title bar buttons (?)(X) -->
         <td align=right><img src="$image_url$/window_buttons.gif" height=18 width=34 border=0 alt="" usemap="#buttons" ismap></td>
         <map name="buttons">
       <area shape="circle" coords="8,9,8"  href="javascript:Help(2)" onfocus="blur();" title="Click for Help">
       <area shape="circle" coords="26,9,8" href="$cgiurl$?logoff=1"	  onfocus="blur();" title="Logoff Program">
         <AREA SHAPE="DEFAULT" NOHREF>
         </map>
        </tr>
       </table>
      </td>
     </tr>
     <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
     <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
     <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
    </table>
    <!-- /title bar -->

    </td>
   <td rowspan="1" colspan="1" width=6><img src="$image_url$/splash_ne.gif" width="6" height="26" border="0"></td>
   <td><img src="$image_url$/spacer.gif" width="1" height="26" border="0"></td>
  </tr>
  <tr>
   <!-- splash image -->
   <td rowspan="2" colspan="2" bgcolor="#FFFFFF" valign=top><img src="$image_url$/splash_image.jpg" width="329" height="120" border="0"></td>
   <td rowspan="3" colspan="1" valign=top>

    <!-- right border -->
    <table border=0 cellspacing=0 cellpadding=0 height=120>
    <tr>
     <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
     <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
    </tr>
   </table>
   <!-- /right border -->

  </td>
  <td><img src="$image_url$/spacer.gif" width="1" height="18" border="0"></td>
 </tr>
 <tr>
  <td rowspan="1" colspan="1" valign=top>

   <!-- left nav bar -->
   <table border=0 cellspacing=0 cellpadding=0 height=102>
    <tr>
     <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
     <td bgcolor="#003399" width=59><img src="$image_url$/spacer.gif" height=1 width=59 border=0 alt=""></td>
     <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
     <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
    </tr>
   </table>
   <!-- /left nav bar -->

  </td>
  <td><img src="$image_url$/spacer.gif" width="1" height="1" border="0"></td>
 </tr>
</table>

<!-- CONTENT TABLE -->

<table border="0" cellpadding="0" cellspacing="0" width=402>
 <tr>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#003399" width=59><img src="$image_url$/spacer.gif" height=1 width=59 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=517>
   <!-- START CONTENT -->

<br>
<center>

   <table border=0 cellspacing=0 cellpadding=0>
    <tr>
     <td><font face="ms sans serif,arial" size=2>Username: &nbsp;&nbsp;&nbsp;</font></td>
     <td><input type=text name="id" value="$id$" size=20></td>
    </tr>
    <tr>
     <td><font face="ms sans serif,arial" size=2>Password: &nbsp;&nbsp;&nbsp;</font></td>
     <td><input type=password name="pw" value="$pw$" size=20></td>
    </tr>
   </table><br>

</center>


   <!-- END CONTENT -->
  </td>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
 </tr>
</table>


<!-- FOOTER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=402>
 <tr>
  <!-- footer image left -->
  <td rowspan=13 width=73>
   <table border=0 cellspacing=0 cellpadding=0>
    <tr><td bgcolor="#003399"><img src="$image_url$/window_sw.gif" width="73" height="6" border="0"></td></tr>
    <tr><td><img src="$image_url$/window_sw2.gif" width="73" height="40" border="0"></td></tr>
   </table>
  </td>
  <td bgcolor="#FFFFFF" width=511 height=20 valign=top>
   <table border=0 cellspacing=0 cellpadding=0 width="100%">
    <tr>
     <!-- footer buttons (left aligned) -->
     <td align="left"><!--
  --></td>
     <!-- footer buttons (right aligned) -->
     <td align="right"><!--
  --><input type=image name="login" src="$image_url$/button_login.gif" height=16 width=77 border=0 alt="Save">&nbsp;<!--
  --><input type=image name="login_about" src="$image_url$/button_about.gif" height=16 width=77 border=0 alt="About">&nbsp;<!--
  --></td>
    </tr>
   </table>
  </td>
  <!-- footer image right -->
  <td rowspan=13 width=6><img src="$image_url$/window_se.gif" width="6" height="46" border="0"></td>
 </tr>
 <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
 <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
 <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
 <!-- footer text -->
 <tr>
  <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
   <table border=0 cellspacing=0 cellpadding=0 width=100%>
    <tr>
     <!-- left text -->
     <td><font face="MS Sans Serif" color="#FFFFFF" size=1></font></td>
     <!-- right text -->
     <td align=right><font face="MS Sans Serif" color="#FFFFFF" size=1>$footerbar$&nbsp;</font></td>
    </tr>
   </table>
  </td>
 </tr>
 <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
 <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
 <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
</table>

</form>
</body>
</html>


<!-- templatecell : session_expired --><b>Login Session Expired</b><!-- /templatecell : session_expired -->
<!-- templatecell : no_username --><b>Please enter username</b><!-- /templatecell : no_username -->
<!-- templatecell : no_password --><b>Please enter password</b><!-- /templatecell : no_password -->
<!-- templatecell : invalid_username --><b>Invalid Username</b><!-- /templatecell : invalid_username -->
<!-- templatecell : invalid_password --><b>Invalid Password</b><!-- /templatecell : invalid_password -->
<!-- templatecell : disabled --><b>Your account has been disabled</b><!-- /templatecell : disabled -->
<!-- templatecell : newuser --><b>You account hasn't been validated yet</b><!-- /templatecell : newuser -->
<!-- templatecell : expired --><b>Your account has expired</b><!-- /templatecell : expired -->
--- _rm_login_about.html ---
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>$titlebar$</title>
 <meta name="robots" content="noindex,nofollow">
 <style type="text/css">
  <!--
  a               { text-decoration: none; }
  a:hover         { text-decoration: underline; }
  .menubar        { text-decoration: none; color: #000000; font-size:9pt;  }
  .menubar:hover  { text-decoration: none; color: #0000CC; }
  .menubar:active { text-decoration: none; color: #0000CC; }
  -->
</style>
<script language="Javascript"><!--

function Help(num) {		// Popup a help window
  var win1 = window.open("$cgiurl$?help="+num,"HelpWin","width=240,height=350,toolbar=no,resizable=yes,scrollbars=yes,directories=no");
  }

//--></script>
</head>
<body bgcolor="#003366" text="#000000" link="#0000CC" vlink="#0000CC" alink="#0000CC" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<center>


<table border="0" cellpadding="0" cellspacing="0" width="404">
  <tr><!-- row 01 -->
   <td rowspan="3" width=1><img src="$image_url$/spacer.gif" width="1" height="1" border="0"></td>
   <td rowspan="2" colspan="1" width=67><img src="$image_url$/splash_nw.gif" width="67" height="44" border="0"></td>
   <td rowspan="1" colspan="1" width=6><img src="$image_url$/splash_nnw.gif" width="6" height="26" border="0"></td>
   <td rowspan="1" colspan="1" width=324>

    <!-- title bar -->
    <table border=0 cellspacing=0 cellpadding=0 width=100%>
     <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
     <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
     <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
     <tr>
      <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
       <table border=0 cellspacing=0 cellpadding=0 width=100%>
        <tr>
         <!-- title bar text -->
         <td><font face="MS Sans Serif" color="#FFFFFF" size=1><b>$titlebar$</b></font></td>
         <!-- title bar buttons (?)(X) -->
         <td align=right><img src="$image_url$/window_buttons.gif" height=18 width=34 border=0 alt="" usemap="#buttons" ismap></td>
         <map name="buttons">
       <area shape="circle" coords="8,9,8"  href="javascript:Help(3)" onfocus="blur();" title="Click for Help">
       <area shape="circle" coords="26,9,8" href="$cgiurl$?logoff=1"	  onfocus="blur();" title="Logoff Program">
         <AREA SHAPE="DEFAULT" NOHREF>
         </map>
        </tr>
       </table>
      </td>
     </tr>
     <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
     <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
     <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
    </table>
    <!-- /title bar -->

    </td>
   <td rowspan="1" colspan="1" width=6><img src="$image_url$/splash_ne.gif" width="6" height="26" border="0"></td>
   <td><img src="$image_url$/spacer.gif" width="1" height="26" border="0"></td>
  </tr>
  <tr>
   <!-- splash image -->
   <td rowspan="2" colspan="2" bgcolor="#FFFFFF" valign=top><img src="$image_url$/splash_image_blank.gif" width="329" height="18" border="0"></td>
   <td rowspan="3" colspan="1" valign=top>

    <!-- right border -->
    <table border=0 cellspacing=0 cellpadding=0 height=18>
    <tr>
     <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
     <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
     <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
    </tr>
   </table>
   <!-- /right border -->

  </td>
  <td><img src="$image_url$/spacer.gif" width="1" height="18" border="0"></td>
 </tr>
</table>

<!-- CONTENT TABLE -->

<table border="0" cellpadding="0" cellspacing="0" width=402>
 <tr>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#003399" width=59><img src="$image_url$/spacer.gif" height=1 width=59 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=329>
   <!-- START CONTENT -->

   <table border=0 cellspacing=0 cellpadding=0>
    <tr>
     <td width=8><font size=1>&nbsp;</font></td>
     <td>
      <font face="tahoma, ms sans serif" size=1>
      <font size=2><b>Realty Manager v2.00</b></font><br><br>

      Copyright &copy; 1998-2000 interactivetools.com, inc. All Rights Reserved.<br>
      This program is protected by Canadian and international copyright laws
      as described in the license agreement.<br><br>

<table border=0 cellspacing=0 cellpadding=1>
 <tr><td bgcolor="#666666"><font face="tahoma, ms sans serif" color="#FFFFFF" size=1>&nbsp;This product is licensed to&nbsp;</font></td></tr>
</table><br>

$company_name$<br>
$domain_name$<br>
Product ID: $product_id$<br><br>

      Usage is subject to the terms of the <a href="#">license agreement</a>.<br><br>

      This web application is designed for version 4.0+ browsers. Please ensure
      your browser accepts cookies and javascript is enabled before logging in.<br>
      </font>
     </td>
     <td width=8><font size=1>&nbsp;</font></td>
    </tr>
   </table>



   <!-- END CONTENT -->
  </td>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
 </tr>
</table>


<!-- FOOTER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=402>
 <tr>
  <!-- footer image left -->
  <td rowspan=13 width=73>
   <table border=0 cellspacing=0 cellpadding=0>
    <tr><td bgcolor="#003399"><img src="$image_url$/window_sw.gif" width="73" height="6" border="0"></td></tr>
    <tr><td><img src="$image_url$/window_sw2.gif" width="73" height="40" border="0"></td></tr>
   </table>
  </td>
  <td bgcolor="#FFFFFF" width=511 height=20 valign=top>
   <table border=0 cellspacing=0 cellpadding=0 width="100%">
    <tr>
     <!-- footer buttons (left aligned) -->
     <td align="left"><!--
  --></td>
     <!-- footer buttons (right aligned) -->
     <td align="right"><!--
  --><input type=image name="login" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">&nbsp;<!--
  --></td>
    </tr>
   </table>
  </td>
  <!-- footer image right -->
  <td rowspan=13 width=6><img src="$image_url$/window_se.gif" width="6" height="46" border="0"></td>
 </tr>
 <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
 <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
 <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
 <!-- footer text -->
 <tr>
  <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
   <table border=0 cellspacing=0 cellpadding=0 width=100%>
    <tr>
     <!-- left text -->
     <td><font face="MS Sans Serif" color="#FFFFFF" size=1>&nbsp;</font></td>
     <!-- right text -->
     <td align=right><font face="MS Sans Serif" color="#FFFFFF" size=1>$footerbar$&nbsp;</font></td>
    </tr>
   </table>
  </td>
 </tr>
 <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
 <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
 <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
</table>

</form>
</body>
</html>

--- _setup_hfields_confirm_reset.html ---

<input type=hidden name="num" value="$num$">


<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

 <!-- Content Title -->
 <p><table border=0 width=100% cellspacing=0 cellpadding=2>
  <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Database Fields - Reset Field</b></font></td></tr>
 </table>
 <font size=1><br></font>
 <!-- /Content Title -->

  <font face="arial" size=2><br><br>
    Are you sure you want to reset this field?<br>
    $name$<p>

    <table border=0 cellspacing=0 cellpadding=0 width=400><tr><td>
    <font face="arial" color="#FF0000" size=2><b>Warning:</b></font>
    <font face="arial" size=2>
    You should only do this if you want to completely remove a field and erase
    the field data stored for each listing.  The database will need to be
    re-published to update any HTML files.
    </font></td></tr>
    </table>

   </font><br><br>

</td></tr></table>

--- _setup_hfields_edit.html ---
   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td>

    <!-- license information -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Database Fields</b></font></td></tr>
    </table>
    <font size=1><br></font>

   <table border=0 cellspacing=0 cellpadding=0>
     <tr>
      <td align=center width=40><font size=1 face="arial">Field Num</font></td>
      <td align=center width=240><font size=1 face="arial"><b>Field Name</b></font></td>
      <td align=center width=110><font size=1 face="arial"><b>Field Type</b></font></td>
      <td align=center width=50><font size=1 face="arial"><b>Active<br>Field</b></font></td>
<!--      <td align=center width=50><font size=1 face="arial"><b>Reset<br>Field</b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">1</font></td>
      <td><input type=text name="hfield1_name" value="$hfield1_name$" size=30> </td>
      <td align=center>
       <select name="hfield1_type">
       <option value="">
       <option value="1" $hfield1_type_1_selected$>text field
       <option value="2" $hfield1_type_2_selected$>text box
       <option value="3" $hfield1_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield1_active" value="1" $hfield1_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=1">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">2</font></td>
      <td><input type=text name="hfield2_name" value="$hfield2_name$" size=30> </td>
      <td align=center>
       <select name="hfield2_type">
       <option value="">
       <option value="1" $hfield2_type_1_selected$>text field
       <option value="2" $hfield2_type_2_selected$>text box
       <option value="3" $hfield2_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield2_active" value="1" $hfield2_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=2">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">3</font></td>
      <td><input type=text name="hfield3_name" value="$hfield3_name$" size=30> </td>
      <td align=center>
       <select name="hfield3_type">
       <option value="">
       <option value="1" $hfield3_type_1_selected$>text field
       <option value="2" $hfield3_type_2_selected$>text box
       <option value="3" $hfield3_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield3_active" value="1" $hfield3_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=3">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">4</font></td>
      <td><input type=text name="hfield4_name" value="$hfield4_name$" size=30> </td>
      <td align=center>
       <select name="hfield4_type">
       <option value="">
       <option value="1" $hfield4_type_1_selected$>text field
       <option value="2" $hfield4_type_2_selected$>text box
       <option value="3" $hfield4_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield4_active" value="1" $hfield4_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=4">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">5</font></td>
      <td><input type=text name="hfield5_name" value="$hfield5_name$" size=30> </td>
      <td align=center>
       <select name="hfield5_type">
       <option value="">
       <option value="1" $hfield5_type_1_selected$>text field
       <option value="2" $hfield5_type_2_selected$>text box
       <option value="3" $hfield5_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield5_active" value="1" $hfield5_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=5">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">6</font></td>
      <td><input type=text name="hfield6_name" value="$hfield6_name$" size=30> </td>
      <td align=center>
       <select name="hfield6_type">
       <option value="">
       <option value="1" $hfield6_type_1_selected$>text field
       <option value="2" $hfield6_type_2_selected$>text box
       <option value="3" $hfield6_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield6_active" value="1" $hfield6_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=6">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">7</font></td>
      <td><input type=text name="hfield7_name" value="$hfield7_name$" size=30> </td>
      <td align=center>
       <select name="hfield7_type">
       <option value="">
       <option value="1" $hfield7_type_1_selected$>text field
       <option value="2" $hfield7_type_2_selected$>text box
       <option value="3" $hfield7_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield7_active" value="1" $hfield7_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=7">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">8</font></td>
      <td><input type=text name="hfield8_name" value="$hfield8_name$" size=30> </td>
      <td align=center>
       <select name="hfield8_type">
       <option value="">
       <option value="1" $hfield8_type_1_selected$>text field
       <option value="2" $hfield8_type_2_selected$>text box
       <option value="3" $hfield8_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield8_active" value="1" $hfield8_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=8">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">9</font></td>
      <td><input type=text name="hfield9_name" value="$hfield9_name$" size=30> </td>
      <td align=center>
       <select name="hfield9_type">
       <option value="">
       <option value="1" $hfield9_type_1_selected$>text field
       <option value="2" $hfield9_type_2_selected$>text box
       <option value="3" $hfield9_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield9_active" value="1" $hfield9_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=9">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">10</font></td>
      <td><input type=text name="hfield10_name" value="$hfield10_name$" size=30> </td>
      <td align=center>
       <select name="hfield10_type">
       <option value="">
       <option value="1" $hfield10_type_1_selected$>text field
       <option value="2" $hfield10_type_2_selected$>text box
       <option value="3" $hfield10_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield10_active" value="1" $hfield10_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=10">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">11</font></td>
      <td><input type=text name="hfield11_name" value="$hfield11_name$" size=30> </td>
      <td align=center>
       <select name="hfield11_type">
       <option value="">
       <option value="1" $hfield11_type_1_selected$>text field
       <option value="2" $hfield11_type_2_selected$>text box
       <option value="3" $hfield11_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield11_active" value="1" $hfield11_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=11">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">12</font></td>
      <td><input type=text name="hfield12_name" value="$hfield12_name$" size=30> </td>
      <td align=center>
       <select name="hfield12_type">
       <option value="">
       <option value="1" $hfield12_type_1_selected$>text field
       <option value="2" $hfield12_type_2_selected$>text box
       <option value="3" $hfield12_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield12_active" value="1" $hfield12_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=12">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">13</font></td>
      <td><input type=text name="hfield13_name" value="$hfield13_name$" size=30> </td>
      <td align=center>
       <select name="hfield13_type">
       <option value="">
       <option value="1" $hfield13_type_1_selected$>text field
       <option value="2" $hfield13_type_2_selected$>text box
       <option value="3" $hfield13_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield13_active" value="1" $hfield13_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=13">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">14</font></td>
      <td><input type=text name="hfield14_name" value="$hfield14_name$" size=30> </td>
      <td align=center>
       <select name="hfield14_type">
       <option value="">
       <option value="1" $hfield14_type_1_selected$>text field
       <option value="2" $hfield14_type_2_selected$>text box
       <option value="3" $hfield14_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield14_active" value="1" $hfield14_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=14">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">15</font></td>
      <td><input type=text name="hfield15_name" value="$hfield15_name$" size=30> </td>
      <td align=center>
       <select name="hfield15_type">
       <option value="">
       <option value="1" $hfield15_type_1_selected$>text field
       <option value="2" $hfield15_type_2_selected$>text box
       <option value="3" $hfield15_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield15_active" value="1" $hfield15_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=15">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">16</font></td>
      <td><input type=text name="hfield16_name" value="$hfield16_name$" size=30> </td>
      <td align=center>
       <select name="hfield16_type">
       <option value="">
       <option value="1" $hfield16_type_1_selected$>text field
       <option value="2" $hfield16_type_2_selected$>text box
       <option value="3" $hfield16_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield16_active" value="1" $hfield16_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=16">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">17</font></td>
      <td><input type=text name="hfield17_name" value="$hfield17_name$" size=30> </td>
      <td align=center>
       <select name="hfield17_type">
       <option value="">
       <option value="1" $hfield17_type_1_selected$>text field
       <option value="2" $hfield17_type_2_selected$>text box
       <option value="3" $hfield17_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield17_active" value="1" $hfield17_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=17">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">18</font></td>
      <td><input type=text name="hfield18_name" value="$hfield18_name$" size=30> </td>
      <td align=center>
       <select name="hfield18_type">
       <option value="">
       <option value="1" $hfield18_type_1_selected$>text field
       <option value="2" $hfield18_type_2_selected$>text box
       <option value="3" $hfield18_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield18_active" value="1" $hfield18_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=18">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">19</font></td>
      <td><input type=text name="hfield19_name" value="$hfield19_name$" size=30> </td>
      <td align=center>
       <select name="hfield19_type">
       <option value="">
       <option value="1" $hfield19_type_1_selected$>text field
       <option value="2" $hfield19_type_2_selected$>text box
       <option value="3" $hfield19_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield19_active" value="1" $hfield19_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=19">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">20</font></td>
      <td><input type=text name="hfield20_name" value="$hfield20_name$" size=30> </td>
      <td align=center>
       <select name="hfield20_type">
       <option value="">
       <option value="1" $hfield20_type_1_selected$>text field
       <option value="2" $hfield20_type_2_selected$>text box
       <option value="3" $hfield20_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield20_active" value="1" $hfield20_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=20">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">21</font></td>
      <td><input type=text name="hfield21_name" value="$hfield21_name$" size=30> </td>
      <td align=center>
       <select name="hfield21_type">
       <option value="">
       <option value="1" $hfield21_type_1_selected$>text field
       <option value="2" $hfield21_type_2_selected$>text box
       <option value="3" $hfield21_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield21_active" value="1" $hfield21_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=21">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">22</font></td>
      <td><input type=text name="hfield22_name" value="$hfield22_name$" size=30> </td>
      <td align=center>
       <select name="hfield22_type">
       <option value="">
       <option value="1" $hfield22_type_1_selected$>text field
       <option value="2" $hfield22_type_2_selected$>text box
       <option value="3" $hfield22_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield22_active" value="1" $hfield22_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=22">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">23</font></td>
      <td><input type=text name="hfield23_name" value="$hfield23_name$" size=30> </td>
      <td align=center>
       <select name="hfield23_type">
       <option value="">
       <option value="1" $hfield23_type_1_selected$>text field
       <option value="2" $hfield23_type_2_selected$>text box
       <option value="3" $hfield23_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield23_active" value="1" $hfield23_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=23">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">24</font></td>
      <td><input type=text name="hfield24_name" value="$hfield24_name$" size=30> </td>
      <td align=center>
       <select name="hfield24_type">
       <option value="">
       <option value="1" $hfield24_type_1_selected$>text field
       <option value="2" $hfield24_type_2_selected$>text box
       <option value="3" $hfield24_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield24_active" value="1" $hfield24_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=24">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">25</font></td>
      <td><input type=text name="hfield25_name" value="$hfield25_name$" size=30> </td>
      <td align=center>
       <select name="hfield25_type">
       <option value="">
       <option value="1" $hfield25_type_1_selected$>text field
       <option value="2" $hfield25_type_2_selected$>text box
       <option value="3" $hfield25_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield25_active" value="1" $hfield25_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=25">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">26</font></td>
      <td><input type=text name="hfield26_name" value="$hfield26_name$" size=30> </td>
      <td align=center>
       <select name="hfield26_type">
       <option value="">
       <option value="1" $hfield26_type_1_selected$>text field
       <option value="2" $hfield26_type_2_selected$>text box
       <option value="3" $hfield26_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield26_active" value="1" $hfield26_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=26">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">27</font></td>
      <td><input type=text name="hfield27_name" value="$hfield27_name$" size=30> </td>
      <td align=center>
       <select name="hfield27_type">
       <option value="">
       <option value="1" $hfield27_type_1_selected$>text field
       <option value="2" $hfield27_type_2_selected$>text box
       <option value="3" $hfield27_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield27_active" value="1" $hfield27_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=27">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">28</font></td>
      <td><input type=text name="hfield28_name" value="$hfield28_name$" size=30> </td>
      <td align=center>
       <select name="hfield28_type">
       <option value="">
       <option value="1" $hfield28_type_1_selected$>text field
       <option value="2" $hfield28_type_2_selected$>text box
       <option value="3" $hfield28_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield28_active" value="1" $hfield28_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=28">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">29</font></td>
      <td><input type=text name="hfield29_name" value="$hfield29_name$" size=30> </td>
      <td align=center>
       <select name="hfield29_type">
       <option value="">
       <option value="1" $hfield29_type_1_selected$>text field
       <option value="2" $hfield29_type_2_selected$>text box
       <option value="3" $hfield29_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield29_active" value="1" $hfield29_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=29">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">30</font></td>
      <td><input type=text name="hfield30_name" value="$hfield30_name$" size=30> </td>
      <td align=center>
       <select name="hfield30_type">
       <option value="">
       <option value="1" $hfield30_type_1_selected$>text field
       <option value="2" $hfield30_type_2_selected$>text box
       <option value="3" $hfield30_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield30_active" value="1" $hfield30_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=30">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">31</font></td>
      <td><input type=text name="hfield31_name" value="$hfield31_name$" size=30> </td>
      <td align=center>
       <select name="hfield31_type">
       <option value="">
       <option value="1" $hfield31_type_1_selected$>text field
       <option value="2" $hfield31_type_2_selected$>text box
       <option value="3" $hfield31_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield31_active" value="1" $hfield31_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=31">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">32</font></td>
      <td><input type=text name="hfield32_name" value="$hfield32_name$" size=30> </td>
      <td align=center>
       <select name="hfield32_type">
       <option value="">
       <option value="1" $hfield32_type_1_selected$>text field
       <option value="2" $hfield32_type_2_selected$>text box
       <option value="3" $hfield32_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield32_active" value="1" $hfield32_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=32">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">33</font></td>
      <td><input type=text name="hfield33_name" value="$hfield33_name$" size=30> </td>
      <td align=center>
       <select name="hfield33_type">
       <option value="">
       <option value="1" $hfield33_type_1_selected$>text field
       <option value="2" $hfield33_type_2_selected$>text box
       <option value="3" $hfield33_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield33_active" value="1" $hfield33_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=33">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">34</font></td>
      <td><input type=text name="hfield34_name" value="$hfield34_name$" size=30> </td>
      <td align=center>
       <select name="hfield34_type">
       <option value="">
       <option value="1" $hfield34_type_1_selected$>text field
       <option value="2" $hfield34_type_2_selected$>text box
       <option value="3" $hfield34_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield34_active" value="1" $hfield34_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=34">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">35</font></td>
      <td><input type=text name="hfield35_name" value="$hfield35_name$" size=30> </td>
      <td align=center>
       <select name="hfield35_type">
       <option value="">
       <option value="1" $hfield35_type_1_selected$>text field
       <option value="2" $hfield35_type_2_selected$>text box
       <option value="3" $hfield35_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield35_active" value="1" $hfield35_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=35">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">36</font></td>
      <td><input type=text name="hfield36_name" value="$hfield36_name$" size=30> </td>
      <td align=center>
       <select name="hfield36_type">
       <option value="">
       <option value="1" $hfield36_type_1_selected$>text field
       <option value="2" $hfield36_type_2_selected$>text box
       <option value="3" $hfield36_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield36_active" value="1" $hfield36_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=36">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">37</font></td>
      <td><input type=text name="hfield37_name" value="$hfield37_name$" size=30> </td>
      <td align=center>
       <select name="hfield37_type">
       <option value="">
       <option value="1" $hfield37_type_1_selected$>text field
       <option value="2" $hfield37_type_2_selected$>text box
       <option value="3" $hfield37_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield37_active" value="1" $hfield37_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=37">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">38</font></td>
      <td><input type=text name="hfield38_name" value="$hfield38_name$" size=30> </td>
      <td align=center>
       <select name="hfield38_type">
       <option value="">
       <option value="1" $hfield38_type_1_selected$>text field
       <option value="2" $hfield38_type_2_selected$>text box
       <option value="3" $hfield38_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield38_active" value="1" $hfield38_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=38">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">39</font></td>
      <td><input type=text name="hfield39_name" value="$hfield39_name$" size=30> </td>
      <td align=center>
       <select name="hfield39_type">
       <option value="">
       <option value="1" $hfield39_type_1_selected$>text field
       <option value="2" $hfield39_type_2_selected$>text box
       <option value="3" $hfield39_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield39_active" value="1" $hfield39_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=39">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">40</font></td>
      <td><input type=text name="hfield40_name" value="$hfield40_name$" size=30> </td>
      <td align=center>
       <select name="hfield40_type">
       <option value="">
       <option value="1" $hfield40_type_1_selected$>text field
       <option value="2" $hfield40_type_2_selected$>text box
       <option value="3" $hfield40_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield40_active" value="1" $hfield40_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=40">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">41</font></td>
      <td><input type=text name="hfield41_name" value="$hfield41_name$" size=30> </td>
      <td align=center>
       <select name="hfield41_type">
       <option value="">
       <option value="1" $hfield41_type_1_selected$>text field
       <option value="2" $hfield41_type_2_selected$>text box
       <option value="3" $hfield41_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield41_active" value="1" $hfield41_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=41">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">42</font></td>
      <td><input type=text name="hfield42_name" value="$hfield42_name$" size=30> </td>
      <td align=center>
       <select name="hfield42_type">
       <option value="">
       <option value="1" $hfield42_type_1_selected$>text field
       <option value="2" $hfield42_type_2_selected$>text box
       <option value="3" $hfield42_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield42_active" value="1" $hfield42_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=42">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">43</font></td>
      <td><input type=text name="hfield43_name" value="$hfield43_name$" size=30> </td>
      <td align=center>
       <select name="hfield43_type">
       <option value="">
       <option value="1" $hfield43_type_1_selected$>text field
       <option value="2" $hfield43_type_2_selected$>text box
       <option value="3" $hfield43_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield43_active" value="1" $hfield43_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=43">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">44</font></td>
      <td><input type=text name="hfield44_name" value="$hfield44_name$" size=30> </td>
      <td align=center>
       <select name="hfield44_type">
       <option value="">
       <option value="1" $hfield44_type_1_selected$>text field
       <option value="2" $hfield44_type_2_selected$>text box
       <option value="3" $hfield44_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield44_active" value="1" $hfield44_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=44">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">45</font></td>
      <td><input type=text name="hfield45_name" value="$hfield45_name$" size=30> </td>
      <td align=center>
       <select name="hfield45_type">
       <option value="">
       <option value="1" $hfield45_type_1_selected$>text field
       <option value="2" $hfield45_type_2_selected$>text box
       <option value="3" $hfield45_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield45_active" value="1" $hfield45_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=45">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">46</font></td>
      <td><input type=text name="hfield46_name" value="$hfield46_name$" size=30> </td>
      <td align=center>
       <select name="hfield46_type">
       <option value="">
       <option value="1" $hfield46_type_1_selected$>text field
       <option value="2" $hfield46_type_2_selected$>text box
       <option value="3" $hfield46_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield46_active" value="1" $hfield46_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=46">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">47</font></td>
      <td><input type=text name="hfield47_name" value="$hfield47_name$" size=30> </td>
      <td align=center>
       <select name="hfield47_type">
       <option value="">
       <option value="1" $hfield47_type_1_selected$>text field
       <option value="2" $hfield47_type_2_selected$>text box
       <option value="3" $hfield47_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield47_active" value="1" $hfield47_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=47">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">48</font></td>
      <td><input type=text name="hfield48_name" value="$hfield48_name$" size=30> </td>
      <td align=center>
       <select name="hfield48_type">
       <option value="">
       <option value="1" $hfield48_type_1_selected$>text field
       <option value="2" $hfield48_type_2_selected$>text box
       <option value="3" $hfield48_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield48_active" value="1" $hfield48_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=48">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">49</font></td>
      <td><input type=text name="hfield49_name" value="$hfield49_name$" size=30> </td>
      <td align=center>
       <select name="hfield49_type">
       <option value="">
       <option value="1" $hfield49_type_1_selected$>text field
       <option value="2" $hfield49_type_2_selected$>text box
       <option value="3" $hfield49_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield49_active" value="1" $hfield49_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=49">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">50</font></td>
      <td><input type=text name="hfield50_name" value="$hfield50_name$" size=30> </td>
      <td align=center>
       <select name="hfield50_type">
       <option value="">
       <option value="1" $hfield50_type_1_selected$>text field
       <option value="2" $hfield50_type_2_selected$>text box
       <option value="3" $hfield50_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="hfield50_active" value="1" $hfield50_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_hfields_confirm_reset=50">Reset</a></b></font></td> -->
     </tr>
    </table> 

</td></tr></table>


--- _setup_hfields_saved.html ---
<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Homepage Database Fields</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

  <font face="arial" size=2><br><br><br>
    Homepage Fields have been saved<br>
   </font><br><br>

</td></tr></table>

--- _setup_lfields_confirm_reset.html ---

<input type=hidden name="num" value="$num$">


<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

 <!-- Content Title -->
 <p><table border=0 width=100% cellspacing=0 cellpadding=2>
  <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Database Fields - Reset Field</b></font></td></tr>
 </table>
 <font size=1><br></font>
 <!-- /Content Title -->

  <font face="arial" size=2><br><br>
    Are you sure you want to reset this field?<br>
    $name$<p>

    <table border=0 cellspacing=0 cellpadding=0 width=400><tr><td>
    <font face="arial" color="#FF0000" size=2><b>Warning:</b></font>
    <font face="arial" size=2>
    You should only do this if you want to completely remove a field and erase
    the field data stored for each listing.  The database will need to be
    re-published to update any HTML files.
    </font></td></tr>
    </table>

   </font><br><br>

</td></tr></table>

--- _setup_lfields_edit.html ---
   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td>

    <!-- license information -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Database Fields</b></font></td></tr>
    </table>
    <font size=1><br></font>

   <table border=0 cellspacing=0 cellpadding=0>
     <tr>
      <td align=center width=40><font size=1 face="arial">Field Num</font></td>
      <td align=center width=240><font size=1 face="arial"><b>Field Name</b></font></td>
      <td align=center width=110><font size=1 face="arial"><b>Field Type</b></font></td>
      <td align=center width=50><font size=1 face="arial"><b>Active<br>Field</b></font></td>
<!--      <td align=center width=50><font size=1 face="arial"><b>Reset<br>Field</b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">1</font></td>
      <td><input type=text name="lfield1_name" value="$lfield1_name$" size=30> </td>
      <td align=center>
       <select name="lfield1_type">
       <option value="">
       <option value="1" $lfield1_type_1_selected$>text field
       <option value="2" $lfield1_type_2_selected$>text box
       <option value="3" $lfield1_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield1_active" value="1" $lfield1_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=1">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">2</font></td>
      <td><input type=text name="lfield2_name" value="$lfield2_name$" size=30> </td>
      <td align=center>
       <select name="lfield2_type">
       <option value="">
       <option value="1" $lfield2_type_1_selected$>text field
       <option value="2" $lfield2_type_2_selected$>text box
       <option value="3" $lfield2_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield2_active" value="1" $lfield2_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=2">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">3</font></td>
      <td><input type=text name="lfield3_name" value="$lfield3_name$" size=30> </td>
      <td align=center>
       <select name="lfield3_type">
       <option value="">
       <option value="1" $lfield3_type_1_selected$>text field
       <option value="2" $lfield3_type_2_selected$>text box
       <option value="3" $lfield3_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield3_active" value="1" $lfield3_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=3">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">4</font></td>
      <td><input type=text name="lfield4_name" value="$lfield4_name$" size=30> </td>
      <td align=center>
       <select name="lfield4_type">
       <option value="">
       <option value="1" $lfield4_type_1_selected$>text field
       <option value="2" $lfield4_type_2_selected$>text box
       <option value="3" $lfield4_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield4_active" value="1" $lfield4_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=4">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">5</font></td>
      <td><input type=text name="lfield5_name" value="$lfield5_name$" size=30> </td>
      <td align=center>
       <select name="lfield5_type">
       <option value="">
       <option value="1" $lfield5_type_1_selected$>text field
       <option value="2" $lfield5_type_2_selected$>text box
       <option value="3" $lfield5_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield5_active" value="1" $lfield5_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=5">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">6</font></td>
      <td><input type=text name="lfield6_name" value="$lfield6_name$" size=30> </td>
      <td align=center>
       <select name="lfield6_type">
       <option value="">
       <option value="1" $lfield6_type_1_selected$>text field
       <option value="2" $lfield6_type_2_selected$>text box
       <option value="3" $lfield6_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield6_active" value="1" $lfield6_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=6">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">7</font></td>
      <td><input type=text name="lfield7_name" value="$lfield7_name$" size=30> </td>
      <td align=center>
       <select name="lfield7_type">
       <option value="">
       <option value="1" $lfield7_type_1_selected$>text field
       <option value="2" $lfield7_type_2_selected$>text box
       <option value="3" $lfield7_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield7_active" value="1" $lfield7_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=7">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">8</font></td>
      <td><input type=text name="lfield8_name" value="$lfield8_name$" size=30> </td>
      <td align=center>
       <select name="lfield8_type">
       <option value="">
       <option value="1" $lfield8_type_1_selected$>text field
       <option value="2" $lfield8_type_2_selected$>text box
       <option value="3" $lfield8_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield8_active" value="1" $lfield8_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=8">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">9</font></td>
      <td><input type=text name="lfield9_name" value="$lfield9_name$" size=30> </td>
      <td align=center>
       <select name="lfield9_type">
       <option value="">
       <option value="1" $lfield9_type_1_selected$>text field
       <option value="2" $lfield9_type_2_selected$>text box
       <option value="3" $lfield9_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield9_active" value="1" $lfield9_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=9">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">10</font></td>
      <td><input type=text name="lfield10_name" value="$lfield10_name$" size=30> </td>
      <td align=center>
       <select name="lfield10_type">
       <option value="">
       <option value="1" $lfield10_type_1_selected$>text field
       <option value="2" $lfield10_type_2_selected$>text box
       <option value="3" $lfield10_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield10_active" value="1" $lfield10_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=10">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">11</font></td>
      <td><input type=text name="lfield11_name" value="$lfield11_name$" size=30> </td>
      <td align=center>
       <select name="lfield11_type">
       <option value="">
       <option value="1" $lfield11_type_1_selected$>text field
       <option value="2" $lfield11_type_2_selected$>text box
       <option value="3" $lfield11_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield11_active" value="1" $lfield11_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=11">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">12</font></td>
      <td><input type=text name="lfield12_name" value="$lfield12_name$" size=30> </td>
      <td align=center>
       <select name="lfield12_type">
       <option value="">
       <option value="1" $lfield12_type_1_selected$>text field
       <option value="2" $lfield12_type_2_selected$>text box
       <option value="3" $lfield12_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield12_active" value="1" $lfield12_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=12">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">13</font></td>
      <td><input type=text name="lfield13_name" value="$lfield13_name$" size=30> </td>
      <td align=center>
       <select name="lfield13_type">
       <option value="">
       <option value="1" $lfield13_type_1_selected$>text field
       <option value="2" $lfield13_type_2_selected$>text box
       <option value="3" $lfield13_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield13_active" value="1" $lfield13_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=13">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">14</font></td>
      <td><input type=text name="lfield14_name" value="$lfield14_name$" size=30> </td>
      <td align=center>
       <select name="lfield14_type">
       <option value="">
       <option value="1" $lfield14_type_1_selected$>text field
       <option value="2" $lfield14_type_2_selected$>text box
       <option value="3" $lfield14_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield14_active" value="1" $lfield14_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=14">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">15</font></td>
      <td><input type=text name="lfield15_name" value="$lfield15_name$" size=30> </td>
      <td align=center>
       <select name="lfield15_type">
       <option value="">
       <option value="1" $lfield15_type_1_selected$>text field
       <option value="2" $lfield15_type_2_selected$>text box
       <option value="3" $lfield15_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield15_active" value="1" $lfield15_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=15">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">16</font></td>
      <td><input type=text name="lfield16_name" value="$lfield16_name$" size=30> </td>
      <td align=center>
       <select name="lfield16_type">
       <option value="">
       <option value="1" $lfield16_type_1_selected$>text field
       <option value="2" $lfield16_type_2_selected$>text box
       <option value="3" $lfield16_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield16_active" value="1" $lfield16_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=16">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">17</font></td>
      <td><input type=text name="lfield17_name" value="$lfield17_name$" size=30> </td>
      <td align=center>
       <select name="lfield17_type">
       <option value="">
       <option value="1" $lfield17_type_1_selected$>text field
       <option value="2" $lfield17_type_2_selected$>text box
       <option value="3" $lfield17_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield17_active" value="1" $lfield17_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=17">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">18</font></td>
      <td><input type=text name="lfield18_name" value="$lfield18_name$" size=30> </td>
      <td align=center>
       <select name="lfield18_type">
       <option value="">
       <option value="1" $lfield18_type_1_selected$>text field
       <option value="2" $lfield18_type_2_selected$>text box
       <option value="3" $lfield18_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield18_active" value="1" $lfield18_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=18">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">19</font></td>
      <td><input type=text name="lfield19_name" value="$lfield19_name$" size=30> </td>
      <td align=center>
       <select name="lfield19_type">
       <option value="">
       <option value="1" $lfield19_type_1_selected$>text field
       <option value="2" $lfield19_type_2_selected$>text box
       <option value="3" $lfield19_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield19_active" value="1" $lfield19_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=19">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">20</font></td>
      <td><input type=text name="lfield20_name" value="$lfield20_name$" size=30> </td>
      <td align=center>
       <select name="lfield20_type">
       <option value="">
       <option value="1" $lfield20_type_1_selected$>text field
       <option value="2" $lfield20_type_2_selected$>text box
       <option value="3" $lfield20_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield20_active" value="1" $lfield20_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=20">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">21</font></td>
      <td><input type=text name="lfield21_name" value="$lfield21_name$" size=30> </td>
      <td align=center>
       <select name="lfield21_type">
       <option value="">
       <option value="1" $lfield21_type_1_selected$>text field
       <option value="2" $lfield21_type_2_selected$>text box
       <option value="3" $lfield21_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield21_active" value="1" $lfield21_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=21">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">22</font></td>
      <td><input type=text name="lfield22_name" value="$lfield22_name$" size=30> </td>
      <td align=center>
       <select name="lfield22_type">
       <option value="">
       <option value="1" $lfield22_type_1_selected$>text field
       <option value="2" $lfield22_type_2_selected$>text box
       <option value="3" $lfield22_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield22_active" value="1" $lfield22_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=22">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">23</font></td>
      <td><input type=text name="lfield23_name" value="$lfield23_name$" size=30> </td>
      <td align=center>
       <select name="lfield23_type">
       <option value="">
       <option value="1" $lfield23_type_1_selected$>text field
       <option value="2" $lfield23_type_2_selected$>text box
       <option value="3" $lfield23_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield23_active" value="1" $lfield23_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=23">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">24</font></td>
      <td><input type=text name="lfield24_name" value="$lfield24_name$" size=30> </td>
      <td align=center>
       <select name="lfield24_type">
       <option value="">
       <option value="1" $lfield24_type_1_selected$>text field
       <option value="2" $lfield24_type_2_selected$>text box
       <option value="3" $lfield24_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield24_active" value="1" $lfield24_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=24">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">25</font></td>
      <td><input type=text name="lfield25_name" value="$lfield25_name$" size=30> </td>
      <td align=center>
       <select name="lfield25_type">
       <option value="">
       <option value="1" $lfield25_type_1_selected$>text field
       <option value="2" $lfield25_type_2_selected$>text box
       <option value="3" $lfield25_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield25_active" value="1" $lfield25_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=25">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">26</font></td>
      <td><input type=text name="lfield26_name" value="$lfield26_name$" size=30> </td>
      <td align=center>
       <select name="lfield26_type">
       <option value="">
       <option value="1" $lfield26_type_1_selected$>text field
       <option value="2" $lfield26_type_2_selected$>text box
       <option value="3" $lfield26_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield26_active" value="1" $lfield26_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=26">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">27</font></td>
      <td><input type=text name="lfield27_name" value="$lfield27_name$" size=30> </td>
      <td align=center>
       <select name="lfield27_type">
       <option value="">
       <option value="1" $lfield27_type_1_selected$>text field
       <option value="2" $lfield27_type_2_selected$>text box
       <option value="3" $lfield27_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield27_active" value="1" $lfield27_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=27">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">28</font></td>
      <td><input type=text name="lfield28_name" value="$lfield28_name$" size=30> </td>
      <td align=center>
       <select name="lfield28_type">
       <option value="">
       <option value="1" $lfield28_type_1_selected$>text field
       <option value="2" $lfield28_type_2_selected$>text box
       <option value="3" $lfield28_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield28_active" value="1" $lfield28_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=28">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">29</font></td>
      <td><input type=text name="lfield29_name" value="$lfield29_name$" size=30> </td>
      <td align=center>
       <select name="lfield29_type">
       <option value="">
       <option value="1" $lfield29_type_1_selected$>text field
       <option value="2" $lfield29_type_2_selected$>text box
       <option value="3" $lfield29_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield29_active" value="1" $lfield29_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=29">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">30</font></td>
      <td><input type=text name="lfield30_name" value="$lfield30_name$" size=30> </td>
      <td align=center>
       <select name="lfield30_type">
       <option value="">
       <option value="1" $lfield30_type_1_selected$>text field
       <option value="2" $lfield30_type_2_selected$>text box
       <option value="3" $lfield30_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield30_active" value="1" $lfield30_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=30">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">31</font></td>
      <td><input type=text name="lfield31_name" value="$lfield31_name$" size=30> </td>
      <td align=center>
       <select name="lfield31_type">
       <option value="">
       <option value="1" $lfield31_type_1_selected$>text field
       <option value="2" $lfield31_type_2_selected$>text box
       <option value="3" $lfield31_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield31_active" value="1" $lfield31_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=31">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">32</font></td>
      <td><input type=text name="lfield32_name" value="$lfield32_name$" size=30> </td>
      <td align=center>
       <select name="lfield32_type">
       <option value="">
       <option value="1" $lfield32_type_1_selected$>text field
       <option value="2" $lfield32_type_2_selected$>text box
       <option value="3" $lfield32_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield32_active" value="1" $lfield32_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=32">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">33</font></td>
      <td><input type=text name="lfield33_name" value="$lfield33_name$" size=30> </td>
      <td align=center>
       <select name="lfield33_type">
       <option value="">
       <option value="1" $lfield33_type_1_selected$>text field
       <option value="2" $lfield33_type_2_selected$>text box
       <option value="3" $lfield33_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield33_active" value="1" $lfield33_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=33">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">34</font></td>
      <td><input type=text name="lfield34_name" value="$lfield34_name$" size=30> </td>
      <td align=center>
       <select name="lfield34_type">
       <option value="">
       <option value="1" $lfield34_type_1_selected$>text field
       <option value="2" $lfield34_type_2_selected$>text box
       <option value="3" $lfield34_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield34_active" value="1" $lfield34_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=34">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">35</font></td>
      <td><input type=text name="lfield35_name" value="$lfield35_name$" size=30> </td>
      <td align=center>
       <select name="lfield35_type">
       <option value="">
       <option value="1" $lfield35_type_1_selected$>text field
       <option value="2" $lfield35_type_2_selected$>text box
       <option value="3" $lfield35_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield35_active" value="1" $lfield35_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=35">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">36</font></td>
      <td><input type=text name="lfield36_name" value="$lfield36_name$" size=30> </td>
      <td align=center>
       <select name="lfield36_type">
       <option value="">
       <option value="1" $lfield36_type_1_selected$>text field
       <option value="2" $lfield36_type_2_selected$>text box
       <option value="3" $lfield36_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield36_active" value="1" $lfield36_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=36">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">37</font></td>
      <td><input type=text name="lfield37_name" value="$lfield37_name$" size=30> </td>
      <td align=center>
       <select name="lfield37_type">
       <option value="">
       <option value="1" $lfield37_type_1_selected$>text field
       <option value="2" $lfield37_type_2_selected$>text box
       <option value="3" $lfield37_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield37_active" value="1" $lfield37_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=37">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">38</font></td>
      <td><input type=text name="lfield38_name" value="$lfield38_name$" size=30> </td>
      <td align=center>
       <select name="lfield38_type">
       <option value="">
       <option value="1" $lfield38_type_1_selected$>text field
       <option value="2" $lfield38_type_2_selected$>text box
       <option value="3" $lfield38_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield38_active" value="1" $lfield38_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=38">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">39</font></td>
      <td><input type=text name="lfield39_name" value="$lfield39_name$" size=30> </td>
      <td align=center>
       <select name="lfield39_type">
       <option value="">
       <option value="1" $lfield39_type_1_selected$>text field
       <option value="2" $lfield39_type_2_selected$>text box
       <option value="3" $lfield39_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield39_active" value="1" $lfield39_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=39">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">40</font></td>
      <td><input type=text name="lfield40_name" value="$lfield40_name$" size=30> </td>
      <td align=center>
       <select name="lfield40_type">
       <option value="">
       <option value="1" $lfield40_type_1_selected$>text field
       <option value="2" $lfield40_type_2_selected$>text box
       <option value="3" $lfield40_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield40_active" value="1" $lfield40_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=40">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">41</font></td>
      <td><input type=text name="lfield41_name" value="$lfield41_name$" size=30> </td>
      <td align=center>
       <select name="lfield41_type">
       <option value="">
       <option value="1" $lfield41_type_1_selected$>text field
       <option value="2" $lfield41_type_2_selected$>text box
       <option value="3" $lfield41_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield41_active" value="1" $lfield41_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=41">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">42</font></td>
      <td><input type=text name="lfield42_name" value="$lfield42_name$" size=30> </td>
      <td align=center>
       <select name="lfield42_type">
       <option value="">
       <option value="1" $lfield42_type_1_selected$>text field
       <option value="2" $lfield42_type_2_selected$>text box
       <option value="3" $lfield42_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield42_active" value="1" $lfield42_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=42">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">43</font></td>
      <td><input type=text name="lfield43_name" value="$lfield43_name$" size=30> </td>
      <td align=center>
       <select name="lfield43_type">
       <option value="">
       <option value="1" $lfield43_type_1_selected$>text field
       <option value="2" $lfield43_type_2_selected$>text box
       <option value="3" $lfield43_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield43_active" value="1" $lfield43_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=43">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">44</font></td>
      <td><input type=text name="lfield44_name" value="$lfield44_name$" size=30> </td>
      <td align=center>
       <select name="lfield44_type">
       <option value="">
       <option value="1" $lfield44_type_1_selected$>text field
       <option value="2" $lfield44_type_2_selected$>text box
       <option value="3" $lfield44_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield44_active" value="1" $lfield44_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=44">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">45</font></td>
      <td><input type=text name="lfield45_name" value="$lfield45_name$" size=30> </td>
      <td align=center>
       <select name="lfield45_type">
       <option value="">
       <option value="1" $lfield45_type_1_selected$>text field
       <option value="2" $lfield45_type_2_selected$>text box
       <option value="3" $lfield45_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield45_active" value="1" $lfield45_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=45">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">46</font></td>
      <td><input type=text name="lfield46_name" value="$lfield46_name$" size=30> </td>
      <td align=center>
       <select name="lfield46_type">
       <option value="">
       <option value="1" $lfield46_type_1_selected$>text field
       <option value="2" $lfield46_type_2_selected$>text box
       <option value="3" $lfield46_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield46_active" value="1" $lfield46_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=46">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">47</font></td>
      <td><input type=text name="lfield47_name" value="$lfield47_name$" size=30> </td>
      <td align=center>
       <select name="lfield47_type">
       <option value="">
       <option value="1" $lfield47_type_1_selected$>text field
       <option value="2" $lfield47_type_2_selected$>text box
       <option value="3" $lfield47_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield47_active" value="1" $lfield47_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=47">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">48</font></td>
      <td><input type=text name="lfield48_name" value="$lfield48_name$" size=30> </td>
      <td align=center>
       <select name="lfield48_type">
       <option value="">
       <option value="1" $lfield48_type_1_selected$>text field
       <option value="2" $lfield48_type_2_selected$>text box
       <option value="3" $lfield48_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield48_active" value="1" $lfield48_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=48">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">49</font></td>
      <td><input type=text name="lfield49_name" value="$lfield49_name$" size=30> </td>
      <td align=center>
       <select name="lfield49_type">
       <option value="">
       <option value="1" $lfield49_type_1_selected$>text field
       <option value="2" $lfield49_type_2_selected$>text box
       <option value="3" $lfield49_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield49_active" value="1" $lfield49_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=49">Reset</a></b></font></td> -->
     </tr>
     <tr>
      <td align=center><font size=1 face="arial">50</font></td>
      <td><input type=text name="lfield50_name" value="$lfield50_name$" size=30> </td>
      <td align=center>
       <select name="lfield50_type">
       <option value="">
       <option value="1" $lfield50_type_1_selected$>text field
       <option value="2" $lfield50_type_2_selected$>text box
       <option value="3" $lfield50_type_3_selected$>dropdown
       </select>
      </td>
      <td align=center><input type=checkbox name="lfield50_active" value="1" $lfield50_active_checked$></td>
<!--      <td align=center><font face="arial" size=1><b><a href="$cgiurl$?setup_lfields_confirm_reset=50">Reset</a></b></font></td> -->
     </tr>
    </table> 

</td></tr></table>


--- _setup_lfields_saved.html ---
<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Listing Database Fields</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

  <font face="arial" size=2><br><br><br>
    Listing Fields have been saved<br>
   </font><br><br>

</td></tr></table>

--- _setup_options_edit.html ---

   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td>


    <!-- License Info -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;License Info</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td width=200 valign=top><font size=2 face="ms sans serif">Company Name<br></font></td>
      <td><input type=text name="company_name" value="$company_name$" size=30></td>
     </tr>
     <tr>
      <td width=200 valign=top><font size=2 face="ms sans serif">Domain Name<br></font></td>
      <td><input type=text name="domain_name" value="$domain_name$" size=30></td>
     </tr>
     <tr>
      <td width=200 valign=top><font size=2 face="ms sans serif">Product ID<br></font></td>
      <td><font size=2 face="ms sans serif">$product_id$</font><font size=3>&nbsp;</font></td>
     </tr>
    </table>
    <!-- /License Info -->


    <!-- General Options -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;General Options</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Publish index of listing pages?</font></td>
      <td>
       <input type=radio name="publish_listing_index" value="1" $publish_listing_index_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="publish_listing_index" value="0" $publish_listing_index_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Publish index of homepages?</font></td>
      <td>
       <input type=radio name="publish_homepage_index" value="1" $publish_homepage_index_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="publish_homepage_index" value="0" $publish_homepage_index_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Show preview image on listing pages?</font></td>
      <td>
       <input type=radio name="publish_listing_image0" value="1" $publish_listing_image0_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="publish_listing_image0" value="0" $publish_listing_image0_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Show preview image on homepages?</font></td>
      <td>
       <input type=radio name="publish_homepage_image0" value="1" $publish_homepage_image0_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="publish_homepage_image0" value="0" $publish_homepage_image0_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Maximum size of uploaded Images?</font></td>
      <td>&nbsp;<input type=text name="upload_maxk" value="$upload_maxk$" size=5> <font size=2 face="ms sans serif">kbytes</font></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Login Inactivity Timeout?</font></td>
      <td>&nbsp;<input type=text name="login_timeout" value="$login_timeout$" size=5> <font size=2 face="ms sans serif">minutes</font></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Show how many results per page in Listing Editor?</font></td>
      <td>&nbsp;<input type=text name="listing_perpage" value="$listing_perpage$" size=5> <font size=2 face="ms sans serif">per page</font></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Show how many results per page in Homepage Editor?</font></td>
      <td>&nbsp;<input type=text name="homepage_perpage" value="$homepage_perpage$" size=5> <font size=2 face="ms sans serif">per page</font></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Show how many results per page in User Manager?</font></td>
      <td>&nbsp;<input type=text name="userman_perpage" value="$userman_perpage$" size=5> <font size=2 face="ms sans serif">per page</font></td>
     </tr>
   </table>
    <!-- /General Options -->

    <!-- Database Options -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr>
      <td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Database Options</b></font></td>
     </tr>
    </table>
    <font size=1><br></font>
    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Setup Listings Fields</font></td>
      <td><input type=submit name="setup_lfields_edit" value="     Setup     "></td>
     </tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Setup Homepage Fields</font></td>
      <td><input type=submit name="setup_hfields_edit" value="     Setup     "></td>
     </tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Re-publish all listings</font></td>
      <td><input type=submit name="setup_publish_listings" value="    Publish   "></td>
     </tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Publish Listing Index</font></td>
      <td><input type=submit name="setup_publish_listing_index" value="    Publish   "></td>
     </tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Re-publish all homepages</font></td>
      <td><input type=submit name="setup_publish_homepages" value="    Publish   "></td>
     </tr>
     <tr>
      <td width=310><font size=2 face="ms sans serif">Publish Homepage Index</font></td>
      <td><input type=submit name="setup_publish_homepage_index" value="    Publish   "></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Enable database sorting?<br>(Not recommended for over 100 records)</font></td>
      <td>
       <input type=radio name="db_sorting" value="1" $db_sorting_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="db_sorting" value="0" $db_sorting_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
    </table>
    <!-- /Database Options -->

    <!-- Customization Options -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Customization Options</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td><font size=2 face="ms sans serif">Titlebar Text</font></td>
      <td><input type=text name="titlebar" value="$titlebar$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Footerbar Text</font></td>
      <td><input type=text name="footerbar" value="$footerbar$" size=30></td>
     </tr>
     <tr>
      <td width=200><font size=2 face="ms sans serif">Logoff URL</font></td>
      <td><input type=text name="logoff_url" value="$logoff_url$" size=30></td>
     </tr>
    </table>
    <!-- /Customization Options -->


    <!-- Directories and URLs -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Directories and URLs</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td width=200 valign=top><font size=2 face="ms sans serif">Current Directory<br></font></td>
      <td>
       <font size=2 face="ms sans serif">$cgidir$</font><br>
       <font size=1 face="ms sans serif">Note: Dir paths are relative to the current dir.</font><br>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Listings Directory Path</font></td>
      <td><input type=text name="listing_dir" value="$listing_dir$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Homepage Directory Path</font></td>
      <td><input type=text name="homepage_dir" value="$homepage_dir$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Image Directory URL</font></td>
      <td><input type=text name="image_url" value="$image_url$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Listings Directory URL</font></td>
      <td><input type=text name="listing_url" value="$listing_url$" size=30></td>
     </tr>

     <tr>
      <td><font size=2 face="ms sans serif">Homepage Directory URL</font></td>
      <td><input type=text name="homepage_url" value="$homepage_url$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Search Engine URL</font></td>
      <td><input type=text name="search_url" value="$search_url$" size=30></td>
     </tr>
    </table>
    <!-- /Directories and URLs -->

    <!-- Local Time Adjustment -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Local Time Adjustment</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td width=200><font size=2 face="ms sans serif">Server Time</font></td>
      <td><font size=2 face="ms sans serif">$server_time$<font size=3>&nbsp;</font></font></td>
     </tr>
     <tr>
      <td width=200><font size=2 face="ms sans serif">Adjust Hours</font></td>
      <td>
       <select name="time_adjh">
       <option value="add"   $time_adjh_add_selected$>add
       <option value="minus" $time_adjh_minus_selected$>minus
       </select>
       <input type=text name="time_adj_hour" value="$time_adj_hour$" size=3>
       <font size=2 face="ms sans serif">hours</font>
      </td>
     </tr>
     <tr>
      <td width=200><font size=2 face="ms sans serif">Adjust Minutes</font></td>
      <td>
       <select name="time_adjm">
       <option value="add"   $time_adjm_add_selected$>add
       <option value="minus" $time_adjm_minus_selected$>minus
       </select>
       <input type=text name="time_adj_min" value="$time_adj_min$" size=3>
       <font size=2 face="ms sans serif">mins</font><br>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Local Time</font></td>
      <td><font size=2 face="ms sans serif">$local_time$<font size=3>&nbsp;</font></font></td>
     </tr>
    </table>
    <!-- /Local Time Adjustment -->

    <!-- Upgrade Available -->
    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Upgrade Information</b></font></td></tr>
    </table>
    <font size=1><br></font>
    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td width=200 valign=top><font size=2 face="ms sans serif">Your version number<br></font></td>
      <td><font size=2 face="ms sans serif">Version $progVer$</font><font size=3>&nbsp;</font></td>
     </tr>
     <tr>
      <td width=200 valign=top><font size=2 face="ms sans serif">Upgrade Availability<br></font></td>
      <td><img src="http://www.edisdigital.com/products/realtymanager/upgrade_available.cgi?$upgrade_id$" height=19 width=250 alt="" border=0></td>
     </tr>

     <tr>
      <td width=200 valign=top><font size=2 face="ms sans serif">How to upgrade<br></font></td>
      <td><font size=2 face="ms sans serif"><a href="http://www.interactivetools.com/" target="_blank">Click here for upgrade information</a></font><font size=3>&nbsp;</font></td>
     </tr>
    </table>
    <!-- /Upgrade Available -->


  </td></tr></table>
<br>

--- _setup_options_saved.html ---
<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

<!-- Content Title -->
<table border=0 width=100% cellspacing=0 cellpadding=2>
 <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;Setup Options</b></font></td></tr>
</table>
<font size=1><br></font>
<!-- /Content Title -->

  <font face="arial" size=2><br><br><br>
    Setup Options have been saved<br>
   </font><br><br>

</td></tr></table>

--- _ui_admin.html ---

<html><head><title>$titlebar$</title>
 <meta name="robots" content="noindex,nofollow">
 <style type="text/css"><!--
  a		{ text-decoration: none; color: #000099; }
  a:hover	{ text-decoration: underline; color: #0000FF; }
  a:active	{ text-decoration: underline; }
  .menu		{ text-decoration: none; color: #000000; }
  .menu:hover	{ text-decoration: none; color: #000000; }
  .menu:active	{ text-decoration: none; color: #000000; }
 --></style>
<script language="Javascript"><!--
var OldDesc;

// Check for IE4+ CSS Support
(navigator.userAgent.indexOf("MSIE")!=-1)?IE=true:IE=false;
Ver = parseInt(navigator.appVersion);
if (IE) { IE = Ver; }

function Help(num) {		// Popup a help window
  var win1 = window.open("$cgiurl$?help="+num,"HelpWin","width=240,height=350,toolbar=no,resizable=yes,scrollbars=yes,directories=no");
  }

//--></script>
</head>
<body bgcolor="#003366" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<center>

<!-- MENU TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td rowspan=3 width=68>
   <a href="$cgiurl$?"><img src="$image_url$/window_nw.gif" width="68" height="44" border="0" alt="Click here to return to the start page"></a><br>
    <table border=0 cellspacing=0 cellpadding=0><tr><td bgcolor="#003399">
     <img src="$image_url$/window_nw2.gif" width="68" height="4" border="0" alt=""><br>
    </td></tr></table>
  </td>
  <td bgcolor="#CCCCCC" width=516>
  <!-- title bar -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr>
    <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
     <table border=0 cellspacing=0 cellpadding=0 width=100%>
      <tr>
       <!-- title bar text -->
       <td><font face="MS Sans Serif" color="#FFFFFF" size=1><b>&nbsp;$titlebar$</b></font></td>
       <!-- title bar buttons (?)(X) -->
       <td align=right><img src="$image_url$/window_buttons.gif" height=18 width=34 border=0 alt="" usemap="#buttons" ismap></td>
       <map name="buttons">
       <area shape="circle" coords="8,9,8"  href="javascript:Help($hnum$)" onfocus="blur();" title="Click for Help">
       <area shape="circle" coords="26,9,8" href="$cgiurl$?logoff=1"	  onfocus="blur();" title="Logoff Program">
       <AREA SHAPE="DEFAULT" NOHREF>
       </map>
      </tr>
     </table>
    </td>
   </tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /title bar -->
  </td>
  <td rowspan=3 width=6><img src="$image_url$/window_ne.gif" width="6" height="48" border="0" alt=""></td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC" height=18 valign=middle>
   <!-- menu bar -->
   <table border=0 cellpadding=0 cellspacing=0>
    <tr>
     <td id="m1" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1;"><a href="$cgiurl$?listing_list=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m1.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m1.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m1.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m1.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m1.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m1.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m1.style.borderColor = '#CCCCCC'; m1.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;Listing Editor&nbsp;&nbsp;</font></a><br>
     </td>
     <td id="m2" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1;"><a href="$cgiurl$?homepage_list=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m2.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m2.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m2.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m2.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m2.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m2.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m2.style.borderColor = '#CCCCCC'; m2.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;Homepage Editor&nbsp;&nbsp;</font></a><br>
     </td>
     <td id="m3" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1 ;"><a href="$cgiurl$?userman_list=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m3.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m3.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m3.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m3.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m3.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m3.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m3.style.borderColor = '#CCCCCC'; m3.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;User Manager&nbsp;&nbsp;</font></a><br>
     </td>
    </tr>
   </table> 
   <!-- /menu bar -->
  </td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC">
  <!-- lower border -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /lower border -->
  </td>
 </tr>
</table>

<!-- template : define pagebody -->
<!-- CONTENT TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#003399" width=59><img src="$image_url$/spacer.gif" height=1 width=59 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=517>
   <!-- PAGE CONTENT -->
   $content$
   <!-- /PAGE CONTENT -->
  </td>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
 </tr>
</table>


<!-- FOOTER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td rowspan=2 width=73>
   <table border=0 cellspacing=0 cellpadding=0>
    <tr><td bgcolor="#003399"><img src="$image_url$/window_sw.gif" width="73" height="6" border="0" alt=""></td></tr>
    <tr><td><img src="$image_url$/window_sw2.gif" width="73" height="40" border="0" alt=""></td></tr>
   </table>
  </td>
  <td bgcolor="#FFFFFF" width=511 height=20 valign=top align=right>$buttons$&nbsp;</td>
  <!-- footer image right -->
  <td rowspan=2 width=6><img src="$image_url$/window_se.gif" width="6" height="46" border="0" alt=""></td>
 </tr>
 <tr>
  <td bgcolor="#000066" height=18>
  <!-- footer bar -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr>
    <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
     <table border=0 cellspacing=0 cellpadding=0 width=100%>
      <tr>
       <td align=left><font face="MS Sans Serif" color="#FFFFFF" size=1>Current User: $cuser_name$ (admin)</font></td>
       <td align=right><font face="MS Sans Serif" color="#FFFFFF" size=1><span id="desc">$footerbar$</span>&nbsp;</font></td>
      </tr>
     </table>
    </td>
   </tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /footer bar -->
  </td>
 </tr>
</table>

</center>
</form>
</body>
</html>

<!-- template : /define pagebody -->


--- _ui_buttons.html ---
<!--

  This is the button template file, it contains the button HTML
  for all of the pages generated by Realty Manager

-->

<!-- LOGIN SCREENS.html.buttons -->

<!-- templatecell : _rm_about.html.buttons -->
<!-- /templatecell : _rm_about.html.buttons -->

<!-- templatecell : _rm_error.html.buttons -->
  <input type=image name="about" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _rm_error.html.buttons -->

<!-- LISTING EDITOR.html.buttons -->

<!-- templatecell : _listing_list.html.buttons -->
  <input type=image name="listing_add" src="$image_url$/button_add.gif" height=16 width=77 border=0 alt="Add">
  <input type=image name="listing_listall" src="$image_url$/button_listall.gif" height=16 width=77 border=0 alt="List All">
<!-- /templatecell : _listing_list.html.buttons -->

<!-- templatecell : _listing_add.html.buttons -->
  <input type=image name="listing_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="listing_list" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _listing_add.html.buttons -->

<!-- templatecell : _listing_edit.html.buttons -->
  <input type=image name="listing_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="listing_list" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _listing_edit.html.buttons -->

<!-- templatecell : _listing_confirm_erase.html.buttons -->
  <input type=image name="listing_erase" src="$image_url$/button_erase.gif" height=16 width=77 border=0 alt="Erase">
  <input type=image name="listing_list" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _listing_confirm_erase.html.buttons -->

<!-- templatecell : _listing_erased.html.buttons -->
  <input type=image name="listing_list" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _listing_erased.html.buttons -->

<!-- templatecell : _listing_saved.html.buttons -->
  <input type=image name="listing_list" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _listing_saved.html.buttons -->

<!-- templatecell : _listing_iview.html.buttons -->
  <input type=image name="listing_edit" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _listing_iview.html.buttons -->

<!-- templatecell : _listing_iviewall.html.buttons -->
  <input type=image name="listing_edit" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _listing_iviewall.html.buttons -->

<!-- templatecell : _listing_iedit.html.buttons -->
  <input type=image name="listing_iedit_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="listing_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _listing_iedit.html.buttons -->

<!-- templatecell : _listing_iconfirm_erase.html.buttons -->
  <input type=image name="listing_ierase" src="$image_url$/button_erase.gif" height=16 width=77 border=0 alt="Erase">
  <input type=image name="listing_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _listing_iconfirm_erase.html.buttons -->

<!-- templatecell : _listing_iupload_step1.html.buttons -->
  <input type=image name="listing_iupload_step2" src="$image_url$/button_upload.gif" height=16 width=77 border=0 alt="Upload">
  <input type=image name="listing_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _listing_iupload_step1.html.buttons -->

<!-- templatecell : _listing_iupload_step2.html.buttons -->
  <input type=image name="listing_iupload_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="listing_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _listing_iupload_step2.html.buttons -->


<!-- HOMEPAGE EDITOR.html.buttons -->

<!-- templatecell : _homepage_list.html.buttons -->
  <input type=image name="homepage_listall" src="$image_url$/button_listall.gif" height=16 width=77 border=0 alt="List All">
<!-- /templatecell : _homepage_list.html.buttons -->

<!-- templatecell : _homepage_edit.html.buttons -->
  <input type=image name="homepage_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="homepage_list" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _homepage_edit.html.buttons -->

<!-- templatecell : _homepage_saved.html.buttons -->
  <input type=image name="homepage_list" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _homepage_saved.html.buttons -->

<!-- templatecell : _homepage_iview.html.buttons -->
  <input type=image name="homepage_edit" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _homepage_iview.html.buttons -->

<!-- templatecell : _homepage_iviewall.html.buttons -->
  <input type=image name="homepage_edit" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _homepage_iviewall.html.buttons -->

<!-- templatecell : _homepage_iedit.html.buttons -->
  <input type=image name="homepage_iedit_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="homepage_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _homepage_iedit.html.buttons -->

<!-- templatecell : _homepage_iconfirm_erase.html.buttons -->
  <input type=image name="homepage_ierase" src="$image_url$/button_erase.gif" height=16 width=77 border=0 alt="Erase">
  <input type=image name="homepage_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _homepage_iconfirm_erase.html.buttons -->

<!-- templatecell : _homepage_iupload_step1.html.buttons -->
  <input type=image name="homepage_iupload_step2" src="$image_url$/button_upload.gif" height=16 width=77 border=0 alt="Upload">
  <input type=image name="homepage_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _homepage_iupload_step1.html.buttons -->

<!-- templatecell : _homepage_iupload_step2.html.buttons -->
  <input type=image name="homepage_iupload_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="homepage_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _homepage_iupload_step2.html.buttons -->

<!-- USER MANAGER.html.buttons -->

<!-- templatecell : _userman_list.html.buttons -->
  <input type=image name="userman_add" src="$image_url$/button_add.gif" height=16 width=77 border=0 alt="Add">
  <input type=image name="userman_listall" src="$image_url$/button_listall.gif" height=16 width=77 border=0 alt="List All">
<!-- /templatecell : _userman_list.html.buttons -->

<!-- templatecell : _userman_add.html.buttons -->
  <input type=image name="userman_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="userman_list" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _userman_add.html.buttons -->

<!-- templatecell : _userman_edit.html.buttons -->
  <input type=image name="userman_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="userman_list" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _userman_edit.html.buttons -->

<!-- templatecell : _userman_confirm_erase.html.buttons -->
  <input type=image name="userman_erase" src="$image_url$/button_erase.gif" height=16 width=77 border=0 alt="Erase">
  <input type=image name="userman_list" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _userman_confirm_erase.html.buttons -->

<!-- templatecell : _userman_erased.html.buttons -->
  <input type=image name="userman_list" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _userman_erased.html.buttons -->

<!-- templatecell : _userman_saved.html.buttons -->
  <input type=image name="userman_list" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _userman_saved.html.buttons -->

<!-- SETUP OPTIONS.html.buttons -->

<!-- templatecell : _setup_options_edit.html.buttons -->
  <input type=image name="setup_options_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="about" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _setup_options_edit.html.buttons -->

<!-- templatecell : _setup_options_saved.html.buttons -->
  <input type=image name="setup_options_edit" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _setup_options_saved.html.buttons -->

<!-- templatecell : _setup_lfields_edit.html.buttons -->
  <input type=image name="setup_lfields_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="setup_options_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _setup_lfields_edit.html.buttons -->

<!-- templatecell : _setup_lfields_confirm_reset.html.buttons -->
  <input type=image name="setup_lfields_reset" src="$image_url$/button_reset.gif" height=16 width=77 border=0 alt="Reset">
  <input type=image name="setup_lfields_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _setup_lfields_confirm_reset.html.buttons -->

<!-- templatecell : _setup_lfields_saved.html.buttons -->
  <input type=image name="setup_options_edit" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _setup_lfields_saved.html.buttons -->

<!-- templatecell : _setup_hfields_edit.html.buttons -->
  <input type=image name="setup_hfields_save" src="$image_url$/button_save.gif" height=16 width=77 border=0 alt="Save">
  <input type=image name="setup_options_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _setup_hfields_edit.html.buttons -->

<!-- templatecell : _setup_hfields_confirm_reset.html.buttons -->
  <input type=image name="setup_hfields_reset" src="$image_url$/button_reset.gif" height=16 width=77 border=0 alt="Reset">
  <input type=image name="setup_hfields_edit" src="$image_url$/button_cancel.gif" height=16 width=77 border=0 alt="Cancel">
<!-- /templatecell : _setup_hfields_confirm_reset.html.buttons -->

<!-- templatecell : _setup_hfields_saved.html.buttons -->
  <input type=image name="setup_options_edit" src="$image_url$/button_ok.gif" height=16 width=77 border=0 alt="OK">
<!-- /templatecell : _setup_hfields_saved.html.buttons -->


--- _ui_disabled.html ---

<html><head><title>$titlebar$</title>
 <meta name="robots" content="noindex,nofollow">
 <style type="text/css"><!--
  a		{ text-decoration: none; color: #000099; }
  a:hover	{ text-decoration: underline; color: #0000FF; }
  a:active	{ text-decoration: underline; }
  .menu		{ text-decoration: none; color: #000000; }
  .menu:hover	{ text-decoration: none; color: #000000; }
  .menu:active	{ text-decoration: none; color: #000000; }
 --></style>
<script language="Javascript"><!--
var OldDesc;

// Check for IE4+ CSS Support
(navigator.userAgent.indexOf("MSIE")!=-1)?IE=true:IE=false;
Ver = parseInt(navigator.appVersion);
if (IE) { IE = Ver; }

function Help(num) {		// Popup a help window
  var win1 = window.open("$cgiurl$?help="+num,"HelpWin","width=240,height=350,toolbar=no,resizable=yes,scrollbars=yes,directories=no");
  }

//--></script>
</head>
<body bgcolor="#003366" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<center>

<!-- MENU TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td rowspan=3 width=68>
   <a href="$cgiurl$?"><img src="$image_url$/window_nw.gif" width="68" height="44" border="0" alt="Click here to return to the start page"></a><br>
    <table border=0 cellspacing=0 cellpadding=0><tr><td bgcolor="#003399">
     <img src="$image_url$/window_nw2.gif" width="68" height="4" border="0" alt=""><br>
    </td></tr></table>
  </td>
  <td bgcolor="#CCCCCC" width=516>
  <!-- title bar -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr>
    <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
     <table border=0 cellspacing=0 cellpadding=0 width=100%>
      <tr>
       <!-- title bar text -->
       <td><font face="MS Sans Serif" color="#FFFFFF" size=1><b>&nbsp;$titlebar$</b></font></td>
       <!-- title bar buttons (?)(X) -->
       <td align=right><img src="$image_url$/window_buttons.gif" height=18 width=34 border=0 alt="" usemap="#buttons" ismap></td>
       <map name="buttons">
       <area shape="circle" coords="8,9,8"  href="javascript:Help($hnum$)" onfocus="blur();" title="Click for Help">
       <area shape="circle" coords="26,9,8" href="$cgiurl$?logoff=1"	  onfocus="blur();" title="Logoff Program">
       <AREA SHAPE="DEFAULT" NOHREF>
       </map>
      </tr>
     </table>
    </td>
   </tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /title bar -->
  </td>
  <td rowspan=3 width=6><img src="$image_url$/window_ne.gif" width="6" height="48" border="0" alt=""></td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC" height=18 valign=middle>
   <!-- menu bar -->
   <font size=1>&nbsp;</font><br>
   <!-- /menu bar -->
  </td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC">
  <!-- lower border -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /lower border -->
  </td>
 </tr>
</table>

<!-- template : define pagebody -->
<!-- CONTENT TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#003399" width=59><img src="$image_url$/spacer.gif" height=1 width=59 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=517>
   <!-- PAGE CONTENT -->
   $content$
   <!-- /PAGE CONTENT -->
  </td>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
 </tr>
</table>


<!-- FOOTER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td rowspan=2 width=73>
   <table border=0 cellspacing=0 cellpadding=0>
    <tr><td bgcolor="#003399"><img src="$image_url$/window_sw.gif" width="73" height="6" border="0" alt=""></td></tr>
    <tr><td><img src="$image_url$/window_sw2.gif" width="73" height="40" border="0" alt=""></td></tr>
   </table>
  </td>
  <td bgcolor="#FFFFFF" width=511 height=20 valign=top align=right>$buttons$&nbsp;</td>
  <!-- footer image right -->
  <td rowspan=2 width=6><img src="$image_url$/window_se.gif" width="6" height="46" border="0" alt=""></td>
 </tr>
 <tr>
  <td bgcolor="#000066" height=18>
  <!-- footer bar -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr>
    <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
     <table border=0 cellspacing=0 cellpadding=0 width=100%>
      <tr>
       <td align=left><font face="MS Sans Serif" color="#FFFFFF" size=1>Current User: $cuser_name$</font></td>
       <td align=right><font face="MS Sans Serif" color="#FFFFFF" size=1><span id="desc">$footerbar$</span>&nbsp;</font></td>
      </tr>
     </table>
    </td>
   </tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /footer bar -->
  </td>
 </tr>
</table>

</center>
</form>
</body>
</html>

<!-- template : /define pagebody -->

--- _ui_regular.html ---

<html><head><title>$titlebar$</title>
 <meta name="robots" content="noindex,nofollow">
 <style type="text/css"><!--
  a		{ text-decoration: none; color: #000099; }
  a:hover	{ text-decoration: underline; color: #0000FF; }
  a:active	{ text-decoration: underline; }
  .menu		{ text-decoration: none; color: #000000; }
  .menu:hover	{ text-decoration: none; color: #000000; }
  .menu:active	{ text-decoration: none; color: #000000; }
 --></style>
<script language="Javascript"><!--
var OldDesc;

// Check for IE4+ CSS Support
(navigator.userAgent.indexOf("MSIE")!=-1)?IE=true:IE=false;
Ver = parseInt(navigator.appVersion);
if (IE) { IE = Ver; }

function Help(num) {		// Popup a help window
  var win1 = window.open("$cgiurl$?help="+num,"HelpWin","width=240,height=350,toolbar=no,resizable=yes,scrollbars=yes,directories=no");
  }

//--></script>
</head>
<body bgcolor="#003366" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<center>

<!-- MENU TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td rowspan=3 width=68>
   <a href="$cgiurl$?"><img src="$image_url$/window_nw.gif" width="68" height="44" border="0" alt="Click here to return to the start page"></a><br>
    <table border=0 cellspacing=0 cellpadding=0><tr><td bgcolor="#003399">
     <img src="$image_url$/window_nw2.gif" width="68" height="4" border="0" alt=""><br>
    </td></tr></table>
  </td>
  <td bgcolor="#CCCCCC" width=516>
  <!-- title bar -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr>
    <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
     <table border=0 cellspacing=0 cellpadding=0 width=100%>
      <tr>
       <!-- title bar text -->
       <td><font face="MS Sans Serif" color="#FFFFFF" size=1><b>&nbsp;$titlebar$</b></font></td>
       <!-- title bar buttons (?)(X) -->
       <td align=right><img src="$image_url$/window_buttons.gif" height=18 width=34 border=0 alt="" usemap="#buttons" ismap></td>
       <map name="buttons">
       <area shape="circle" coords="8,9,8"  href="javascript:Help($hnum$)" onfocus="blur();" title="Click for Help">
       <area shape="circle" coords="26,9,8" href="$cgiurl$?logoff=1"	  onfocus="blur();" title="Logoff Program">
       <AREA SHAPE="DEFAULT" NOHREF>
       </map>
      </tr>
     </table>
    </td>
   </tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /title bar -->
  </td>
  <td rowspan=3 width=6><img src="$image_url$/window_ne.gif" width="6" height="48" border="0" alt=""></td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC" height=18 valign=middle>
   <!-- menu bar -->
   <table border=0 cellpadding=0 cellspacing=0>
    <tr>
     <td id="m1" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1;"><a href="$cgiurl$?listing_list=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m1.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m1.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m1.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m1.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m1.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m1.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m1.style.borderColor = '#CCCCCC'; m1.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;Listing Editor&nbsp;&nbsp;</font></a><br>
     </td>
     <td id="m2" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1;"><a href="$cgiurl$?homepage_edit=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m2.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m2.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m2.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m2.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m2.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m2.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m2.style.borderColor = '#CCCCCC'; m2.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;Homepage Editor&nbsp;&nbsp;</font></a><br>
     </td>
    </tr>
   </table> 
   <!-- /menu bar -->
  </td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC">
  <!-- lower border -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /lower border -->
  </td>
 </tr>
</table>

<!-- template : define pagebody -->
<!-- CONTENT TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#003399" width=59><img src="$image_url$/spacer.gif" height=1 width=59 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=517>
   <!-- PAGE CONTENT -->
   $content$
   <!-- /PAGE CONTENT -->
  </td>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
 </tr>
</table>


<!-- FOOTER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td rowspan=2 width=73>
   <table border=0 cellspacing=0 cellpadding=0>
    <tr><td bgcolor="#003399"><img src="$image_url$/window_sw.gif" width="73" height="6" border="0" alt=""></td></tr>
    <tr><td><img src="$image_url$/window_sw2.gif" width="73" height="40" border="0" alt=""></td></tr>
   </table>
  </td>
  <td bgcolor="#FFFFFF" width=511 height=20 valign=top align=right>$buttons$&nbsp;</td>
  <!-- footer image right -->
  <td rowspan=2 width=6><img src="$image_url$/window_se.gif" width="6" height="46" border="0" alt=""></td>
 </tr>
 <tr>
  <td bgcolor="#000066" height=18>
  <!-- footer bar -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr>
    <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
     <table border=0 cellspacing=0 cellpadding=0 width=100%>
      <tr>
       <td align=left><font face="MS Sans Serif" color="#FFFFFF" size=1>Current User: $cuser_name$</font></td>
       <td align=right><font face="MS Sans Serif" color="#FFFFFF" size=1><span id="desc">$footerbar$</span>&nbsp;</font></td>
      </tr>
     </table>
    </td>
   </tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /footer bar -->
  </td>
 </tr>
</table>

</center>
</form>
</body>
</html>

<!-- template : /define pagebody -->

--- _ui_superuser.html ---

<html><head><title>$titlebar$</title>
 <meta name="robots" content="noindex,nofollow">
 <style type="text/css"><!--
  a		{ text-decoration: none; color: #000099; }
  a:hover	{ text-decoration: underline; color: #0000FF; }
  a:active	{ text-decoration: underline; }
  .menu		{ text-decoration: none; color: #000000; }
  .menu:hover	{ text-decoration: none; color: #000000; }
  .menu:active	{ text-decoration: none; color: #000000; }
 --></style>
<script language="Javascript"><!--
var OldDesc;

// Check for IE4+ CSS Support
(navigator.userAgent.indexOf("MSIE")!=-1)?IE=true:IE=false;
Ver = parseInt(navigator.appVersion);
if (IE) { IE = Ver; }

function Help(num) {		// Popup a help window
  var win1 = window.open("$cgiurl$?help="+num,"HelpWin","width=240,height=350,toolbar=no,resizable=yes,scrollbars=yes,directories=no");
  }

//--></script>
</head>
<body bgcolor="#003366" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000" marginwidth=0 marginheight=15 topmargin=15 leftmargin=0> 

<form method=post action="$cgiurl$">
<center>

<!-- MENU TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td rowspan=3 width=68>
   <a href="$cgiurl$?"><img src="$image_url$/window_nw.gif" width="68" height="44" border="0" alt="Click here to return to the start page"></a><br>
    <table border=0 cellspacing=0 cellpadding=0><tr><td bgcolor="#003399">
     <img src="$image_url$/window_nw2.gif" width="68" height="4" border="0" alt=""><br>
    </td></tr></table>
  </td>
  <td bgcolor="#CCCCCC" width=516>
  <!-- title bar -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr>
    <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
     <table border=0 cellspacing=0 cellpadding=0 width=100%>
      <tr>
       <!-- title bar text -->
       <td><font face="MS Sans Serif" color="#FFFFFF" size=1><b>&nbsp;$titlebar$</b></font></td>
       <!-- title bar buttons (?)(X) -->
       <td align=right><img src="$image_url$/window_buttons.gif" height=18 width=34 border=0 alt="" usemap="#buttons" ismap></td>
       <map name="buttons">
       <area shape="circle" coords="8,9,8"  href="javascript:Help($hnum$)" onfocus="blur();" title="Click for Help">
       <area shape="circle" coords="26,9,8" href="$cgiurl$?logoff=1"	  onfocus="blur();" title="Logoff Program">
       <AREA SHAPE="DEFAULT" NOHREF>
       </map>
      </tr>
     </table>
    </td>
   </tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /title bar -->
  </td>
  <td rowspan=3 width=6><img src="$image_url$/window_ne.gif" width="6" height="48" border="0" alt=""></td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC" height=18 valign=middle>
   <!-- menu bar -->
   <table border=0 cellpadding=0 cellspacing=0>
    <tr>
     <td id="m1" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1;"><a href="$cgiurl$?listing_list=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m1.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m1.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m1.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m1.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m1.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m1.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m1.style.borderColor = '#CCCCCC'; m1.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;Listing Editor&nbsp;&nbsp;</font></a><br>
     </td>
     <td id="m2" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1;"><a href="$cgiurl$?homepage_list=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m2.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m2.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m2.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m2.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m2.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m2.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m2.style.borderColor = '#CCCCCC'; m2.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;Homepage Editor&nbsp;&nbsp;</font></a><br>
     </td>
     <td id="m3" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1 ;"><a href="$cgiurl$?userman_list=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m3.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m3.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m3.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m3.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m3.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m3.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m3.style.borderColor = '#CCCCCC'; m3.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;User Manager&nbsp;&nbsp;</font></a><br>
     </td>
     <td id="m4" style="border-style: solid; border-width: 1; border-color: #CCCCCC; padding: 0 1 0 1 ;"><a href="$cgiurl$?setup_options_edit=1" class="menu" onfocus="blur();"
      onmouseover="if(IE>3){ m4.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m4.style.padding='0 1 1 1';}"
      onclick    ="if(IE>3){ m4.style.borderColor = '#FFFFFF #999999 #999999 #FFFFFF'; m4.style.padding='0 1 1 1';}"
      onmousedown="if(IE>3){ m4.style.borderColor = '#999999 #FFFFFF #FFFFFF #999999'; m4.style.padding='1 0 0 2';}"
      onmouseout= "if(IE>3){ m4.style.borderColor = '#CCCCCC'; m4.style.padding='0 1 1 1';}"><font face="ms sans serif" size=1>&nbsp;&nbsp;Setup Options&nbsp;&nbsp;</font></a><br>
     </td>
    </tr>
   </table> 
   <!-- /menu bar -->
  </td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC">
  <!-- lower border -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /lower border -->
  </td>
 </tr>
</table>

<!-- template : define pagebody -->
<!-- CONTENT TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#003399" width=59><img src="$image_url$/spacer.gif" height=1 width=59 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=517>
   <!-- PAGE CONTENT -->
   $content$
   <!-- /PAGE CONTENT -->
  </td>
  <td bgcolor="#CCCCCC" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#FFFFFF" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#999999" width=2><img src="$image_url$/spacer.gif" height=1 width=2 border=0 alt=""></td>
  <td bgcolor="#666666" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
  <td bgcolor="#000000" width=1><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td>
 </tr>
</table>


<!-- FOOTER TABLE -->
<table border="0" cellpadding="0" cellspacing="0" width=590>
 <tr>
  <td rowspan=2 width=73>
   <table border=0 cellspacing=0 cellpadding=0>
    <tr><td bgcolor="#003399"><img src="$image_url$/window_sw.gif" width="73" height="6" border="0" alt=""></td></tr>
    <tr><td><img src="$image_url$/window_sw2.gif" width="73" height="40" border="0" alt=""></td></tr>
   </table>
  </td>
  <td bgcolor="#FFFFFF" width=511 height=20 valign=top align=right>$buttons$&nbsp;</td>
  <!-- footer image right -->
  <td rowspan=2 width=6><img src="$image_url$/window_se.gif" width="6" height="46" border="0" alt=""></td>
 </tr>
 <tr>
  <td bgcolor="#000066" height=18>
  <!-- footer bar -->
  <table border=0 cellspacing=0 cellpadding=0 width=100%>
   <tr><td bgcolor="#CCCCCC"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#FFFFFF"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr>
    <td bgcolor="#000066" height=18 background="$image_url$/window_bg.gif">
     <table border=0 cellspacing=0 cellpadding=0 width=100%>
      <tr>
       <td align=left><font face="MS Sans Serif" color="#FFFFFF" size=1>Current User: $cuser_name$ (superuser)</font></td>
       <td align=right><font face="MS Sans Serif" color="#FFFFFF" size=1><span id="desc">$footerbar$</span>&nbsp;</font></td>
      </tr>
     </table>
    </td>
   </tr>
   <tr><td bgcolor="#999999"><img src="$image_url$/spacer.gif" height=2 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#666666"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
   <tr><td bgcolor="#000000"><img src="$image_url$/spacer.gif" height=1 width=1 border=0 alt=""></td></tr>
  </table>
  <!-- /footer bar -->
  </td>
 </tr>
</table>

</center>
</form>
</body>
</html>

<!-- template : /define pagebody -->

--- _userman_add.html ---

<script language="JavaScript"><!--

function showPass() { alert(document.forms[0].login_pw.value); }

// --></script>


<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

 <!-- Content Title -->
 <p><table border=0 width=100% cellspacing=0 cellpadding=2>
  <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;User Manager - Add User</b></font></td></tr>
 </table>
 <font size=1><br></font>
 <!-- /Content Title -->

    <!-- insert error message here -->
    <center>
<!-- template insert : $error$ -->
<!-- templatecell : invalid_login_name -->
      <font face="ms sans serif" size=2 color="#FF0000"><b>Sorry, That login name is already taken,<br>please choose another.</b></font><br><br>
<!-- /templatecell : invalid_login_name -->
<!-- templatecell : invalid_filename -->
      <font face="ms sans serif" size=2 color="#FF0000"><b>Sorry, That homepage filename is already taken,<br>please choose another.</b></font><br><br>
<!-- /templatecell : invalid_filename -->
    </center>

    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td width=200><font size=2 face="ms sans serif">Full Name</font></td>
      <td><input type=text name="name" value="$name$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Login Name</font></td>
      <td><input type=text name="login_id" value="$login_id$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Login Password <font size=1>[<a href="javascript:showPass();">view</a>]</font></font></td>
      <td><input type=password name="login_pw" value="$login_pw$" size=30></td>
     </tr> 
     <tr>
      <td><font size=2 face="ms sans serif">Access Level</font></td>
      <td>
       <select name="access">
       <option value="1" $access_1_selected$>New User
       <option value="2" $access_2_selected$>Regular User
       <option value="3" $access_3_selected$>Administrator
<!-- template : insert $extra_option$ -->
<!-- template : define superuser -->
       <option value="4" $access_4_selected$>Superuser
<!-- template : /define superuser -->
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Account Created</font></td>
      <td>
       <select name="created_mon">
       <option value="1"  $created_mon_1_selected$>Jan
       <option value="2"  $created_mon_2_selected$>Feb
       <option value="3"  $created_mon_3_selected$>Mar
       <option value="4"  $created_mon_4_selected$>Apr
       <option value="5"  $created_mon_5_selected$>May
       <option value="6"  $created_mon_6_selected$>Jun
       <option value="7"  $created_mon_7_selected$>Jul
       <option value="8"  $created_mon_8_selected$>Aug
       <option value="9"  $created_mon_9_selected$>Sep
       <option value="10" $created_mon_10_selected$>Oct
       <option value="11" $created_mon_11_selected$>Nov
       <option value="12" $created_mon_12_selected$>Dec
       </select>
              
       <select name="created_day">
       <option value="1" $created_day_1_selected$>1
       <option value="2" $created_day_2_selected$>2
       <option value="3" $created_day_3_selected$>3
       <option value="4" $created_day_4_selected$>4
       <option value="5" $created_day_5_selected$>5
       <option value="6" $created_day_6_selected$>6
       <option value="7" $created_day_7_selected$>7
       <option value="8" $created_day_8_selected$>8
       <option value="9" $created_day_9_selected$>9
       <option value="10" $created_day_10_selected$>10
       <option value="11" $created_day_11_selected$>11
       <option value="12" $created_day_12_selected$>12
       <option value="13" $created_day_13_selected$>13
       <option value="14" $created_day_14_selected$>14
       <option value="15" $created_day_15_selected$>15
       <option value="16" $created_day_16_selected$>16
       <option value="17" $created_day_17_selected$>17
       <option value="18" $created_day_18_selected$>18
       <option value="19" $created_day_19_selected$>19
       <option value="20" $created_day_20_selected$>20
       <option value="21" $created_day_21_selected$>21
       <option value="22" $created_day_22_selected$>22
       <option value="23" $created_day_23_selected$>23
       <option value="24" $created_day_24_selected$>24
       <option value="25" $created_day_25_selected$>25
       <option value="26" $created_day_26_selected$>26
       <option value="27" $created_day_27_selected$>27
       <option value="28" $created_day_28_selected$>28
       <option value="29" $created_day_29_selected$>29
       <option value="30" $created_day_30_selected$>30
       <option value="31" $created_day_31_selected$>31
       </select>
              
       <select name="created_year">
       <option value="1999" $created_year_1999_selected$>1999
       <option value="2000" $created_year_2000_selected$>2000
       <option value="2001" $created_year_2001_selected$>2001
       <option value="2002" $created_year_2002_selected$>2002
       <option value="2003" $created_year_2003_selected$>2003
       <option value="2004" $created_year_2004_selected$>2004
       <option value="2005" $created_year_2005_selected$>2005
       <option value="2006" $created_year_2006_selected$>2006
       <option value="2007" $created_year_2007_selected$>2007
       <option value="2008" $created_year_2008_selected$>2008
       <option value="2009" $created_year_2009_selected$>2009
       <option value="2010" $created_year_2010_selected$>2010
       <option value="2011" $created_year_2011_selected$>2011
       <option value="2012" $created_year_2012_selected$>2012
       <option value="2013" $created_year_2013_selected$>2013
       <option value="2014" $created_year_2014_selected$>2014
       <option value="2015" $created_year_2015_selected$>2015
       <option value="2016" $created_year_2016_selected$>2016
       <option value="2017" $created_year_2017_selected$>2017
       <option value="2018" $created_year_2018_selected$>2018
       <option value="2019" $created_year_2019_selected$>2019
       <option value="2020" $created_year_2020_selected$>2020
       <option value="2021" $created_year_2021_selected$>2021
       <option value="2022" $created_year_2022_selected$>2022
       <option value="2023" $created_year_2023_selected$>2023
       <option value="2024" $created_year_2024_selected$>2024
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Account Expires</font></td>
      <td>       
       <select name="expires_mon">
       <option value="1"  $expires_mon_1_selected$>Jan
       <option value="2"  $expires_mon_2_selected$>Feb
       <option value="3"  $expires_mon_3_selected$>Mar
       <option value="4"  $expires_mon_4_selected$>Apr
       <option value="5"  $expires_mon_5_selected$>May
       <option value="6"  $expires_mon_6_selected$>Jun
       <option value="7"  $expires_mon_7_selected$>Jul
       <option value="8"  $expires_mon_8_selected$>Aug
       <option value="9"  $expires_mon_9_selected$>Sep
       <option value="10" $expires_mon_10_selected$>Oct
       <option value="11" $expires_mon_11_selected$>Nov
       <option value="12" $expires_mon_12_selected$>Dec
       </select>
              
       <select name="expires_day">
       <option value="1" $expires_day_1_selected$>1
       <option value="2" $expires_day_2_selected$>2
       <option value="3" $expires_day_3_selected$>3
       <option value="4" $expires_day_4_selected$>4
       <option value="5" $expires_day_5_selected$>5
       <option value="6" $expires_day_6_selected$>6
       <option value="7" $expires_day_7_selected$>7
       <option value="8" $expires_day_8_selected$>8
       <option value="9" $expires_day_9_selected$>9
       <option value="10" $expires_day_10_selected$>10
       <option value="11" $expires_day_11_selected$>11
       <option value="12" $expires_day_12_selected$>12
       <option value="13" $expires_day_13_selected$>13
       <option value="14" $expires_day_14_selected$>14
       <option value="15" $expires_day_15_selected$>15
       <option value="16" $expires_day_16_selected$>16
       <option value="17" $expires_day_17_selected$>17
       <option value="18" $expires_day_18_selected$>18
       <option value="19" $expires_day_19_selected$>19
       <option value="20" $expires_day_20_selected$>20
       <option value="21" $expires_day_21_selected$>21
       <option value="22" $expires_day_22_selected$>22
       <option value="23" $expires_day_23_selected$>23
       <option value="24" $expires_day_24_selected$>24
       <option value="25" $expires_day_25_selected$>25
       <option value="26" $expires_day_26_selected$>26
       <option value="27" $expires_day_27_selected$>27
       <option value="28" $expires_day_28_selected$>28
       <option value="29" $expires_day_29_selected$>29
       <option value="30" $expires_day_30_selected$>30
       <option value="31" $expires_day_31_selected$>31
       </select>
              
       <select name="expires_year">
       <option value="1999" $expires_year_1999_selected$>1999
       <option value="2000" $expires_year_2000_selected$>2000
       <option value="2001" $expires_year_2001_selected$>2001
       <option value="2002" $expires_year_2002_selected$>2002
       <option value="2003" $expires_year_2003_selected$>2003
       <option value="2004" $expires_year_2004_selected$>2004
       <option value="2005" $expires_year_2005_selected$>2005
       <option value="2006" $expires_year_2006_selected$>2006
       <option value="2007" $expires_year_2007_selected$>2007
       <option value="2008" $expires_year_2008_selected$>2008
       <option value="2009" $expires_year_2009_selected$>2009
       <option value="2010" $expires_year_2010_selected$>2010
       <option value="2011" $expires_year_2011_selected$>2011
       <option value="2012" $expires_year_2012_selected$>2012
       <option value="2013" $expires_year_2013_selected$>2013
       <option value="2014" $expires_year_2014_selected$>2014
       <option value="2015" $expires_year_2015_selected$>2015
       <option value="2016" $expires_year_2016_selected$>2016
       <option value="2017" $expires_year_2017_selected$>2017
       <option value="2018" $expires_year_2018_selected$>2018
       <option value="2019" $expires_year_2019_selected$>2019
       <option value="2020" $expires_year_2020_selected$>2020
       <option value="2021" $expires_year_2021_selected$>2021
       <option value="2022" $expires_year_2022_selected$>2022
       <option value="2023" $expires_year_2023_selected$>2023
       <option value="2024" $expires_year_2024_selected$>2024
       </select>
      </td>
     </tr>
     <tr>
      <td valign=top><font size=2 face="ms sans serif">&nbsp;</font></td>
      <td><input type=checkbox name="expires_never" value="1" $expires_never_checked$><font size=2 face="ms sans serif">Account Never Expires</font></td>
     </tr>
     <tr>
      <td valign=top><font size=2 face="ms sans serif">&nbsp;</font></td>
      <td><input type=checkbox name="disabled" value="1" $disabled_1_checked$><font size=2 face="ms sans serif">Account Disabled</font></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Max listings allowed</font></td>
      <td>
       <input type=text name="listings_max" value="$listings_max$" size=5>
       <input type=checkbox name="listings_unlimited" value="1" $listings_unlimited_checked$><font size=2 face="ms sans serif">No Limit</font>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Display in homepage index?</font></td>
      <td>
       <input type=radio name="user_listed" value="1" $user_listed_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="user_listed" value="0" $user_listed_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Specify homepage filename?</font></td>
      <td>
       <input type=radio name="specify_filename" value="1" $specify_filename_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="specify_filename" value="0" $specify_filename_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Homepage Filename</font></td>
      <td><input type=text name="homepage_filename" value="$homepage_filename$" size=30></td>
     </tr> 
    </table>

    <table border=0 cellspacing=0 cellpadding=1>
     <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>
       <font size=2 face="ms sans serif"><br>Notes</font>
       <textarea name="notes" cols=55 rows=5>$notes$</textarea><br>
      </td>
     </tr>
    </table>

  </td></tr></table>
--- _userman_confirm_erase.html ---

<input type=hidden name="num" value="$num$">


<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

 <!-- Content Title -->
 <p><table border=0 width=100% cellspacing=0 cellpadding=2>
  <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;User Manager - Erase User</b></font></td></tr>
 </table>
 <font size=1><br></font>
 <!-- /Content Title -->

  <font face="arial" size=2><br><br>
    Are you sure you want to erase this user?<br>
    $name$<p>

    <font color="#FF0000"><b>Warning:</b></font> User homepage and listings will also be erased.

   </font><br><br><br>

</td></tr></table>

--- _userman_edit.html ---
<input type=hidden name="num" value="$num$">

<script language="JavaScript"><!--

function showPass() { alert(document.forms[0].login_pw.value); }

// --></script>


<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

 <!-- Content Title -->
 <p><table border=0 width=100% cellspacing=0 cellpadding=2>
  <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;User Manager - Edit User</b></font></td></tr>
 </table>
 <font size=1><br></font>
 <!-- /Content Title -->

    <!-- insert error message here -->
    <center>
<!-- template insert : $error$ -->
<!-- templatecell : invalid_login_name -->
      <font face="ms sans serif" size=2 color="#FF0000"><b>Sorry, That login name is already taken,<br>please choose another.</b></font><br><br>
<!-- /templatecell : invalid_login_name -->
<!-- templatecell : invalid_filename -->
      <font face="ms sans serif" size=2 color="#FF0000"><b>Sorry, That homepage filename is already taken,<br>please choose another.</b></font><br><br>
<!-- /templatecell : invalid_filename -->
    </center>


    <table border=0 cellspacing=0 cellpadding=1>
     <tr><td rowspan=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
     <tr>
      <td width=200><font size=2 face="ms sans serif">User #</font></td>
      <td><font size=2 face="ms sans serif">$num$<font size=3>&nbsp;</font></font></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Full Name</font></td>
      <td><input type=text name="name" value="$name$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Login Name</font></td>
      <td><input type=text name="login_id" value="$login_id$" size=30></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Login Password <font size=1>[<a href="javascript:showPass();">view</a>]</font></font></td>
      <td><input type=password name="login_pw" value="$login_pw$" size=30></td>
     </tr> 
     <tr>
      <td><font size=2 face="ms sans serif">Access Level</font></td>
      <td>
       <select name="access">
       <option value="1" $access_1_selected$>New User
       <option value="2" $access_2_selected$>Regular User
       <option value="3" $access_3_selected$>Administrator
<!-- template : insert $extra_option$ -->
<!-- template : define superuser -->
       <option value="4" $access_4_selected$>Superuser
<!-- template : /define superuser -->
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Account Created</font></td>
      <td>
       <select name="created_mon">
       <option value="1"  $created_mon_1_selected$>Jan
       <option value="2"  $created_mon_2_selected$>Feb
       <option value="3"  $created_mon_3_selected$>Mar
       <option value="4"  $created_mon_4_selected$>Apr
       <option value="5"  $created_mon_5_selected$>May
       <option value="6"  $created_mon_6_selected$>Jun
       <option value="7"  $created_mon_7_selected$>Jul
       <option value="8"  $created_mon_8_selected$>Aug
       <option value="9"  $created_mon_9_selected$>Sep
       <option value="10" $created_mon_10_selected$>Oct
       <option value="11" $created_mon_11_selected$>Nov
       <option value="12" $created_mon_12_selected$>Dec
       </select>
              
       <select name="created_day">
       <option value="1" $created_day_1_selected$>1
       <option value="2" $created_day_2_selected$>2
       <option value="3" $created_day_3_selected$>3
       <option value="4" $created_day_4_selected$>4
       <option value="5" $created_day_5_selected$>5
       <option value="6" $created_day_6_selected$>6
       <option value="7" $created_day_7_selected$>7
       <option value="8" $created_day_8_selected$>8
       <option value="9" $created_day_9_selected$>9
       <option value="10" $created_day_10_selected$>10
       <option value="11" $created_day_11_selected$>11
       <option value="12" $created_day_12_selected$>12
       <option value="13" $created_day_13_selected$>13
       <option value="14" $created_day_14_selected$>14
       <option value="15" $created_day_15_selected$>15
       <option value="16" $created_day_16_selected$>16
       <option value="17" $created_day_17_selected$>17
       <option value="18" $created_day_18_selected$>18
       <option value="19" $created_day_19_selected$>19
       <option value="20" $created_day_20_selected$>20
       <option value="21" $created_day_21_selected$>21
       <option value="22" $created_day_22_selected$>22
       <option value="23" $created_day_23_selected$>23
       <option value="24" $created_day_24_selected$>24
       <option value="25" $created_day_25_selected$>25
       <option value="26" $created_day_26_selected$>26
       <option value="27" $created_day_27_selected$>27
       <option value="28" $created_day_28_selected$>28
       <option value="29" $created_day_29_selected$>29
       <option value="30" $created_day_30_selected$>30
       <option value="31" $created_day_31_selected$>31
       </select>
              
       <select name="created_year">
       <option value="1999" $created_year_1999_selected$>1999
       <option value="2000" $created_year_2000_selected$>2000
       <option value="2001" $created_year_2001_selected$>2001
       <option value="2002" $created_year_2002_selected$>2002
       <option value="2003" $created_year_2003_selected$>2003
       <option value="2004" $created_year_2004_selected$>2004
       <option value="2005" $created_year_2005_selected$>2005
       <option value="2006" $created_year_2006_selected$>2006
       <option value="2007" $created_year_2007_selected$>2007
       <option value="2008" $created_year_2008_selected$>2008
       <option value="2009" $created_year_2009_selected$>2009
       <option value="2010" $created_year_2010_selected$>2010
       <option value="2011" $created_year_2011_selected$>2011
       <option value="2012" $created_year_2012_selected$>2012
       <option value="2013" $created_year_2013_selected$>2013
       <option value="2014" $created_year_2014_selected$>2014
       <option value="2015" $created_year_2015_selected$>2015
       <option value="2016" $created_year_2016_selected$>2016
       <option value="2017" $created_year_2017_selected$>2017
       <option value="2018" $created_year_2018_selected$>2018
       <option value="2019" $created_year_2019_selected$>2019
       <option value="2020" $created_year_2020_selected$>2020
       <option value="2021" $created_year_2021_selected$>2021
       <option value="2022" $created_year_2022_selected$>2022
       <option value="2023" $created_year_2023_selected$>2023
       <option value="2024" $created_year_2024_selected$>2024
       </select>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Account Expires</font></td>
      <td>       
       <select name="expires_mon">
       <option value="1"  $expires_mon_1_selected$>Jan
       <option value="2"  $expires_mon_2_selected$>Feb
       <option value="3"  $expires_mon_3_selected$>Mar
       <option value="4"  $expires_mon_4_selected$>Apr
       <option value="5"  $expires_mon_5_selected$>May
       <option value="6"  $expires_mon_6_selected$>Jun
       <option value="7"  $expires_mon_7_selected$>Jul
       <option value="8"  $expires_mon_8_selected$>Aug
       <option value="9"  $expires_mon_9_selected$>Sep
       <option value="10" $expires_mon_10_selected$>Oct
       <option value="11" $expires_mon_11_selected$>Nov
       <option value="12" $expires_mon_12_selected$>Dec
       </select>
              
       <select name="expires_day">
       <option value="1" $expires_day_1_selected$>1
       <option value="2" $expires_day_2_selected$>2
       <option value="3" $expires_day_3_selected$>3
       <option value="4" $expires_day_4_selected$>4
       <option value="5" $expires_day_5_selected$>5
       <option value="6" $expires_day_6_selected$>6
       <option value="7" $expires_day_7_selected$>7
       <option value="8" $expires_day_8_selected$>8
       <option value="9" $expires_day_9_selected$>9
       <option value="10" $expires_day_10_selected$>10
       <option value="11" $expires_day_11_selected$>11
       <option value="12" $expires_day_12_selected$>12
       <option value="13" $expires_day_13_selected$>13
       <option value="14" $expires_day_14_selected$>14
       <option value="15" $expires_day_15_selected$>15
       <option value="16" $expires_day_16_selected$>16
       <option value="17" $expires_day_17_selected$>17
       <option value="18" $expires_day_18_selected$>18
       <option value="19" $expires_day_19_selected$>19
       <option value="20" $expires_day_20_selected$>20
       <option value="21" $expires_day_21_selected$>21
       <option value="22" $expires_day_22_selected$>22
       <option value="23" $expires_day_23_selected$>23
       <option value="24" $expires_day_24_selected$>24
       <option value="25" $expires_day_25_selected$>25
       <option value="26" $expires_day_26_selected$>26
       <option value="27" $expires_day_27_selected$>27
       <option value="28" $expires_day_28_selected$>28
       <option value="29" $expires_day_29_selected$>29
       <option value="30" $expires_day_30_selected$>30
       <option value="31" $expires_day_31_selected$>31
       </select>
              
       <select name="expires_year">
       <option value="1999" $expires_year_1999_selected$>1999
       <option value="2000" $expires_year_2000_selected$>2000
       <option value="2001" $expires_year_2001_selected$>2001
       <option value="2002" $expires_year_2002_selected$>2002
       <option value="2003" $expires_year_2003_selected$>2003
       <option value="2004" $expires_year_2004_selected$>2004
       <option value="2005" $expires_year_2005_selected$>2005
       <option value="2006" $expires_year_2006_selected$>2006
       <option value="2007" $expires_year_2007_selected$>2007
       <option value="2008" $expires_year_2008_selected$>2008
       <option value="2009" $expires_year_2009_selected$>2009
       <option value="2010" $expires_year_2010_selected$>2010
       <option value="2011" $expires_year_2011_selected$>2011
       <option value="2012" $expires_year_2012_selected$>2012
       <option value="2013" $expires_year_2013_selected$>2013
       <option value="2014" $expires_year_2014_selected$>2014
       <option value="2015" $expires_year_2015_selected$>2015
       <option value="2016" $expires_year_2016_selected$>2016
       <option value="2017" $expires_year_2017_selected$>2017
       <option value="2018" $expires_year_2018_selected$>2018
       <option value="2019" $expires_year_2019_selected$>2019
       <option value="2020" $expires_year_2020_selected$>2020
       <option value="2021" $expires_year_2021_selected$>2021
       <option value="2022" $expires_year_2022_selected$>2022
       <option value="2023" $expires_year_2023_selected$>2023
       <option value="2024" $expires_year_2024_selected$>2024
       </select>
      </td>
     </tr>
     <tr>
      <td valign=top><font size=2 face="ms sans serif">&nbsp;</font></td>
      <td><input type=checkbox name="expires_never" value="1" $expires_never_checked$><font size=2 face="ms sans serif">Account Never Expires</font></td>
     </tr>
     <tr>
      <td valign=top><font size=2 face="ms sans serif">&nbsp;</font></td>
      <td><input type=checkbox name="disabled" value="1" $disabled_1_checked$><font size=2 face="ms sans serif">Account Disabled</font></td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Max listings allowed</font></td>
      <td>
       <input type=text name="listings_max" value="$listings_max$" size=5>
       <input type=checkbox name="listings_unlimited" value="1" $listings_unlimited_checked$><font size=2 face="ms sans serif">No Limit</font>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Display in homepage index?</font></td>
      <td>
       <input type=radio name="user_listed" value="1" $user_listed_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="user_listed" value="0" $user_listed_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Specify homepage filename?</font></td>
      <td>
       <input type=radio name="specify_filename" value="1" $specify_filename_1_checked$> <font size=2 face="ms sans serif">Yes</font>
       <input type=radio name="specify_filename" value="0" $specify_filename_0_checked$> <font size=2 face="ms sans serif">No</font><br>
      </td>
     </tr>
     <tr>
      <td><font size=2 face="ms sans serif">Homepage Filename</font></td>
      <td><input type=text name="homepage_filename" value="$homepage_filename$" size=30></td>
     </tr> 
    </table>

    <table border=0 cellspacing=0 cellpadding=1>
     <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>
       <font size=2 face="ms sans serif"><br>Notes</font>
       <textarea name="notes" cols=55 rows=5>$notes$</textarea><br>
      </td>
     </tr>
    </table>

  </td></tr></table>
--- _userman_erased.html ---

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

 <!-- Content Title -->
 <p><table border=0 width=100% cellspacing=0 cellpadding=2>
  <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;User Manager</b></font></td></tr>
 </table>
 <font size=1><br></font>
 <!-- /Content Title -->

  <font face="arial" size=2><br><br><br>User has been erased.<br></font><br><br>

</td></tr></table>

--- _userman_list.html ---
<input type=hidden name="userman_list" value=1>

   <table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

    <p><table border=0 width=100% cellspacing=0 cellpadding=2>
     <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;User Manager</b></font></td></tr>
    </table>

    <table border=0 width=100% cellspacing=8 cellpadding=0>
     <tr>
      <td>

       <table border=0 cellspacing=0 cellpadding=1>
        <tr>
        <td>
         <font face="ms sans serif" size=1>Search&nbsp;</font><br>
         <select name="search">
         <option value="all">All Users
         <option value="1" $search_1_selected$>New Users
         <option value="2" $search_2_selected$>Regular Users
         <option value="3" $search_3_selected$>Administrators
<!-- template : insert $extra_option$ -->
<!-- template : define search_superuser -->
         <option value="4" $search_4_selected$>Superusers
<!-- template : /define search_superuser -->
         <option value="5" $search_5_selected$>Expired Users
         <option value="D" $search_D_selected$>Disabled Users
         </select>
        </td>
        <td>
         <font face="ms sans serif" size=1>for keyword</font><br>
         <input type=text name="keyword" value="$keyword$" size=15><br>
        </td>
        <td valign=bottom>&nbsp;<input type=submit name="userman_list" value="Go"></td>
       </tr>
      </table>

     </td>
     <td align=center>
 
      <table border=0 cellspacing=0 cellpadding=1>
       <tr><td align=center><font face="ms sans serif" size=1>Found $mcount$ of $rcount$</font></td></tr>
       <tr><td align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_list=1&pagenum=$lpage$" title="Last Page">&lt;&lt;</a> &nbsp;Page $cpage$ of $pcount$&nbsp; <a href="$cgiurl$?userman_list=1&pagenum=$npage$" title="Next Page">&gt;&gt;</a></font></td></tr>
      </table>
     </td>
    </tr>
   </table>

    <table border=0 cellspacing=1 cellpadding=1>
     <tr>
      <td bgcolor="#CCCCCC" width=240><font size=1 face="ms sans serif"><b>&nbsp;Full Name</b></font></td>
      <td bgcolor="#CCCCCC" width=75><font size=1 face="ms sans serif"><b>&nbsp;Access</b></font></td>
      <td bgcolor="#CCCCCC" width=75><font size=1 face="ms sans serif"><b>&nbsp;Expires</b></font></td>
      <td bgcolor="#CCCCCC" align=center width=90 colspan=2><font face="ms sans serif" size=1><b>Action</b></font></td>
     </tr>
<!-- template insert : $list$ -->
<!-- templatecell : disabled -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;Disabled</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_edit=$num$">modify</a></font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_confirm_erase=$num$">erase</a></font></td>
     </tr>
<!-- /templatecell : disabled -->
<!-- templatecell : newuser -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;New User</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_edit=$num$">modify</a></font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_confirm_erase=$num$">erase</a></font></td>
     </tr>
<!-- /templatecell : newuser -->
<!-- templatecell : regular -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;Regular</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_edit=$num$">modify</a></font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_confirm_erase=$num$">erase</a></font></td>
     </tr>
<!-- /templatecell : regular -->
<!-- templatecell : admin -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;Administrator</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_edit=$num$">modify</a></font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_confirm_erase=$num$">erase</a></font></td>
     </tr>
<!-- /templatecell : admin -->
<!-- templatecell : superuser -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$name$</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;Superuser</font></td>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=1>&nbsp;$expires$</font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_edit=$num$">modify</a></font></td>
      <td bgcolor="#EEEEEE" width=45 align=center><font face="ms sans serif" size=1><a href="$cgiurl$?userman_confirm_erase=$num$">erase</a></font></td>
     </tr>
<!-- /templatecell : superuser -->
<!-- templatecell : not_found -->
     <tr>
      <td bgcolor="#EEEEEE"><font face="ms sans serif" size=2>&nbsp;Sorry, no records were found.</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=2>&nbsp;</font></td>
      <td bgcolor="#EEEEEE" align=center><font face="ms sans serif" size=2>&nbsp;</font></td>
      <td bgcolor="#EEEEEE" colspan=2><font face="ms sans serif" size=2>&nbsp;</font></td>
     </tr>
<!-- /templatecell : not_found -->
    </table>
    </td></tr></table>


<!-- templatecell : null -->
<font face="ms sans serif" size=2>
<font color="#666666">Language specific text used on this page included below in templatecells:</font><br>
<p>
<!-- /templatecell : null -->

<!-- templatecell : never -->Never<!-- /templatecell : never -->
<!-- templatecell : expired -->Expired<!-- /templatecell : expired -->
<!-- templatecell : mon1 -->Jan<!-- /templatecell : mon1 -->
<!-- templatecell : mon2 -->Feb<!-- /templatecell : mon2 -->
<!-- templatecell : mon3 -->Mar<!-- /templatecell : mon3 -->
<!-- templatecell : mon4 -->Apr<!-- /templatecell : mon4 -->
<!-- templatecell : mon5 -->May<!-- /templatecell : mon5 -->
<!-- templatecell : mon6 -->Jun<!-- /templatecell : mon6 -->
<!-- templatecell : mon7 -->Jul<!-- /templatecell : mon7 -->
<!-- templatecell : mon8 -->Aug<!-- /templatecell : mon8 -->
<!-- templatecell : mon9 -->Sep<!-- /templatecell : mon9 -->
<!-- templatecell : mon10 -->Oct<!-- /templatecell : mon10 -->
<!-- templatecell : mon11 -->Nov<!-- /templatecell : mon11 -->
<!-- templatecell : mon12 -->Dec<!-- /templatecell : mon12 -->


--- _userman_saved.html ---

<table border=0 cellspacing=0 cellpadding=7 width=517><tr><td align=center>

 <!-- Content Title -->
 <p><table border=0 width=100% cellspacing=0 cellpadding=2>
  <tr><td bgcolor="#CCCCCC"><font size=2 face="ms sans serif"><b>&nbsp;User Manager</b></font></td></tr>
 </table>
 <font size=1><br></font>
 <!-- /Content Title -->

 <font face="arial" size=2><br><br><br>User data has been saved<br></font><br><br>

</td></tr></table>
