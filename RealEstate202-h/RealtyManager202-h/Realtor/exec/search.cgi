#!/usr/local/bin/perl
# -----------------------------------------------------------------------------
# Edis Realty Manager v2.01 - Search Engine
# Copyright (C) 1998-1999 Edis Digital Inc. All Rights Reserved
# http://www.edisdigital.com/
# -----------------------------------------------------------------------------
# This program is protected by Canadian and international copyright laws. Any
# use of this program is subject to the the terms of the license agreement
# included as part of this distribution archive. Any other uses are stictly
# prohibited without the written permission of Edis Digital and all other
# rights are reserved.
# -----------------------------------------------------------------------------
# Version History (see rm.cgi)
#
# -----------------------------------------------------------------------------
# Warning : Modifying the source code violates your license agreement!
# -----------------------------------------------------------------------------
$SIG{__DIE__}=$SIG{__WARN__}=\&so;%he=("progVer"=>"2.01","progRel"=>"June 25th,1999","progUpd"=>"August 9th,1999","perlOS"=>$^O||"Unknown","perlVer"=>$]||"Unknown","cgidir"=>$0=~m#^(.*)[\\/]#?$1:(`pwd`=~/(.*)/)[0],"cgiurl"=>(split("/",$ENV{'SCRIPT_NAME'}))[-1],"ltime"=>time,"stime"=>time,);
for(0..9){push(@af,"limage$_")}for(1..50){push(@af,"lfield$_")}for(0..9){push(@ae,"himage$_")}
for(1..50){push(@ae,"hfield$_")}for(1..50){push(@ac,"lfield$_"."_name");push(@ac,"lfield$_"."_type");
push(@ac,"lfield$_"."_active")}for(1..50){push(@ac,"hfield$_"."_name");push(@ac,"hfield$_"."_type");
push(@ac,"hfield$_"."_active")}%hj=("datafile"=>"listing.dat","filelock"=>"filelock.lock","fields"=>[qw(num owner created updated),@af],"backup"=>"disabled","cgiext"=>".cgi");%hi=("datafile"=>"user.dat","filelock"=>"filelock.lock","fields"=>[qw(num name login_id login_pw access created_mon created_day created_year expires_mon expires_day expires_year expires_date expires_never disabled listings_max listings_unlimited user_listed specify_filename homepage_filename notes),@ae],"backup"=>"disabled","cgiext"=>".cgi");%hl=("datafile"=>"setup.dat","filelock"=>"filelock.lock","fields"=>["num",@ac,qw(company_name domain_name product_id publish_listing_index publish_homepage_index publish_listing_image0 publish_homepage_image0 upload_maxk login_timeout listing_perpage homepage_perpage userman_perpage db_sorting titlebar footerbar logoff_url image_url listing_dir listing_url homepage_dir homepage_url search_url time_adjh time_adj_hour time_adjm time_adj_min installed)],"backup"=>"disabled","cgiext"=>".cgi");%hy=("datafile"=>"help.dat","filelock"=>"filelock.lock","fields"=>[qw(num parent title content)],"backup"=>"disabled","cgiext"=>".cgi");%hb=&ue;%hn=&ud;
&si(\%hl,\%hd,1);$he{'titlebar'}=$hd{'titlebar'};$he{'footerbar'}=$hd{'footerbar'};$he{'image_url'}=$hd{'image_url'};
$he{'homepage_url'}=$hd{'homepage_url'};$he{'listing_url'}=$hd{'listing_url'};$he{'search_url'}=$hd{'search_url'};
if($hd{'time_adjh'}eq"add"){$he{'ltime'}+=(int($hd{'time_adj_hour'}*60*60))};if($hd{'time_adjh'}
eq"minus"){$he{'ltime'}-=(int($hd{'time_adj_hour'}*60*60))};if($hd{'time_adjm'}eq"add"){$he{'ltime'}+=(int($hd{'time_adj_min'}*60))};
if($hd{'time_adjm'}eq"minus"){$he{'ltime'}-=(int($hd{'time_adj_min'}*60))};$hk{'mon'}=(localtime($he{'ltime'}))[4]+1;
$hk{'day'}=(localtime($he{'ltime'}))[3];$hk{'year'}=(localtime($he{'ltime'}))[5]+1900;$hk{'date'}=sprintf("%04d%02d%02d",$hk{'year'},$hk{'mon'},$hk{'day'});
$|++;$he{'query'}=$ENV{'QUERY_STRING'};if($hb{"search"}){&uf}else{&uc}exit;sub uc{$rowcode=sub{
if(!$hc{'user_listed'}){return(0)}$ha{'userlist'}.=qq|<option value="$hc{'num'}">$hc{'name'}\n|};
$sortcode=sub{(split(/\¡/,$a))[1]cmp(split(/\¡/,$b))[1]};&sf(\%hi,$rowcode,$sortcode,\%hc);
print"Content-type: text/html\n\n" unless($ContentType++);print&uv("_search_query.html",\%ha)}
sub uf{$pagenum=int$hb{'pagenum'}||1;$perpage=int$hb{'perpage'}||10;if($hb{'marknew'}){$marknew=time - ($hb{'marknew'}*60*60*24)}
if($hb{'shownew'}){$shownew=time - ($hb{'shownew'}*60*60*24)}&uv("_search_results.html");$rowcode=sub{
$hx{$hc{'num'}}=$hc{'name'};if($hc{'specify_filename'}&&$hc{'homepage_filename'}){$hv{$hc{'num'}}=$hc{'homepage_filename'}}
else{$hv{$hc{'num'}}=sprintf("h%04d.html",$hc{'num'})}};&sf(\%hi,$rowcode,undef,\%hc);$query=sub{
if($shownew&&$hg{'updated'}<$shownew){return(0)}$hg{'user_num'}=$hg{'owner'};$hg{'user_name'}=$hx{
$hg{'owner'}};if($hb{'user_num'}&&$hb{'user_num'}!=$hg{'user_num'}){return(0)}if($hb{'user_keyword'}
&&$hg{'user_name'}!~/\Q$hb{'user_keyword'}\E/i){return(0)}if($hb{'user_match'}&&lc$hg{'user_name'}
ne lc$hb{'user_match'}){return(0)}for$num(1..50){$val=$hg{"lfield$num"};$nval=$hg{"lfield$num"};
$nval=~s/[^0-9\.]//gs;$min=$hb{"lfield$num"."_min"};$max=$hb{"lfield$num"."_max"};$keyword=$hb{"lfield$num"."_keyword"};
$match=$hb{"lfield$num"."_match"};foreach($min,$max){s/[^0-9\.]//gs}if((length $min)&&$min>$nval){
return(0)}if((length $max)&&$max<$nval){return(0)}if((length $keyword)&&$val!~/\Q$keyword\E/i){
return(0)}if((length $match)&&lc$val ne lc$field_match){return(0)}}return(1)};$match=sub{$hg{'user_num'}=$hg{'owner'};
$hg{'user_name'}=$hx{$hg{'owner'}};$hg{'user_name_ue'}=&uy($hx{$hg{'owner'}});$hg{'user_file'}=$hv{
$hg{'owner'}};$hg{'file'}=$hg{'limage0'};foreach(1..50){$hg{"lfield$_"."_ue"}=&uy($hg{"lfield$_"})}$hg{'listing_file'}=sprintf("l%04d.html",$hg{'num'});
if($marknew&&$hg{'updated'}>=$marknew){if($hg{'limage0'}){$ha{'list'}.=&uw("row_image_new",\%hg)}
else{$ha{'list'}.=&uw("row_noimage_new",\%hg)}}else{if($hg{'limage0'}){$ha{'list'}.=&uw("row_image",\%hg)}
else{$ha{'list'}.=&uw("row_noimage",\%hg)}}};if($hd{'db_sorting'}&&$hb{'sort_order'}){$sort=sub{(split(/\¡/,$a))[14]cmp(split(/\¡/,$b))[14]};($field,$order,$direction)=split(/\,/,$hb{'sort_order'});
$field+=13;if($order eq"123"&&$direction=~/^f/i){$sort=sub{(split(/\¡/,$a))[$field]<=>(split(/\¡/,$b))[$field]}}
elsif($order eq"123"&&$direction!~/^f/i){$sort=sub{(split(/\¡/,$b))[$field]<=>(split(/\¡/,$a))[$field]}}
elsif($order eq"abc"&&$direction=~/^f/i){$sort=sub{lc((split(/\¡/,$a))[$field])cmp lc((split(/\¡/,$b))[$field])}}
elsif($order eq"abc"&&$direction!~/^f/i){$sort=sub{lc((split(/\¡/,$b))[$field])cmp lc((split(/\¡/,$a))[$field])}}
else{$sort=undef}}else{$sort=undef}($ha{'pcount'},$ha{'mcount'},$ha{'rcount'},$ha{'cpage'},$ha{'lpage'},$ha{'npage'})=&sg(\%hj,$query,$match,$sort,\%hg,$pagenum,$perpage);
if(!$ha{'list'}){$ha{'list'}=&uw("not_found")}print"Content-type: text/html\n\n" unless($ContentType++);
print&uv("_search_results.html",\%ha);printf("\n<!-- %.2f CPU seconds -->",(times)[0]);printf("\n<!-- %.2f seconds -->\n",time - $^T);
exit}sub so{print"Content-type: text/html\n\n";if(-e $filelock){&sl($filelock)}foreach(@_){
$error.="$_ "}print&uv("$tmpldir/_error.html");exit}sub sf{if(ref($_[0])ne"HASH"){die"DB_List : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"CODE"&&$_[1]){die"DB_List : The second argument must be a CODE reference!\n"}
if(ref($_[2])ne"CODE"&&$_[2]){die"DB_List : The third argument must be a CODE reference!\n"}
if(ref($_[3])ne"HASH"&&$_[3]){die"DB_List : The fourth argument must be a HASH reference!\n"}
if(!$_[0]->{'datafile'}){die"DB_List : No datafile was specified in the DB definition!\n"}
if(!$_[0]->{'filelock'}){die"DB_List : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_List : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_List : No fields were specified in the DB definition!\n"}
my($datafile)="$he{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$he{'cgidir'}/../data/$_[0]->{'filelock'}";
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
fields}}<0){die"DB_ListPage : No fields were specified in the DB definition!\n"}my($datafile)="$he{'cgidir'}/../data/$_[0]->{'datafile'}";
my($filelock)="$he{'cgidir'}/../data/$_[0]->{'filelock'}";my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};
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
my($datafile)="$he{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$he{'cgidir'}/../data/$_[0]->{'filelock'}";
my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};$datafile.=$_[0]->{'cgiext'};
my($rowcode)=$_[1];my($sortcode)=$_[2];my($out)=$_[3];my(@aa);my(@ab);unless(-e $datafile){
return(0)}if($backup){&sd($_[0])}&sj($filelock);open(F,"<$datafile")||die("DB_List : Can't open '$datafile'.$!\n");@aa=<F>;
close(F);if($sortcode&&&$sortcode ne""){@aa=sort{&$sortcode} @aa}foreach(@aa){/^\d/||next;
s/[^¡]+$//;undef %$out;@ab=split(/\¡/);for$i(0..$#fields){$out->{$fields[$i]}=$ab[$i];$out->{
$fields[$i]}=~s/¿([A-F0-9]{2})/pack("C",hex($1))/egix}&$rowcode;$_="$ab[$i]¡";for$i(1..$#fields){
my($enc)=$out->{$fields[$i]};$enc=~s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;$_.="$enc¡"}$_.="\n"}
open(F,">$datafile")||die("DB_List : Can't write $datafile.$!\n");print F qq|#!$^X\n|;print F qq|print"Content-type: text/plain\\n\\n|;
print F qq|Edis Realty Manager v$he{'progVer'} data file.";\n__END__\n|;foreach(@aa){/^\d/||next;
s/[^¡]+$//;print F"$_\n"}close(F);&sl($filelock)}sub sc{if(ref($_[0])ne"HASH"){die"DB_Add : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"HASH"){die"DB_Add : The second argument must be a HASH reference!\n"}if(!$_[0]->{'datafile'}){
die"DB_Add : No datafile was specified in the DB definition!\n"}if(!$_[0]->{'filelock'}){die"DB_Add : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_Add : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_Add : No fields were specified in the DB definition!\n"}my($datafile)="$he{'cgidir'}/../data/$_[0]->{'datafile'}";
my($filelock)="$he{'cgidir'}/../data/$_[0]->{'filelock'}";my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};
$datafile.=$_[0]->{'cgiext'};my($in)=$_[1];my(@aa);my(@ab);my(%ho);if((-e $datafile)&&$backup){&sd($_[0])}
&sj($filelock);if(-e "$datafile"){open(F,"<$datafile")||die("DB_Add : Error,Can't open '$datafile'.$!\n");@aa=<F>;
close(F)}foreach(@aa){/^\d/||next;$ho{(split(/\¡/))[0]}=1}my($nnum)=1;while($ho{$nnum}){$nnum++}
open(F,">$datafile")||die("DB_Add : Can't write to $datafile.$!\n");print F qq|#!$^X\n|;print F qq|print"Content-type: text/plain\\n\\n|;
print F qq|Edis Realty Manager v$he{'progVer'} data file.";\n__END__\n|;foreach(@aa){/^\d/||next;
s/[^¡]+$//;print F"$_\n"}my($line)="$nnum¡";for$i(1..$#fields){my($enc)=$in->{$fields[$i]};
$enc=~s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;$line.="$enc¡"}print F"$line\n";close(F);
&sl($filelock);return$nnum}sub si{if(ref($_[0])ne"HASH"){die"DB_Load : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"HASH"){die"DB_Load : The second argument must be a HASH reference!\n"}if(!$_[2]){
die"DB_Load : No record number was specified!\n"}if($_[2]=~/[^0-9]/){die"DB_Load : Record number contains non-numeric characters!\n"}
if(!$_[0]->{'datafile'}){die"DB_Load : No datafile was specified in the DB definition!\n"}
if(!$_[0]->{'filelock'}){die"DB_Load : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_Load : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_Load : No fields were specified in the DB definition!\n"}
my($datafile)="$he{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$he{'cgidir'}/../data/$_[0]->{'filelock'}";
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
if($#{$_[0]->{fields}}<0){die"DB_Del : No fields were specified in the DB definition!\n"}my($datafile)="$he{'cgidir'}/../data/$_[0]->{'datafile'}";
my($filelock)="$he{'cgidir'}/../data/$_[0]->{'filelock'}";my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};
$datafile.=$_[0]->{'cgiext'};my($rnum)=int$_[1];my(%ho);my($erased)=0;for(1..$#_){$ho{$_[$_]}++}
my(@aa);unless(-e $datafile){return(0)}if($backup){&sd($_[0])}&sj($filelock);if(-e "$datafile"){
open(F,"<$datafile")||die("DB_Del : Error,Can't open '$datafile'.$!\n");@aa=<F>;close(F)}open(F,">$datafile")||die("DB_Del : Can't write to $datafile.$!\n");
print F qq|#!$^X\n|;print F qq|print"Content-type: text/plain\\n\\n|;print F qq|Edis Realty Manager v$he{'progVer'} data file.";\n__END__\n|;
foreach(@aa){/^(\d+)\¡/||next;if($ho{$1}){$erased++; next}s/[^¡]+$//;print F"$_\n"}close(F);
&sl($filelock);return$erased}sub sk{if(ref($_[0])ne"HASH"){die"DB_Save : The first argument must be a HASH reference!\n"}
if(ref($_[1])ne"HASH"){die"DB_Save : The second argument must be a HASH reference!\n"}if(!$_[2]){
die"DB_Save : No record number was specified!\n"}if($_[2]=~/[^0-9]/){die"DB_Save : Record number contains non-numeric characters!\n"}
if(!$_[0]->{'datafile'}){die"DB_Save : No datafile was specified in the DB definition!\n"}
if(!$_[0]->{'filelock'}){die"DB_Save : No filelock was specified in the DB definition!\n"}
if(ref($_[0]->{fields})ne"ARRAY"){die"DB_Save : Field names in the DB definition must be a ARRAY reference!\n"}
if($#{$_[0]->{fields}}<0){die"DB_Save : No fields were specified in the DB definition!\n"}
my($datafile)="$he{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$he{'cgidir'}/../data/$_[0]->{'filelock'}";
my(@fields)=@{$_[0]->{fields}};my($backup)=$_[0]->{'backup'};$datafile.=$_[0]->{'cgiext'};
my($in)=$_[1];my($rnum)=int$_[2];my($saved)=0;my(@aa);my(@ab);unless(-e $datafile){return(0)}
if($backup){&sd($_[0])}&sj($filelock);open(F,"<$datafile")||die("DB_Add : Error,Can't open '$datafile'.$!\n");@aa=<F>;
close(F);open(F,">$datafile")||die("DB_Add : Can't write to $datafile.$!\n");print F qq|#!$^X\n|;
print F qq|print"Content-type: text/plain\\n\\n|;print F qq|Edis Realty Manager v$he{'progVer'} data file.";\n__END__\n|;
foreach(@aa){/^\d/||next;if(/^$rnum\¡/){my($line)="$rnum¡";for$i(1..$#fields){my($enc)=$in->{
$fields[$i]};$enc=~s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;$line.="$enc¡"}print F"$line\n";
$saved++;next}s/[^¡]+$//;print F"$_\n"}close(F);&sl($filelock);unless($saved){&sc(@_)}}sub sd{
my($datafile)="$he{'cgidir'}/../data/$_[0]->{'datafile'}";my($filelock)="$he{'cgidir'}/../data/$_[0]->{'filelock'}";
my($backup)=$_[0]->{'backup'};my($cgiext)=$_[0]->{'cgiext'};my($bkupfile);unless($backup){
return}if($backup eq"disabled"){return}if($backup eq"none"){return}my($hour,$day,$month,$year)=(localtime(time))[2..5];
$hour=sprintf("%02d",$hour);$day=sprintf("%02d",$day);$month=sprintf("%02d",$month+1);$year=sprintf("%04d",$year+1900);
if($backup eq"hourly"){$bkupfile="$datafile.$year-$month-$day-$hour-backup$cgiext"}elsif($backup eq"daily"){
$bkupfile="$datafile.$year-$month-$day-backup$cgiext"}elsif($backup eq"monthly"){$bkupfile="$datafile.$year-$month-backup$cgiext"}
elsif($backup eq"yearly"){$bkupfile="$datafile.$year-backup$cgiext"}else{die("DB_Backup : Unknown backup setting\n")}
if(-e $bkupfile){return}$datafile="$datafile$cgiext";&sj($filelock);open(F,"<$datafile")||die("DB_Backup : Can't open '$datafile'.$!\n");
open(BKUP,">$bkupfile")||die("DB_Backup : Can't open '$bkupfile'.$!\n");print BKUP<F>;close(F);
close(BKUP);&sl($filelock)}sub sj{my($filelock)=$_[0];my($i);if(!-w "$he{'cgidir'}/../data/"){
die("DB_Lock : $he{'cgidir'}/../data/ isn't writable,can't create filelock\n")}while(!mkdir($filelock,0777)){
sleep 1;if(++$i>50){die("DB_Lock : Can't create filelock : $!\n")}}}sub sl{my($filelock)=$_[0];
rmdir($filelock)}sub ue{my($max)=$_[0];my($name,$value,$pair,@ad,$buffer,%hh);my($file,$path,$ext);
my($boundary);binmode(STDIN);if($max&&($ENV{'CONTENT_LENGTH'}||length $ENV{'QUERY_STRING'})>$max){
die("ReadForm : Input exceeds max input limit of $max bytes\n")}($boundary)=$ENV{'CONTENT_TYPE'}=~/boundary=(?:"?)(\S+?)(?:"?)$/;
if($ENV{'REQUEST_METHOD'}eq"POST"&&$ENV{'CONTENT_TYPE'}=~m|^multipart/form-data|){while(<STDIN>){
if(/^--$boundary--/){$buffer.="--$boundary"; last}else{$buffer.=$_}}@ad=split(/--$boundary/,$buffer);
foreach$pair(@ad){unless($pair=~/^(\r\n|\n)Content-Disposition/){next}($name,$value)=$pair=~/^(?:\r\n|\n)(.*?)(?:\r\n|\n){2}(.*?)(?:\r\n|\n)$/s;($path)=$name=~/filename="([^"]+)"/;($name)=$name=~/name="([^"]+)"/;($file)=$path=~/([^\/\\]+)$/;($ext)=$path=~/([^\.]+)$/;
$hh{"$name"}=$value;$hh{"$name"."_path"}=$path;$hh{"$name"."_file"}=$file;$hh{"$name"."_ext"}=$ext}}
else{if($ENV{'REQUEST_METHOD'}eq'POST'){read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'})}elsif($ENV{'REQUEST_METHOD'}
eq'GET'){$buffer=$ENV{'QUERY_STRING'}}@ad=split(/&/,$buffer);foreach$pair(@ad){($name,$value)=split(/=/,$pair);
$value=~tr/+/ /;$value=~s/%([A-F0-9]{2})/pack("C",hex($1))/egi;$value=~s/\r\n/\n/go;$hh{$name}=$value}}
foreach(keys %hh){if(/^(.*)(\.x|\.y)$/){$hh{$1}="true"}}return%hh}sub uv{if(!$_[0]){die"Template : No template file was specified!\n"}
if($_[1]&&ref($_[1])ne"HASH"){die"Template : The second argument must be a HASH reference or undefined!\n"}
my($file)="$he{'cgidir'}/../templates/$_[0]";my($hashref)=$_[1];my(%hh)=%{$hashref};my($cfile);
my($content);local(*F);if($hashref){foreach(keys %he){$hh{$_}=$he{$_}}}else{foreach(keys %he){
${$_}=$he{$_}}}if(-e "$he{'cgidir'}/../templates/$_[0]"){open(F,"<$file")||die"Template : Couldn't open $file! $!\n";
while(<F>){$content.=$_}close(F)}else{open(F,"<$he{'cgidir'}/../data/interface.dat.cgi");while(<F>){
if(/^-/&&/^--- (\w+\.html) ---$/){$cfile=$1; next}if($cfile eq$_[0]){$content.=$_}elsif($content){
last}}close(F)}for($content){s/<!-- insert : (.*?) -->/\1/gi;s/<!-- template\s?: insert (.*?) -->/\1/gi;
s/<!-- template insert\s?:\s?(.*?) -->/\1/gi;s/<!-- template\s?:\s?define ([A-Za-z0-9_\.]+) -->(?:\r\n|\n)?(.*?)<!-- template\s?:\s?\/define \1 -->/$hr{
$1}=$2;''/gesi;s/<!-- templatecell\s?:\s?([A-Za-z0-9_\.]+) -->(?:\r\n|\n)?(.*?)<!-- \/templatecell\s?:\s? \1 -->/$hr{
$1}=$2;''/gesi;if($hashref){s/\$(\w+)\$/$hh{$1}/g}else{s/\$(\w+)\$/${$1}/g}}return$content}
sub uw{if(!$_[0]){die"Template : No template cell was specified!\n"}if(!defined $hr{$_[0]}){
die"Template : Template cell '$_[0]' is not defined!\n"}if($_[1]&&ref($_[1])ne"HASH"){die"Template : The second argument must be a HASH reference or undefined!\n"}
my($cellname)=$_[0];my($hashref)=$_[1];my(%hh)=%{$hashref};my($content)=$hr{$cellname};local(*F);
if($hashref){foreach(keys %he){$hh{$_}=$he{$_}}}else{foreach(keys %he){${$_}=$he{$_}}}if($hashref){
$content=~s/\$(\w+)\$/$hh{$1}/g}else{$content=~s/\$(\w+)\$/${$1}/g}return$content}sub ub{my($in)=$_[0];
my(@ai)=((A..Z,a..z,0..9),'+','/');my($out)=unpack("B*",$in);$out=~s/(\d{6}|\d+$)/$ai[ord(pack"B*","00$1")]/ge;
while(length($out)%4){$out.="="}return$out}sub ua{my($in)=$_[0];my(%hu);my($out);for((A..Z,a..z,0..9),'+','/'){
$hu{$_}=$i++}$in=$_[0]||return"MIME64 : Nothing to decode";$in=~s/[^A-Za-z0-9+\/]//g;$in=~s/[A-Za-z0-9+\/]/unpack"B*",chr($hu{
$&})/ge;$in=~s/\d\d(\d{6})/$1/g;$in=~s/\d{8}/$out.=pack("B*",$&)/ge;return$out}sub uy{my($text)=$_[0];
$text=~tr/ /+/;$text=~s/[^A-Za-z0-9\+\*\.\@\_\-]/uc sprintf("%%%02x",ord($&))/egx;return$text}
sub ux{my($text)=$_[0];$text=~tr/+/ /;$text=~s/%([A-F0-9]{2})/pack("C",hex($1))/egi;return$text}
sub ug{my($cookie_info);my($name,$value,$exp,$path,$domain,$secure)=@_;my($expires);unless(defined $name){
die("SetCookie : Cookie name must be specified\n")}if($exp&&$exp ne int($exp)){die("SetCookie : Expire Date isn't in seconds using time();\n")}
if($exp){my(@aj)=qw(Sun Mon Tue Wed Thu Fri Sat);my(@ah)=qw(Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec);
my($SS,$MM,$HH,$DD,$Mon,$YYYY,$Wdy)=gmtime($exp);foreach($DD,$HH,$MM,$SS){$_=sprintf("%02d",$_)}
my($YYYY)=sprintf("%04d",$YYYY+1900);$expires="$aj[$Wdy],$DD-$ah[$Mon]-$YYYY $HH:$MM:$SS GMT"}
if($name){$name=&uy($name)}if($value){$value=&uy($value)}if($exp){$cookie_info.="expires=$expires; "}
if($path){$cookie_info.="path=$path; "}if($domain){$cookie_info.="domain=$domain; "}if($secure){
$cookie_info.="secure; "}print"Set-Cookie: $name=$value; $cookie_info\n"}sub ud{my($cookie,$name,$value,%hp);
foreach$cookie(split(/; /,$ENV{'HTTP_COOKIE'})){($name,$value)=split(/=/,$cookie);foreach($name,$value){
$_=&ux($_)}$hp{$name}=$value}return%hp}
# -----------------------------------------------------------------------------
# This program is protected by Canadian and international copyright laws. Any
# use of this program is subject to the the terms of the license agreement
# included as part of this distribution archive. Any other uses are stictly
# prohibited without the written permission of Edis Digital and all other
# rights are reserved.
# -----------------------------------------------------------------------------
#	               Programming by Edis Digital Inc. <info@edisdigital.com>