Before use please replace {TABLE NAME} with your table name.

CREATE TABLE {TABLE NAME}_tables (
  tablename char(30) NOT NULL
);

CREATE TABLE {TABLE NAME} (
  image varchar(150),
  caption text,
  bgcolor varchar(7),
  towho varchar(50),
  to_email varchar(50) NOT NULL,
  fromwho varchar(50),
  from_email varchar(50) NOT NULL,
  fontcolor varchar(7),
  fontface varchar(100),
  message text,
  music varchar(70),
  id varchar(14) NOT NULL,
  notify char(1) default 1,
  emailsent char(1) default 1,
  template varchar(30),
  des varchar(30),
  img_width char(3),
  img_height char(3),
  applet_name char(40),
  user1 varchar(50),
  user2 varchar(50),
  PRIMARY KEY (id)
);

INSERT INTO {TABLE NAME}_tables VALUES ('{TABLE NAME}');