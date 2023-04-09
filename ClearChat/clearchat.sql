CREATE TABLE nuke_clearchat
(
id int NOT NULL AUTO_INCREMENT,
username varchar(30),
comment text,
useraddress varchar(20),
date varchar(30),
PRIMARY KEY (id),
UNIQUE id (id)
);

CREATE TABLE nuke_ccerror
(
id int NOT NULL AUTO_INCREMENT,
username varchar(30),
userpw varchar(30),
realuserpw varchar(30),
useraddress varchar(20),
userinfo varchar(100),
date varchar(30),
errornumber varchar(20),
comment text,
PRIMARY KEY (id),
UNIQUE id (id)
);

UPDATE nuke_blocks SET content = CONCAT(content, '<br><strong><big>·</big></strong> <a href="modules.php?name=ClearChat">ClearChat</a>') WHERE bkey = 'admin';