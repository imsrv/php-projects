package FlatFileDriver;

# FlatFileDriver 0.90
# Copyright (C) 2002  Philip Lehmann-Böhm
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
# See http://www.philiplb.de/impressum.shtml for contact information

use strict;

sub _sortIt {
  my ($sortby) = shift;
  my ($sortdirection) = shift;
  my ($sorttype) = shift;
  my (@EntryLines) = @_;

  my @rankings;
  if ($sortdirection == 1 && $sorttype == 1) {
    @rankings=sort{(split(/\¿/,$a))[$sortby] <=> (split(/\¿/,$b))[$sortby]} @EntryLines;
  }
  if ($sortdirection == 1 && $sorttype == 2) {
    @rankings=sort{(split(/\¿/,$a))[$sortby] cmp (split(/\¿/,$b))[$sortby]} @EntryLines;
  }
  if ($sortdirection == 2 && $sorttype == 1) {
    @rankings=sort{(split(/\¿/,$b))[$sortby] <=> (split(/\¿/,$a))[$sortby]} @EntryLines;
  }
  if ($sortdirection == 2 && $sorttype == 2) {
    @rankings=sort{(split(/\¿/,$b))[$sortby] cmp (split(/\¿/,$a))[$sortby]} @EntryLines;
  }
  return @rankings;
}

sub _getFile {
  my($file) = shift;
  my($useFilelock) = shift;
  open (FILE, $file)  || die "Could not open $file";
  flock(FILE, 2) if $useFilelock == 1;
  my @Lines = <FILE>;
  flock(FILE,8) if $useFilelock == 1;
  close(FILE);
  chomp(@Lines);
  return @Lines;
}

sub _getLine {
  my($id)=shift;
  my(@EntryLines) = @_;
  my $counter = 0;
  my $linePos = -1;
  my $curentEntry;
  ExitLabel:
  foreach $curentEntry (@EntryLines) {
    my @curentEntry=split (/\¿/,$EntryLines[$counter]);
    if ($curentEntry[0] eq $id) {
      $linePos=$counter;
      last ExitLabel;
    }
    $counter++;
  }
  return $linePos;
}

sub new {
  my($class) = shift;

  my %self;
  $self{'filename'} = shift;
  $self{'useFlock'} = shift;
  if (!(-e $self{'filename'})) {
    open(FILE,">".$self{'filename'});
    flock(FILE,2) if $self{'useFlock'} == 1;
    print FILE "0";
    flock(FILE,8) if $self{'useFlock'} == 1;
    close(FILE);
  }
  my @EntryLines = _getFile($self{'filename'},$self{'useFlock'});
  $self{'globalid'} = shift(@EntryLines);
  $self{'EntryLines'} = \@EntryLines;
  chomp($self{'globalid'});
  return bless \%self, $class;
}

sub deleteEntry {
  my $class = shift;
  my $id = shift;
  my @EntryLines =  @{$class->{'EntryLines'}};
  my $deleteline= _getLine($id,@EntryLines);
  if ($deleteline != -1) {
    splice (@EntryLines,$deleteline,1);
    open (ENTRIES,'>'.$class->{'filename'})  || die "Could not open ".$class->{'filename'};
    flock (ENTRIES,2) if $class->{'useFlock'} == 1;
    my $curent;
    print ENTRIES $class->{'globalid'};
    foreach $curent (@EntryLines) {
      print ENTRIES "\n$curent";
    }
    flock(ENTRIES,8) if $class->{'useFlock'} == 1;
    close (ENTRIES);
    $class->{'EntryLines'} = \@EntryLines;
    return 0;
  } else {
    return 1;
  }
}

sub addEntry{
  my $class = shift;
  my @data = @_;
  $class->{'globalid'}++;

  open (EINTRAG,">".$class->{'filename'})  || die "Could not open ".$class->{'filename'};
  flock (EINTRAG,2) if $class->{'useFlock'} == 1;
  my $newEntry;
  my $curent;
  $newEntry = "\n".$class->{'globalid'};
  foreach $curent (@data) {
    $newEntry.="\¿$curent";
  }
  print EINTRAG $class->{'globalid'};
  my @EntryLines = @{$class->{'EntryLines'}};
  foreach $curent (@EntryLines) {
    print EINTRAG "\n$curent";
  }
  print EINTRAG "$newEntry";
  flock (EINTRAG,8) if $class->{'useFlock'} == 1;
  close(EINTRAG);
  push(@EntryLines,$newEntry);
  $class->{'EntryLines'} = \@EntryLines;
  return 0;
}

sub editEntry {
  my $class = shift;
  my $id = shift;
  my @data = @_;
  my @EntryLines = @{$class->{'EntryLines'}};
  my $editline= _getLine($id,@EntryLines);
  if ($editline != -1) {
    my $curent;
    my $Entry = $id;
    foreach $curent (@data){
      $Entry .= "\¿$curent";
    }
    $EntryLines[$editline]=$Entry;
    open (ENTRIES,'>'.$class->{'filename'})  || die "Could not open ".$class->{'filename'};
    flock (ENTRIES,2) if $class->{'useFlock'} == 1;

    print ENTRIES $class->{'globalid'};
    foreach $curent(@EntryLines) {
      print ENTRIES "\n$curent";
    }
    flock(ENTRIES,8) if $class->{'useFlock'} == 1;
    close (ENTRIES);
    $class->{'EntryLines'} = \@EntryLines;
    return 0;
  } else {
    return 1;
  }
}

sub getIdList {
  my $class = shift;
  my $sortby = shift;
  my $sortdir = shift;
  my $sortstyle = shift;
  my @idList;
  my $curent;
  my @EntryLines = @{$class->{'EntryLines'}};
  my @sorted=_sortIt($sortby, $sortdir, $sortstyle,@EntryLines);
  foreach $curent (@sorted) {
    my @tmp = split (/\¿/,$curent);
    push(@idList,$tmp[0]);
  }
  return @idList;
}

sub getEntry {
  my $class = shift;
  my $id = shift;
  my $curent;
  my $counter=0;
  my @entry;
  my @EntryLines = @{$class->{'EntryLines'}};
  ExitLabel:
  foreach $curent (@EntryLines) {
      my @curentEntry=split (/\¿/,$EntryLines[$counter]);
       if ($curentEntry[0] eq $id) {
         @entry = @curentEntry;
         last ExitLabel;
       }
       $counter++;
  }
  chomp(@entry);
  return @entry;
}
1;