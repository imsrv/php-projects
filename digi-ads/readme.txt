README file for digi-ads 1.0
http://www.digi-fx.net
andrew@digi-fx.net

//////////////////
//    Files
//////////////////
1.)  admin.php
2.)  ads.inc.php
3.)  ads.php
4.)  click.php
5.)  stats.php
6.)  template.htm
7.)  bar.gif
8.)  baroff.gif
9.)  ads.dat
10.) readme.txt
11.) license.txt

//////////////////
// Requirements
//////////////////
- PHP4

//////////////////
// Installation
//////////////////
1. Open "admin.php", "ads.php", "click.php", and "stats.php" in a TEXT-ONLY
editor. Notepad or any other editor will suffice. Do not use an HTML editor
or Word.

  Edit the lines that read:
     $digiAdsPath = '/path/to/digi-ads/ads.dat';
     require '/path/to/digi-ads/ads.inc.php';

You should change the absolute paths to mirror your directory structure. It
is recommended that you place ads.dat in a directory not accessible from the
web.

2.) Edit "template.htm" to match the look and feel of your web site. This
file is used to render the display of an individual ad's stats.

3.) Upload all files into a directory named digi-ads. All files should be
uploaded in ASCII mode except for "bar.gif" and "baroff.gif" which should be
uploaded in binary mode. It is recommended that you place ads.dat in a
directory not accessible from the web, so not in the directory digi-ads.

4.) On UNIX-like operating systems, CHMOD ads.dat 777.

//////////////////
// Script Usage
//////////////////
1.) Visit admin.php in your web browser e.g.
http://www.domain.com/digi-ads/admin.php.

2.) Login to the control panel using the following login name and password:
       Login Name: admin
       Password:   1234

3.) Configure the script by clicking on "Configuration".

4.) Ad Ads as necessary.

5.) Displaying ads is relatively simple. The following is just a bare-boned
example (feel free to change the arguments and HTML).
<?php include '/path/to/digi-ads/ads.php'; ?>
<?php $buttons = new digiAds (numAds, width, height); ?>
<?php echo $buttons->ad[0]; ?>
<?php echo $buttons->ad[1]; ?>

- numAds: The number of ads you want pulled and displayed randomly from the
database. This example displayes two ads.
- width (optional): The width of all ads if you only want ads with a specific
width pulled and displayed from the database. Height must not be left blank.
- height (optional): The height of all ads if you only want ads with a
specific height pulled and displayed from the database. Width must not be
left blank.

6.) To display a specified ad's stats, call stats.php with a query string
/stats.php?id=$id where $id equals the unique id of the ad.

//////////////////
//  Change Log
//////////////////
Version 1.0 - Official Release