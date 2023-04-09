#
# Структура таблицы `admininfo`
#

CREATE TABLE admininfo (
  id int(10) NOT NULL auto_increment,
  name varchar(30) NOT NULL default '',
  email varchar(30) NOT NULL default '',
  password varchar(30) NOT NULL default '',
  defurl varchar(50) NOT NULL default '',
  adminpath varchar(100) NOT NULL default '',
  topaffp varchar(50) NOT NULL default '',
  botaffp varchar(50) NOT NULL default '',
  affdir varchar(50) NOT NULL default '',
  setaffpt varchar(50) NOT NULL default '',
  payfreq varchar(20) NOT NULL default '',
  calctype varchar(30) NOT NULL default '',
  minbal int(30) NOT NULL default '0',
  cookex int(30) NOT NULL default '0',
  leveld int(30) NOT NULL default '0',
  cooloff int(30) NOT NULL default '0',
  linklifehours int(10) NOT NULL default '0',
  paypaladdr varchar(100) NOT NULL default '',
  path varchar(100) NOT NULL default '',
  terms text NOT NULL,
  contactus text NOT NULL,
  faq text NOT NULL,
  testmode tinyint(1) NOT NULL default '0',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `admininfo`
#

INSERT INTO admininfo VALUES (1, 'test', 'test', '7654321', 'www.null.ru', 'admin/', '', '', '', '', '', '', 40, 10, 7, 0, 10, 'gtt@null.ru', '/home/null/public_html/mlm/', '<table width="760" border="0" cellspacing="0" cellpadding="0">\r\n  <tr> \r\n    <td width="416" rowspan="2"> <div align="center"><br>\r\n        <font size="4" face="Arial Narrow"><strong>JOIN THE BEST<br>\r\n        AFFILIATE PROGRAM ON THE NET</strong></font><br>\r\n      </div></td>\r\n    <td width="344"> <div align="center"><strong><font face="Arial Narrow">~ YOUR \r\n        TERMS & CONDITIONS~</font></strong></div></td>\r\n  </tr>\r\n  <tr> \r\n    <td><div align="center"><font face="Arial Narrow">INTRODUCTION TO OUR AFFILIATE \r\n        / REFERRAL PROGRAM</font></div></td>\r\n  </tr>\r\n</table>', '', '<table width="760" border="0" cellspacing="0" cellpadding="0">\r\n  <tr> \r\n    <td width="416" rowspan="2"> <div align="center"><img src="images/money.jpg" width="225" height="150"><br>\r\n        <font size="4" face="Arial Narrow"><strong>JOIN THE BEST<br>\r\n        INVESTMENT PROGRAM IN THE NET</strong></font><br>\r\n      </div></td>\r\n    <td width="344"> <div align="center"><strong><font face="Arial Narrow">~ YOUR \r\n        FAQs ~</font></strong></div></td>\r\n  </tr>\r\n  <tr> \r\n    <td><div align="center"><font face="Arial Narrow">INTRODUCTION TO OUR AFFILIATE \r\n        / REFERRAL PROGRAM</font></div></td>\r\n  </tr>\r\n</table>\r\n', 0);
# --------------------------------------------------------

#
# Структура таблицы `aff_payments`
#

CREATE TABLE aff_payments (
  id int(50) NOT NULL auto_increment,
  name varchar(30) NOT NULL default '',
  description text NOT NULL,
  price float NOT NULL default '0',
  paypalurl varchar(60) NOT NULL default '',
  directaf float NOT NULL default '0',
  af1 float NOT NULL default '0',
  af2 float NOT NULL default '0',
  af3 float NOT NULL default '0',
  af4 float NOT NULL default '0',
  af5 float NOT NULL default '0',
  af6 float NOT NULL default '0',
  af7 float NOT NULL default '0',
  complurl varchar(30) NOT NULL default '',
  recurring varchar(30) NOT NULL default '',
  sid varchar(30) NOT NULL default '',
  programid int(10) NOT NULL default '0',
  subscrid int(10) NOT NULL default '0',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `aff_payments`
#

INSERT INTO aff_payments VALUES (1, 'Resume Writing', 'resume writing service', '100', '', '7', '7', '6', '5', '4', '3', '2', '1', '', '', '', 0, 0);
INSERT INTO aff_payments VALUES (2, 'new item', 'cool', '0.01', '', '12', '2', '2', '2', '2', '2', '2', '2', '', '', '', 0, 0);
INSERT INTO aff_payments VALUES (4, '', '', '0', '', '12', '1', '1', '1', '1', '1', '1', '1', '', '', '', 0, 1);
INSERT INTO aff_payments VALUES (5, '', '', '0', '', '12', '1', '1', '1', '1', '1', '1', '1', '', '', '', 1, 0);
INSERT INTO aff_payments VALUES (6, '', '', '0', '', '12', '1', '1', '1', '1', '1', '1', '1', '', '', '', 1, 0);
INSERT INTO aff_payments VALUES (9, 'new item', 'cool', '99', '', '12', '2', '2', '2', '2', '23', '2', '2', '', '', '', 0, 0);
INSERT INTO aff_payments VALUES (10, '', '', '0', '', '0.5', '0.5', '0.5', '0.5', '0.5', '0.5', '0.5', '0.5', '', '', '', 8, 0);
INSERT INTO aff_payments VALUES (11, 'new itemmmm', 'fsdfsd', '5', '', '1', '1', '1', '1', '1', '1', '1', '1', '', '', '', 0, 0);
INSERT INTO aff_payments VALUES (12, 'NEW TEST', 'NEW TEST', '10', '', '9.99', '4.99', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '', '', '', 0, 0);
INSERT INTO aff_payments VALUES (13, '', '', '0', '', '10', '5', '1', '1', '1', '1', '1', '1', '', '', '', 9, 0);
# --------------------------------------------------------

#
# Структура таблицы `banner_index`
#

CREATE TABLE banner_index (
  id int(40) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  link_url varchar(255) NOT NULL default '',
  banner_url varchar(255) NOT NULL default '',
  PRIMARY KEY (id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Структура таблицы `banners`
#

CREATE TABLE banners (
  id tinyint(40) NOT NULL auto_increment,
  imgsrc varchar(200) NOT NULL default '',
  text text NOT NULL,
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `banners`
#

INSERT INTO banners VALUES (27, 'http://www.null.ru/bla/bla.jpg', '');
INSERT INTO banners VALUES (19, '', 'Click here to find out more about our services.');
# --------------------------------------------------------

#
# Структура таблицы `grpsnclicks`
#

CREATE TABLE grpsnclicks (
  id int(100) NOT NULL auto_increment,
  name char(30) NOT NULL default '',
  affid int(60) NOT NULL default '0',
  clicks bigint(80) NOT NULL default '0',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `grpsnclicks`
#

INSERT INTO grpsnclicks VALUES (1, 'test', 3, 0);
INSERT INTO grpsnclicks VALUES (2, 'test2', 3, 0);
INSERT INTO grpsnclicks VALUES (3, 'test', 4, 1);
INSERT INTO grpsnclicks VALUES (4, 'ry7uutjy', 2, 0);
INSERT INTO grpsnclicks VALUES (9, 'The link on my main page', 7, 0);
# --------------------------------------------------------

#
# Структура таблицы `letters`
#

CREATE TABLE letters (
  fromperson varchar(50) NOT NULL default '',
  fromemail varchar(50) NOT NULL default '',
  subject varchar(80) NOT NULL default '',
  message text NOT NULL,
  action varchar(20) NOT NULL default ''
) TYPE=MyISAM;

#
# Дамп данных таблицы `letters`
#

INSERT INTO letters VALUES ('Affiliate Admin', 'mail@yourdomain.com', 'Welcome to our Affiliate Program', 'Dear [fullname],\r\n\r\nYour affiliate account has been created.\r\n\r\nYou can use the following data to log in:\r\n\r\nAffiliate ID:   [maxid]\r\nPassword:       [password]\r\n\r\nThank you for joining our affiliate program.', 'welcome');
INSERT INTO letters VALUES ('Password Retrieval', 'mail@yourdomain.com', 'Your password as requested', 'Dear [fname],\r\n\r\nAs requested, here are your login details:\r\n\r\nWebsite:  http://mlm.null.ru\r\nUserID:   [affid]\r\nPassword: [password]\r\n\r\nThank you!', 'lostpass');
INSERT INTO letters VALUES ('Affiliate Admin', 'mail@yourdomain.com', 'Thank you for your referral', 'Dear [fullname],\r\n\r\nCongratulations, you have just referred an affiliate.\r\n\r\nThank you for your continued support!', 'signbelow');
INSERT INTO letters VALUES ('Affiliate Admin', 'mail@yourdomain.com', 'Congrats on your sale!', 'Dear [fullname],\r\n\r\nCongratulations! Either you or one of your referrals has generated a sale.\r\n\r\nYour account will be credited after [coolingoff] days.\r\n\r\nThank you for your continued support!', 'sale');
INSERT INTO letters VALUES ('', '', '[affiliatename] would like you to have a look at this site', 'Dear [friendname],\r\n\r\nHave a look at this site. I found it extremely interesting:\r\n[affiliateurl]\r\n\r\nLet me know what you think.\r\n\r\nFrom\r\n[affiliatename]', 'friends');
# --------------------------------------------------------

#
# Структура таблицы `orders`
#

CREATE TABLE orders (
  txn_id char(100) NOT NULL default '',
  date char(60) NOT NULL default '',
  goodid int(50) NOT NULL default '0',
  affid int(60) NOT NULL default '0',
  ptsmade int(100) NOT NULL default '0',
  customername char(100) NOT NULL default '',
  paid tinyint(2) NOT NULL default '0',
  cancelrecurl tinyint(2) NOT NULL default '0',
  subscrdate char(60) NOT NULL default '',
  subscrid char(60) NOT NULL default '',
  payerid char(80) NOT NULL default ''
) TYPE=MyISAM;

#
# Дамп данных таблицы `orders`
#

INSERT INTO orders VALUES ('5PU81074JR5852740', '1053009287', 4, 0, 1, 'Cecelia Lee', 1, 0, '07:33:24 May 15, 2003 PDT', 'S-3GX272144A4842940', '');
INSERT INTO orders VALUES ('', '1053009350', 4, 0, 0, 'Cecelia Lee', 1, 0, '07:34:26 May 15, 2003 PDT', 'S-8RL39410L4425823W', '');
INSERT INTO orders VALUES ('3VT11232MD971841W', '1053013294', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-9WC847619H151770E', '');
INSERT INTO orders VALUES ('8K788633EL857921T', '1053013429', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-53E578972L2058800', '');
INSERT INTO orders VALUES ('03Y63526LG240370U', '1053013893', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-2UM48161603868212', '');
INSERT INTO orders VALUES ('2FV48016HT227270H', '1053014204', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-83D11685XC714751D', '');
INSERT INTO orders VALUES ('6XM84496UN8076447', '1053017062', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-4EU88482V16558841', '');
INSERT INTO orders VALUES ('46R25975V2852493B', '1053017395', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-6E9801748P2090702', '');
INSERT INTO orders VALUES ('23U94113A18533421', '1053018044', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-894208259T9890611', '');
INSERT INTO orders VALUES ('9J939140K85696536', '1053018319', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-0FW34030781789726', '');
INSERT INTO orders VALUES ('6RE1828225523191N', '1053018453', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-4M37971040587351A', '');
INSERT INTO orders VALUES ('4A650681W52367125', '1053019750', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-5FF67084JN072842R', '');
INSERT INTO orders VALUES ('6VB96278L5318403S', '1053019888', 4, 0, 0, 'Cecelia Lee', 1, 0, '', 'S-2CC01003LB489292E', '');
INSERT INTO orders VALUES ('', '1055441129', 4, 0, 0, 'Mun Fei Ho', 1, 0, '10:46:25 Jun 12, 2003 PDT', 'S-7GY41371GL5067644', '');
INSERT INTO orders VALUES ('', '1055442003', 4, 0, 0, 'Mun Fei Ho', 1, 0, '11:15:16 Jun 12, 2003 PDT', 'S-4K578805FC3775834', '');
INSERT INTO orders VALUES ('5YN262525G026504M', '1055446460', 4, 0, 0, 'Mun Fei Ho', 1, 0, '', 'S-2WD91829ND493730U', '');
INSERT INTO orders VALUES ('', '1055446460', 4, 0, 0, 'Mun Fei Ho', 1, 0, '12:33:34 Jun 12, 2003 PDT', 'S-2WD91829ND493730U', '');
INSERT INTO orders VALUES ('', '1055446707', 4, 0, 0, 'Mun Fei Ho', 1, 0, '12:37:42 Jun 12, 2003 PDT', 'S-00F44346L5991120G', '');
INSERT INTO orders VALUES ('6T1200408V726502G', '1055446712', 4, 0, 0, 'Mun Fei Ho', 1, 0, '', 'S-00F44346L5991120G', '');
INSERT INTO orders VALUES ('6WF79515SU628240S', '1055446914', 4, 0, 1, 'Mun Fei Ho', 1, 0, '12:41:03 Jun 12, 2003 PDT', 'S-1S071670HA3836038', '');
INSERT INTO orders VALUES ('9GF090950M124573J', '1055661926', 4, 0, 1, 'Mun Fei Ho', 1, 0, '00:23:30 Jun 15, 2003 PDT', 'S-6S817998FG1920610', '');
INSERT INTO orders VALUES ('2TH27403RJ841792V', '1055662255', 4, 8, 1, 'Mun Fei Ho', 1, 0, '00:28:58 Jun 15, 2003 PDT', 'S-5B990845EK451721N', '');
INSERT INTO orders VALUES ('68V72124PK816890V', '1055662682', 4, 9, 0, 'Mun Fei Ho', 1, 0, '00:36:05 Jun 15, 2003 PDT', 'S-6BM88453912488704', '');
# --------------------------------------------------------

#
# Структура таблицы `programs`
#

CREATE TABLE programs (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  description text,
  price decimal(12,2) default NULL,
  filename varchar(255) default NULL,
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `programs`
#

INSERT INTO programs VALUES (7, '1', '2', '10.00', 'nick.bmp');
INSERT INTO programs VALUES (6, 'tre', 'te', '54.00', 'inf.zip');
INSERT INTO programs VALUES (8, 'test', 'terwter', '0.01', 'elitetgp.zip');
INSERT INTO programs VALUES (9, 'Testing Thread', 'This is a test', '0.01', 'bb01.jpg');
# --------------------------------------------------------

#
# Структура таблицы `singleitems`
#

CREATE TABLE singleitems (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  description text,
  price decimal(12,2) default NULL,
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `singleitems`
#

# --------------------------------------------------------

#
# Структура таблицы `startpages`
#

CREATE TABLE startpages (
  id tinyint(40) NOT NULL auto_increment,
  url char(80) NOT NULL default '',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `startpages`
#

INSERT INTO startpages VALUES (1, 'http://www.null.ru/null');
INSERT INTO startpages VALUES (2, 'http://www.bla.ru');
INSERT INTO startpages VALUES (3, 'http://www.bla.ru');
# --------------------------------------------------------

#
# Структура таблицы `subscribtions`
#

CREATE TABLE subscribtions (
  id int(100) unsigned NOT NULL auto_increment,
  name varchar(100) NOT NULL default '',
  description text NOT NULL,
  signupfee float NOT NULL default '0',
  duration int(10) unsigned NOT NULL default '0',
  reoccuringfee float NOT NULL default '0',
  successurl varchar(200) NOT NULL default '',
  cancelurl varchar(200) NOT NULL default '',
  button_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `subscribtions`
#

INSERT INTO subscribtions VALUES (1, 'rwerewrere', 'tewrtrwe', '0.01', 32, '0.01', '', '', 2);
INSERT INTO subscribtions VALUES (2, 'tre', 'trewtrwe', '543', 54, '543', '', '', 0);
INSERT INTO subscribtions VALUES (3, 'gfd', 'gfds', '54', 4, '5', '', '', 0);
# --------------------------------------------------------

#
# Структура таблицы `temp_link`
#

CREATE TABLE temp_link (
  id int(10) unsigned NOT NULL auto_increment,
  date varchar(60) default NULL,
  link varchar(255) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  progid int(10) NOT NULL default '0',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `temp_link`
#

# --------------------------------------------------------

#
# Структура таблицы `users`
#

CREATE TABLE users (
  id int(60) NOT NULL auto_increment,
  password varchar(50) NOT NULL default '',
  email varchar(30) NOT NULL default '',
  frstname varchar(30) NOT NULL default '',
  lstname varchar(30) NOT NULL default '',
  compname varchar(60) NOT NULL default '',
  country varchar(30) NOT NULL default '',
  city varchar(30) NOT NULL default '',
  state varchar(30) NOT NULL default '',
  zip varchar(60) NOT NULL default '0',
  address varchar(50) NOT NULL default '',
  socsec varchar(30) NOT NULL default '',
  phone varchar(80) NOT NULL default '',
  website varchar(60) NOT NULL default '',
  referer int(60) NOT NULL default '0',
  saleam float NOT NULL default '0',
  saleqt int(60) NOT NULL default '0',
  banclicks bigint(100) unsigned NOT NULL default '0',
  textclicks bigint(100) unsigned NOT NULL default '0',
  lastresettime varchar(60) NOT NULL default '',
  totalpaidamt float NOT NULL default '0',
  lastpaidamt float NOT NULL default '0',
  lastpaidtime varchar(60) NOT NULL default '',
  lev1saleam float NOT NULL default '0',
  lev2saleam float NOT NULL default '0',
  lev3saleam float NOT NULL default '0',
  lev4saleam float NOT NULL default '0',
  lev5saleam float NOT NULL default '0',
  lev6saleam float NOT NULL default '0',
  lev7saleam float NOT NULL default '0',
  lev1saleqt int(60) NOT NULL default '0',
  lev2saleqt int(60) NOT NULL default '0',
  lev3saleqt int(60) NOT NULL default '0',
  lev4saleqt int(60) NOT NULL default '0',
  lev5saleqt int(60) NOT NULL default '0',
  lev6saleqt int(60) NOT NULL default '0',
  lev7saleqt int(60) NOT NULL default '0',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Дамп данных таблицы `users`
#

INSERT INTO users VALUES (1, '123456', 'test@hotmail.com', 'John', 'Doe', 'John Inc', 'United States', 'LA', 'CA', '12312', '32 Dobly Road', '', '123-131-1312', 'http://', 3, '0', 0, 0, 0, '', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (2, '12345', 'test@hotmail.com', '123', '123', '123', 'United States', 'LA', 'CA', '12312', '123', '', '123-131-1312', '', 0, '0', 0, 0, 0, '', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (3, 'logmein', 'drares@ms.fx.ro', 'Durigu', 'Rares', '', 'rares', 'Alaska', 'asda', '24345', 'asdas', 'sdas', '', 'dasdas.com', 1, '0', 0, 0, 0, '', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (4, 'logmein', 'drares@smartdownloads.net', 'Rread', 'asdsa', 'safd', 'asdasda', 'dsad', 'asd', '24', 'dasd', '', '', '', 0, '0', 0, 0, 0, '', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (5, '12345', 'alexey@nycap.rr.com', 'aa', 'vvv', '', 'dsfg', 'dsfsd', 'sddfsd', '12345', 'dffsd', '', '', 'nothibng.com', 0, '0', 0, 0, 0, '', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (6, '12345', 'johnganty@hotmail.com', 'John', 'Ganty', 'John Inc', 'United States', 'LA', 'CA', '12312', '32 Dobly Road', '', '123-131-1312', 'http://', 0, '0', 0, 0, 0, '', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (7, 'test', 'support@hyperblast.net', 'John', 'Smith', 'Smith company', 'USA', 'Smith City', 'SC', '11234', 'Smith Street', '123', '123', '', 0, '0', 0, 0, 2, '1054410827', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (8, '1111', 'eu@voliacable.com', 'yiu', 'yiu', '', 'erterw', 'hkj', '', '4343', 'hkj', '', '', '', 0, '0', 1, 1, 0, '', '0', '0', '', '1', '0', '0', '0', '0', '0', '0', 2, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (9, '1111', 'babin46@mail.ru', 'yui', 'uiuiui', '', 'gds', 'yuiui', '', '767', 'yuiyiu', '', '', '', 8, '12', 2, 1, 0, '', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (10, 'nulook', 'phlgrn@inetgalaxy.com', 'Phil', 'Grinevitch', 'Inet Systems', 'usa', 'Tempe', 'AZ', '85285', 'Box 25710', '', '', '', 0, '0', 0, 0, 0, '', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0);

