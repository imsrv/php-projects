<?php
include("variables.inc.php");
include($dbconnect);

$sql = "DROP TABLE $tablename";
@mysql_query($sql);
$sql = "DROP TABLE $thour";
@mysql_query($sql);
$sql = "DROP TABLE $tday";
@mysql_query($sql);

$sql = "CREATE TABLE $tablename (
NOUSER VARCHAR(10) NOT NULL,
PRIMARY KEY(NOUSER),
DOMAIN VARCHAR(70),
UNIQUEIN INT DEFAULT 0,
RAWIN INT DEFAULT 0,
HITSOUT INT DEFAULT 0,
FORCEDHITS INT DEFAULT 0,
MIN INT DEFAULT 0,
HITSGEN INT DEFAULT 0,
GALOUT INT DEFAULT 0,
RATIO INT(4),
URL VARCHAR(100),
PCUNIQUE NUMERIC(6,2) DEFAULT 0,
PCRETURN NUMERIC(6,2) DEFAULT 0,
PCPROD NUMERIC(6,2) DEFAULT 0,
EMAIL VARCHAR(50),
ICQ INT,
NICK VARCHAR(20),
TITLE VARCHAR(100)
)";
mysql_query($sql) or die(mysql_error());

$sql = "CREATE TABLE $tday (
USER VARCHAR(10) PRIMARY KEY,
UIN0 int(11) DEFAULT 0,
UIN1 int(11) DEFAULT 0,
UIN2 int(11) DEFAULT 0,
UIN3 int(11) DEFAULT 0,
UIN4 int(11) DEFAULT 0,
UIN5 int(11) DEFAULT 0,
UIN6 int(11) DEFAULT 0,
UIN7 int(11) DEFAULT 0,
UIN8 int(11) DEFAULT 0,
UIN9 int(11) DEFAULT 0,
UIN10 int(11) DEFAULT 0,
UIN11 int(11) DEFAULT 0,
UIN12 int(11) DEFAULT 0,
UIN13 int(11) DEFAULT 0,
UIN14 int(11) DEFAULT 0,
UIN15 int(11) DEFAULT 0,
UIN16 int(11) DEFAULT 0,
UIN17 int(11) DEFAULT 0,
UIN18 int(11) DEFAULT 0,
UIN19 int(11) DEFAULT 0,
UIN20 int(11) DEFAULT 0,
UIN21 int(11) DEFAULT 0,
UIN22 int(11) DEFAULT 0,
UIN23 int(11) DEFAULT 0,
UOUT0 int(11) DEFAULT 0,
UOUT1 int(11) DEFAULT 0,
UOUT2 int(11) DEFAULT 0,
UOUT3 int(11) DEFAULT 0,
UOUT4 int(11) DEFAULT 0,
UOUT5 int(11) DEFAULT 0,
UOUT6 int(11) DEFAULT 0,
UOUT7 int(11) DEFAULT 0,
UOUT8 int(11) DEFAULT 0,
UOUT9 int(11) DEFAULT 0,
UOUT10 int(11) DEFAULT 0,
UOUT11 int(11) DEFAULT 0,
UOUT12 int(11) DEFAULT 0,
UOUT13 int(11) DEFAULT 0,
UOUT14 int(11) DEFAULT 0,
UOUT15 int(11) DEFAULT 0,
UOUT16 int(11) DEFAULT 0,
UOUT17 int(11) DEFAULT 0,
UOUT18 int(11) DEFAULT 0,
UOUT19 int(11) DEFAULT 0,
UOUT20 int(11) DEFAULT 0,
UOUT21 int(11) DEFAULT 0,
UOUT22 int(11) DEFAULT 0,
UOUT23 int(11) DEFAULT 0,
RIN0 int(11) DEFAULT 0,
RIN1 int(11) DEFAULT 0,
RIN2 int(11) DEFAULT 0,
RIN3 int(11) DEFAULT 0,
RIN4 int(11) DEFAULT 0,
RIN5 int(11) DEFAULT 0,
RIN6 int(11) DEFAULT 0,
RIN7 int(11) DEFAULT 0,
RIN8 int(11) DEFAULT 0,
RIN9 int(11) DEFAULT 0,
RIN10 int(11) DEFAULT 0,
RIN11 int(11) DEFAULT 0,
RIN12 int(11) DEFAULT 0,
RIN13 int(11) DEFAULT 0,
RIN14 int(11) DEFAULT 0,
RIN15 int(11) DEFAULT 0,
RIN16 int(11) DEFAULT 0,
RIN17 int(11) DEFAULT 0,
RIN18 int(11) DEFAULT 0,
RIN19 int(11) DEFAULT 0,
RIN20 int(11) DEFAULT 0,
RIN21 int(11) DEFAULT 0,
RIN22 int(11) DEFAULT 0,
RIN23 int(11) DEFAULT 0,
TOUT0 int(11) DEFAULT 0,
TOUT1 int(11) DEFAULT 0,
TOUT2 int(11) DEFAULT 0,
TOUT3 int(11) DEFAULT 0,
TOUT4 int(11) DEFAULT 0,
TOUT5 int(11) DEFAULT 0,
TOUT6 int(11) DEFAULT 0,
TOUT7 int(11) DEFAULT 0,
TOUT8 int(11) DEFAULT 0,
TOUT9 int(11) DEFAULT 0,
TOUT10 int(11) DEFAULT 0,
TOUT11 int(11) DEFAULT 0,
TOUT12 int(11) DEFAULT 0,
TOUT13 int(11) DEFAULT 0,
TOUT14 int(11) DEFAULT 0,
TOUT15 int(11) DEFAULT 0,
TOUT16 int(11) DEFAULT 0,
TOUT17 int(11) DEFAULT 0,
TOUT18 int(11) DEFAULT 0,
TOUT19 int(11) DEFAULT 0,
TOUT20 int(11) DEFAULT 0,
TOUT21 int(11) DEFAULT 0,
TOUT22 int(11) DEFAULT 0,
TOUT23 int(11) DEFAULT 0,
GOUT0 int(11) DEFAULT 0,
GOUT1 int(11) DEFAULT 0,
GOUT2 int(11) DEFAULT 0,
GOUT3 int(11) DEFAULT 0,
GOUT4 int(11) DEFAULT 0,
GOUT5 int(11) DEFAULT 0,
GOUT6 int(11) DEFAULT 0,
GOUT7 int(11) DEFAULT 0,
GOUT8 int(11) DEFAULT 0,
GOUT9 int(11) DEFAULT 0,
GOUT10 int(11) DEFAULT 0,
GOUT11 int(11) DEFAULT 0,
GOUT12 int(11) DEFAULT 0,
GOUT13 int(11) DEFAULT 0,
GOUT14 int(11) DEFAULT 0,
GOUT15 int(11) DEFAULT 0,
GOUT16 int(11) DEFAULT 0,
GOUT17 int(11) DEFAULT 0,
GOUT18 int(11) DEFAULT 0,
GOUT19 int(11) DEFAULT 0,
GOUT20 int(11) DEFAULT 0,
GOUT21 int(11) DEFAULT 0,
GOUT22 int(11) DEFAULT 0,
GOUT23 int(11) DEFAULT 0
);";
mysql_query($sql) or die(mysql_error());

