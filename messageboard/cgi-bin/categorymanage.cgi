#!/usr/bin/perl

# This script will allow an administrator to create, delete, reorganize or
# edit categories as they see fit.
#
# ScareCrow (C)opyright 2001 Jonathan Bravata.
#
# This file is part of ScareCrow.
#
# ScareCrow is free software; you can redistribute it and/or modify it under
# the terms of the GNU General Public License as published by the Free
# Software Foundation; either version 2 of the License, or (at your option),
# any later version.
#
# ScareCrow is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
# more details.
#
# You should have received a copy of the GNU General Public License along
# with ScareCrow; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.

require "global.cgi";
require "admin.lib";

# Check the cookie
$inf = get_cookie("mb-admin");
($cookieuser,$cookiepassword) = split(/\|/,$inf);

if(!$cookieuser) {   # Give them a chance to log in the admin cookie
  content();
  page_header("$config{'board_name'} > Category Manager");
  admin_login("$paths{'board_url'}categorymanage.cgi");
  page_footer();
  exit;
}

if(check_account($cookieuser,$cookiepassword) == $FALSE || perms($cookieuser,"ADMINCP") == $FALSE) {
  redirect_die("We're sorry, but your username/password combination was
  invalid or you do not have access to this area..","","4","black","You Do Not Have Access");
}

# Output the content type
content();
page_header("$config{'board_name'} > Category Manager");

# Get the action and pass control to the appropriate function
$action = $Pairs{'action'};

if($action eq 'add')        { addcategory();       }   # done
elsif($action eq 'acat')    { categoryadd();       }   # done
elsif(!$action)             { categorylist();      }   # done
elsif($action eq 'edit')    { editcategory();      }   # done
elsif($action eq 'ecat')    { categoryedit();      }   # done
elsif($action eq 'del')     { delcategory();       }
elsif($action eq 'dcat')    { categorydel();       }
elsif($action eq 'reorder') { reordercategories(); }
elsif($action eq 'rcat')    { categoriesreorder(); }
else                        { categorylist();      }   # done

sub addcategory {
  # Print out the form
  print <<end;
    <form action="$paths{'board_url'}categorymanage.cgi" method="post">
    <table width="98%" bgcolor="$color_config{'border_color'}" border="0" cellspacing="0" cellpadding="0"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Add a Category</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Category Name</b></td>
	  <td><input type="text" name="catname"></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><font face="Verdana" size="1">
	  This category will be inserted at the bottom of the category list.  You may use the "Reorder
	  Categories" option in the admincenter to change where this or any category is placed.
	</font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Add Category"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="acat">
    </form>
end

}

sub categoryadd {
  # Get the category name
  my $catname = $Pairs{'catname'};
  
  # Append it to the list
  lock_open(CATS,"$cgi_path/data/catagories.lst","a");
  seek(CATS,0,2);
  print CATS "$catname\n";
  close(CATS);
  
  # Update the user on the progress
  print "<b>Thank you!</b>  $catname has successfully been added.<br>\n";
}

sub editcategory {
  # Get the category number
  my $cat = $Pairs{'cat'};
  
  # Get the current name of the category
  lock_open(CATS,"$cgi_path/data/catagories.lst","r");
  while($name = <CATS>) {
    $catnum++;
    if($cat == $catnum) { $catname = strip($name); last; }
  }
  close(CATS);
  
  # Print out the form
  print <<end;
    <form action="$paths{'board_url'}categorymanage.cgi" method="post">
    <center>[ <a href="$paths{'board_url'}forummanage.cgi?action=reorder&cat=$cat">Reorder Forums in This Category</a> ]</center>
    <table width="98%" bgcolor="$color_config{'border_color'}" border="0" cellspacing="0" cellpadding="0"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Rename a Category</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Category Name</b></td>
	  <td><input type="text" name="catname" value="$catname"></td>
	</tr>
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Rename Category"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="wasname" value="$catname">
    <input type="hidden" name="action" value="ecat">
    </form>
end

}

sub categoryedit {
  # Get the name the category WAS previously
  my $wasname = $Pairs{'wasname'};
  # Get the NEW name for the category
  my $catname = $Pairs{'catname'};
  
  # If they're NOT the same, replace them.  If they are, just leave it be, lie and said we did something. :)
  my $final = "";
  if($catname ne $wasname) {
    lock_open(CATS,"$cgi_path/data/catagories.lst","rw");
    seek(CATS,0,0);
    while($name = <CATS>) {
      $name = strip($name);
      if($name eq $wasname) { $name = $catname; $done = 1; }   # Rename it if we have a match
      $name .= "\n";
      $final .= $name;
    }
    truncate(CATS,0);     seek(CATS,0,0);
    print CATS $final;
    close(CATS);
    
    # Check if something was NOT done and let them know
    if($done != 1) {
      print "<b>We're sorry</b>, but no such category as \"$wasname\" exists.<br>\n";
      return;
    }
  }
  
  # Let the user know the progress
  print "<b>Thank you!</b>  $wasname was successfully renamed to $catname.<br>\n";
}


sub categorylist {
  # Load all the categories
  lock_open(CATS,"$cgi_path/data/catagories.lst","r");
  my @categories = <CATS>;
  close(CATS);
  
  # Begin the table
  print <<end;
    <table width="98%" bgcolor="$color_config{'border_color'}" border="0" cellspacing="0" cellpadding="0"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="3"><font face="Verdana" size="2"><b>&#187; Category List</b></font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}">
	  <td width="10%" align="center"><font face="Verdana" size="2"><b>Category</b></font></td>
	  <td width="65%"><font face="Verdana" size="2"><b>Name</b></font></td>
	  <td width="25%" align="center"><font face="Verdana" size="2"><b>Options</b></font></td>
	</tr>
end
  
  # Loop through the categories and print the info line about them
  my $catnum = "";
  foreach my $catname (@categories) {
    $catname = strip($catname);
    $catnum++;
    # Print the entry
    print <<end;
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td width="10%" align="center"><font face="Verdana" size="1">$catnum</font></td>
	<td width="65%"><font face="Verdana" size="1">$catname</font></td>
	<td width="25%" align="center"><font face="Verdana" size="1">
	  <a href="$paths{'board_url'}categorymanage.cgi?action=edit&cat=$catnum">Edit</a> | 
	  <a href="$paths{'board_url'}categorymanage.cgi?action=del&cat=$catnum">Delete</a>
	</font></td>
      </tr>
end
  }
  
  # Finish up the table
  print <<end;
      </table>
    </td></tr></table>
end
}


sub delcategory {
  # Grab some variables
  my $forum = $Pairs{'cat'};
  my($user,$pass) = ($cookieuser,$cookiepassword);
  
  # Output the table
  print <<end;
    <form action="$path{'board_url'}usereditor.cgi" method="post">
    <table width="98%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Please Log In to Delete Category $forum</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><font face="Verdana" size="1"><b>Warning!</b><br>
	Deleting a category is <i>irreversible</i>.  Proceed only if you are sure you wish to do this.</td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Delete Categpry $forum"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="dcat">
    <input type="hidden" name="cat" value="$forum">
    </form>
end
}

sub categorydel {
  # Get the category to remove
  my $cat = $Pairs{'cat'};
  
  # Loop through and remove the category
  my $catnum = 0;    my $final = "";
  lock_open(CATS,"$cgi_path/catagories.lst","rw");
  seek(CATS,0,0);
  while($in = <CATS>) {
    $catnum++;
    if($cat == $catnum) { $done=1; }   # Fonud the one to delete -- do it.
    else { $final .= $in; }
  }
  truncate(CATS,0);
  seek(CATS,0,0);
  print CATS $final;
  close(CATS);
  
  # Update them on the progress
  if($done == 1) {
    print "<b>Thank you!</b>  Category $cat has successfully been removed.<br>\n";
  } else {
    print "<b>We're sorry</b>, but category $cat does not exist.<br>\n";
  }
}

# Provides the form to reorder forums
sub reordercategories {
  
  # Figure out how many options there are in total
  lock_open(FORUMS,"$cgi_path/data/catagories.lst","r");
  while($in = <FORUMS>) {
    $in = strip($in);
    $total++;
    push @cats,$in;
  }
  close(FORUMS);
  
  # Compile the option list
  my $optionlist = qq~<option value="">&nbsp;</option>~;
  for($x = 1; $x <= $total; $x++) {
    $optionlist .= qq~<option value="$x">$x</option>~;
  }
  
  # Print out the form and the bit of javascript we'll need to (ostensibly) verify we don't have duplicates
  print <<end;    
    <!-- Begin the table -->
    <table width="98%" align="center" bgcolor="$color_config{'border_color'}" border="0" cellspacing="0" cellpadding="0"><tr><td>
      <form action="$paths{'board_url'}categorymanage.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="3"><font face="Verdana" size="2"><b>&#187; Reorder Categories</b></td></tr>
        <tr bgcolor="$color_config{'nav_top'}">
	  <td width="15%"><font face="Verdana" size="2"><b>Current Position</b></font></td>
	  <td width="15%"><font face="Verdana" size="2"><b>New Position</b></font></td>
	  <td width="70%"><font face="Verdana" size="2"><b>Category Name</b></font></td>
	</tr>
end
  
  # Loop through and print each entry
  foreach my $entry (@cats) {
    $position++;
    my @parts = split(/\|/,$entry);
    print <<end;
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td width="15%"><font face="Verdana" size="2">$position</font></td>
	<td width="15%">
	  <select name="forum-$entry" onChange="checkStatus(this); return true;">
	    $optionlist
	  </select>
	</td>
	<td width="70%"><font face="Verdana" size="2"><b>$entry</b></font></td>
      </tr>
end
  }
  
  # Finish the table off
  print <<end;
      <tr bgcolor="$color_config{'nav_top'}"><td colspan="3" align="center"><input type="submit" name="submit" value="Reorder Categories"></td></tr>
      </table>
      <input type="hidden" name="action" value="rcat">
      </form>
    </td></tr></table>
end
}

# Physically reorders forums
sub categoriesreorder {
  
  # Loop through the list of forums for this category and place them in the appropriate place.
  lock_open(FORUMS,"$cgi_path/data/catagories.lst","r");
  while($in = <FORUMS>) {
    $in = strip($in);
    my $position = $Pairs{"forum-$in"};
    if($positions[$position]) {
      print "<b>Duplicate entries for position $position.</b><br>\n";
      exit;
    }
    else {
      $positions[$position] = $in;
    }
  }
  close(FORUMS);
  
  # Write the changes back out to the file
  lock_open(FORUMS,"$cgi_path/data/catagories.lst","w");
  truncate(FORUMS,0);    seek(FORUMS,0,0);
  foreach my $category (@positions) {
    if($category) { print FORUMS "$category\n"; }
  }
  close(FORUMS);
  
  print "<p><b>Thank you!</b>  The categories have successfully be reordered.  The new order is as follows:<br></p><ul>";
  foreach my $category (@positions) {
    if($category) { print "<li>$category</li>"; }
  }
  print "</ul><br><br>";
}






# This script handles organizing the forums/categories.
sub organizescript {

  print <<end;
<SCRIPT LANGUAGE="JavaScript">
  <!-- Original:  Phil Webb (phil\@philwebb.com) -->
  <!-- Web Site:  http://www.philwebb.com -->

  <!-- This script and many more are available free online at -->
  <!-- The JavaScript Source!! http://javascript.internet.com -->

  <!-- Begin
    function move(fbox, tbox) {
    var arrFbox = new Array();
    var arrTbox = new Array();
    var arrLookup = new Array();
    var i;
    for (i = 0; i < tbox.options.length; i++) {
      arrLookup[tbox.options[i].text] = tbox.options[i].value;
      arrTbox[i] = tbox.options[i].text;
    }
    var fLength = 0;
    var tLength = arrTbox.length;
    for(i = 0; i < fbox.options.length; i++) {
      arrLookup[fbox.options[i].text] = fbox.options[i].value;
      if (fbox.options[i].selected && fbox.options[i].value != "") {
        arrTbox[tLength] = fbox.options[i].text;
        tLength++;
      }
      else {
      arrFbox[fLength] = fbox.options[i].text;
      fLength++;
      }
    }
 
    arrFbox.sort();
    arrTbox.sort();
    fbox.length = 0;
    tbox.length = 0;
    var c;
    for(c = 0; c < arrFbox.length; c++) {
      var no = new Option();
      no.value = arrLookup[arrFbox[c]];
      no.text = arrFbox[c];
      fbox[c] = no;
    }
    for(c = 0; c < arrTbox.length; c++) {
      var no = new Option();
      no.value = arrLookup[arrTbox[c]];
      no.text = arrTbox[c];
      tbox[c] = no;
    }
  }
  //  End -->
  </script>
</HEAD>
end
}
