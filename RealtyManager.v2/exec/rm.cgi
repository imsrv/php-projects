#!/usr/local/bin/perl
# -----------------------------------------------------------------------------
# Edis Realty Manager v2.01
# Copyright (C) 1998-1999 Edis Digital Inc. All Rights Reserved
# http://www.edisdigital.com/
# -----------------------------------------------------------------------------
# This program is protected by Canadian and international copyright laws. Any
# use of this program is subject to the the terms of the license agreement
# included as part of this distribution archive. Any other uses are stictly
# prohibited without the written permission of Edis Digital and all other
# rights are reserved.
# -----------------------------------------------------------------------------
# Version History:
#
# v2.01 - Aug/09/1999 - Several Bug Fixs and Updates:
#			Commented out exec time on search results page
#			Updated exec time display code
#			Fixed Prev/Next page links on homepage list page
#			Fixed Keyword search button name on homepage list page
#			Listing index is republished when listing is erased
#
# v2.00 - Jun/25/1999 - Initial Release
# -----------------------------------------------------------------------------
# Warning : Modifying the source code violates your license agreement!
# -----------------------------------------------------------------------------
$SIG{__DIE__}=$SIG{__WARN__}=\&so;%hf=("progVer"=>"2.01","progRel"=>"June 25th,1999","progUpd"=>"August 9th,1999","perlOS"=>$^O||"Unknown","perlVer"=>$]||"Unknown","cgidir"=>$0=~m#^(.*)[\\/]#?$1:(`pwd`=~/(.*)/)[0],"cgiurl"=>(split("/",$ENV{'SCRIPT_NAME'}))[-1],"ltime"=>time,"stime"=>time,);
for(0..9){push(@ai,"limage$_")}for(1..50){push(@ai,"lfield$_")}for(0..9){push(@aj,"himage$_")}
for(1..50){push(@aj,"hfield$_")}for(1..50){push(@ad,"lfield$_"."_name");push(@ad,"lfield$_"."_type");
push(@ad,"lfield$_"."_active")}for(1..50){push(@ad,"hfield$_"."_name");push(@ad,"hfield$_"."_type");
push(@ad,"hfield$_"."_active")}%hh=("datafile"=>"listing.dat","filelock"=>"filelock.lock","fields"=>[qw(num owner created updated),@ai],"backup"=>"disabled","cgiext"=>".cgi");%hi=("datafile"=>"user.dat","filelock"=>"filelock.lock","fields"=>[qw(num name login_id login_pw access created_mon created_day created_year expires_mon expires_day expires_year expires_date expires_never disabled listings_max listings_unlimited user_listed specify_filename homepage_filename notes),@aj],"backup"=>"disabled","cgiext"=>".cgi");%hk=("datafile"=>"setup.dat","filelock"=>"filelock.lock","fields"=>["num",@ad,qw(company_name domain_name product_id publish_listing_index publish_homepage_index publish_listing_image0 publish_homepage_image0 upload_maxk login_timeout listing_perpage homepage_perpage userman_perpage db_sorting titlebar footerbar logoff_url image_url listing_dir listing_url homepage_dir homepage_url search_url time_adjh time_adj_hour time_adjm time_adj_min installed)],"backup"=>"disabled","cgiext"=>".cgi");%ia=("datafile"=>"help.dat","filelock"=>"filelock.lock","fields"=>[qw(num parent title content)],"backup"=>"disabled","cgiext"=>".cgi");%hc=&ud;%hm=&uc;
&si(\%hk,\%hd,1);$hf{'titlebar'}=$hd{'titlebar'};$hf{'footerbar'}=$hd{'footerbar'};$hf{'image_url'}=$hd{'image_url'};
$hf{'homepage_url'}=$hd{'homepage_url'};$hf{'listing_url'}=$hd{'listing_url'};$hf{'search_url'}=$hd{'search_url'};
if($hd{'time_adjh'}eq"add"){$hf{'ltime'}+=(int($hd{'time_adj_hour'}*60*60))};if($hd{'time_adjh'}
eq"minus"){$hf{'ltime'}-=(int($hd{'time_adj_hour'}*60*60))};if($hd{'time_adjm'}eq"add"){$hf{'ltime'}+=(int($hd{'time_adj_min'}*60))};
if($hd{'time_adjm'}eq"minus"){$hf{'ltime'}-=(int($hd{'time_adj_min'}*60))};$hj{'mon'}=(localtime($hf{'ltime'}))[4]+1;
$hj{'day'}=(localtime($hf{'ltime'}))[3];$hj{'year'}=(localtime($hf{'ltime'}))[5]+1900;$hj{'date'}=sprintf("%04d%02d%02d",$hj{'year'},$hj{'mon'},$hj{'day'});
$|++;if($hc{'help'}){&sp}if($hc{'help_index'}){&sq}if($hc{'info'}){&tf}&sb;if($hc{'login_about'}){&ty}
if($hc{'logoff'}){&tz}&tx;if($hc{'listing_add'}){&tg}if($hc{'listing_edit'}){&ti}if($hc{'listing_confirm_erase'}){&th}
if($hc{'listing_erase'}){&tj}if($hc{'listing_save'}){&tw}if($hc{'listing_list'}){&tt}if($hc{'listing_listall'}){&tt}
if($hc{'listing_iview'}){&tr}if($hc{'listing_iviewall'}){&ts}if($hc{'listing_iedit'}){&tl}
if($hc{'listing_iedit_save'}){&tm}if($hc{'listing_iconfirm_erase'}){&tk}if($hc{'listing_ierase'}){&tn}
if($hc{'listing_iupload_step1'}){&tp}if($hc{'listing_iupload_step2'}){&tq}if($hc{'listing_iupload_save'}){&to}
if($hc{'homepage_edit'}){&sr}if($hc{'homepage_save'}){&te}if($hc{'homepage_list'}){&tb}if($hc{'homepage_listall'}){&tb}
if($hc{'homepage_iview'}){&sz}if($hc{'homepage_iviewall'}){&ta}if($hc{'homepage_iedit'}){&st}
if($hc{'homepage_iedit_save'}){&su}if($hc{'homepage_iconfirm_erase'}){&ss}if($hc{'homepage_ierase'}){&sv}
if($hc{'homepage_iupload_step1'}){&sx}if($hc{'homepage_iupload_step2'}){&sy}if($hc{'homepage_iupload_save'}){&sw}
if($hc{'userman_add'}){&ux}if($hc{'userman_edit'}){&uz}if($hc{'userman_confirm_erase'}){&uy}
if($hc{'userman_erase'}){&va}if($hc{'userman_save'}){&vc}if($hc{'userman_list'}){&vb}if($hc{'userman_listall'}){&vb}
if($hc{'setup_options_edit'}){&un}if($hc{'setup_options_save'}){&uo}if($hc{'setup_lfields_edit'}){&uk}
if($hc{'setup_lfields_confirm_reset'}){&uj}if($hc{'setup_lfields_reset'}){&ul}if($hc{'setup_lfields_save'}){&um}
if($hc{'setup_hfields_edit'}){&ug}if($hc{'setup_hfields_confirm_reset'}){&uf}if($hc{'setup_hfields_reset'}){&uh}
if($hc{'setup_hfields_save'}){&ui}if($hc{'setup_publish_listings'}){&us}if($hc{'setup_publish_listing_index'}){&ur}
if($hc{'setup_publish_homepages'}){&uq}if($hc{'setup_publish_homepage_index'}){&up}&sa;exit;
sub sp{$num=int$hc{'help'};&si(\%ia,\%hn,$num)||&sq;print"Content-type: text/html\n\n";print&ut("_help.html",\%hn);
exit}sub sq{&ut("_help.html");$rowcode=sub{$hq{$hn{'num'}}=$hn{'parent'}||0;$ht{$hn{'num'}}=$hn{'title'};
$ig{$hn{'num'}}=$hn{'content'}};&sf(\%ia,$rowcode,undef,\%hn);foreach$a(sort{$a<=>$b} keys %hq){
if($hq{$a}==0){$content.=qq|<p><a href="$hf{'cgiurl'}?help=$a">$ht{$a}</a><br>\n|;foreach$b(sort{
$a<=>$b} keys %hq){if($hq{$b}==$a){$num=$b;$title=$ht{$num};$content.=&uu('row1');foreach$c(sort{
$a<=>$b} keys %hq){$num=$c;$title=$ht{$num};if($hq{$c}==$b){$content.=&uu('row2')}}}}}}print"Content-type: text/html\n\n";
print&ut("_help.html");exit}sub tf{print"Content-type: text/plain\n\n";print qq|Product : Edis Realty Manager\n|;
print qq|Version : $hf{'progVer'}\n|;print qq|Released : $hf{'progRel'}\n|;print qq|Updated : $hf{'progUpd'}\n|;
print qq|Perl OS : $hf{'perlOS'}\n|;print qq|Perl Ver : $hf{'perlVer'}\n|;print qq|\n|;print qq|This product is licensed to:\n|;
print qq|\n|;print qq|Company Name : $hd{'company_name'}\n|;print qq|Domain Name : $hd{'domain_name'}\n|;
print qq|Product ID : $hd{'product_id'}\n|;exit}sub sb{if(!$hd{&ua('cHJvZHVjdF9pZA==')}||!&vd($hd{&ua('cHJvZHVjdF9pZA==')})){
print"Content-type: text/html\n\n" unless($ContentType++);print&ut(&ua('X2luc3RhbGxfcm0uaHRtbA=='),\%ha);
exit}}sub vd{my($w,$x,$y,$z)=split(/-/,shift);my($v)=$w+join("",unpack("C3",$x))+$z;while(length $v>7){
$v>>=1}if(!($w%47)&&$w/20.68==(5*20)&&$x=~/^[A-Z]{3}$/&&!($z%47)&&$y==$v){return(1)}else{return(1)}}
sub tx{&ut("_rm_login.html");$id=lc$hc{'id'}||lc$hm{'id'};$pw=lc$hc{'pw'}||lc$hm{'pw'};$rowcode=sub{
$hp{(lc$hb{'login_id'})}=lc$hb{'login_pw'};$ie{(lc$hb{'login_id'})}=$hb{'num'}};&sf(\%hi,$rowcode,undef,\%hb);
if(!$hc{'login'}&&(!$id||!$pw)&&$ENV{'CONTENT_LENGTH'}){$error=&uu("session_expired")}elsif(!$hc{'login'}
&&(!$id||!$pw)&&$ENV{'QUERY_STRING'}){$error=&uu("session_expired")}elsif(defined $hc{'id'}
&&!$hc{'id'}){$error=&uu("no_username")}elsif(defined $hc{'pw'}&&!$hc{'pw'}){$error=&uu("no_password")}
elsif($id&&!$hp{$id}){$error=&uu("invalid_username")}elsif($pw&&$pw ne$hp{$id}){$error=&uu("invalid_password")}
if($hp{$id}&&$pw eq$hp{$id}){&si(\%hi,\%hb,$ie{$id});if($hb{'disabled'}){$error=&uu("disabled")}
if($hb{'access'}<2){$error=&uu("newuser")}elsif($hb{'expires_date'}<=$hj{'date'}&&!$hb{'expires_never'}){
$error=&uu("expired")}}if(!$error&&$hp{$id}&&$pw eq$hp{$id}){$expires=time+(($hd{'login_timeout'}|1)*60);
&ue('id',$id,$expires);&ue('pw',$pw,$expires);%he=%hb;return}if($error){$hf{'footerbar'}=$error}
print"Content-type: text/html\n\n" unless($ContentType++);print&ut("_rm_login.html");exit}
sub ty{$ha{'company_name'}=$hd{'company_name'};$ha{'domain_name'}=$hd{'domain_name'};$ha{'product_id'}=$hd{'product_id'};
print"Content-type: text/html\n\n";print&ut("_rm_login_about.html",\%ha);exit}sub tz{&ue('id',"");
&ue('pw',"");if($hd{'logoff_url'}){if($ENV{'SERVER_SOFTWARE'}=~/PWS/){print"Content-type: text/html\n\n";
print qq|<html><head>|;print qq|<meta http-equiv="REFRESH" content="0; URL=$hd{'logoff_url'}">|;
print qq|</head></html>|;exit}else{print"Location: $hd{'logoff_url'}\n\n";exit}}else{print"Content-type: text/html\n\n" unless($ContentType++);
print&ut("_rm_login.html");exit}}sub sa{&sm(4);&ut("_rm_about.html");$ha{'name'}=$he{'name'};
$ha{'access'}=&uu("access$he{'access'}");$ha{'created'}=&uu("mon$he{'created_mon'}");$ha{'created'}.=sprintf(" %02d,",$he{'created_day'});
$ha{'created'}.=$he{'created_year'};if($he{'expires_never'}){$ha{'expires'}=&uu('never')}else{
$ha{'expires'}=&uu("mon$he{'expires_mon'}");$ha{'expires'}.=sprintf(" %02d,",$he{'expires_day'});
$ha{'expires'}.=$he{'expires_year'}}if($he{'listings_unlimited'}){$ha{'listings'}=&uu("unlimited")}
else{$ha{'listings'}=int$he{'listings_max'}}if($he{'user_listed'}){$ha{'displayed'}=&uu("yes")}
else{$ha{'displayed'}=&uu("no")}if($he{'specify_filename'}&&$he{'homepage_filename'}){$hp_file=$he{'homepage_filename'}}
else{$hp_file=sprintf("h%04d.html",$he{'num'})}$ha{'homepage'}="$hd{'homepage_url'}/$hp_file";
&sn("_rm_about.html",\%ha)}sub sm{local($hnum)=int($_[0]);print"Content-type: text/html\n\n" unless($ContentType++);
print&ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');unless($ContentHeader++){
if($he{'access'}==4){print&ut("_ui_superuser.html")}elsif($he{'access'}==3){print&ut("_ui_admin.html")}
elsif($he{'access'}==2){print&ut("_ui_regular.html")}else{print&ut("_ui_disabled.html")}}print"\n<!--\n";
printf(" %.2f CPU seconds\n",(times)[0]);print" " ,time - $^T ," seconds\n";print"-->\n"}sub sn{
local($file)=$_[0];local($out)=$_[1];unless($file){die("Display_Page : No template file was specified!\n")}
print"Content-type: text/html\n\n" unless($ContentType++);unless($ContentHeader++){print&ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
if($he{'access'}==4){print&ut("_ui_superuser.html")}elsif($he{'access'}==3){print&ut("_ui_admin.html")}
elsif($he{'access'}==2){print&ut("_ui_regular.html")}else{print&ut("_ui_disabled.html")}}$ha{'content'}=&ut($file,$out);
&ut("_ui_buttons.html");$ha{'buttons'}=&uu("$file.buttons");$ha{'cuser_name'}="$he{'name'}";
unless($ContentBody++){print&uu("pagebody",\%ha)}print&ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
printf("\n<!-- %.2f CPU seconds -->",(times)[0]);printf("\n<!-- %.2f seconds -->\n",time - $^T);
exit}sub so{print"Content-type: text/html\n\n" unless($ContentType++);if(-e $hk{'filelock'}){&sl($hk{'filelock'})}
foreach(@_){$ha{'error'}.="$_ "}print$ha{'error'};exit}sub tt{$pagenum=$hc{'pagenum'}||$hm{'listing_pagenum'}||1;
$perpage=int$hd{'listing_perpage'}||10;$search=$hc{'search'}||$hm{'listing_search'};if(defined $hc{'keyword'}){
$keyword=$hc{'keyword'}}else{$keyword=$hm{'listing_keyword'}}if($hc{'listing_listall'}){$search=""; $keyword=""}
if(defined $hc{'keyword'}||$hc{'listing_listall'}){$pagenum=1}&ue("listing_search",$search);
&ue("listing_keyword",$keyword);&ue("listing_pagenum",$pagenum);local(%hx);$rowcode=sub{$hx{
$hb{'num'}}=$hb{'name'}};&sf(\%hi,$rowcode,undef,\%hb);for$fnum(1..50){if($hd{"lfield$fnum"."_active"}){
$fname=$hd{"lfield$fnum"."_name"};if($fname=~m/^(.*?)\((.*?)\)$/i){$fname=$1}if($search eq$fnum){
$ha{'search_options'}.=qq|<option value="$fnum" selected>$fname\n|}else{$ha{'search_options'}.=qq|<option value="$fnum">$fname\n|}}}
&sm(10);&ut("_listing_list.html");$ha{'lfield1_name'}=$hd{'lfield1_name'};if($ha{'lfield1_name'}=~m/^(.*?)\((.*?)\)$/i){
$ha{'lfield1_name'}=$1}if($he{'access'}>=3){$ha{'list'}.=&uu("header",\%ha)}else{$ha{'list'}.=&uu("header2",\%ha)}
if($he{'access'}>=3){$query=sub{if(!$keyword){return(1)}if($search eq"all"&&$keyword){for(1..50){
if($hg{"lfield$_"}=~/\Q$keyword\E/i){return(1)}}}if($search eq"lby"&&$hx{$hg{'owner'}}=~/\Q$keyword\E/i){
return(1)}if($hg{"lfield$search"}=~/\Q$keyword\E/i){return(1)}return(0)}}else{$query=sub{if($hg{'owner'}!=$he{'num'}){
return(0)}$listing_count++;if(!$keyword){return(1)}if($search eq"all"&&$keyword){for(1..50){
if($hg{"lfield$_"}=~/\Q$keyword\E/i){return(1)}}}if($hg{"lfield$search"}=~/\Q$keyword\E/i){
return(1)}return(0)}};$match=sub{$hg{'owner'}=$hx{$hg{'owner'}};if($he{'access'}>=3){$ha{'list2'}.=&uu("row",\%hg)}
else{$ha{'list2'}.=&uu("row2",\%hg)}};if($hd{'db_sorting'}){$sort=sub{lc((split(/\¡/,$a))[14])cmp lc((split(/\¡/,$b))[14])}}
else{$sort=undef}($ha{'pcount'},$ha{'mcount'},$ha{'rcount'},$ha{'cpage'},$ha{'lpage'},$ha{'npage'})=&sg(\%hh,$query,$match,$sort,\%hg,$pagenum,$perpage);
if(!$ha{'list2'}){$ha{'list2'}=&uu("not_found")}$ha{"search_$search"."_selected"}="selected";
$ha{'keyword'}=$keyword;if($search eq"lby"){$search_lby_selected="selected"}if($he{'access'}>2){
$ha{'search_options'}=&uu("listedby").$ha{'search_options'}}if($he{'access'}<3){$ha{'rcount'}=$listing_count}
if($error){$ha{'error'}=&uu("exceeded_listing_limit")}&sn("_listing_list.html",\%ha)}sub tg{
if(!$he{'listings_unlimited'}){$rowcode=sub{if($hg{'owner'}==$he{'num'}){$lcount++}};&sf(\%hh,$rowcode,undef,\%hg);
$max=int$he{'listings_max'};if($lcount>=$max){$error++;&tt}}&sm(11);&ut("_listing_add.html");
local($listedby_list);$rowcode=sub{if($he{'num'}eq$hb{'num'}){$listedby_list.=qq|<option value="$hb{'num'}" selected>$hb{'name'}\n|}
else{$listedby_list.=qq|<option value="$hb{'num'}">$hb{'name'}\n|}};$sortcode=sub{(split(/\¡/,$a))[1]cmp(split(/\¡/,$b))[1]};
&sf(\%hi,$rowcode,$sortcode,\%hb);for$fnum(1..50){if(!$hd{"lfield$fnum"."_active"}){next}$ftype=$hd{"lfield$fnum"."_type"};
$fname=$hd{"lfield$fnum"."_name"};$fvalue="";$foptions="";if($fname=~m/^(.*?)\((.*?)\)$/i){($fname,$fostr)=($1,$2)}
else{$fostr=""}$fostr=~s/(^|[^\\]),/$1 ,/g;foreach(split(/ ,/,$fostr)){s/\\,/,/go;s/(^\s+|\s+$)//go;
if($fvalue&&$fvalue eq$_){$foptions.="<option selected>$_\n"}else{$foptions.="<option>$_\n"}}
if($ftype==1){$ha{'list'}.=&uu("text_field")}if($ftype==2){$ha{'list'}.=&uu("text_box")}if($ftype==3){
$ha{'list'}.=&uu("dropdown")}}$owner=$he{'name'};if($he{'access'}>=3){$ha{'listedby'}=&uu("listedby_select")}
else{$ha{'listedby'}=&uu("listedby_cuser")}&sn("_listing_add.html",\%ha)}sub ti{$num=int$hc{'listing_edit'}||int$hc{'num'};
&si(\%hh,\%hg,$num)||&tt;if($he{'access'}<3&&$hg{'owner'}!=$he{'num'}){&tt}&sm(12);&ut("_listing_edit.html");
local($listedby_list);$rowcode=sub{if($hb{'num'}eq$hg{'owner'}){$listedby_list.=qq|<option value="$hb{'num'}" selected>$hb{'name'}\n|}
else{$listedby_list.=qq|<option value="$hb{'num'}">$hb{'name'}\n|}};$sortcode=sub{(split(/\¡/,$a))[1]cmp(split(/\¡/,$b))[1]};
&sf(\%hi,$rowcode,$sortcode,\%hb);for$fnum(1..50){if(!$hd{"lfield$fnum"."_active"}){next}$ftype=$hd{"lfield$fnum"."_type"};
$fname=$hd{"lfield$fnum"."_name"};$fvalue=$hg{"lfield$fnum"};$fvalue=~s/\"/&quot;/g;$foptions="";
if($fname=~m/^(.*?)\((.*?)\)$/i){($fname,$fostr)=($1,$2)}else{$fostr=""}$fostr=~s/(^|[^\\]),/$1 ,/g;
foreach(split(/ ,/,$fostr)){s/\\,/,/go;s/(^\s+|\s+$)//go;if($fvalue&&$fvalue eq$_){$foptions.="<option selected>$_\n"}
else{$foptions.="<option>$_\n"}}if($ftype==1){$ha{'list'}.=&uu("text_field")}if($ftype==2){
$ha{'list'}.=&uu("text_box")}if($ftype==3){$ha{'list'}.=&uu("dropdown")}}opendir(DIR,"$hf{'cgidir'}/$hd{'listing_dir'}/images/");
my(@ac)=grep(/^$num\_\d{1,2}\.(jpg|gif)$/,readdir(DIR));closedir(DIR);foreach$file(@ac){my($desc);
my($descfile)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file.dat";if(-e $descfile){open(F,"<$descfile");
$desc=<F>;close(F)}else{$desc="No description"}if(length $desc>45){$desc=substr($desc,0,45)."..."}
for$lnum(0..10){if($hg{"limage$lnum"}eq$file){$ha{"ilist$lnum"}.=qq|<option value="$file" selected>$desc\n|}
else{$ha{"ilist$lnum"}.=qq|<option value="$file">$desc\n|}}}$owner=$he{'name'};if($he{'access'}>=3){
$ha{'listedby'}=&uu("listedby_select")}else{$ha{'listedby'}=&uu("listedby_cuser")}$ha{'num'}=int$num;
&sn("_listing_edit.html",\%ha)}sub th{my($num)=int$hc{'listing_confirm_erase'};&si(\%hh,\%hg,$num)||&tt;
if($he{'access'}<3&&$hg{'owner'}!=$he{'num'}){&tt}&sm(13);&sn("_listing_confirm_erase.html",\%hg)}
sub tj{my($num)=int$hc{'num'};&si(\%hh,\%hg,$num)||&tt;if($he{'access'}<3&&$hg{'owner'}!=$he{'num'}){&tt}
&se(\%hh,$num)||&tt;my($pfile)=sprintf("l%04d.html",$num);unlink("$hf{'cgidir'}/$hd{'listing_dir'}/$pfile");
opendir(DIR,"$hf{'cgidir'}/$hd{'listing_dir'}/images/");my(@ac)=grep(/^$num\_\d{1,2}\.(jpg|gif)$/,readdir(DIR));
closedir(DIR);foreach$file(@ac){unlink("$hf{'cgidir'}/$hd{'listing_dir'}/images/$file");unlink("$hf{'cgidir'}/$hd{'listing_dir'}/images/$file.dat")}
if($hd{'publish_listing_index'}){&tv}&tt}sub tw{$num=int$hc{'num'};if(!$num&&!$he{'listings_unlimited'}){
$rowcode=sub{if($hg{'owner'}==$he{'num'}){$lcount++}};&sf(\%hh,$rowcode,undef,\%hg);$max=int$he{'listings_max'};
if($lcount>=$max){$error++;&tt}}if(!$return){&sm(10)}if($num){&si(\%hh,\%hg,$num);if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}}
if($he{'access'}>=3){$hc{'owner'}=int$hc{'owner'}}else{$hc{'owner'}=int$he{'num'}}$hc{'created'}=$hg{'created'}||$hf{'ltime'};
$hc{'updated'}=$hf{'ltime'};if($num){&sk(\%hh,\%hc,$num)}else{$hc{'num'}=$num=&sc(\%hh,\%hc)}
&tu($num);if($hd{'publish_listing_index'}){&tv}if($return){return}&sn("_listing_saved.html")}
sub tu{&ut("_publish_listing.html");$num=int$_[0];local(%ha);&si(\%hh,\%hg,$num);foreach(1..50){
$ha{"lfield$_"}=$hg{"lfield$_"};$ha{"lfield$_"."_ue"}=&uw($hg{"lfield$_"})}&si(\%hi,\%hb,$hg{'owner'});
$ha{"user_num"}=$hb{'num'};$ha{"user_name"}=$hb{'name'};$ha{"user_name_ue"}=&uw($hb{'name'});
if($hb{'specify_filename'}&&$hb{'homepage_filename'}){$ha{"user_file"}=$hb{'homepage_filename'}}
else{$ha{"user_file"}=sprintf("h%04d.html",$hb{'num'})}foreach(1..50){$ha{"hfield$_"}=$hg{"hfield$_"};
$ha{"hfield$_"."_ue"}=&uw($hg{"hfield$_"})}my($pfile)=sprintf("l%04d.html",$num);if($hd{'publish_listing_image0'}){
$start_inum=0}else{$start_inum=1}for($start_inum..9){$file=$hg{"limage$_"};$filepath="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file";
open(F,"<$filepath.dat");$desc=<F>;close(F);if($file&&-e $filepath){$ha{'images'}.=&uu("image")}}
if(!$ha{'images'}){$ha{'images'}=&uu("no_images")}foreach(keys %ha){$ha{$_}=~s/\<\!--#/<!--|/go}
open(F,">$hf{'cgidir'}/$hd{'listing_dir'}/$pfile");print F &ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
print F &ut("_publish_listing.html",\%ha);print F &ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
close(F)}sub tv{&ut("_publish_listing_index.html");local %ha;$rowcode=sub{$if{$hb{'num'}}=$hb{'name'};
$id{$hb{'num'}}=&uw($hb{'name'});if($hb{'specify_filename'}&&$hb{'homepage_filename'}){$ic{
$hb{'num'}}=$hb{'homepage_filename'}}else{$ic{$hb{'num'}}=sprintf("h%04d.html",$hb{'num'})}};
&sf(\%hi,$rowcode,undef,\%hb);$rowcode=sub{$file=$hg{"limage0"};$filepath="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file";
if($file&&-e $filepath){$ha{'file'}=$file}else{$ha{'file'}=""}$ha{"user_num"}=$ih{$hg{'owner'}};
$ha{"user_name"}=$if{$hg{'owner'}};$ha{"user_name_ue"}=$id{$hg{'owner'}};$ha{"user_file"}=$ic{
$hg{'owner'}};foreach(1..50){$ha{"lfield$_"}=$hg{"lfield$_"};$ha{"lfield$_"."_ue"}=&uw($hg{"lfield$_"})}$ha{'listing_file'}=sprintf("l%04d.html",$hg{'num'});
if($ha{'file'}){$ha{'list'}.=&uu("listing_image",\%ha)}else{$ha{'list'}.=&uu("listing_noimage",\%ha)}};
if($hd{'db_sorting'}){$sortcode=sub{lc((split(/\¡/,$a))[14])cmp lc((split(/\¡/,$b))[14])}}
else{$sortcode=undef}&sf(\%hh,$rowcode,$sortcode,\%hg);foreach(keys %ha){$ha{$_}=~s/\<\!--#/<!--|/go}
open(F,">$hf{'cgidir'}/$hd{'listing_dir'}/index.html");print F &ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
print F &ut("_publish_listing_index.html",\%ha);print F &ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
close(F)}sub tr{$return=1;&tw;my($num)=int$hc{'num'};my($file)=$hc{'limage10'};my($filepath)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file";
&si(\%hh,\%hg,$num);if(!$file){&ti}if($file!~/^$num\_/){&ti}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&ti}
if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}&sm(14);$ha{'file'}=$file;$ha{'size'}=(-s $filepath);
open(F,"<$filepath.dat");$ha{'desc'}=<F>;close(F);$ha{'num'}=$num;&sn("_listing_iview.html",\%ha)}
sub ts{$return=1;&tw;my($num)=int$hc{'num'};&si(\%hh,\%hg,$num);if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}
&sm(14);&ut("_listing_iviewall.html");opendir(DIR,"$hf{'cgidir'}/$hd{'listing_dir'}/images/");
my(@ac)=grep(/^$num\_\d{1,2}\.(jpg|gif)$/,readdir(DIR));closedir(DIR);foreach$file(@ac){local($desc);
my($descfile)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file.dat";if(-e $descfile){open(F,"<$descfile");
$desc=<F>;close(F)}else{$desc=""}$size=(-s "$hf{'cgidir'}/$hd{'listing_dir'}/images/$file");
$ha{'list'}.=&uu("row")}if(!$ha{'list'}){&ti}$ha{'num'}=$num;&sn("_listing_iviewall.html",\%ha)}
sub tl{$return=1;&tw;my($num)=int$hc{'num'};my($file)=$hc{'limage10'};my($filepath)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file";
&si(\%hh,\%hg,$num);if(!$file){&ti}if($file!~/^$num\_/){&ti}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&ti}
if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}&sm(14);$ha{'file'}=$file;$ha{'size'}=(-s $filepath);
open(F,"<$filepath.dat");$ha{'desc'}=<F>;$ha{'desc'}=~s/\"/&quot;/g;close(F);$ha{'num'}=$num;
&sn("_listing_iedit.html",\%ha)}sub tm{my($num)=int$hc{'num'};my($file)=$hc{'file'};my($desc)=$hc{'desc'};
my($filepath)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file";&si(\%hh,\%hg,$num);if(!$file){&ti}
if($file!~/^$num\_/){&ti}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&ti}if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}
open(F,">$filepath.dat");print F$desc;close(F);&ti}sub tk{$return=1;&tw;&sm(14);my($num)=int$hc{'num'};
my($file)=$hc{'limage10'};my($filepath)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file";&si(\%hh,\%hg,$num);
if(!$file){&ti}if($file!~/^$num\_/){&ti}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&ti}if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}$ha{'file'}=$file;
$ha{'size'}=(-s $filepath);open(F,"<$filepath.dat");$ha{'desc'}=<F>;close(F);$ha{'num'}=$num;
&sn("_listing_iconfirm_erase.html",\%ha)}sub tn{my($num)=int$hc{'num'};my($file)=$hc{'file'};
my($filepath)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$file";&si(\%hh,\%hg,$num);if(!$file){&ti}
if($file!~/^$num\_/){&ti}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&ti}if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}
unlink("$filepath");unlink("$filepath.dat");&ti}sub tp{$return=1;&tw;my($num)=int$hc{'num'};
&si(\%hh,\%hg,$num);if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}&sm(14);$ha{'num'}=$num;
&sn("_listing_iupload_step1.html",\%ha)}sub tq{&sm(14);&ut("_listing_iupload_step2.html");
my($num)=int$hc{'num'};&si(\%hh,\%hg,$num);if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}
for(1..10){local($file_uploaded)=$hc{"image$_"."_file"};local($data)=$hc{"image$_"};local($size)=length $data;
if(!$file_uploaded||!$data){next}elsif($size>$hd{'upload_maxk'}*1000){$ha{'list'}.=&uu("too_large")}
elsif($file_uploaded!~/\.(jpg|gif)$/i){$ha{'list'}.=&uu("invalid_format")}else{my($inum)=1;
my($ext)=lc$hc{"image$_"."_ext"};my($savefile)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$num"."_$inum.$ext";
while(-e $savefile){$inum++;$savefile="$hf{'cgidir'}/$hd{'listing_dir'}/images/$num"."_$inum.$ext"}
open(F,">$savefile");binmode(STDIN);binmode(F);print F$data;close(F);$file="$num"."_$inum.$ext";
$ha{'list'}.=&uu("row")}}$ha{'num'}=$num;&sn("_listing_iupload_step2.html",\%ha)}sub to{my($num)=int$hc{'num'};
&si(\%hh,\%hg,$num);if($he{'access'}<3&&$he{'num'}!=$hg{'owner'}){&ti}foreach(keys %hc){local($file)="$hf{'cgidir'}/$hd{'listing_dir'}/images/$_";
if(/^$num\_/&&/(gif|jpg)$/&&-e $file){open(F,">$file.dat");print F$hc{$_};close(F)}}&ti}sub tb{
if($he{'access'}<3){&sr}$pagenum=$hc{'pagenum'}||$hm{'homepage_pagenum'}||1;$perpage=int$hd{'homepage_perpage'}||10;
$search=$hc{'search'}||$hm{'homepage_search'};if(defined $hc{'keyword'}){$keyword=$hc{'keyword'}}
else{$keyword=$hm{'homepage_keyword'}}if($hc{'homepage_listall'}){$search=""; $keyword=""}
if(defined $hc{'keyword'}||$hc{'homepage_listall'}){$pagenum=1}&ue("homepage_search",$search);
&ue("homepage_keyword",$keyword);&ue("homepage_pagenum",$pagenum);&sm(20);&ut("_homepage_list.html");
$query=sub{if(!$hb{'expires_never'}&&$hb{'expires_date'}<=$hj{'date'}){$hb{'expired'}=1}else{
$hb{'expired'}=0}if($keyword&&$hb{'name'}!~/\Q$keyword\E/i){return(0)}if(!$search||$search eq"all"){
return(1)}if($hb{'access'}eq$search&&!$hb{'expired'}&&!$hb{'disabled'}){return(1)}if($search==5&&$hb{'expired'}){
return(1)}if($search eq"D"&&$hb{'disabled'}){return(1)}return(0)};$match=sub{if($hb{'expires_never'}){
$hb{'expires'}=&uu("never")}elsif(!$hb{'expires_never'}&&$hb{'expires_date'}<=$hj{'date'}){
$hb{'expires'}=&uu("expired")}else{$hb{'expires'}=&uu("mon$hb{'expires_mon'}");$hb{'expires'}.=sprintf(" %02d,",$hb{'expires_day'});
$hb{'expires'}.=" $hb{'expires_year'}"}if($hb{'disabled'}){$ha{'list'}.=&uu("disabled",\%hb)}
elsif($hb{'access'}==1){$ha{'list'}.=&uu("newuser",\%hb)}elsif($hb{'access'}==2){$ha{'list'}.=&uu("regular",\%hb)}
elsif($hb{'access'}==3){$ha{'list'}.=&uu("admin",\%hb)}elsif($hb{'access'}==4){$ha{'list'}.=&uu("superuser",\%hb)}};
$sort=sub{(split(/\¡/,$a))[1]cmp(split(/\¡/,$b))[1]};($ha{'pcount'},$ha{'mcount'},$ha{'rcount'},$ha{'cpage'},$ha{'lpage'},$ha{'npage'})=&sg(\%hi,$query,$match,$sort,\%hb,$pagenum,$perpage);
if(!$ha{'list'}){$ha{'list'}=&uu("not_found")}$ha{"search_$search"."_selected"}="selected";
$ha{'keyword'}=$keyword;&sn("_homepage_list.html",\%ha)}sub sr{if($he{'access'}<3){$num=$he{'num'}}
else{$num=int$hc{'homepage_edit'}||int$hc{'num'}}&sm(21);&ut("_homepage_edit.html");&si(\%hi,\%hu,$num);
$ha{'name'}=$hu{'name'};for$fnum(1..50){if(!$hd{"hfield$fnum"."_active"}){next}$ftype=$hd{"hfield$fnum"."_type"};
$fname=$hd{"hfield$fnum"."_name"};$fvalue=$hu{"hfield$fnum"};$fvalue=~s/\"/&quot;/g;$foptions="";
if($fname=~m/^(.*?)\((.*?)\)$/i){($fname,$fostr)=($1,$2)}else{$fostr=""}$fostr=~s/(^|[^\\]),/$1 ,/g;
foreach(split(/ ,/,$fostr)){s/\\,/,/go;s/(^\s+|\s+$)//go;if($fvalue&&$fvalue eq$_){$foptions.="<option selected>$_\n"}
else{$foptions.="<option>$_\n"}}if($ftype==1){$ha{'list'}.=&uu("text_field")}if($ftype==2){
$ha{'list'}.=&uu("text_box")}if($ftype==3){$ha{'list'}.=&uu("dropdown")}}opendir(DIR,"$hf{'cgidir'}/$hd{'homepage_dir'}/images/");
my(@ac)=grep(/^$num\_\d{1,2}\.(jpg|gif)$/,readdir(DIR));closedir(DIR);foreach$file(@ac){my($desc);
my($descfile)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file.dat";if(-e $descfile){open(F,"<$descfile");
$desc=<F>;close(F)}else{$desc="No description"}if(length $desc>45){$desc=substr($desc,0,45)."..."}
for$hnum(0..10){if($hu{"himage$hnum"}eq$file){$ha{"ilist$hnum"}.=qq|<option value="$file" selected>$desc\n|}
else{$ha{"ilist$hnum"}.=qq|<option value="$file">$desc\n|}}}$ha{'num'}=int$num;&sn("_homepage_edit.html",\%ha)}
sub te{if($he{'access'}<3){$num=$he{'num'}}else{$num=int$hc{'num'}}if(!$return){&sm(21)}&si(\%hi,\%hb,$num);
foreach(keys %hb){if(/^himage/){$hb{$_}=$hc{$_}}if(/^hfield/){$hb{$_}=$hc{$_}}}&sk(\%hi,\%hb,$num);
&tc($num);if($hd{'publish_homepage_index'}){&td}if($return){return}&sn("_homepage_saved.html")}
sub tc{&ut("_publish_homepage.html");$num=int$_[0];local(%ha);&si(\%hi,\%hb,$num);foreach(1..50){
$ha{"hfield$_"}=$hb{"hfield$_"};$ha{"hfield$_"."_ue"}=&uw($hb{"hfield$_"})}$ha{"user_num"}=$hb{'num'};
$ha{"user_name"}=$hb{'name'};$ha{"user_name_ue"}=&uw($hb{'name'});$ha{"user_file"}=sprintf("h%04d.html",$hb{'num'});
my($pfile);if($hb{'specify_filename'}&&$hb{'homepage_filename'}){$pfile=$hb{'homepage_filename'}}
else{$pfile=sprintf("h%04d.html",$num)}if($hd{'publish_homepage_image0'}){$start_inum=0}else{
$start_inum=1}for($start_inum..9){$file=$hb{"himage$_"};$filepath="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file";
open(F,"<$filepath.dat");$desc=<F>;close(F);if($file&&-e $filepath){$ha{'images'}.=&uu("image")}}
if(!$ha{'images'}){$ha{'images'}=&uu("no_images")}foreach(keys %ha){$ha{$_}=~s/\<\!--#/<!--|/go}
open(F,">$hf{'cgidir'}/$hd{'homepage_dir'}/$pfile");print F &ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
print F &ut("_publish_homepage.html",\%ha);print F &ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
close(F)}sub td{&ut("_publish_homepage_index.html");local %ha;$rowcode=sub{$file=$hb{"himage0"};
$filepath="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file";if($file&&-e $filepath){$ha{'file'}=$file}
else{$ha{'file'}=""}$ha{"user_num"}=$hb{'num'};$ha{"user_name"}=$hb{'name'};$ha{"user_name_ue"}=&uw($hb{'name'});
if($hb{'specify_filename'}&&$hb{'homepage_filename'}){$ha{"user_file"}=$hb{'homepage_filename'}}
else{$ha{"user_file"}=sprintf("h%04d.html",$hb{'num'})}foreach(1..50){$ha{"hfield$_"}=$hb{"hfield$_"};
$ha{"hfield$_"."_ue"}=&uw($hb{"hfield$_"})}if($hb{'user_listed'}){if($ha{'file'}){$ha{'list'}.=&uu("user_image",\%ha)}
else{$ha{'list'}.=&uu("user_noimage",\%ha)}}};&sf(\%hi,$rowcode,undef,\%hb);foreach(keys %ha){
$ha{$_}=~s/\<\!--#/<!--|/go}open(F,">$hf{'cgidir'}/$hd{'homepage_dir'}/index.html");print F &ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
print F &ut("_publish_homepage_index.html",\%ha);print F &ua('CjwhLS0gUG93ZXJlZCBieSBFZGlzIFJlYWx0eSBNYW5hZ2VyIDIuMCAtLT4KCg==');
close(F)}sub sz{$return=1;&te;if($he{'access'}<3){$num=$he{'num'}}else{$num=int$hc{'num'}}
my($file)=$hc{'himage10'};my($filepath)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file";if(!$file){&sr}
if($file!~/^$num\_/){&sr}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&sr}&sm(22);$ha{'file'}=$file;
$ha{'size'}=(-s $filepath);open(F,"<$filepath.dat");$ha{'desc'}=<F>;close(F);$ha{'num'}=$num;
&sn("_homepage_iview.html",\%ha)}sub ta{$return=1;&te;local %ha;if($he{'access'}<3){$num=$he{'num'}}
else{$num=int$hc{'num'}}&sm(22);&ut("_homepage_iviewall.html");opendir(DIR,"$hf{'cgidir'}/$hd{'homepage_dir'}/images/");
my(@ac)=grep(/^$num\_\d{1,2}\.(jpg|gif)$/,readdir(DIR));closedir(DIR);foreach$file(@ac){local($desc);
my($descfile)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file.dat";if(-e $descfile){open(F,"<$descfile");
$desc=<F>;close(F)}else{$desc=""}$size=(-s "$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file");
$ha{'list'}.=&uu("row")}if(!$ha{'list'}){&sr}$ha{'num'}=$num;&sn("_homepage_iviewall.html",\%ha)}
sub st{$return=1;&te;if($he{'access'}<3){$num=$he{'num'}}else{$num=int$hc{'num'}}my($file)=$hc{'himage10'};
my($filepath)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file";if(!$file){&sr}if($file!~/^$num\_/){&sr}
if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&sr}&sm(22);$ha{'file'}=$file;$ha{'size'}=(-s $filepath);
open(F,"<$filepath.dat");$ha{'desc'}=<F>;$ha{'desc'}=~s/\"/&quot;/g;close(F);$ha{'num'}=$num;
&sn("_homepage_iedit.html",\%ha)}sub su{if($he{'access'}<3){$num=$he{'num'}}else{$num=int$hc{'num'}}
my($file)=$hc{'file'};my($desc)=$hc{'desc'};my($filepath)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file";
if(!$file){&sr}if($file!~/^$num\_/){&sr}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&sr}open(F,">$filepath.dat");
print F$desc;close(F);&sr}sub ss{$return=1;&te;&sm(22);if($he{'access'}<3){$num=$he{'num'}}
else{$num=int$hc{'num'}}my($file)=$hc{'himage10'};my($filepath)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file";
if(!$file){&sr}if($file!~/^$num\_/){&sr}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&sr}$ha{'file'}=$file;
$ha{'size'}=(-s $filepath);open(F,"<$filepath.dat");$ha{'desc'}=<F>;close(F);$ha{'num'}=$num;
&sn("_homepage_iconfirm_erase.html",\%ha)}sub sv{if($he{'access'}<3){$num=$he{'num'}}else{
$num=int$hc{'num'}}my($file)=$hc{'file'};my($filepath)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file";
if(!$file){&sr}if($file!~/^$num\_/){&sr}if($file!~/^\d+\_\d{1,2}\.(jpg|gif)$/){&sr}unlink("$filepath");
unlink("$filepath.dat");&sr}sub sx{$return=1;&te;if($he{'access'}<3){$num=$he{'num'}}else{
$num=int$hc{'num'}}&sm(22);$ha{'num'}=$num;&sn("_homepage_iupload_step1.html",\%ha)}sub sy{&sm(22);
&ut("_homepage_iupload_step2.html");if($he{'access'}<3){$num=$he{'num'}}else{$num=int$hc{'num'}}
for(1..10){local($file_uploaded)=$hc{"image$_"."_file"};local($data)=$hc{"image$_"};local($size)=length $data;
if(!$file_uploaded||!$data){next}elsif($size>$hd{'upload_maxk'}*1000){$ha{'list'}.=&uu("too_large")}
elsif($file_uploaded!~/\.(jpg|gif)$/i){$ha{'list'}.=&uu("invalid_format")}else{my($inum)=1;
my($ext)=lc$hc{"image$_"."_ext"};my($savefile)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$num"."_$inum.$ext";
while(-e $savefile){$inum++;$savefile="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$num"."_$inum.$ext"}
open(F,">$savefile");binmode(STDIN);binmode(F);print F$data;close(F);$file="$num"."_$inum.$ext";
$ha{'list'}.=&uu("row")}}$hc{'num'}=$num;if(!$ha{'list'}){&sr}$ha{'num'}=$num;&sn("_homepage_iupload_step2.html",\%ha)}
sub sw{if($he{'access'}<3){$num=$he{'num'}}else{$num=int$hc{'num'}}foreach(keys %hc){local($file)="$hf{'cgidir'}/$hd{'homepage_dir'}/images/$_";
if(/^$num\_/&&/(gif|jpg)$/&&-e $file){open(F,">$file.dat");print F$hc{$_};close(F)}}&sr}sub vb{
if($he{'access'}<3){return}$pagenum=$hc{'pagenum'}||$hm{'userman_pagenum'}||1;$perpage=int$hd{'userman_perpage'}||10;
$search=$hc{'search'}||$hm{'userman_search'};if(defined $hc{'keyword'}){$keyword=$hc{'keyword'}; $pagenum=1}
else{$keyword=$hm{'userman_keyword'}}if($hc{'userman_listall'}){$search=""; $keyword=""; $pagenum=1}
&ue("userman_search",$search);&ue("userman_keyword",$keyword);&ue("userman_pagenum",$pagenum);
&sm(30);&ut("_userman_list.html",\%ha);$query=sub{if($he{'access'}<4&&$hb{'access'}==4){return(0)}$admin_count++;
if(!$hb{'expires_never'}&&$hb{'expires_date'}<=$hj{'date'}){$hb{'expired'}=1}else{$hb{'expired'}=0}
if($keyword&&$hb{'name'}!~/\Q$keyword\E/i){return(0)}if(!$search||$search eq"all"){return(1)}
if($hb{'access'}eq$search&&!$hb{'expired'}&&!$hb{'disabled'}){return(1)}if($search==5&&$hb{'expired'}){
return(1)}if($search eq"D"&&$hb{'disabled'}){return(1)}return(0)};$match=sub{if($hb{'expires_never'}){
$hb{'expires'}=&uu("never")}elsif(!$hb{'expires_never'}&&$hb{'expires_date'}<=$hj{'date'}){
$hb{'expires'}=&uu("expired")}else{$hb{'expires'}=&uu("mon$hb{'expires_mon'}");$hb{'expires'}.=sprintf(" %02d,",$hb{'expires_day'});
$hb{'expires'}.=" $hb{'expires_year'}"}if($hb{'disabled'}){$ha{'list'}.=&uu("disabled",\%hb)}
elsif($hb{'access'}==1){$ha{'list'}.=&uu("newuser",\%hb)}elsif($hb{'access'}==2){$ha{'list'}.=&uu("regular",\%hb)}
elsif($hb{'access'}==3){$ha{'list'}.=&uu("admin",\%hb)}elsif($hb{'access'}==4){$ha{'list'}.=&uu("superuser",\%hb)}};
$sort=sub{(split(/\¡/,$a))[1]cmp(split(/\¡/,$b))[1]};($ha{'pcount'},$ha{'mcount'},$ha{'rcount'},$ha{'cpage'},$ha{'lpage'},$ha{'npage'})=&sg(\%hi,$query,$match,$sort,\%hb,$pagenum,$perpage);
if(!$ha{'list'}){$ha{'list'}=&uu("not_found")}$ha{"search_$search"."_selected"}="selected";
$ha{'keyword'}=$keyword;if($he{'access'}==4){$ha{'extra_option'}=&uu('search_superuser',\%ha)}$ha{'rcount'}=$admin_count;
&sn("_userman_list.html",\%ha)}sub ux{if($he{'access'}<3){return}&sm(31);if($hc{'userman_save'}){%ha=%hc;
$ha{"access_$ha{'access'}_selected"}="selected";$ha{"created_mon_$ha{'created_mon'}_selected"}="selected";
$ha{"created_day_$ha{'created_day'}_selected"}="selected";$ha{"created_year_$ha{'created_year'}_selected"}="selected";
$ha{"expires_mon_$ha{'expires_mon'}_selected"}="selected";$ha{"expires_day_$ha{'expires_day'}_selected"}="selected";
$ha{"expires_year_$ha{'expires_year'}_selected"}="selected";$ha{"expires_never_checked"}="checked"if$ha{'expires_never'};
$ha{"disabled_$ha{'disabled'}_checked"}="checked";$ha{"listings_max"}=int$ha{"listings_max"};
$ha{"listings_unlimited_checked"}="checked"if$ha{'listings_unlimited'};$ha{"user_listed_$ha{'user_listed'}_checked"}="checked";
$ha{"specify_filename_$ha{'specify_filename'}_checked"}="checked"}else{$ha{'access_2_selected'}="selected";
$ha{"created_mon_$hj{'mon'}_selected"}="selected";$ha{"created_day_$hj{'day'}_selected"}="selected";
$ha{"created_year_$hj{'year'}_selected"}="selected";$ha{"expires_mon_$hj{'mon'}_selected"}="selected";
$ha{"expires_day_$hj{'day'}_selected"}="selected";$ha{"expires_year_".($hj{'year'}+1)."_selected"}="selected";
$ha{"user_listed_1_checked"}="checked";$ha{"specify_filename_0_checked"}="checked"}foreach(keys %ha){
$ha{$_}=~s/"/&quot;/g}&ut("_userman_add.html",\%ha);if($he{'access'}==4){$ha{'extra_option'}=&uu('superuser',\%ha)}
if($error eq"invalid_login_name"){$ha{'error'}=&uu("invalid_login_name")}if($error eq"invalid_filename"){
$ha{'error'}=&uu("invalid_filename")}&sn("_userman_add.html",\%ha)}sub uz{if($he{'access'}<3){
return}my($num)=int$hc{'userman_edit'}||int$hc{'num'};&si(\%hi,\%hb,$num)||&vb;if($he{'access'}<4&&$hb{'access'}==4){&vb}
&sm(32);if($hc{'userman_save'}){%ha=%hc;$ha{"access_$ha{'access'}_selected"}="selected";$ha{"created_mon_$ha{'created_mon'}_selected"}="selected";
$ha{"created_day_$ha{'created_day'}_selected"}="selected";$ha{"created_year_$ha{'created_year'}_selected"}="selected";
$ha{"expires_mon_$ha{'expires_mon'}_selected"}="selected";$ha{"expires_day_$ha{'expires_day'}_selected"}="selected";
$ha{"expires_year_$ha{'expires_year'}_selected"}="selected";$ha{"expires_never_checked"}="checked"if$ha{'expires_never'};
$ha{"disabled_$ha{'disabled'}_checked"}="checked";$ha{"listings_max"}=int$ha{"listings_max"};
$ha{"listings_unlimited_checked"}="checked"if$ha{'listings_unlimited'};if($ha{'user_listed'}){
$ha{'user_listed_1_checked'}="checked"}else{$ha{'user_listed_0_checked'}="checked"}if($ha{'specify_filename'}){
$ha{'specify_filename_1_checked'}="checked"}else{$ha{'specify_filename_0_checked'}="checked"}}
else{$hb{"access_$hb{'access'}_selected"}="selected";$hb{"created_mon_$hb{'created_mon'}_selected"}="selected";
$hb{"created_day_$hb{'created_day'}_selected"}="selected";$hb{"created_year_$hb{'created_year'}_selected"}="selected";
$hb{"expires_mon_$hb{'expires_mon'}_selected"}="selected";$hb{"expires_day_$hb{'expires_day'}_selected"}="selected";
$hb{"expires_year_$hb{'expires_year'}_selected"}="selected";$hb{"expires_never_checked"}="checked"if$hb{'expires_never'};
$hb{"disabled_$hb{'disabled'}_checked"}="checked";$hb{"listings_max"}=int$hb{"listings_max"};
$hb{"listings_unlimited_checked"}="checked"if$hb{'listings_unlimited'};if($hb{'user_listed'}){
$hb{'user_listed_1_checked'}="checked"}else{$hb{'user_listed_0_checked'}="checked"}if($hb{'specify_filename'}){
$hb{'specify_filename_1_checked'}="checked"}else{$hb{'specify_filename_0_checked'}="checked"}%ha=%hb}
foreach(keys %ha){$ha{$_}=~s/"/&quot;/g}&ut("_userman_edit.html",\%ha);if($he{'access'}==4){
$ha{'extra_option'}=&uu('superuser',\%ha)}if($error eq"invalid_login_name"){$ha{'error'}=&uu("invalid_login_name")}
if($error eq"invalid_filename"){$ha{'error'}=&uu("invalid_filename")}&sn("_userman_edit.html",\%ha)}
sub uy{if($he{'access'}<3){return}my($num)=int$hc{'userman_confirm_erase'};&si(\%hi,\%hb,$num)||&vb;
if($he{'access'}<4&&$hb{'access'}==4){&vb}&sm(33);%ha=%hb;&sn("_userman_confirm_erase.html",\%ha)}
sub va{if($he{'access'}<3){return}my($num)=int$hc{'num'};&si(\%hi,\%hb,$num)||&vb;if($he{'access'}<4&&$hb{'access'}==4){&vb}
&sm(33);&se(\%hi,$num)||&vb;my($pfile);if($hb{'specify_filename'}&&$hb{'homepage_filename'}){
$pfile=$hb{'homepage_filename'}}else{$pfile=sprintf("h%04d.html",$num)}my($ppath)="$hf{'cgidir'}/$hd{'homepage_dir'}/$pfile";
unlink($ppath);opendir(DIR,"$hf{'cgidir'}/$hd{'homepage_dir'}/images/");my(@ac)=grep(/^$num\_\d{1,2}\.(jpg|gif)$/,readdir(DIR));
closedir(DIR);foreach$file(@ac){unlink("$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file");unlink("$hf{'cgidir'}/$hd{'homepage_dir'}/images/$file.dat")}
my(@ah);$rowcode=sub{if($hg{'owner'}==$num){push(@ah,$hg{'num'})}};&sf(\%hh,$rowcode,undef,\%hg);
foreach$lnum(@ah){&se(\%hh,$lnum);my($pfile)=sprintf("l%04d.html",$lnum);unlink("$hf{'cgidir'}/$hd{'listing_dir'}/$pfile");
opendir(DIR,"$hf{'cgidir'}/$hd{'listing_dir'}/images/");my(@ac)=grep(/^$lnum\_\d{1,2}\.(jpg|gif)$/,readdir(DIR));
closedir(DIR);foreach$file(@ac){unlink("$hf{'cgidir'}/$hd{'listing_dir'}/images/$file");unlink("$hf{'cgidir'}/$hd{'listing_dir'}/images/$file.dat")}}
if($hd{'publish_homepage_index'}){&td}&sn("_userman_erased.html",\%ha)}sub vc{if($he{'access'}<3){
return}my($num)=int$hc{'num'};$hc{'login_id'}=lc$hc{'login_id'};$hc{'homepage_filename'}=lc$hc{'homepage_filename'};
if($he{'access'}<4&&$hc{'access'}>=4){&vb}my%hv;$rowcode=sub{$hv{lc$hb{'login_id'}}=$hb{'num'};
$hz{lc$hb{'homepage_filename'}}=$hb{'num'}};&sf(\%hi,$rowcode,undef,\%hb);if($hc{'login_id'}
&&$hv{$hc{'login_id'}}&&$num!=$hv{$hc{'login_id'}}){$error="invalid_login_name"}if($hc{'homepage_filename'}
&&$hz{$hc{'homepage_filename'}}&&$num!=$hz{$hc{'homepage_filename'}}){$error="invalid_filename"}
if($error){if($num){&uz}else{&ux}}&sm(30);$hc{'expires_date'}=sprintf("%04d%02d%02d",$hc{'expires_year'},$hc{'expires_mon'},$hc{'expires_day'});
if($num){&si(\%hi,\%hb,$num);foreach(keys %hb){if(/^himage/){next}if(/^hfield/){next}$hb{$_}=$hc{
$_}}&sk(\%hi,\%hb,$num)}else{$num=&sc(\%hi,\%hc)}&tc($num);if($hd{'publish_homepage_index'}){&td}
&sn("_userman_saved.html",\%ha)}sub un{if($he{'access'}<4){return}&sm(40);&si(\%hk,\%hd,1);
foreach$var("publish_listing_index","publish_homepage_index","publish_listing_image0","publish_homepage_image0","db_sorting"){
if($hd{$var}){$hd{"$var"."_1_checked"}="checked"; $hd{"$var"."_0_checked"}=""}else{$hd{"$var"."_0_checked"}="checked"; $hd{"$var"."_1_checked"}=""}}
if($hd{'time_adjh'}eq"add"){$hd{'time_adjh_add_selected'}="selected"}if($hd{'time_adjh'}eq"minus"){
$hd{'time_adjh_minus_selected'}="selected"}if($hd{'time_adjm'}eq"add"){$hd{'time_adjm_add_selected'}="selected"}
if($hd{'time_adjm'}eq"minus"){$hd{'time_adjm_minus_selected'}="selected"}$hd{'server_time'}=localtime($hf{'stime'});
$hd{'time_adj_hour'}=int$hd{'time_adj_hour'};$hd{'time_adj_min'}=int$hd{'time_adj_min'};$hd{'local_time'}=localtime($hf{'ltime'});
$hd{'str'}="c=".&uw($hd{'company_name'});$hd{'str'}.="&d=".&uw($hd{'domain_name'});$hd{'str'}.="&p=".&uw($hd{'product_id'});
$hd{'str'}.="&v=".&uw($hf{'progVer'});$hd{'str'}.="&h=".&uw($ENV{'HTTP_HOST'});$hd{'str'}.="&s=".&uw($ENV{'SERVER_NAME'});
$hd{'upgrade_id'}=&ub($hd{'str'});%ha=%hd;&sn("_setup_options_edit.html",\%ha)}sub uo{if($he{'access'}<4){
return}$hf{'titlebar'}=$hc{'titlebar'};$hf{'footerbar'}=$hc{'footerbar'};&sm(40);&si(\%hk,\%hd,1);
foreach$field(keys %hd){if($field=~/^lfield/){next}if($field=~/^hfield/){next}if($field eq"product_id"){
next}$hd{$field}=$hc{$field}}$hd{'login_timeout'}=int$hd{'login_timeout'}||1;&sk(\%hk,\%hd,1);%ha=%hd;
&sn("_setup_options_saved.html",\%ha)}sub uk{if($he{'access'}<4){return}&sm(41);&si(\%hk,\%hd,1);
for$num(1..50){if($hd{"lfield$num"."_active"}){$hd{"lfield$num"."_active_checked"}="checked"}$val=$hd{"lfield$num"."_type"};
if($val){$hd{"lfield$num"."_type_$val"."_selected"}="selected"}}%ha=%hd;&sn("_setup_lfields_edit.html",\%ha)}
sub uj{if($he{'access'}<4){return}&sm(41);$num=int$hc{'setup_lfields_confirm_reset'};$ha{'name'}=$hd{"lfield$num"."_name"};
if($ha{'name'}=~m/^(.*?)\((.*?)\)$/i){$ha{'name'}=$1}$ha{'num'}=$num;&sn("_setup_lfields_confirm_reset.html",\%ha)}
sub ul{if($he{'access'}<4){return}$num=int$hc{'num'};&si(\%hk,\%hd,1);$hd{"lfield$num"."_name"}="";
$hd{"lfield$num"."_type"}="";$hd{"lfield$num"."_active"}="";&sk(\%hk,\%hd,1);$rowcode=sub{
$hg{"lfield$num"}=""};&sh(\%hh,$rowcode,undef,\%hg);&uk}sub um{if($he{'access'}<4){return}
&sm(41);&si(\%hk,\%hd,1);foreach$field(keys %hd){if($field!~/^lfield/){next}$hd{$field}=$hc{
$field}}&sk(\%hk,\%hd,1);if($return){return}%ha=%hd;&sn("_setup_lfields_saved.html",\%ha)}
sub ug{if($he{'access'}<4){return}&sm(42);&si(\%hk,\%hd,1);for$num(1..50){if($hd{"hfield$num"."_active"}){
$hd{"hfield$num"."_active_checked"}="checked"}}for$num(1..50){$val=$hd{"hfield$num"."_type"};
$hd{"hfield$num"."_type_$val"."_selected"}="selected"}%ha=%hd;&sn("_setup_hfields_edit.html",\%ha)}
sub uf{if($he{'access'}<4){return}&sm(42);$num=int$hc{'setup_hfields_confirm_reset'};$ha{'name'}=$hd{"hfield$num"."_name"};
if($ha{'name'}=~m/^(.*?)\((.*?)\)$/i){$ha{'name'}=$1}$ha{'num'}=$num;&sn("_setup_hfields_confirm_reset.html",\%ha)}
sub uh{if($he{'access'}<4){return}$num=int$hc{'num'};&si(\%hk,\%hd,1);$hd{"hfield$num"."_name"}="";
$hd{"hfield$num"."_type"}="";$hd{"hfield$num"."_active"}="";&sk(\%hk,\%hd,1);$rowcode=sub{
$hb{"hfield$num"}=""};&sh(\%hi,$rowcode,undef,\%hb);&ug}sub ui{if($he{'access'}<4){return}
&sm(42);&si(\%hk,\%hd,1);foreach$field(@{$hk{"fields"}}){if($field!~/^hfield/){next}$hd{$field}=$hc{
$field}}&sk(\%hk,\%hd,1);%ha=%hd;&sn("_setup_hfields_saved.html",\%ha)}sub us{if($he{'access'}<4){
return}my(@ae);$rowcode=sub{push(@ae,$hg{'num'})};&sf(\%hh,$rowcode,undef,\%hg);foreach$num(@ae){&tu($num)}
&un}sub ur{if($he{'access'}<4){return}&tv;&un}sub uq{if($he{'access'}<4){return}my(@ae);$rowcode=sub{
push(@ae,$hb{'num'})};&sf(\%hi,$rowcode,undef,\%hb);foreach$num(@ae){&tc($num)}&un}sub up{
if($he{'access'}<4){return}&td;&un}sub sf{if(ref($_[0])ne"HASH"){die"DB_List : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"CODE"&&$_[1]){die"DB_List : The second argument must be a CODE reference!\n"}
if(ref($_[2])ne"CODE"&&$_[2]){die"DB_List : The third argument must be a CODE reference!\n"}
if(ref($_[3])ne"HASH"&&$_[3]){die"DB_List : The fourth argument must be a HASH reference!\n"}
if(!$_[0]->{'datafile'}){die"DB_List : No datafile was specified in the DB definition!\n"}
if(!$_[0]->{'filelock'}){die"DB_List : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_List : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_List : No fields were specified in the DB definition!\n"}
my($datafile)="$hf{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$hf{'cgidir'}/../data/$_[0]->{'filelock'}";
my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};$datafile.=$_[0]->{'cgiext'};
my($rowcode)=$_[1];my($sortcode)=$_[2];my($out)=$_[3];my(@aa);my(@ab);unless(-e $datafile){
return(0)}if($backup){&sd($_[0])}&sj($filelock);open(F,"<$datafile")||die("DB_List : Can't open '$datafile'.$!\n");@aa=<F>;
close(F);&sl($filelock);if($sortcode&&&$sortcode ne""){@aa=sort{&$sortcode} @aa}foreach(@aa){/^\d/||next;
s/[^¡]+$//;undef %$out;@ab=split(/\¡/);for$i(0..$#fields){$out->{$fields[$i]}=$ab[$i];$out->{
$fields[$i]}=~s/¿([A-F0-9]{2})/pack("C",hex($1))/egix}&$rowcode}}sub sg{if(ref($_[0])ne"HASH"){
die"DB_ListPage : The first argument must be a HASH reference!\n"}if(ref($_[1])ne"CODE"&&$_[1]){
die"DB_ListPage : The second argument must be a CODE reference!\n"}if(ref($_[2])ne"CODE"&&$_[2]){
die"DB_ListPage : The third argument must be a CODE reference!\n"}if(ref($_[3])ne"CODE"&&$_[3]){
die"DB_ListPage : The fourth argument must be a CODE reference!\n"}if(ref($_[4])ne"HASH"&&$_[4]){
die"DB_ListPage : The fifth argument must be a HASH reference!\n"}if($_[5]=~/[^0-9]/){die"DB_ListPage : Page number value contains non-numeric characters!\n"}
if(!$_[6]){die"DB_ListPage : No Records PerPage value was specified!\n"}if($_[6]=~/[^0-9]/){
die"DB_ListPage : Records PerPage value contains non-numeric characters!\n"}if(!$_[0]->{'datafile'}){
die"DB_ListPage : No datafile was specified in the DB definition!\n"}if(!$_[0]->{'filelock'}){
die"DB_ListPage : No filelock was specified in the DB definition!\n"}if(ref($_[0]->{fields})ne"ARRAY"){
die"DB_ListPage : Field names in the DB definition must be a ARRAY reference!\n"}if($#{$_[0]->{
fields}}<0){die"DB_ListPage : No fields were specified in the DB definition!\n"}my($datafile)="$hf{'cgidir'}/../data/$_[0]->{'datafile'}";
my($filelock)="$hf{'cgidir'}/../data/$_[0]->{'filelock'}";my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};
$datafile.=$_[0]->{'cgiext'};my($querycode)=$_[1];my($matchcode)=$_[2];my($sortcode)=$_[3];
my($out)=$_[4];my($perpage)=int$_[6];my($pcount)=0;my($mcount)=0;my($rcount)=0;my($cpage)=int$_[5]||1;
my($lpage)=0;my($npage)=0;my(@aa);my(@ab);unless(-e $datafile){return(0,0,0,0,0,0)}if($backup){&sd($_[0])}
&sj($filelock);open(F,"<$datafile")||die("DB_List : Can't open '$datafile'.$!\n");@aa=<F>;
close(F);&sl($filelock);if($sortcode&&&$sortcode ne""){@aa=sort{&$sortcode} @aa}foreach(@aa){/^\d/||next;
$rcount++;s/[^\¡]+$//;undef %$out;@ab=split(/\¡/);for$i(0..$#fields){$out->{$fields[$i]}=$ab[$i];
$out->{$fields[$i]}=~s/¿([A-F0-9]{2})/pack("C",hex($1))/egix}if(&$querycode){$mcount++;my($thispage)=($mcount%$perpage) ?int($mcount/$perpage)+1 : $mcount/$perpage;
if($thispage==$cpage){&$matchcode}}}$pcount=int($mcount / $perpage);if($mcount % $perpage){
$pcount++}if(($cpage-1)<1||($cpage-1)>$pcount){$lpage=$pcount}else{$lpage=$cpage-1}if(($cpage+1)>$pcount){
$npage=1}else{$npage=$cpage+1}if(!$pcount){$cpage=$lpage=$npage=0}return($pcount,$mcount,$rcount,$cpage,$lpage,$npage)}
sub sh{if(ref($_[0])ne"HASH"){die"DB_ListSave : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"CODE"&&$_[1]){die"DB_ListSave : The second argument must be a CODE reference!\n"}
if(ref($_[2])ne"CODE"&&$_[2]){die"DB_ListSave : The third argument must be a CODE reference!\n"}
if(ref($_[3])ne"HASH"&&$_[3]){die"DB_ListSave : The fourth argument must be a HASH reference!\n"}
if(!$_[0]->{'datafile'}){die"DB_ListSave : No datafile was specified in the DB definition!\n"}
if(!$_[0]->{'filelock'}){die"DB_ListSave : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_ListSave : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_ListSave : No fields were specified in the DB definition!\n"}
my($datafile)="$hf{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$hf{'cgidir'}/../data/$_[0]->{'filelock'}";
my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};$datafile.=$_[0]->{'cgiext'};
my($rowcode)=$_[1];my($sortcode)=$_[2];my($out)=$_[3];my(@aa);my(@ab);unless(-e $datafile){
return(0)}if($backup){&sd($_[0])}&sj($filelock);open(F,"<$datafile")||die("DB_List : Can't open '$datafile'.$!\n");@aa=<F>;
close(F);if($sortcode&&&$sortcode ne""){@aa=sort{&$sortcode} @aa}foreach(@aa){/^\d/||next;
s/[^¡]+$//;undef %$out;@ab=split(/\¡/);for$i(0..$#fields){$out->{$fields[$i]}=$ab[$i];$out->{
$fields[$i]}=~s/¿([A-F0-9]{2})/pack("C",hex($1))/egix}&$rowcode;$_="$ab[$i]¡";for$i(1..$#fields){
my($enc)=$out->{$fields[$i]};$enc=~s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;$_.="$enc¡"}$_.="\n"}
open(F,">$datafile")||die("DB_List : Can't write $datafile.$!\n");print F qq|#!$^X\n|;print F qq|print"Content-type: text/plain\\n\\n|;
print F qq|Edis Realty Manager v$hf{'progVer'} data file.";\n__END__\n|;foreach(@aa){/^\d/||next;
s/[^¡]+$//;print F"$_\n"}close(F);&sl($filelock)}sub sc{if(ref($_[0])ne"HASH"){die"DB_Add : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"HASH"){die"DB_Add : The second argument must be a HASH reference!\n"}if(!$_[0]->{'datafile'}){
die"DB_Add : No datafile was specified in the DB definition!\n"}if(!$_[0]->{'filelock'}){die"DB_Add : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_Add : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_Add : No fields were specified in the DB definition!\n"}my($datafile)="$hf{'cgidir'}/../data/$_[0]->{'datafile'}";
my($filelock)="$hf{'cgidir'}/../data/$_[0]->{'filelock'}";my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};
$datafile.=$_[0]->{'cgiext'};my($in)=$_[1];my(@aa);my(@ab);my(%hr);if((-e $datafile)&&$backup){&sd($_[0])}
&sj($filelock);if(-e "$datafile"){open(F,"<$datafile")||die("DB_Add : Error,Can't open '$datafile'.$!\n");@aa=<F>;
close(F)}foreach(@aa){/^\d/||next;$hr{(split(/\¡/))[0]}=1}my($nnum)=1;while($hr{$nnum}){$nnum++}
open(F,">$datafile")||die("DB_Add : Can't write to $datafile.$!\n");print F qq|#!$^X\n|;print F qq|print"Content-type: text/plain\\n\\n|;
print F qq|Edis Realty Manager v$hf{'progVer'} data file.";\n__END__\n|;foreach(@aa){/^\d/||next;
s/[^¡]+$//;print F"$_\n"}my($line)="$nnum¡";for$i(1..$#fields){my($enc)=$in->{$fields[$i]};
$enc=~s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;$line.="$enc¡"}print F"$line\n";close(F);
&sl($filelock);return$nnum}sub si{if(ref($_[0])ne"HASH"){die"DB_Load : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"HASH"){die"DB_Load : The second argument must be a HASH reference!\n"}if(!$_[2]){
die"DB_Load : No record number was specified!\n"}if($_[2]=~/[^0-9]/){die"DB_Load : Record number contains non-numeric characters!\n"}
if(!$_[0]->{'datafile'}){die"DB_Load : No datafile was specified in the DB definition!\n"}
if(!$_[0]->{'filelock'}){die"DB_Load : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_Load : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_Load : No fields were specified in the DB definition!\n"}
my($datafile)="$hf{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$hf{'cgidir'}/../data/$_[0]->{'filelock'}";
my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};$datafile.=$_[0]->{'cgiext'};
my($out)=$_[1];my($rnum)=int$_[2];my(@aa);my(@ab);unless(-e $datafile){return(0)}if($backup){&sd($_[0])}
if(-e "$datafile"){&sj($filelock);open(F,"<$datafile")||die("DB_Load : Error,Can't open '$datafile'.$!\n");@aa=<F>;
close(F);&sl($filelock)}foreach(@aa){/^$rnum\¡/||next;s/[^¡]+$//;undef %$out;@ab=split(/\¡/);
for$i(0..$#fields){$out->{$fields[$i]}=$ab[$i];$out->{$fields[$i]}=~s/¿([A-F0-9]{2})/pack("C",hex($1))/egix}
return(1)}return(0)}sub se{if(ref($_[0])ne"HASH"){die"DB_Del : The first argument must be a HASH reference!\n"}
if(!$_[1]){die"DB_Del : The second argument must be a record number!\n"}if($_[1]=~/[^0-9]/){
die"DB_Del : Record number contains non-numeric characters!\n"}if(!$_[0]->{'datafile'}){die"DB_Del : No datafile was specified in the DB definition!\n"}
if(!$_[0]->{'filelock'}){die"DB_Del : No filelock was specified in the DB definition!\n"}if(ref($_[0]->{
fields})ne"ARRAY"){die"DB_Del : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_Del : No fields were specified in the DB definition!\n"}my($datafile)="$hf{'cgidir'}/../data/$_[0]->{'datafile'}";
my($filelock)="$hf{'cgidir'}/../data/$_[0]->{'filelock'}";my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};
$datafile.=$_[0]->{'cgiext'};my($rnum)=int$_[1];my(%hr);my($erased)=0;for(1..$#_){$hr{$_[$_]}++}
my(@aa);unless(-e $datafile){return(0)}if($backup){&sd($_[0])}&sj($filelock);if(-e "$datafile"){
open(F,"<$datafile")||die("DB_Del : Error,Can't open '$datafile'.$!\n");@aa=<F>;close(F)}open(F,">$datafile")||die("DB_Del : Can't write to $datafile.$!\n");
print F qq|#!$^X\n|;print F qq|print"Content-type: text/plain\\n\\n|;print F qq|Edis Realty Manager v$hf{'progVer'} data file.";\n__END__\n|;
foreach(@aa){/^(\d+)\¡/||next;if($hr{$1}){$erased++; next}s/[^¡]+$//;print F"$_\n"}close(F);
&sl($filelock);return$erased}sub sk{if(ref($_[0])ne"HASH"){die"DB_Save : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"HASH"){die"DB_Save : The second argument must be a HASH reference!\n"}if(!$_[2]){
die"DB_Save : No record number was specified!\n"}if($_[2]=~/[^0-9]/){die"DB_Save : Record number contains non-numeric characters!\n"}
if(!$_[0]->{'datafile'}){die"DB_Save : No datafile was specified in the DB definition!\n"}
if(!$_[0]->{'filelock'}){die"DB_Save : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_Save : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_Save : No fields were specified in the DB definition!\n"}
my($datafile)="$hf{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$hf{'cgidir'}/../data/$_[0]->{'filelock'}";
my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};$datafile.=$_[0]->{'cgiext'};
my($in)=$_[1];my($rnum)=int$_[2];my($saved)=0;my(@aa);my(@ab);unless(-e $datafile){return(0)}
if($backup){&sd($_[0])}&sj($filelock);open(F,"<$datafile")||die("DB_Add : Error,Can't open '$datafile'.$!\n");@aa=<F>;
close(F);open(F,">$datafile")||die("DB_Add : Can't write to $datafile.$!\n");print F qq|#!$^X\n|;
print F qq|print"Content-type: text/plain\\n\\n|;print F qq|Edis Realty Manager v$hf{'progVer'} data file.";\n__END__\n|;
foreach(@aa){/^\d/||next;if(/^$rnum\¡/){my($line)="$rnum¡";for$i(1..$#fields){my($enc)=$in->{
$fields[$i]};$enc=~s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;$line.="$enc¡"}print F"$line\n";
$saved++;next}s/[^¡]+$//;print F"$_\n"}close(F);&sl($filelock);unless($saved){&sc(@_)}}sub sd{
my($datafile)="$hf{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$hf{'cgidir'}/../data/$_[0]->{'filelock'}";
my($backup)=$_[0]->{'backup'};my($cgiext)=$_[0]->{'cgiext'};my($bkupfile);unless($backup){
return}if($backup eq"disabled"){return}if($backup eq"none"){return}my($hour,$day,$month,$year)=(localtime(time))[2..5];
$hour=sprintf("%02d",$hour);$day=sprintf("%02d",$day);$month=sprintf("%02d",$month+1);$year=sprintf("%04d",$year+1900);
if($backup eq"hourly"){$bkupfile="$datafile.$year-$month-$day-$hour-backup$cgiext"}elsif($backup eq"daily"){
$bkupfile="$datafile.$year-$month-$day-backup$cgiext"}elsif($backup eq"monthly"){$bkupfile="$datafile.$year-$month-backup$cgiext"}
elsif($backup eq"yearly"){$bkupfile="$datafile.$year-backup$cgiext"}else{die("DB_Backup : Unknown backup setting\n")}
if(-e $bkupfile){return}$datafile="$datafile$cgiext";&sj($filelock);open(F,"<$datafile")||die("DB_Backup : Can't open '$datafile'.$!\n");
open(BKUP,">$bkupfile")||die("DB_Backup : Can't open '$bkupfile'.$!\n");print BKUP<F>;close(F);
close(BKUP);&sl($filelock)}sub sj{my($filelock)=$_[0];my($i);if(!-w "$hf{'cgidir'}/../data/"){
die("DB_Lock : $hf{'cgidir'}/../data/ isn't writable,can't create filelock\n")}while(!mkdir($filelock,0777)){
sleep 1;if(++$i>50){die("DB_Lock : Can't create filelock : $!\n")}}}sub sl{my($filelock)=$_[0];
rmdir($filelock)}sub ud{my($max)=$_[0];my($name,$value,$pair,@af,$buffer,%hl);my($file,$path,$ext);
my($boundary);binmode(STDIN);if($max&&($ENV{'CONTENT_LENGTH'}||length $ENV{'QUERY_STRING'})>$max){
die("ReadForm : Input exceeds max input limit of $max bytes\n")}($boundary)=$ENV{'CONTENT_TYPE'}=~/boundary=(?:"?)(\S+?)(?:"?)$/;
if($ENV{'REQUEST_METHOD'}eq"POST"&&$ENV{'CONTENT_TYPE'}=~m|^multipart/form-data|){while(<STDIN>){
if(/^--$boundary--/){$buffer.="--$boundary"; last}else{$buffer.=$_}}@af=split(/--$boundary/,$buffer);
foreach$pair(@af){unless($pair=~/^(\r\n|\n)Content-Disposition/){next}($name,$value)=$pair=~/^(?:\r\n|\n)(.*?)(?:\r\n|\n){2}(.*?)(?:\r\n|\n)$/s;($path)=$name=~/filename="([^"]+)"/;($name)=$name=~/name="([^"]+)"/;($file)=$path=~/([^\/\\]+)$/;($ext)=$path=~/([^\.]+)$/;
$hl{"$name"}=$value;$hl{"$name"."_path"}=$path;$hl{"$name"."_file"}=$file;$hl{"$name"."_ext"}=$ext}}
else{if($ENV{'REQUEST_METHOD'}eq'POST'){read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'})}elsif($ENV{'REQUEST_METHOD'}
eq'GET'){$buffer=$ENV{'QUERY_STRING'}}@af=split(/&/,$buffer);foreach$pair(@af){($name,$value)=split(/=/,$pair);
$value=~tr/+/ /;$value=~s/%([A-F0-9]{2})/pack("C",hex($1))/egi;$value=~s/\r\n/\n/go;$hl{$name}=$value}}
foreach(keys %hl){if(/^(.*)(\.x|\.y)$/){$hl{$1}="true"}}return%hl}sub ut{if(!$_[0]){die"Template : No template file was specified!\n"}
if($_[1]&&ref($_[1])ne"HASH"){die"Template : The second argument must be a HASH reference or undefined!\n"}
my($file)="$hf{'cgidir'}/../templates/$_[0]";my($hashref)=$_[1];my(%hl)=%{$hashref};my($cfile);
my($content);local(*F);if($hashref){foreach(keys %hf){$hl{$_}=$hf{$_}}}else{foreach(keys %hf){
${$_}=$hf{$_}}}if(-e "$hf{'cgidir'}/../templates/$_[0]"){open(F,"<$file")||die"Template : Couldn't open $file! $!\n";
while(<F>){$content.=$_}close(F)}else{open(F,"<$hf{'cgidir'}/../data/interface.dat.cgi");while(<F>){
if(/^-/&&/^--- (\w+\.html) ---$/){$cfile=$1; next}if($cfile eq$_[0]){$content.=$_}elsif($content){
last}}close(F)}for($content){s/<!-- insert : (.*?) -->/\1/gi;s/<!-- template\s?: insert (.*?) -->/\1/gi;
s/<!-- template insert\s?:\s?(.*?) -->/\1/gi;s/<!-- template\s?:\s?define ([A-Za-z0-9_\.]+) -->(?:\r\n|\n)?(.*?)<!-- template\s?:\s?\/define \1 -->/$hw{
$1}=$2;''/gesi;s/<!-- templatecell\s?:\s?([A-Za-z0-9_\.]+) -->(?:\r\n|\n)?(.*?)<!-- \/templatecell\s?:\s? \1 -->/$hw{
$1}=$2;''/gesi;if($hashref){s/\$(\w+)\$/$hl{$1}/g}else{s/\$(\w+)\$/${$1}/g}}return$content}
sub uu{if(!$_[0]){die"Template : No template cell was specified!\n"}if(!defined $hw{$_[0]}){
die"Template : Template cell '$_[0]' is not defined!\n"}if($_[1]&&ref($_[1])ne"HASH"){die"Template : The second argument must be a HASH reference or undefined!\n"}
my($cellname)=$_[0];my($hashref)=$_[1];my(%hl)=%{$hashref};my($content)=$hw{$cellname};local(*F);
if($hashref){foreach(keys %hf){$hl{$_}=$hf{$_}}}else{foreach(keys %hf){${$_}=$hf{$_}}}if($hashref){
$content=~s/\$(\w+)\$/$hl{$1}/g}else{$content=~s/\$(\w+)\$/${$1}/g}return$content}sub ub{my($in)=$_[0];
my(@am)=((A..Z,a..z,0..9),'+','/');my($out)=unpack("B*",$in);$out=~s/(\d{6}|\d+$)/$am[ord(pack"B*","00$1")]/ge;
while(length($out)%4){$out.="="}return$out}sub ua{my($in)=$_[0];my(%ib);my($out);for((A..Z,a..z,0..9),'+','/'){
$ib{$_}=$i++}$in=$_[0]||return"MIME64 : Nothing to decode";$in=~s/[^A-Za-z0-9+\/]//g;$in=~s/[A-Za-z0-9+\/]/unpack"B*",chr($ib{
$&})/ge;$in=~s/\d\d(\d{6})/$1/g;$in=~s/\d{8}/$out.=pack("B*",$&)/ge;return$out}sub uw{my($text)=$_[0];
$text=~tr/ /+/;$text=~s/[^A-Za-z0-9\+\*\.\@\_\-]/uc sprintf("%%%02x",ord($&))/egx;return$text}
sub uv{my($text)=$_[0];$text=~tr/+/ /;$text=~s/%([A-F0-9]{2})/pack("C",hex($1))/egi;return$text}
sub ue{my($cookie_info);my($name,$value,$exp,$path,$domain,$secure)=@_;my($expires);unless(defined $name){
die("SetCookie : Cookie name must be specified\n")}if($exp&&$exp ne int($exp)){die("SetCookie : Expire Date isn't in seconds using time();\n")}
if($exp){my(@ak)=qw(Sun Mon Tue Wed Thu Fri Sat);my(@al)=qw(Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec);
my($SS,$MM,$HH,$DD,$Mon,$YYYY,$Wdy)=gmtime($exp);foreach($DD,$HH,$MM,$SS){$_=sprintf("%02d",$_)}
my($YYYY)=sprintf("%04d",$YYYY+1900);$expires="$ak[$Wdy],$DD-$al[$Mon]-$YYYY $HH:$MM:$SS GMT"}
if($name){$name=&uw($name)}if($value){$value=&uw($value)}if($exp){$cookie_info.="expires=$expires; "}
if($path){$cookie_info.="path=$path; "}if($domain){$cookie_info.="domain=$domain; "}if($secure){
$cookie_info.="secure; "}print"Set-Cookie: $name=$value; $cookie_info\n"}sub uc{my($cookie,$name,$value,%hs);
foreach$cookie(split(/; /,$ENV{'HTTP_COOKIE'})){($name,$value)=split(/=/,$cookie);foreach($name,$value){
$_=&uv($_)}$hs{$name}=$value}return%hs}
# -----------------------------------------------------------------------------
# This program is protected by Canadian and international copyright laws. Any
# use of this program is subject to the the terms of the license agreement
# included as part of this distribution archive. Any other uses are stictly
# prohibited without the written permission of Edis Digital and all other
# rights are reserved.
# -----------------------------------------------------------------------------
#	               Programming by Edis Digital Inc. <info@edisdigital.com>