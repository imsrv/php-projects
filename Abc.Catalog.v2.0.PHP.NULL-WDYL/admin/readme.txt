Access control
---------------


This directory contains empty files. This files are soecial - flag files.
They allow you to temporary disable enable login access to the ABC Catalog
admin panel.

There are two files in this directory:

admin.deny - This file allow you to completly deny admin access.
	Admin account is the account you are setup in ../secure.inc file.

demo.allow - This file allow you to allow demo access to you admin panel
	with predefined login demo/demo.


How to use
----------

1. To deny admin access you should copy file admin.deny into the root catalog
of ABC Catalog installation on your hosting. To switch on admin account back
you have to delete file admin.deny from ABC Catalog root directory on your
hosting.

2. To allow demo access to ABC Catalog admin panel you should copy file demo.allow
to the root directory of ABC Catalog installation on your hosting. To switch off
demo account you have to delete file demo.allow from ABC Catalog root directory
on your hosting.

