-------------------------------------------------------------------------------------
=====================================================================================

                          PowerDownload 3.0.3 Readme

=====================================================================================
-------------------------------------------------------------------------------------
+ 1. Einf�hrung                                                                     +
| Beachten sie vor der installation folgendes:                                      |
| In den Ordnern pdl-gfx/smilies/ und pdl-gfx/screens/ muss der CHMOD 777 gesetzt   |
| werden, was bedeutet, dass das Script darauf zugreifen kann und Bilder hochladen  |
| kann.                                                                             |
| Desweiteren ist zu beachten, das die Ordner pdl-inc, pdl-gfx und pdl-admin in     |
+ einem Ordner sein m�ssen, damit das Script auch funktioniert.                     +
-------------------------------------------------------------------------------------
+ 2. Installation                                                                   +
| Bitte f�llen sie als erstes die MySQL Daten in der pdl-inc/pdl_config.inc.php aus |
| Falls sie PowerDownload zum ersten mal installieren, f�hren sie die               |
| install_300.php auf dem Server aus. Sollten sie eine fr�here Version von          |
| PowerDownload installiert haben, stehen ihnen folgende Update Dateien zur         |
| Verf�gung:                                                                        |
| update_224to300.php - Update von Version 2.2.4 auf 3.0.0                          |
| Wichtig ist, nach dem installieren bzw. Updaten die Settings und Templates        |
| anzupassen. In den Settings ist vor allem der Eintrag URL zum Script wichtig, da  |
+ sonnst die Seiten untereinander falsch verlinkt werden.                           +
-------------------------------------------------------------------------------------
+ 3. Einbindung                                                                     +
| Ganz wichtig bei der Einbindung ist, das der Header von PowerDownload ganz oben   |
| noch vor jeglichen Codes eingebunden wird. Ist dies nicht der Fall, kann man sich |
| �ber die DL �bersicht nicht einloggen und man kann keine Downloads runterladen.   |
| Der Header wird �ber folgenden Befehl eingebunden:                                |
| <? include("pdl-inc/pdl_header.inc.php"); ?>                                      |
| Die Download �bersicht selber wird auch �ber einen include Befehl eingebunden:    |
| <? include("pdl-inc/pdl_downloads.inc.php"); ?>                                   |
| PowerDownload hat viele weitere Module, die alle einzeln eingebunden werden k�nnen|
| <? include("pdl-inc/pdl_top.inc.php"); ?> - Bindet die Top X Downloads ein        |
| <? include("pdl-inc/pdl_flop.inc.php"); ?> - Bindet die Flop X Downloads ein      |
| <? include("pdl-inc/pdl_latest.inc.php"); ?> - Bindet die neuesten X Downloads ein|
| <? include("pdl-inc/pdl_rated.inc.php"); ?> - Bindet die bessten X Downloads ein  |
| Die Anzahl der angezeigten Download kann unter Settings eingestellt werden. Das   |
| aussehen der Tabelle kann �ber Templates ge�ndert werden.                         |
| <? include("pdl-inc/pdl_stats.inc.php"); ?> - Bindet eine kleine Download         |
+ Statistik ein. Diese kann �ber Templates an das Design angepasst werden.          +
-------------------------------------------------------------------------------------
+ 4. f�r Profis                                                                     +
| PowerDownload bietet f�r erfahrene User ein sehr Flexibles System an. So lassen   |
| auch sehr leicht Newssysteme oder anderes �ber PowerDownload realisieren.         |
| Im Admin Center haben sie die M�glichkeit neue Rechte, Settings und Templates zu  |
| erstellen und vorhandene zu verwalten.                                            |
| Zu beachten ist:                                                                  |
| Die Settings sind im System �ber die Variable $settings[settingname] wobei der    |
| Settingname im Admin Center nachgelesen werden kann.                              |
| Die Templates sind �ber $template[templatename] erreichbar.                       |
| Die Rechte sind �ber $user_rights[rechtename] erreichbar, wobei diese vom User    |
| abh�ngig sind. Die Details des Users sind �ber $user_details[...] erreichbar. Ist |
| die Variable $user_details nicht gesetzt, so ist der User nicht eingelogt.        |
| Das Men� des Admin Centers ist auch sehr leicht mit Funktionen aufgebaut, die auch|
| die Userrechte checken. Dazu empfehle ich einfach mal den header vom Admin Center |
| zu studieren. Wie man einzelne Admin Dateien sch�tzen kann, ist auch sehr leicht  |
| aus denen herauszulesen.                                                          |
| Als weiteres bietet PowerDownload eine sehr gute MySQL Klasse. Diese ist �ber     |
| $db_handler verf�gbar. Folgende Funktionen stehen zur Verf�gung:                  |
| $db_handler->sql_query("query"); - das selbe wie mysql_query                      |
| $db_handler->sql_fetch_array($result); - das selbe wie mysql_fetch_array          |
| $db_handler->sql_num_rows($result); - das selbe wie mysql_num_rows                |
| $db_handler->sql_num_fields($result); - das selbe wie mysql_num_fields            |
| $db_handler->sql_escape_string("string"); - das selbe wie mysql_escape_string     |
| $db_handler->sql_insert_id(); - liefert die ID des erstellten Eintrages           |
| �ber $db_handler->querys kann man zu Debugzwecken die Anzahl ausgef�hrter MySQL   |
+ Anfragen anzeigen lassen.                                                         +
-------------------------------------------------------------------------------------
=====================================================================================