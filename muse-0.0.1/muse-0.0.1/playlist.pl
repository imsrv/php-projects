#!/usr/bin/perl -w

use Fcntl ':flock'; # import LOCK_* constants
use MPEG::MP3Info;

$streamerPIDFile = "data/streamer.pid";
$listFile = "data/list";
$nowlistFile = "data/req";
$masterlistFile = "data/master.list";
$currentTrackFile = "data/current";

$|=1;


if ($ARGV[0] eq "listmaster")
	{
	open(LIST, $masterlistFile) || die ("Can't open $masterlistFile");
	flock LIST, LOCK_SH;
	print <LIST>;
	close(LIST);
	flock LIST ,LOCK_UN;
	exit;
	}
if ($ARGV[0] eq "list")
	{
	open(LIST, $listFile) || die ("Can't open $listFile");
	flock LIST, LOCK_SH;
	print <LIST>;
	close(LIST);
	flock LIST ,LOCK_UN;
	exit;
	}
elsif ($ARGV[0] eq "listnow")
	{
	open(LIST, $nowlistFile) || die ("Can't open $listfile");
	flock LIST, LOCK_SH;
	print <LIST>;
	close(LIST);
	flock LIST, LOCK_UN;
	exit;
	}
elsif ($ARGV[0] eq "randomise")
	{
	open(LIST, '+<'.$listFile) || die ("Can't open $listfile");
	flock LIST, LOCK_EX;
	$size = 0;
	while(<LIST>)
		{
		$array[$size] = $_;
		$size++;
		}
	seek(LIST, 0, 0);
	while ($size > 0)
		{
		$n = (int rand() * $size * 10) % $size;
		print LIST $array[$n];
		$array[$n] = $array[$size - 1];
		$size --;
		}
	close(LIST);
	flock LIST, LOCK_UN;
	exit;
	}
elsif ($ARGV[0] eq "add")
	{
	$song = <STDIN>;
	open(LIST, $listFile) || die ("Can't open $listfile");
	flock LIST, LOCK_EX;
	while(<LIST>)
		{
		if ($_ eq $song) # already in list, bail out
			{
			close LIST;
			flock LIST, LOCK_UN;
			exit;
			}	
		}
	close LIST;
	flock LIST, LOCK_UN;

	open(LIST, '>>'.$listFile) || die ("Can't open $listfile");
	flock LIST, LOCK_EX;
	seek(LIST, 0, 2);
	print LIST $song;
	close LIST;
	flock LIST, LOCK_UN;
	exit;
	}
elsif ($ARGV[0] eq "addnow")
	{
	$song = <STDIN>;
	open(LIST, $nowlistFile) || die ("Can't open $nowlistfile");
	flock LIST, LOCK_EX;
	while(<LIST>)
		{
		if ($_ eq $song) # already in list, bail out
			{
			close LIST;
			flock LIST, LOCK_UN;
			exit;
			}	
		}
	close LIST;
	flock LIST, LOCK_UN;

	open(LIST, '>>'.$nowlistFile) || die ("Can't open $nowlistfile");
	flock LIST, LOCK_EX;
	seek(LIST, 0, 2);
	print LIST $song;
	flock LIST, LOCK_UN;
	exit;
	}
elsif ($ARGV[0] eq "skip")
	{
	open(PIDFILE, $streamerPIDFile) || die ("Can't open $streamerPIDFile");
	$streamerPID = <PIDFILE>;
	close PIDFILE;
	kill 10, $streamerPID;
	exit;
	}
elsif ($ARGV[0] eq "next")
	{
	open(LIST, $nowlistFile) || die ("Can't open $nowlistfile");
	flock LIST, LOCK_SH;
	$line = <LIST>;
	@rest = <LIST>;
	flock LIST, LOCK_UN;
	close LIST;
	if ($line)
		{
		$song = $line;
		# reopen the file for blatting
		open(LIST, '>'.$nowlistFile) || die ("Can't open $nowlistfile");
		flock LIST, LOCK_EX;
		print LIST @rest;
		close LIST;
		flock LIST, LOCK_UN;
		}
	else
		{
		open(LIST, '+<'.$listFile) || die ("Can't open $listfile");
		flock LIST, LOCK_EX;
		$line = <LIST>;
		@rest = <LIST>;
		$song = $line;
		seek(LIST, 0, 0);
		print LIST @rest, $line;
		close LIST;
		flock LIST, LOCK_UN;
		}
	print $song;
	open(SONGFILE, '>'.$currentTrackFile) || die ("Can't open $currentTrackFile");
	flock SONGFILE, LOCK_EX;
	print SONGFILE $song;
	flock SONGFILE, LOCK_UN;
	}
elsif ($ARGV[0] eq "remove")
	{
	open(LIST, $listFile) || die ("Can't open $listfile");
	flock LIST, LOCK_SH;
	@list = <LIST>;
	$line = <STDIN>;
	foreach $_ (@list)
		{
		s/$line\n//;
		}
	flock LIST, LOCK_UN;
	close LIST;
	open(LIST, '>'.$listFile) || die ("Can't open $listfile");
	flock LIST, LOCK_EX;
	print LIST @list;
	flock LIST, LOCK_UN;
	close LIST;
	exit;
	}
elsif ($ARGV[0] eq "current")
	{
	open(SONG, $currentTrackFile) || die ("Can't open $currentTrackFile");
	flock SONG, LOCK_SH;
	print scalar <SONG>;
	flock SONG, LOCK_UN;
	close SONG;
	exit;
	}
elsif ($ARGV[0] eq "info")
	{
	open(SONG, $currentTrackFile) || die ("Can't open $currentTrackFile");
	flock SONG, LOCK_SH;
	$file = <SONG>;
	flock SONG, LOCK_UN;
	close SONG;
	chomp($file);
	if ($tag = get_mp3tag($file))
		{
		print $tag->{TITLE}."\n";
		print $tag->{ARTIST}."\n";
		print $tag->{ALBUM}."\n";
		print $tag->{YEAR}."\n";
		}
	else
		{
		print "\n\n\n\n";
		}
	exit;
	}

