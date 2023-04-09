$filename = "./users/benman\@unistream.net/Inbox";
    ($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,
       $atime,$mtime,$ctime,$blksize,$blocks)
           = stat($filename);

@mboxstat = stat("./users/benman\@unistream.net/Inbox");
print $mboxstat[7];
foreach $value (@mboxstat) { print $_, "\n"; }
