
sub newbox
{
$myinbox = $_[0];
$mytmp = $_[1];

mkdir("$mytmp/tmp",0777) if(!-e "$mytmp/tmp");

local($/) = undef;
open(F,"$mytmp/$myinbox");
my (@a) = split(/From .*\d{4}/, <F>);
$cnt = scalar(@a) - 1;
for($i=0;$i<=$cnt;$i++) {
open(N,">$mytmp/tmp/$i.$myinbox") || print "Cannot open $mytmp/tmp/$i.$myinbox: $!<BR>";
print N "From ??? Fri Feb 19 09:25:01 1999$a[$i]";
close(N);
                        }
close(F);
return 0 if($cnt < 0);
$cnt;
}

sub readbox
 {
my($msgnum) = $_[0];
my($themsg) = [];
my($cnt);
open(T1,"$mytmp/tmp/$msgnum.$myinbox") || print "Cannot open $mytmp/tmp/$msgnum.$myinbox: $!<BR>";
$line = <T1>;
while(<T1>) { push(@$themsg , $_); $cnt++;}
close(T1);
return 0 if($cnt < 2);
$themsg;
  }

sub deletebox
{
my($msgnum) = $_[0];
unlink "$mytmp/tmp/$msgnum.$myinbox" || print "Cannot del: $!\n";
}

sub cleanup
{
open(N,">$mytmp/$myinbox.new");
opendir(DIR,"$mytmp/tmp");
@fol = readdir(DIR);
foreach $f (@fol)
 {
 next if($f eq "." || $f eq ".." || $f !~ /$myinbox/);
 open(Q,"$mytmp/tmp/$f"); while(<Q>) { print N $_; } close(Q);
 }

for($i=0;$i<=$cnt;$i++) {
unlink "$mytmp/tmp/$i.$myinbox" || print "Cannot delete : $!\n";
                        }
close(N);
rename("$mytmp/$myinbox.new", "$mytmp/$myinbox");
}

1;
