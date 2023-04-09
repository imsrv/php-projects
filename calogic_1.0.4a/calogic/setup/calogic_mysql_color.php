<?php
#
# Table structure for table `".$tabpre."_color_table`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_color_table";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_color_table (
  id int(11) NOT NULL auto_increment,
  cnum int(11) NOT NULL default '0',
  cname varchar(50) NOT NULL default '',
  chex varchar(6) NOT NULL default '',
  nicename varchar(50) NOT NULL default '',
  red int(6) NOT NULL default '0',
  green int(6) NOT NULL default '0',
  blue int(6) NOT NULL default '0',
  rgb varchar(9) NOT NULL default '',
  rgbplus int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='CaLogic Color Table'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

#
# Dumping data for table `".$tabpre."_color_table`
#

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (1, 1, 'Aqua', '00FFFF', 'blue', 0, 255, 255, '000255255', 510)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (2, 0, 'Black', '000000', 'black', 0, 0, 0, '000000000', 0)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (3, 1, 'Blue', '0000FF', 'blue', 0, 0, 255, '000000255', 255)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (4, 2, 'Fuchsia', 'FF00FF', 'purple', 255, 0, 255, '255000255', 510)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (6, 3, 'Green', '008000', 'green', 0, 128, 0, '000128000', 128)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (7, 2, 'Aliceblue', 'F0F8FF', 'purple', 240, 248, 255, '240248255', 743)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (8, 5, 'Antiquewhite', 'FAEBD7', 'brown', 250, 235, 215, '250235215', 700)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (10, 3, 'Aquamarine', '7FFFD4', 'green', 127, 255, 212, '127255212', 594)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (11, 2, 'Azure', 'F0FFFF', 'purple', 240, 255, 255, '240255255', 750)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (12, 5, 'Beige', 'F5F5DC', 'brown', 245, 245, 220, '245245220', 710)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (13, 5, 'Bisque', 'FFE4C4', 'brown', 255, 228, 196, '255228196', 679)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (14, 5, 'Blanchedalmond', 'FFEBCD', 'brown', 255, 235, 205, '255235205', 695)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (15, 2, 'Blueviolet', '8A2BE2', 'purple', 138, 43, 226, '138043226', 407)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (16, 6, 'Brown', 'A52A2A', 'red', 165, 42, 42, '165042042', 249)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (17, 5, 'Burlywood', 'DEB887', 'brown', 222, 184, 135, '222184135', 541)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (18, 3, 'Cadetblue', '5F9EA0', 'green', 95, 158, 160, '095158160', 413)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (19, 4, 'Chartreuse', '7FFF00', 'yellow', 127, 255, 0, '127255000', 382)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (20, 5, 'Chocolate', 'D2691E', 'brown', 210, 105, 30, '210105030', 345)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (21, 6, 'Coral', 'FF7F50', 'red', 255, 127, 80, '255127080', 462)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (22, 1, 'Cornflowerblue', '6495ED', 'blue', 100, 149, 237, '100149237', 486)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (23, 4, 'Cornsilk', 'FFF8DC', 'yellow', 255, 248, 220, '255248220', 723)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (24, 6, 'Crimson', 'DC143C', 'red', 220, 20, 60, '220020060', 300)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (25, 1, 'Cyan', '00FFFF', 'blue', 0, 255, 255, '000255255', 510)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (26, 1, 'Darkblue', '00008B', 'blue', 0, 0, 139, '000000139', 139)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (27, 5, 'Darkgoldenrod', 'B8860B', 'brown', 184, 134, 11, '184134011', 329)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (28, 7, 'Darkgray', 'A9A9A9', 'gray', 169, 169, 169, '169169169', 507)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (29, 3, 'Darkgreen', '006400', 'green', 0, 100, 0, '000100000', 100)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (30, 5, 'Darkkhaki', 'BDB76B', 'brown', 189, 183, 107, '189183107', 479)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (31, 2, 'Darkmagenta', '8B008B', 'purple', 139, 0, 139, '139000139', 278)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (32, 3, 'Darkolivegreen', '556B2F', 'green', 85, 107, 47, '085107047', 239)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (33, 5, 'Darkorange', 'FF8C00', 'brown', 255, 140, 0, '255140000', 395)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (34, 2, 'Darkorchid', '9932CC', 'purple', 153, 50, 204, '153050204', 407)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (35, 6, 'Darkred', '8B0000', 'red', 139, 0, 0, '139000000', 139)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (36, 6, 'Darksalmon', 'E9967A', 'red', 233, 150, 122, '233150122', 505)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (37, 3, 'Darkseagreen', '8FBC8F', 'green', 143, 188, 143, '143188143', 474)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (38, 1, 'Darkslateblue', '483D8B', 'blue', 72, 61, 139, '072061139', 272)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (39, 3, 'Darkslategray', '2F4F4F', 'green', 47, 79, 79, '047079079', 205)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (40, 3, 'Darkturquoise', '00CED1', 'green', 0, 206, 209, '000206209', 415)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (41, 2, 'Darkviolet', '9400D3', 'purple', 148, 0, 211, '148000211', 359)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (42, 2, 'Deeppink', 'FF1493', 'purple', 255, 20, 147, '255020147', 422)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (43, 1, 'Deepskyblue', '00BFFF', 'blue', 0, 191, 255, '000191255', 446)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (44, 7, 'Dimgray', '696969', 'gray', 105, 105, 105, '105105105', 315)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (45, 1, 'Dodgerblue', '1E90FF', 'blue', 30, 144, 255, '030144255', 429)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (46, 6, 'Firebrick', 'B2222', 'red', 178, 34, 2, '178034002', 214)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (47, 4, 'Floralwhite', 'FFFAF0', 'yellow', 255, 250, 240, '255250240', 745)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (48, 3, 'Forestgreen', '228B22', 'green', 34, 139, 34, '034139034', 207)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (49, 7, 'Gainsboro', 'DCDCDC', 'gray', 220, 220, 220, '220220220', 660)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (50, 2, 'Ghostwhite', 'F8F8FF', 'purple', 248, 248, 255, '248248255', 751)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (51, 5, 'Gold', 'FFD700', 'brown', 255, 215, 0, '255215000', 470)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (52, 5, 'Goldenrod', 'DAA520', 'brown', 218, 165, 32, '218165032', 415)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (53, 7, 'Gray', '808080', 'gray', 128, 128, 128, '128128128', 384)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (54, 4, 'Greenyellow', 'ADFF2F', 'yellow', 173, 255, 47, '173255047', 475)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (55, 5, 'Honeydew', 'F0FFF0', 'brown', 240, 255, 240, '240255240', 735)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (57, 2, 'Hotpink', 'FF69B4', 'purple', 255, 105, 180, '255105180', 540)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (58, 6, 'Indianred', 'CD5C5C', 'red', 205, 92, 92, '205092092', 389)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (59, 2, 'Indigo', '4B0082', 'purple', 75, 0, 130, '075000130', 205)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (60, 4, 'Ivory', 'FFFFF0', 'yellow', 255, 255, 240, '255255240', 750)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (61, 4, 'Khaki', 'F0E68C', 'yellow', 240, 230, 140, '240230140', 610)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (62, 2, 'Lavender', 'E6E6FA', 'purple', 230, 230, 250, '230230250', 710)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (63, 6, 'Lavenderblush', 'FFF0F5', 'red', 255, 240, 245, '255240245', 740)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (64, 4, 'Lawngreen', '7CFC00', 'yellow', 124, 252, 0, '124252000', 376)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (65, 4, 'Lemonchiffon', 'FFFACD', 'yellow', 255, 250, 205, '255250205', 710)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (66, 1, 'Lightblue', 'ADD8E6', 'blue', 173, 216, 230, '173216230', 619)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (67, 6, 'Lightcoral', 'F08080', 'red', 240, 128, 128, '240128128', 496)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (68, 2, 'Lightcyan', 'E0FFFF', 'purple', 224, 255, 255, '224255255', 734)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (69, 4, 'Lightgoldenrodyellow', 'FAFAD2', 'yellow', 250, 250, 210, '250250210', 710)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (70, 3, 'Lightgreen', '90EE90', 'green', 144, 238, 144, '144238144', 526)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (71, 7, 'Lightgrey', 'D3D3D3', 'gray', 211, 211, 211, '211211211', 633)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (72, 6, 'Lightpink', 'FFB6C1', 'red', 255, 182, 193, '255182193', 630)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (73, 6, 'Lightsalmon', 'FFA07A', 'red', 255, 160, 122, '255160122', 537)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (74, 3, 'Lightseagreen', '20B2AA', 'green', 32, 178, 170, '032178170', 380)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (75, 1, 'Lightskyblue', '87CEFA', 'blue', 135, 206, 250, '135206250', 591)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (76, 7, 'Lightslategray', '778899', 'gray', 119, 136, 153, '119136153', 408)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (77, 2, 'Lightsteelblue', 'B0C4DE', 'purple', 176, 196, 222, '176196222', 594)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (78, 4, 'Lightyellow', 'FFFFE0', 'yellow', 255, 255, 224, '255255224', 734)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (79, 4, 'Lime', '00FF00', 'yellow', 0, 255, 0, '000255000', 255)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (80, 3, 'Limegreen', '32CD32', 'green', 50, 205, 50, '050205050', 305)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (81, 4, 'Linen', 'FAF0E6', 'yellow', 250, 240, 230, '250240230', 720)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (82, 2, 'Magenta', 'FF00FF', 'purple', 255, 0, 255, '255000255', 510)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (83, 6, 'Maroon', '800000', 'red', 128, 0, 0, '128000000', 128)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (84, 3, 'Mediumaquamarine', '66CDAA', 'green', 102, 205, 170, '102205170', 477)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (85, 1, 'Mediumblue', '0000CD', 'blue', 0, 0, 205, '000000205', 205)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (86, 2, 'Mediumorchid', 'BA55D3', 'purple', 186, 85, 211, '186085211', 482)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (87, 2, 'Mediumpurple', '9370DB', 'purple', 147, 112, 219, '147112219', 478)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (88, 3, 'Mediumseagreen', '3CB371', 'green', 60, 179, 113, '060179113', 352)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (89, 2, 'Mediumslateblue', '7B68EE', 'purple', 123, 104, 238, '123104238', 465)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (90, 3, 'Mediumspringgreen', '00FA9A', 'green', 0, 250, 154, '000250154', 404)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (91, 3, 'Mediumturquoise', '48D1CC', 'green', 72, 209, 204, '072209204', 485)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (92, 2, 'Mediumvioletred', 'C71585', 'purple', 199, 21, 133, '199021133', 353)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (93, 1, 'Midnightblue', '191970', 'blue', 25, 25, 112, '025025112', 162)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (94, 4, 'Mintcream', 'F5FFFA', 'yellow', 245, 255, 250, '245255250', 750)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (95, 6, 'Mistyrose', 'FFE4E1', 'red', 255, 228, 225, '255228225', 708)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (96, 5, 'Moccasin', 'FFE4B5', 'brown', 255, 228, 181, '255228181', 664)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (97, 5, 'Navajowhite', 'FFDEAD', 'brown', 255, 222, 173, '255222173', 650)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (98, 1, 'Navy', '000080', 'blue', 0, 0, 128, '000000128', 128)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (99, 4, 'Oldlace', 'FDF5E6', 'yellow', 253, 245, 230, '253245230', 728)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (100, 3, 'Olive', '808000', 'green', 128, 128, 0, '128128000', 256)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (101, 3, 'Olivedrab', '6B8E23', 'green', 107, 142, 35, '107142035', 284)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (102, 5, 'Orange', 'FFA500', 'brown', 255, 165, 0, '255165000', 420)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (103, 6, 'Orangered', 'FF4500', 'red', 255, 69, 0, '255069000', 324)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (104, 2, 'Orchid', 'DA70D6', 'purple', 218, 112, 214, '218112214', 544)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (105, 4, 'Palegoldenrod', 'EEE8AA', 'yellow', 238, 232, 170, '238232170', 640)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (106, 3, 'Palegreen', '98FB98', 'green', 152, 251, 152, '152251152', 555)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (107, 1, 'Paleturquoise', 'AFEEEE', 'blue', 175, 238, 238, '175238238', 651)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (108, 2, 'Palevioletred', 'DB7093', 'purple', 219, 112, 147, '219112147', 478)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (109, 5, 'Papayawhip', 'FFEFD5', 'brown', 255, 239, 213, '255239213', 707)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (110, 5, 'Peachpuff', 'FFDAB9', 'brown', 255, 218, 185, '255218185', 658)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (111, 5, 'Peru', 'CD853F', 'brown', 205, 133, 63, '205133063', 401)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (112, 6, 'Pink', 'FFC0CB', 'red', 255, 192, 203, '255192203', 650)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (113, 2, 'Plum', 'DDA0DD', 'purple', 221, 160, 221, '221160221', 602)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (114, 1, 'Powderblue', 'B0E0E6', 'blue', 176, 224, 230, '176224230', 630)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (115, 2, 'Purple', '800080', 'purple', 128, 0, 128, '128000128', 256)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (116, 6, 'Red', 'FF0000', 'red', 255, 0, 0, '255000000', 255)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (117, 2, 'Rosybrown', 'BC8F8F', 'purple', 188, 143, 143, '188143143', 474)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (118, 1, 'Royalblue', '4169E1', 'blue', 65, 105, 225, '065105225', 395)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (119, 5, 'Saddlebrown', '8B4513', 'brown', 139, 69, 19, '139069019', 227)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (120, 6, 'Salmon', 'FA8072', 'red', 250, 128, 114, '250128114', 492)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (121, 5, 'Sandybrown', 'F4A460', 'brown', 244, 164, 96, '244164096', 504)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (122, 3, 'Seagreen', '2E8B57', 'green', 46, 139, 87, '046139087', 272)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (123, 4, 'Seashell', 'FFF5EE', 'yellow', 255, 245, 238, '255245238', 738)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (124, 5, 'Sienna', 'A0522D', 'brown', 160, 82, 45, '160082045', 287)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (125, 7, 'Silver', 'C0C0C0', 'gray', 192, 192, 192, '192192192', 576)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (126, 1, 'Skyblue', '87CEEB', 'blue', 135, 206, 235, '135206235', 576)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (127, 2, 'Slateblue', '6A5ACD', 'purple', 106, 90, 205, '106090205', 401)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (128, 7, 'Slategray', '708090', 'gray', 112, 128, 144, '112128144', 384)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (129, 4, 'Snow', 'FFFAFA', 'yellow', 255, 250, 250, '255250250', 755)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (130, 3, 'Springgreen', '00FF7F', 'green', 0, 255, 127, '000255127', 382)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (131, 1, 'Steelblue', '4682B4', 'blue', 70, 130, 180, '070130180', 380)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (132, 5, 'Tan', 'D2B48C', 'brown', 210, 180, 140, '210180140', 530)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (133, 3, 'Teal', '008080', 'green', 0, 128, 128, '000128128', 256)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (135, 2, 'Thistle', 'D8BFD8', 'purple', 216, 191, 216, '216191216', 623)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (136, 6, 'Tomato', 'FF6347', 'red', 255, 99, 71, '255099071', 425)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (137, 3, 'Turquoise', '40E0D0', 'green', 64, 224, 208, '064224208', 496)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (138, 2, 'Violet', 'EE82EE', 'purple', 238, 130, 238, '238130238', 606)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (139, 5, 'Wheat', 'F5DEB3', 'brown', 245, 222, 179, '245222179', 646)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (140, 8, 'White', 'FFFFFF', 'yellow', 255, 255, 255, '255255255', 765)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (141, 4, 'Whitesmoke', 'F5F5F5', 'yellow', 245, 245, 245, '245245245', 735)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (142, 4, 'Yellow', 'FFFF00', 'yellow', 255, 255, 0, '255255000', 510)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (143, 3, 'Yellowgreen', '9ACD32', 'green', 154, 205, 50, '154205050', 409)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_color_table VALUES (144, 3, 'Darkcyan', '008B8B', 'green', 0, 139, 139, '000139139', 278)";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

?>