#!/usr/bin/perl
###################################################################################
#                                                                                 #
#                   PerlDesk - Customer Help Desk Software                        #
#                                                                                 #
###################################################################################
#                                                                                 #
#     Author: John Bennett	                                                  #
#      Email: j.bennett@perldesk.com                                              #
#        Web: http://www.perldesk.com                                             #
#   Filename: kb.cgi                                                              #
#    Details: The main knowledge base file                                        #
#    Release: 1.7                                                                 #
#   Revision: 0                                                                   #
#                                                                                 #
###################################################################################
# Please direct bug reports,suggestions or feedback to the perldesk forums.       #
# www.perldesk.com/board                                                          #
#                                                                                 #
# (c) PerlDesk (JBSERVE LTD) 2002/2003                                            #
# PerlDesk is protected under copyright laws and cannot be resold, redistributed  # 
# in any form without prior written permission from JBServe LTD.                  #
#                                                                                 #
# This program is commercial and only licensed customers may have an installation #
################################################################################### 
 use CGI qw(:standard);                                 
 use DBI();                                             
 use Digest::MD5 ;   

 use lib 'include/mods';

 require "include/pd.cgi";
 require "include/conf.cgi";
 
  get_time();

 $dbh    =  DBI->connect("DBI:mysql:$dbname:$dbhost","$dbuser","$dbpass") or die_nice("Could not connect to the help desk database");
 %global =  get_vars();  
 $q      =  CGI->new();

eval {                                                   
        require "include/subs.cgi";                                    
     };
                                                      
if ($@) 
 {                                               
    print "Content-type: text/plain\n\n";               
    print "Error including file(s): $@\n";                
    print "Please ensure that the file(s) exist and permissions are correct";
    exit;
 }                                                       

   if (defined $q->param('lang')) { $language = $q->param('lang'); } 
   else { $language = $global{'language'}; }

eval 
 {
    require "include/lang/$language.inc"; 
    require "include/parse/user.cgi";
 };

if ($@)
  {                                               
      print "Content-type: text/plain\n\n";               
      print "PerlDesk Error: $@\n";                
      exit;
  }   



   if ($global{'kb_req_user'} == "1")
    {
       check_user(); 
    }


  print "Content-type: text/html\n\n";


if ($q->param('do') eq "email_article")
 {
        $id        = $q->param('id');
        $email     = $q->param('email');
	$statement = 'SELECT * FROM perlDesk_kb_entries WHERE id = ' . "$id"; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
                 {	
			$subject      =  $ref->{'subject'};
			$description  =  $ref->{'description'};
			$id           =  $ref->{'id'};
  	         }


          my $msg = qq|
The following article was requested from $global{'title'} ($ENV{'REMOTE_ADDR'})

$subject

$description
|;

   email( To => "$email", From => "$global{'adminemail'}", Subject => "Knowledge Base Article", Body => "$msg");
       
    	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=kb.cgi?view=$id"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, a copy of this article has been emailed to $email.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="kb.cgi?view=$id">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;  
 
    exit;

 }
  if ((!$ENV{'QUERY_STRING'}) || ($ENV{'QUERY_STRING'} =~ /^lang/) && !$q->param('do')) {

    $num       =  1;
	$statement = 'SELECT * FROM perlDesk_kb_entries ORDER BY id DESC LIMIT 5'; 
	$sth       =  $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) 
         {	
		if ($ref->{'views'} > 50) { $pop = "<img src=\"$global{'imgbase'}/hot.gif\">"; } else { $pop = ' '; }
		if ($num eq "2")
                 {
      			$bgcol   =  '#FFFFFF';
     			$num = 0;
     	         }
                   else    {
			      $bgcol   =   '#F0F0F0';
		           }

		$kb .= '<tr><td width="8%" bgcolor = "' . "$bgcol" . '"><div align="center"><img src="' . "$global{'imgbase'}" . '/article.gif"></div></td>
                        <td width="92%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "<a href=kb.cgi?view=$ref->{'id'}&lang=$language>$ref->{'subject'}</a>" . '</font></td>
                        </tr>';
     	        $num++;
	}

	$statement = 'SELECT category FROM perlDesk_kb_cat'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref())  
                  {	
			$option .= "<option value=\"$ref->{'category'}\">$ref->{'category'}</option>";
	    	        push @categories, $ref->{'category'};
	          }
	$sth->finish;

	$option .= "<option value=\"all\" selected>$LANG{'searchall'}</option>";
 
        @_ = @categories;

        while (my ($one,$two) = (shift @_, shift @_))  
         {     
           last unless defined $one;
           $line .= "<font size=2 color=\"#000000\"><img src=\"$global{'imgbase'}/go1.gif\"> <a href=\"kb.cgi?cat&query=$one&lang=$language\">$one</a><br></font><font size=2 color=\"#000000\">"; 

           if (defined $two) 
              {
            	$line .="<img src=\"$global{'imgbase'}/go1.gif\">  <a href=\"kb.cgi?cat&query=$two&lang=$language\">$two</a></font>";
              }

           last unless defined $two;  
        }

   $template{'categories'} =   $line;
   $template{'category'}   =   $option;
   $template{'list'}       =   $kb;
   
   parse("$global{'data'}/include/tpl/kb");
   exit;
 }