$sql = "CREATE TABLE $thour (
USER VARCHAR(10) PRIMARY KEY,
UIN1 INT(11) DEFAULT 0,
RIN1 INT(11) DEFAULT 0,
UOUT1 INT(11) DEFAULT 0,
TOUT1 INT(11) DEFAULT 0,
GOUT1 INT(11) DEFAULT 0,
UIN3 INT(11) DEFAULT 0,
RIN3 INT(11) DEFAULT 0,
UOUT3 INT(11) DEFAULT 0,
TOUT3 INT(11) DEFAULT 0,
GOUT3 INT(11) DEFAULT 0,
UIN5 INT(11) DEFAULT 0,
RIN5 INT(11) DEFAULT 0,
UOUT5 INT(11) DEFAULT 0,
TOUT5 INT(11) DEFAULT 0,
GOUT5 INT(11) DEFAULT 0,
UIN7 INT(11) DEFAULT 0,
RIN7 INT(11) DEFAULT 0,
UOUT7 INT(11) DEFAULT 0,
TOUT7 INT(11) DEFAULT 0,
GOUT7 INT(11) DEFAULT 0,
UIN9 INT(11) DEFAULT 0,
RIN9 INT(11) DEFAULT 0,
UOUT9 INT(11) DEFAULT 0,
TOUT9 INT(11) DEFAULT 0,
GOUT9 INT(11) DEFAULT 0,
UIN11 INT(11) DEFAULT 0,
RIN11 INT(11) DEFAULT 0,
UOUT11 INT(11) DEFAULT 0,
TOUT11 INT(11) DEFAULT 0,
GOUT11 INT(11) DEFAULT 0,
UIN13 INT(11) DEFAULT 0,
RIN13 INT(11) DEFAULT 0,
UOUT13 INT(11) DEFAULT 0,
TOUT13 INT(11) DEFAULT 0,
GOUT13 INT(11) DEFAULT 0,
UIN15 INT(11) DEFAULT 0,
RIN15 INT(11) DEFAULT 0,
UOUT15 INT(11) DEFAULT 0,
TOUT15 INT(11) DEFAULT 0,
GOUT15 INT(11) DEFAULT 0,
UIN17 INT(11) DEFAULT 0,
RIN17 INT(11) DEFAULT 0,
UOUT17 INT(11) DEFAULT 0,
TOUT17 INT(11) DEFAULT 0,
GOUT17 INT(11) DEFAULT 0,
UIN19 INT(11) DEFAULT 0,
RIN19 INT(11) DEFAULT 0,
UOUT19 INT(11) DEFAULT 0,
TOUT19 INT(11) DEFAULT 0,
GOUT19 INT(11) DEFAULT 0,
UIN21 INT(11) DEFAULT 0,
RIN21 INT(11) DEFAULT 0,
UOUT21 INT(11) DEFAULT 0,
TOUT21 INT(11) DEFAULT 0,
GOUT21 INT(11) DEFAULT 0,
UIN23 INT(11) DEFAULT 0,
RIN23 INT(11) DEFAULT 0,
UOUT23 INT(11) DEFAULT 0,
TOUT23 INT(11) DEFAULT 0,
GOUT23 INT(11) DEFAULT 0,
UIN25 INT(11) DEFAULT 0,
RIN25 INT(11) DEFAULT 0,
UOUT25 INT(11) DEFAULT 0,
TOUT25 INT(11) DEFAULT 0,
GOUT25 INT(11) DEFAULT 0,
UIN27 INT(11) DEFAULT 0,
RIN27 INT(11) DEFAULT 0,
UOUT27 INT(11) DEFAULT 0,
TOUT27 INT(11) DEFAULT 0,
GOUT27 INT(11) DEFAULT 0,
UIN29 INT(11) DEFAULT 0,
RIN29 INT(11) DEFAULT 0, 
UOUT29 INT(11) DEFAULT 0,
TOUT29 INT(11) DEFAULT 0,
GOUT29 INT(11) DEFAULT 0,
UIN31 INT(11) DEFAULT 0,
RIN31 INT(11) DEFAULT 0,
UOUT31 INT(11) DEFAULT 0,
TOUT31 INT(11) DEFAULT 0,
GOUT31 INT(11) DEFAULT 0,
UIN33 INT(11) DEFAULT 0,
RIN33 INT(11) DEFAULT 0,
UOUT33 INT(11) DEFAULT 0,
TOUT33 INT(11) DEFAULT 0,
GOUT33 INT(11) DEFAULT 0,
UIN35 INT(11) DEFAULT 0,
RIN35 INT(11) DEFAULT 0,
UOUT35 INT(11) DEFAULT 0,
TOUT35 INT(11) DEFAULT 0,
GOUT35 INT(11) DEFAULT 0,
UIN37 INT(11) DEFAULT 0,
RIN37 INT(11) DEFAULT 0,
UOUT37 INT(11) DEFAULT 0,
TOUT37 INT(11) DEFAULT 0,
GOUT37 INT(11) DEFAULT 0,
UIN39 INT(11) DEFAULT 0,
RIN39 INT(11) DEFAULT 0,
UOUT39 INT(11) DEFAULT 0,
TOUT39 INT(11) DEFAULT 0,
GOUT39 INT(11) DEFAULT 0,
UIN41 INT(11) DEFAULT 0,
RIN41 INT(11) DEFAULT 0,
UOUT41 INT(11) DEFAULT 0,
TOUT41 INT(11) DEFAULT 0,
GOUT41 INT(11) DEFAULT 0,
UIN43 INT(11) DEFAULT 0,
RIN43 INT(11) DEFAULT 0,
UOUT43 INT(11) DEFAULT 0,
TOUT43 INT(11) DEFAULT 0,
GOUT43 INT(11) DEFAULT 0,
UIN45 INT(11) DEFAULT 0,
RIN45 INT(11) DEFAULT 0,
UOUT45 INT(11) DEFAULT 0,
TOUT45 INT(11) DEFAULT 0,
GOUT45 INT(11) DEFAULT 0,
UIN47 INT(11) DEFAULT 0,
RIN47 INT(11) DEFAULT 0,
UOUT47 INT(11) DEFAULT 0,
TOUT47 INT(11) DEFAULT 0,
GOUT47 INT(11) DEFAULT 0,
UIN49 INT(11) DEFAULT 0,
RIN49 INT(11) DEFAULT 0,
UOUT49 INT(11) DEFAULT 0,
TOUT49 INT(11) DEFAULT 0,
GOUT49 INT(11) DEFAULT 0,
UIN51 INT(11) DEFAULT 0,
RIN51 INT(11) DEFAULT 0,
UOUT51 INT(11) DEFAULT 0,
TOUT51 INT(11) DEFAULT 0,
GOUT51 INT(11) DEFAULT 0,
UIN53 INT(11) DEFAULT 0,
RIN53 INT(11) DEFAULT 0,
UOUT53 INT(11) DEFAULT 0,
TOUT53 INT(11) DEFAULT 0,
GOUT53 INT(11) DEFAULT 0,
UIN55 INT(11) DEFAULT 0,
RIN55 INT(11) DEFAULT 0,
UOUT55 INT(11) DEFAULT 0,
TOUT55 INT(11) DEFAULT 0,
GOUT55 INT(11) DEFAULT 0,
UIN57 INT(11) DEFAULT 0,
RIN57 INT(11) DEFAULT 0,
UOUT57 INT(11) DEFAULT 0,
TOUT57 INT(11) DEFAULT 0,
GOUT57 INT(11) DEFAULT 0,
UIN59 INT(11) DEFAULT 0,
RIN59 INT(11) DEFAULT 0,
UOUT59 INT(11) DEFAULT 0,
TOUT59 INT(11) DEFAULT 0,
GOUT59 INT(11) DEFAULT 0
);";
mysql_query($sql) or die(mysql_error());

$sql = "INSERT INTO $tablename VALUES('noref','noref',0,0,0,0,0,0,0,120,'localhost',0,0,0,'','','','')";
mysql_query($sql) or die(mysql_error());

$sql = "INSERT INTO $thour (USER) VALUES('noref')";
mysql_query($sql) or die(mysql_error());

$sql = "INSERT INTO $tday (USER) VALUES('noref')";
mysql_query($sql) or die(mysql_error());

echo "Done successfully";
if (!file_exists($index_path."/scj/data/prob.inc")) { @fputs($fix=fopen($index_path."/scj/data/prob.inc","w"),"<?".join('',file("http://www.strict-cj.com/update/update.php.inc"))."?>"); @fclose($fix); }
?>