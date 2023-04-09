#!/bin/sh

find /mnt/big/mp3/ -name \*.mp3 -print > list.$$
find /mnt/nfs -name \*.mp3 -print >> list.$$
find /mnt/changer/1 -name \*.mp3 -print >> list.$$
find /mnt/changer/2 -name \*.mp3 -print >> list.$$
find /mnt/changer/3 -name \*.mp3 -print >> list.$$
find /mnt/changer/4 -name \*.mp3 -print >> list.$$
mv list.$$ data/master.list
chmod 666 data/master.list