if ($ENV{'QUERY_STRING'} =~ /^view/) 
  {

    $id        = $q->param('view');
	$statement = 'SELECT * FROM perlDesk_kb_entries WHERE id = ' . "$id"; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
         {	
			$read         =  $ref->{'views'};
			$author       =  $ref->{'author'};
			$subject      =  $ref->{'subject'};
			$description  =  $ref->{'description'};
			$id           =  $ref->{'id'};
  	     }

	$ead       = $read;
	$ead++;
	$sth->finish;
	$statement = 'UPDATE perlDesk_kb_entries SET views  = "' . "$ead" . '" WHERE id = "' . "$id" . '";'; 
	$sth       =  $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute();# or die print "Couldn't execute statement: $DBI::errstr; stopped";


   $template{'subject'} = $subject;
   $template{'author'}  = $author;
   $template{'article'} = $description;
   $template{'read'}    = $read;
   $template{'id'}      = $id;
   
   parse("include/tpl/kb_article");
   $dbh->disconnect;
	exit;
}


if ($ENV{'QUERY_STRING'} =~ /^search/)	{
	
	my $select    =  $q->param('select');
	   $query     =  $q->param('query');
	   $field     =  $query;
	   $category  =  $q->param('select');

    $query = $q->param('query');
    $feld  = $q->param('field');
	$query =~  s/_/ /g;
    $feld  =   $field if !$feld;

	if ($category eq "all") 
         {
              $sth = $dbh->prepare( 'SELECT COUNT(*) FROM perlDesk_kb_entries WHERE description LIKE "%' . "$query" . '%" OR subject LIKE "%' . "$query" . '%"' ) or die DBI->errstr;
   	     }
      else {  $sth = $dbh->prepare( 'SELECT COUNT(*) FROM perlDesk_kb_entries WHERE category = "' . "$category" . '" AND description LIKE "%' . "$query" . '%" OR subject LIKE "%' . "$query" . '%"' ) or die DBI->errstr;  } 

	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        $count = $sth->fetchrow_array();
   	$sth->finish;

	if ($ENV{'QUERY_STRING'} !~ /show/) { $pae = 0; }
	if (($count > 30) || ($ENV{'QUERY_STRING'} =~ /show/)) { $showbar = "1"; }
		if ($showbar) {
		if ($ENV{'QUERY_STRING'} =~ /show/) {
				my $string = "$ENV{'QUERY_STRING'}";
 			 	 @values = split(/\&/,$ENV{'QUERY_STRING'});
   		      	foreach $i (@values) { 
                if ($i =~/show/) {
                    ($action, $pae) = split(/=/,$i);
                }   }

	if (!$pae)	{		$prevlink = '&laquo; prev';   } 
    else   {
			$link     =  $query;
			$link     =~ s/ /_/g;
			$prevpage =  $pae-1;
			$prevlink =  "<a href=\"kb.cgi?search&query=$link&show=$prevpage&field=$feld\">" . '&laquo; prev' . "</a>";
	} }	
    else	{	$prevlink = '&laquo; prev';   }
	
    	$res = $pae+1;
		$total = (30*$res);
		if ($count > $total){
	     	        $nextpage = $pae+1;
	    	        $link = $query;
	     	        $link =~ s/\s/_/g;
	    	        $nextlink = "<a href=\"kb.cgi?search&query=$link&show=$nextpage&field=$feld\">" . 'next &raquo;' . "</a>";
		} else {
	    		$nextlink = 'next &raquo;';
		}
				$bar = '<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center"><tr bgcolor="#E8E8E8"><td> 
      			<div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$prevlink" . '</font></div></td><td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$nextlink" . '</font></div></td></tr></table>';
		}

	$showp = $pae*30;
    $bar   = '' if !$bar;

	 $statement = 'SELECT * FROM perlDesk_kb_entries WHERE description LIKE "%' . "$query" . '%" OR subject LIKE "%' . "$query" . '%" ORDER BY id LIMIT ' . "$showp" . ',30'; 
	 $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
	$num = 1;
    $total = 0;
	while(my $ref = $sth->fetchrow_hashref()) {	

	if ($category ne "all")
             {
                next if $ref->{'category'} ne $category;
             }

    if ($num eq "2")  
            {
     			$bgcol   =  '#FFFFFF';
     			$num     =  0;
     		} 
             else 
               {
                 	$bgcol   =   '#F0F0F0';  
               }

	$num++;
    $total++;

		if ($ref->{'views'} > 50) { $pop = "<img src=\"$global{'imgbase'}/hot.gif\">"; } else { $pop = ' '; }

				$article .= '<tr><td width="4%"  bgcolor = "' . "$bgcol" . '"> 
    			<div align="center"><img src="' . "$global{'imgbase'}" . '/article.gif"></div></td>
    			<td width="60%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "<a href=kb.cgi?view=$ref->{'id'}&lang=$language>$ref->{'subject'}</a>" . '</font></td>
    			<td width="30%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'category'}" . '</font></td>
    			<td width="6%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$pop" . '</font></td>
  				</tr>';
		}
		$sth->finish;

   $template{'results'} =  $article;
   $template{'bar'}     =  $bar;
   $template{'num'}     =  $total;
   
   parse("$global{'data'}/include/tpl/kb_results");


   $dbh->disconnect;
   exit;	
}

