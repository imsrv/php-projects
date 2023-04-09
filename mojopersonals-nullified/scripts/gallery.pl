############################################################
sub GalleryMain{
	use vars qw($message);
	$CONFIG{member_gallery} = "$CONFIG{photo_path}/$FORM{username}";
	if($FORM{gallery}){						&GalleryImage;			}
		
	&MemberValidateSession;
	   if($FORM{action} eq "delete"){	&GalleryDelete;		}
	elsif($FORM{action} eq "deleteall"){&GalleryDeleteAll;	}
	elsif($FORM{action} eq "faq"){		&GalleryFaq;			}
	elsif($FORM{action} eq "recount"){	&GalleryRecount;		}
	elsif($FORM{action} eq "stat"){		&GalleryStats;			}
	elsif($FORM{action} eq "upload"){	&GalleryUpload;		}
	elsif($FORM{action} eq "view"){		&GalleryView;			}
	&GalleryDisplay($message);
}
############################################################
sub GalleryImage{
	my(%DB, $gallery, $html, $image, $template);
	$gallery = qq|$CONFIG{photo_path}/$FORM{gallery}|;
	$image   = qq|$gallery/$FORM{file}|;
	$template = &ParseCommonCodes($TEMPLATE{image});
	$FORM{username} = $FORM{gallery};
	if(-f $image){
		%DB = &RetrievePhotoDB($image);
		foreach (keys %DB){	$template =~ s/\[$_\]/$DB{$_}/ig;	}
	}
	elsif(-d $gallery){
		if(defined $MEMPER{photo_view_gallery} and not $MEMPER{photo_view_gallery}){
			$html = &BuildGalleryImages($gallery, 0, 4);
			unless ($html){ $html =qq|<table><tr><td colspan=3><font color=red>Gallery Empty</font></td></tr></table>|;			}
			$template =~ s/\[FULLSIZE\]/$html/iges;
		}
		else{
			$template =~ s/\[FULLSIZE\]/$mj{403}/;
		}
	}
	else{						$template =~ s/\[FULLSIZE\]/$mj{404}/;	}
	&PrintTemplate($template);
}
############################################################
sub GalleryDisplay{
	unless(-d $CONFIG{member_gallery}){
		mkpath($CONFIG{member_gallery}, 0, 0777);
		chmod(0777, $CONFIG{member_gallery});
	}
	$FORM{username} = $MEMBER{username};
	my $html = &BuildGalleryImages($CONFIG{member_gallery}, 0, 4);
	&PrintGalleryDisplay($html, @_);
}
############################################################
sub GalleryDelete{
	my($image, @images, $name, $ext);
	if($FORM{step} eq "final"){
		@images = $Cgi->param(mojochecklist);
		foreach $image (@images){
			next unless $image;
			if(unlink("$CONFIG{photo_path}/$MEMBER{username}/$image")){	$MEMBER{media_used}--;	}
			else{			$message .=qq|<li>Cannot delete file \'$image\' because $!.</li>|;		}
			($name, $ext) = &NameAndExt($image);
			unlink("$CONFIG{photo_path}/$MEMBER{username}/$name.$ext");
			unlink("$CONFIG{photo_path}/$MEMBER{username}/mojoscripts_$name.$ext");
			unlink("$CONFIG{photo_path}/$MEMBER{username}/mojoscripts_$name.jpg");
			unlink("$CONFIG{photo_path}/$MEMBER{username}/$name.txt");
		}
		$message = $mj{success} unless $message;
		&UpdateMemberDB(\%MEMBER);
	}
	&PrintGalleryDelete(&BuildGalleryImages($CONFIG{member_gallery}, "checkbox", 4), $message);
}
############################################################
sub GalleryDeleteAll{
	use File::Path;
	rmtree("$CONFIG{photo_path}/$MEMBER{username}");
	mkpath("$CONFIG{photo_path}/$MEMBER{username}");
	$MEMBER{media_used} =0;
	&UpdateMemberDB(\%MEMBER);
}
############################################################
sub GalleryFaq{
	&PrintTemplate("$CONFIG{template_path}/faq.html");
}
############################################################
sub GalleryRecount{
	my($count, $ext, @images, $name);
	mkpath("$CONFIG{photo_path}/$MEMBER{username}", 0, 0) unless (-d "$CONFIG{photo_path}/$MEMBER{username}");
	@images = &DirectoryFiles("$CONFIG{photo_path}/$MEMBER{username}");
	foreach (@images){
		($name, $ext) = &NameAndExt($_);
		next if ($name =~ /mojoscripts_/);
		next if ($ext =~ /txt/i);
		$count++;
	}
	$MEMBER{media_used} = $count;
	$MEMBER{media_allowed} = $CONFIG{media_allowed} unless ($MEMBER{media_allowed} >= $CONFIG{media_allowed});
	&UpdateMemberDB(\%MEMBER);
	&GalleryStats($mj{success});
}
############################################################
sub GalleryStats{		&PrintGalleryStats(@_);	}
############################################################
sub GalleryUpload{
	my($buffer, $ext, $file, $filename, $left, $name, $time);
	&CreateGallery($DB{username}) unless (-d $CONFIG{member_gallery});
	if($FORM{step} eq "final"){
		$left = $MEMBER{media_allowed} - $MEMBER{media_used};
		$time = &TimeNow;
		require "images.pl";
		for(my $i=1; $i<= $left; $i++){
			$file = "file_$i";
			next unless $FORM{$file};
###Check for existing file with the same name
			($name, $ext) = &NameAndExt($FORM{$file});
			$filename = "$CONFIG{photo_path}/$MEMBER{username}/$name.$ext";
			if(-f $filename){
				$message .= qq|<li>"$name.$ext" is already exist on your photo folder. Please choose a different one</li>|;
				next;
			}
##Check for valid file format
			if ($CONFIG{media_ext} !~ /$ext/i){
				$message .= qq|<li>"$name.$ext" is not an allowable image extension</li>|;
				next;
			}
###Start reading the file			
			$content = &ReadRemoteFile($FORM{$file}, $CONFIG{media_size});
			if($content == -1 ){
				$message .= qq|<li>This file size is larger than the allowable size of $CONFIG{media_size} bytes: "$name.$ext"</li>|;
				next;
			}
			next unless $content;
###if we read successfully, then $content is a pointer, convert to a string
			&FileWrite($filename, $content, "binary");
			$MEMBER{media_used}++;
###Create the thumbnail and write a image description			
			%PHOTO = &Thumbnail($filename, $CONFIG{media_width},$CONFIG{media_height});
			$PHOTO{username} = $MEMBER{username};
			&AddPhotoDB("$CONFIG{photo_path}/$MEMBER{username}/$name.txt",\%PHOTO);
		}
		&UpdateMemberDB(\%MEMBER);
		$message = $mj{success} unless $message;
	}
	else{	&PrintGalleryUploads($message);	}
}
############################################################
sub GalleryView{
	my $image_url = &PathToUrl("$CONFIG{photo_path}/$MEMBER{username}/$FORM{file}");
	&PrintGalleryView(qq|<a href="$CONFIG{gallery_url}"><img src="$image_url" border=0></a>|);
}
############################################################
sub PrintGallery{
	my($template, $html);
	$html = shift;
	$template = &ParseCommonCodes($TEMPLATE{gallery});
	$template =~ s/\[TEMPLATE_MENU\]/&BuildGalleryMenu()/e;
	$template =~ s/\[TEMPLATE_CONTENT\]/$html/;
	$template =~ s/\[TEMPLATE_TITLE\]/&BuildGalleryTitle()/e;
	$template =~ s/\[TEMPLATE_SUBTITLE\]/&BuildGallerySubtitle()/e;
	&PrintHeader;
	print $template;
	&PrintFooter;	
}
############################################################
sub PrintGalleryDelete{		&PrintGallery(&BuildGalleryDelete(@_));	}
sub PrintGalleryDisplay{	&PrintGallery(&BuildGalleryDisplay(@_));	}
sub PrintGalleryStats{		&PrintGallery(&BuildGalleryStats(@_));		}
sub PrintGalleryUploads{	&PrintGallery(&BuildGalleryUpload(@_));	}
sub PrintGalleryView{		&PrintGallery(@_);								}
############################################################
sub BuildGalleryImages{
	my($count, $ext, @ext, @images, $image, $filename, $fileurl, $html, $name);
	my($path, $checkbox, $cols) = @_;
	$cols = 4 unless $cols;
	@ext = split(/\,\s*/, $CONFIG{media_ext});
	return "" unless (-d $path);
	
	@images = &DirectoryFiles($path, \@ext);
	foreach $image (@images){
		($name, $ext) = &NameAndExt($image);
		next if ($name =~ /mojoscripts_/);
		if(-f "$path/mojoscripts_$name.$ext"){	$fileurl = &PathToUrl("$path/mojoscripts_$name.$ext");		}
		else{		$fileurl = &PathToUrl("$path/$name.$ext");		}
		
		$html .= qq|<td><table border="0" cellpadding="0" cellspacing="3">
  					<tr><td align="center" valign="bottom" nowrap><a href="$CONFIG{gallery_url}&gallery=$FORM{username}&action=view&file=$name.$ext"><img src="$fileurl" width="$CONFIG{media_width}" height="$CONFIG{media_height}" border=0></a></td></tr>
 	 				<tr><td align="center"><font size="1">$name.$ext</font></td></tr>
  					|;
		if($checkbox){	$html .=qq|<tr><td align="center"><input type="$checkbox" name="mojochecklist" value="$name.$ext"></td></tr>|;	}
		$html .=qq|</table></td>|;
		
		if($count == $cols){ $html .=qq|</tr><tr>|;			$count=0;		}
		else{		$count++;	}
	}
	if($html){	$html = qq|<div align="center"><table border="0" cellpadding="3" cellspacing="1"><tr>$html</tr></table></div>|;	}
	else{			$html =qq|<table><tr><td colspan=3><font color=red>Gallery Empty</font></td></tr></table>|;			}
	
	return $html;
}
############################################################
sub BuildGalleryMenu{
	return qq|

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><a href="$CONFIG{gallery_url}">Gallery</a><br>
      <a href="$CONFIG{gallery_url}&action=delete">Delete Photos</a><br>
      <a href="$CONFIG{gallery_url}&action=upload">Upload Photos</a><br>
      <a href="$CONFIG{gallery_url}&action=recount">Recount Photos</a><br>
      <a href="$CONFIG{gallery_url}&action=stat">Gallery Stats</a><br>
      <a href="$CONFIG{gallery_url}&action=faq#gallery">Gallery FAQs</a></td>
  </tr>
  <tr><td> <hr width="100%" size="0"></td></tr>
  <tr> <td height="5"><a href="$CONFIG{ad_url}">Ads</a></td></tr>
  <tr> <td><a href="$CONFIG{mail_url}">Mailbox</a></td></tr>
  <tr> <td><a href="$CONFIG{member_url}&action=profile">Profile</a></td></tr>
</table>
	|;
}
############################################################
sub BuildGalleryDelete{
	my($html, $message) = @_; 
	return  qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td height="62"> 
      <form action="$CONFIG{gallery_url}" method="post" name="mojo">
          <input type="hidden" name="type" value="gallery">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="step" value="final">
        <table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
          <tr> 
              <td valign="top"> 
                <div align="center"><font color="#FF0000"><b>$message </b></font><font face="Verdana,Geneva,Arial" size="1"></font></div>
              </td>
            </tr>
            <tr> 
              <td valign="top" height="21">&nbsp;</td>
            </tr>
            <tr> 
              <td valign="top" height="36"> 
                <div align="center">$html </div>
              </td>
            </tr>
            <tr> 
              <td valign="top" height="5" bgcolor="#EBEBEB"> 
                <div align="center"> 
                  <input type="submit" name="delete" value=" Delete ">
                </div>
              </td>
            </tr>
          </table>
      </form>
    </td>
  </tr>
</table>
	|;
}
############################################################
sub BuildGalleryDisplay{
	my($html, $message) = @_; 
	return  qq|
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr> 
    <td width="19" height="72" rowspan="2">&nbsp;</td>
    <td valign="top" height="37"> 
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr> 
          <td valign="top"> 
            <div align="center"><font color="#FF0000"><b>$message </b></font><font face="Verdana,Geneva,Arial" size="1"></font></div>
          </td>
        </tr>
        <tr> 
          <td valign="top"><font face="Verdana,Geneva,Arial" size="1">Post your 
            ad with pictures attract more people. Use the Gallery Manager to upload 
            and manage the images you'll use for your ads for <b>free!</b></font></td>
        </tr>
      </table>
      <div align="center"></div>
    </td>
    <td width="19" height="72" rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" height="36">
      <div align="center">$html </div>
    </td>
  </tr>
</table>
	|;
}
############################################################
sub BuildGalleryStats{
	my($size, $gallery_size);
	$size = &FormatSize($CONFIG{media_size},'kb');
	$gallery_size = &FormatSize(&DirectorySize("$CONFIG{photo_path}/$MEMBER{username}"));
	$MEMBER{media_used} = 0 unless $MEMBER{media_used};
	return qq|
<div align="center">
  <table width="95%" border="0" cellspacing="1" cellpadding="3">
    <tr> 
    <td bgcolor="#ebebeb" colspan="2"><b>Gallery Statistics</b></td>
  </tr>
  <tr> 
      <td width="223"><b>Allowable image extensions</b></td>
      <td>$CONFIG{media_ext}</td>
  </tr>
  <tr> 
      <td width="223"><b>Allowable image size</b></td>
      <td>smaller than $size KB</td>
  </tr>
  <tr> 
      <td width="223"><b>You can upload</b></td>
      <td>$MEMBER{media_allowed} images</td>
  </tr>
  <tr> 
      <td width="223"><b>You've uploaded</b></td>
      <td>$MEMBER{media_used} images</td>
  </tr>
  <tr> 
      <td width="223"><b>Your gallery size</b></td>
      <td>$gallery_size KB</td>
  </tr>
  <tr> 
      <td width="223"><b></b></td>
      <td>&nbsp;</td>
  </tr>
  <tr> 
      <td width="223" height="11"><b></b></td>
      <td height="11"><b>note:</b> <font size="2">If you have used less upload 
        credit than what's displayed, please use the &quot;Recount Photos&quot; 
        function to have us recount your photos. </font></td>
  </tr>
</table>
<p>&nbsp;</p>
</div>
	|;
}
############################################################
sub BuildGalleryUpload{
	my($i, $end, $html, $file, $size);
	$end = $MEMBER{media_allowed} - $MEMBER{media_used};
	$size = sprintf("%2d", $CONFIG{media_size}/1024);
	$end = 5 unless $end < 5;
	for(my $i=1; $i <= $end; $i++){
		$file = "file_$i";
		$html .= qq|
	<table border="0" cellpadding="3" cellspacing="1" width="100%">
  <tr><td height="38" nowrap><font face="Verdana,Geneva,Arial" size="1"><b>&nbsp;&nbsp;Image 
      File:&nbsp;&nbsp;</b></font></td>
    <td width="100%" height="38"><input type="file" name="$file" size="28">
    </td>
  </tr>
	</table>
		|;
	}
	unless ($html){
		$html =qq|<p>You have used all your available upload credits. Please delete the images you don't want and try again</p>|;
	}
	return qq|
 
<table border="0" cellpadding="0" cellspacing="0" width="440" height="141">
  <tr> 
    <td width="19" height="161">&nbsp;</td>
    <td valign="top" height="161"> 
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr> 
          <td bgcolor="#ebebeb" width="100%"><font face="Arial,Geneva" size="4" class="i"><b>Upload 
            Images</b></font></td>
        </tr>
        <tr> 
          <td width="100%"><font face="Verdana,Geneva,Arial" size="1">Add images 
            to your ads for <b>free!</b> You may upload images in $CONFIG{media_ext}. 
            Each image can be up to $size KB in size.<br>
            <br>
            It may take a few minutes to upload an image, depending on the size 
            of the file and your Internet connection.</font></td>
        </tr>
      </table>
      <div align="center"> 
        <form name="mojo" method="post" action="$CONFIG{gallery_url}" enctype="multipart/form-data">
          <input type="hidden" name="type" value="gallery">
          <input type="hidden" name="action" value="upload">
          <input type="hidden" name="step" value="final">
          $html<br>
          <br>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td bgcolor="#ebebeb"> 
                <div align="center"> 
                  <input type="submit" name="upload" value="Upload">
                </div>
              </td>
            </tr>
          </table>
        </form>
        <br>
      </div>
    </td>
    <td width="19" height="161">&nbsp;</td>
  </tr>
</table>

	|;
}
############################################################
sub BuildGallerySubtitle{
	my($title);
	if($FORM{action} eq "stat"){			$title =qq|Gallery Statistics|;		}
	elsif($FORM{action} eq "upload"){	$title =qq|Upload Photos|;				}
	elsif($FORM{action} eq "view"){		$title =qq|Gallery View|;				}
	elsif($FORM{folder}){					$title =qq|$FORM{folder}|;				}
	else{											$title =qq|Gallery Manager|;			}
	return $title;
}
############################################################
sub BuildGalleryTitle{		return "Your Gallery Center";	}
############################################################

1;