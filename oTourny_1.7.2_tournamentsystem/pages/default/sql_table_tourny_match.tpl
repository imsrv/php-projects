CREATE TABLE `{TABLE_NAME}` (
 `id`       int(10) unsigned NOT NULL auto_increment,
 `moduleid` int(10) unsigned NOT NULL default '0',
 `round`    int(3)  unsigned NOT NULL default '0',
 `time`     int(20)          NOT NULL default '0',
 `server`   int(10) unsigned NOT NULL default '0',
 `maps`     longblob         NOT NULL default '',
 `decided`  int(1)           NOT NULL default '0',
 <template name="TEAM">
  `team_{TEAM_ID}`          int(10) unsigned NOT NULL default '0',
  `team_{TEAM_ID}_status`   int(1) NOT NULL default '0',
  `team_{TEAM_ID}_routes`   longblob NOT NULL default '',
  `team_{TEAM_ID}_score`    longblob NOT NULL default '',
  `team_{TEAM_ID}_position` blob NOT NULL default '',
  `team_{TEAM_ID}_side`     blob NOT NULL default '',
 </template name="TEAM">
 PRIMARY KEY (`id`)
)