if ($ENV{'QUERY_STRING'} =~ /^cat/)	{


    $query  =  $q->param('query');
	$query  =~  s/\%20/ /g;

	if (!$feld) {
		$feld = $field;	
	} 
	$sth = $dbh->prepare( 'SELECT COUNT(*) FROM perlDesk_kb_entries WHERE category = ?' ) or die DBI->errstr;
	$sth->execute($query) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	 $count = $sth->fetchrow_array();
	$sth->finish;

	if ($ENV{'QUERY_STRING'} !~ /show/) { $pae = 0; }
	if (($count > 30) || ($ENV{'QUERY_STRING'} =~ /show/)) { $showbar = "1"; }
		if ($showbar) 
		{
		if ($ENV{'QUERY_STRING'} =~ /show/) 
			{
				my $string = "$ENV{'QUERY_STRING'}";
 			 	 @values = split(/\&/,$ENV{'QUERY_STRING'});
   		      	foreach $i (@values) { 
                if ($i =~/show/) 
				{
                    ($action, $pae) = split(/=/,$i);
                }   }
	if ($pae eq "0") 		{
		$prevlink = '&laquo; prev';
		} else 		{
			$link = $query;
			$link =~ s/ /_/g;
			$prevpage = $pae-1;
			$prevlink = "<a href=\"kb.cgi?cat&query=$link&show=$prevpage\">" . '&laquo; prev' . "</a>";
		} }	 else 		{
		$prevlink = '&laquo; prev';
		}
		$res = $pae+1;
		$total = (30*$res);
		if ($count > $total){
			$nextpage = $pae+1;
			$link = $query;
			$link =~ s/\s/_/g;
			$nextlink = "<a href=\"kb.cgi?cat&query=$link&show=$nextpage\">" . 'next &raquo;' . "</a>";
		} else		 {
			$nextlink = 'next &raquo;';
		}
				$bar = '<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center"><tr bgcolor="#E8E8E8"><td> 
      			<div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$prevlink" . '</font></div></td><td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$nextlink" . '</font></div></td></tr></table>';
		}
	$showp = $pae*30;

	 $statement = 'SELECT * FROM perlDesk_kb_entries WHERE category = ? ORDER BY id LIMIT ' . "$showp" . ',30'; 
	 $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($query) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
	$num = 1;
	while(my $ref = $sth->fetchrow_hashref()) 
		{	
     		if ($num eq "2") 
                {
         			$bgcol   =  '#FFFFFF';
        			$num     =  0;
        		} 
                  else {
			              $bgcol   =   '#F0F0F0';
		               }
		$num++;

		if ($ref->{'views'} > 50) { $pop = "<img src=\"$global{'imgbase'}/hot.gif\">"; } else { $pop = ' '; }

				$article .= '<tr><td width="4%"  bgcolor = "' . "$bgcol" . '"> 
    			<div align="center"><img src="' . "$global{'imgbase'}" . '/article.gif"></div></td>
    			<td width="60%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "<a href=kb.cgi?view=$ref->{'id'}&lang=$language>$ref->{'subject'}</a>" . '</font></td>
    			<td width="30%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'category'}" . '</font></td>
    			<td width="6%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$pop" . '</font></td>
  				</tr>';
	
		}
		$sth->finish;

        if (!$bar) { $bar = ''; }

   $template{'bar'}     =  $bar;
   $template{'results'} =  $article;
   $template{'num'}     =  $count;
   
parse("$global{'data'}/include/tpl/kb_results");


	$dbh->disconnect;
	exit;	
}


