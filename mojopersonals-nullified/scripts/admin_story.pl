############################################################
sub StoryMain{
	$featured_story = "$CONFIG{testify_path}/featured_story.txt";
	if($FORM{action} eq "delete"){		&DeleteStory;				}
	elsif($FORM{action} eq "diaster"){	&SetDiaster;				}
	elsif($FORM{action} eq "dreamdate"){&SetDreamdate;				}
	elsif($FORM{action} eq "edit"){		&EditStory;					}
	elsif($FORM{action} eq "feature"){	&SetFeatured;				}
	elsif($FORM{action} eq "success"){	&SetSuccess;				}
	&StoryMain2;
}
sub StoryMain2{
	if($FORM{class} eq "diaster"){		&DiasterStories;			}
	elsif($FORM{class} eq "dreamdate"){	&DreamdateStories;		}
	elsif($FORM{class} eq "featured"){	&FeaturedStory;			}
	elsif($FORM{class} eq "success"){	&SuccessStories;				}
	elsif($FORM{class} eq "unreviewed"){&UnreviewedStories;		}
	&PrintStoryMain;
}
############################################################
sub DiasterStories{
	my($file, @files, $id, $line, @lines, $link, $html, $name);
	$file = &DirectoryFiles($CONFIG{testify_path}, ['dia']);
	@files = @$file;
	foreach $file (@files){
		$name = &LastDirectory($file);
		$line = &RetrieveStoryDatabase($file);
		%STORY = %$line;
		$HTML_action =qq|<a href="$CONFIG{admin_url}?type=story&class=diaster&action=delete&storyid=$name">Delete</a>|;
		$HTML_story .= &StoryTemplate;
	}
	&PrintStory("Diaster Stories", "dating become a nightmare");
}
############################################################
sub DreamdateStories{
	my($file, @files, $id, $line, @lines, $link, $html, $name);
	$file = &DirectoryFiles($CONFIG{testify_path}, ['dre']);
	@files = @$file;
	foreach $file (@files){
		$name = &LastDirectory($file);
		$line = &RetrieveStoryDatabase($file);
		%STORY = %$line;
		$HTML_action =qq|<a href="$CONFIG{admin_url}?type=story&class=dreamdate&action=delete&storyid=$name">Delete</a>|;
		$HTML_story .= &StoryTemplate;
	}
	&PrintStory("Dreamdate Stories", "Online loves become reality");
}
############################################################
sub SuccessStories{
	my($file, @files, $id, $line, @lines, $link, $html, $name);
	$file = &DirectoryFiles($CONFIG{testify_path}, ['suc']);
	@files = @$file;
	foreach $file (@files){
		$name = &LastDirectory($file);
		$line = &RetrieveStoryDatabase($file);
		%STORY = %$line;
		$HTML_action =qq|<a href="$CONFIG{admin_url}?type=story&class=success&action=delete&storyid=$name">Delete</a>|;
		$HTML_story .= &StoryTemplate;
	}
	&PrintStory("Dreamdate Stories", "Online loves become reality");
}
############################################################
sub UnreviewedStories{
	my($file, @files, $id, $line, @lines, $link, $html, $name);
	$file = &DirectoryFiles($CONFIG{testify_path});
	@files = @$file;
	foreach $file (@files){
		next if $file =~ /[dia|dre|suc]$/;
		$name = &LastDirectory($file);
		$line = &RetrieveStoryDatabase($file);
		%STORY = %$line;
		$HTML_action =qq|<a href="$CONFIG{admin_url}?type=story&class=unreviewed&action=delete&storyid=$name">Delete</a>
				    &nbsp\|<a href="$CONFIG{admin_url}?type=story&class=unreviewed&action=edit&storyid=$name">Edit</a>
					 &nbsp\|<a href="$CONFIG{admin_url}?type=story&class=unreviewed&action=feature&storyid=$name">Featured</a>
				    &nbsp\|<a href="$CONFIG{admin_url}?type=story&class=unreviewed&action=diaster&storyid=$name">Diaster Story</a>
					 &nbsp\|<a href="$CONFIG{admin_url}?type=story&class=unreviewed&action=dreamdate&storyid=$name">Dreamdate Story</a>
					 &nbsp\|<a href="$CONFIG{admin_url}?type=story&class=unreviewed&action=success&storyid=$name">Success Story</a>
					|;
		$HTML_story .= &StoryTemplate;
	}
	&PrintStory("Unreviewed Stories", "Stories submitted by members and haven't been reviewed");
}
############################################################
sub FeaturedStory{
	my($file, @files, $id, $line, @lines, $link, $html);
	if(-f $featured_story){
		$line = &RetrieveStoryDatabase($featured_story);
		%STORY = %$line;
		$HTML_story = &StoryTemplate;
	} else{
		$HTML_story =qq|<table><tr><td>No story has been selected as featured story</td></tr></table>|;
	}
	&PrintStory("Featured Story", "The best user submitted stories");
}
############################################################
#
############################################################
#save the old featured story if exist
sub SetFeatured{
	my($file, @files, $id, $line, @lines, $link, $html);
	if(-f $featured_story){
		$line = &RetrieveStoryDatabase($featured_story);
		%STORY = %$line;
		&SaveStoryDatabase("$CONFIG{testify_path}/$STORY{id}", \%STORY);
		$HTML_message = "This story has been selected as featured story. ID #: $FORM{storyid} ";
	}
	rename ("$CONFIG{testify_path}/$FORM{storyid}", $featured_story);
}
############################################################
sub SetDiaster{
	rename ("$CONFIG{testify_path}/$FORM{storyid}", "$CONFIG{testify_path}/$FORM{storyid}.dia");
	$HTML_message = "This story has been moved to diaster stories. ID #: $FORM{storyid}";	
}
sub SetDreamdate{
	rename ("$CONFIG{testify_path}/$FORM{storyid}", "$CONFIG{testify_path}/$FORM{storyid}.dre");
	$HTML_message = "This story has been moved to dreamdate stories. ID #: $FORM{storyid}";
}
sub SetSuccess{
	rename ("$CONFIG{testify_path}/$FORM{storyid}", "$CONFIG{testify_path}/$FORM{storyid}.suc");
	$HTML_message = "This story has been moved to success stories. ID #: $FORM{storyid}";
}
############################################################
sub DeleteStory{
	$HTML_message = "This story has been deleted. ID #: $FORM{storyid} ";
	unlink "$CONFIG{testify_path}/$FORM{storyid}";
}
############################################################
sub EditStory{
	my($file, @files, $id, $line, @lines, $link, $html);
	$line = &RetrieveStoryDatabase("$CONFIG{testify_path}/$FORM{storyid}");
	%STORY = %$line;
	if($FORM{step} eq "final"){
		$STORY{message} = $FORM{message};
		$STORY{title} = $FORM{title};
		&SaveStoryDatabase("$CONFIG{testify_path}/$FORM{storyid}", \%STORY);
		$HTML_message = "This story has been successfully updated. ID #: $FORM{storyid} ";
	}
	else{	&PrintEditStory;	}
}
############################################################
sub PrintEditStory{
	&PrintMojoHeader;
	print qq|
			<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#999999">
  <tr>
    <td valign="top" height="431"> 
      <center>
        <b><font face="Geneva, Arial, Helvetica, san-serif" size="3">Edit user 
        submitted story <br>
        Story submitted by <a href="$CONFIG{admin_url}?account=&type=member&action=detail&username=$STORY{username}&step=final">$STORY{username}</a></font></b> 
      </center>
      <form name="mojo" action="$CONFIG{admin_url}" method=post>
		 
        <input type="hidden" name="type" value="story">
		  <input type="hidden" name="class" value="$FORM{class}">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="step" value="final">
        <input type="hidden" name="storyid" value="$FORM{storyid}">
        <table border=0 cellpadding=2 cellspacing=0 width=585 align=center>
          <tr> 
            <td width="404" valign=top> <b><font face="Tahoma" size="2">Did you 
              find whom/what you were looking for? </font></b></td>
            <td valign=top width="173"> <b><font face="Tahoma" size="2"> $STORY{find}</font></b></td>
          </tr>
          <tr> 
            <td height=2> <b><font face="Tahoma" size="2">Was it a dreamdate or 
              a disater?</font></b></td>
            <td height=2> <b><font face="Tahoma" size="2"> $STORY{date}</font></b></td>
          </tr>
          <tr> 
            <td height=2><b><font face="Tahoma" size="2">How do you rate our service?</font></b></td>
            <td height=2> <b><font face="Tahoma" size="2"> $STORY{service}</font></b></td>
          </tr>
          <tr> 
            <td colspan=2 valign=top> <b><font face="Tahoma" size="2">Story Title 
              </font></b></td>
          </tr>
          <tr> 
            <td colspan=2 valign=top> <b><font face="Tahoma" size="2"> 
              <input type="text" name="title" size="60" maxlength="100" value="$STORY{title}">
              </font></b></td>
          </tr>
          <tr> 
            <td colspan=2 valign=top><b><font face="Tahoma" size="2">Your story</font></b></td>
          </tr>
          <tr> 
            <td colspan=2 height=4> <b><font face="Tahoma" size="2"> 
              <textarea cols=60 rows=10 wrap=VIRTUAL name=message>$STORY{message}</textarea>
              </font></b></td>
          </tr>
          <tr> 
            <td colspan=2 height=4><b><font face="Tahoma" size="2"></font></b></td>
          </tr>
          <tr align=middle> 
            <td colspan=2 valign=top> <b><font face="Tahoma" size="2"> 
              <input type=submit name=send value=" Save ">
              <input type=reset name=reset value="Reset">
              </font></b></td>
          </tr>
        </table>
        </form>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>

	|;
	&PrintMojoFooter;
}
############################################################
sub PrintStory{
	my($title, $message) = @_;
	&PrintMojoHeader;
	unless($HTML_story){		$HTML_story =qq|No entry available|;	}
	$message = $HTML_message if $HTML_message;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bordercolor="#999999">
  <tr> 
    <td valign="top" height="38"> 
      <center>
        <p><font face="Tahoma" size="5"><b>$title</b></font><br>
          <font color=red>$message </font></p>
      </center>
    </td>
  </tr>
  <tr><td valign="top" height="38"> &nbsp; </td></tr>
  <tr> 
    <td valign="top" height="53"> 
      <div align="center">$HTML_story </div>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
sub PrintStoryMain{
	&PrintMojoHeader;
	print qq|
	
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr> 
    <td colspan="2" height="17"> 
      <div align="center"> 
        <p><b><font face="Tahoma" size="4">Members Testimonials and Submitted 
          Stories<br>
          </font></b>What your customers say and think about your service!</p>
      </div>
    </td>
  </tr>
  <tr> 
    <td width="20%" valign="top"><b><a href="$CONFIG{admin_url}?type=story&class=featured">Featured 
      Story</a></b></td>
    <td width="80%">There is only one featured story, and that will be displayed 
      at the main page. Once a featured story is set, it cannot be deleted but 
      can be replaced by choosing another.</td>
  </tr>
  <tr> 
    <td width="20%" valign="top"><b><a href="$CONFIG{admin_url}?type=story&class=unreviewed">Unreviewed 
      stories</a></b></td>
    <td width="80%">Stories submitted recently and have not ben reviewed, approved, 
      or filtered</td>
  </tr>
  <tr> 
    <td width="20%" valign="top"><b><a href="$CONFIG{admin_url}?type=story&class=dreamdate">Dreamdate 
      stories</a></b></td>
    <td width="80%">Successful dating stories selected from user submitted stories 
      and are put into the <b>dreamdate.html</b> template</td>
  </tr>
  <tr> 
    <td width="20%" valign="top"><b><a href="$CONFIG{admin_url}?type=story&class=diaster">Diaster 
      stories</a></b></td>
    <td width="80%">Unsuccessful dating stories selected from user submitted stories 
      and are put into the <b>diaster.html </b>template</td>
  </tr>
  <tr> 
    <td width="20%" valign="top"><b><a href="$CONFIG{admin_url}?type=story&class=success">Success 
      stories</a></b></td>
    <td width="80%">How $mj{program} $mj{version} has helped many people find 
      the love ones</td>
  </tr>
</table>

	|;
	&PrintMojoFooter;
}
############################################################
sub StoryTemplate{
	return qq|
	<p>
	<table width="500" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#336600">
	<tr><td colspan="2" height="8"><b>$STORY{title}</b> - <a href="$CONFIG{admin_url}?account=&type=member&action=detail&username=$STORY{username}&step=final">$STORY{username}</a></td></tr>
  			<tr>
    <td colspan="2" height="8">$STORY{message}<br>
      <div align="right">$HTML_action</div> </td>
  </tr>
	</table>
	|;
}
############################################################
1;