<?php

	// The SendStudio MySQL table schema used during installation

	$tableSchema = array();

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%admins (
	  AdminID int(11) NOT NULL auto_increment,
	  AdminName text NOT NULL,
	  Username text NOT NULL,
	  Password text NOT NULL,
	  Email text NOT NULL,
	  Manager tinyint(4) NOT NULL default '0',
	  Root tinyint(4) NOT NULL default '0',
	  LoginString text NOT NULL,
	  LoginTime int(11) NOT NULL default '0',
	  Status tinyint(4) NOT NULL default '0',
	  MaxLists int(11) not null DEFAULT '0',
	  KillQuickStart tinyint(4) NOT NULL default '0',
	  PRIMARY KEY  (AdminID),
	  UNIQUE KEY AdminID (AdminID)
	) TYPE=MyISAM";

	$tableSchema[] = "DELETE FROM %%TABLEPREFIX%%admins";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%allow_functions (
	  AdminID int(11) NOT NULL default '0',
	  SectionID int(11) NOT NULL default '0'
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%allow_lists (
	  AdminID int(11) NOT NULL default '0',
	  ListID int(11) NOT NULL default '0'
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%autoresponders (
	  AutoresponderID int(11) NOT NULL auto_increment,
	  ListID int(11) NOT NULL default '0',
	  HoursAfterSubscription int(11) NOT NULL default '0',
	  Format tinyint(4) NOT NULL default '0',
	  Subject text NOT NULL,
	  SendFrom text NOT NULL,
	  HTMLBody longtext NOT NULL,
	  TextBody longtext NOT NULL,
	  DateCreated int(11) NOT NULL default '0',
	  PRIMARY KEY  (AutoresponderID),
	  UNIQUE KEY AutoresponderID (AutoresponderID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%banned_emails (
	  ListID int(11) NOT NULL default '0',
	  Global tinyint(4) NOT NULL default '0',
	  Email text NOT NULL,
	  Status tinyint(4) NOT NULL default '0',
	  DateAdded int(11) NOT NULL default '0'
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%composed_emails (
	  ComposedID int(11) NOT NULL auto_increment,
	  Format smallint(6) NOT NULL default '0',
	  EmailName text NOT NULL,
	  DateCreated int(11) NOT NULL default '0',
	  Subject text NOT NULL,
	  TextBody longtext NOT NULL,
	  HTMLBody longtext NOT NULL,
	  AdminID int(11) NOT NULL default '0',
	  PRIMARY KEY  (ComposedID),
	  UNIQUE KEY ComposedID (ComposedID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%email_opens (
	  SendID int(11) NOT NULL default '0',
	  MemberID int(11) NOT NULL default '0',
	  TimeStamp int(11) NOT NULL default '0'
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%export_users (
	  ExportID int(11) NOT NULL default '0',
	  MemberID int(11) NOT NULL default '0'
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%exports (
	  ExportID int(11) NOT NULL auto_increment,
	  ListID int(11) NOT NULL default '0',
	  DateStarted int(11) NOT NULL default '0',
	  PRIMARY KEY  (ExportID),
	  UNIQUE KEY ExportID (ExportID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%form_fields (
	  FormID int(11) NOT NULL default '0',
	  FieldID int(11) NOT NULL default '0',
	  Include tinyint(4) NOT NULL default '0',
	  SetValue tinyint(4) NOT NULL default '0',
	  TheValue text NOT NULL,
	  Combine tinyint(4) NOT NULL default '0',
	  CombineWith int(11) NOT NULL default '0',
	  TypeOption tinytext NOT NULL
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%form_lists (
	  ListID int(11) NOT NULL default '0',
	  FormID int(11) NOT NULL default '0'
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%form_responses (
	  FormID int(11) NOT NULL default '0',
	  ResponseName text NOT NULL,
	  ResponseData text NOT NULL
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%forms (
	  FormID int(11) NOT NULL auto_increment,
	  FormName text NOT NULL,
	  FormType tinytext NOT NULL,
	  Status tinyint(4) NOT NULL default '0',
	  DateCreated int(11) NOT NULL default '0',
	  RequireConfirm tinyint(4) NOT NULL default '0',
	  SendThankyou tinyint(4) NOT NULL default '0',
	  FormCode text NOT NULL,
	  SelectLists tinyint(4) NOT NULL default '0',
	  ContentTypeID int(11) NOT NULL default '0',
	  EmailField int(11) NOT NULL default '0',
	  AdminID int(11) NOT NULL default '0',
	  ArchiveLink tinyint(4) NOT NULL default '0',
	  TemplateID int(11) NOT NULL default '0',
	  PRIMARY KEY  (FormID),
	  UNIQUE KEY FormID (FormID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%images (
	  ImageID int(11) NOT NULL auto_increment,
	  ImageName text NOT NULL,
	  ImageType tinytext NOT NULL,
	  DateUploaded int(11) NOT NULL default '0',
	  AdminID int(11) NOT NULL default '0',
	  PRIMARY KEY  (ImageID),
	  UNIQUE KEY ImageID (ImageID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%imports (
	  ImportID int(11) NOT NULL auto_increment,
	  ListID int(11) NOT NULL default '0',
	  TimeStamp int(11) NOT NULL default '0',
	  Completed tinyint(4) NOT NULL default '0',
	  Headers tinyint(4) NOT NULL default '0',
	  RecordDelim tinytext NOT NULL,
	  FieldDelim tinytext NOT NULL,
	  FieldLinks text NOT NULL,
	  PRIMARY KEY  (ImportID),
	  UNIQUE KEY ImportID (ImportID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%link_clicks (
	  LinkID int(11) NOT NULL default '0',
	  TimeStamp int(11) NOT NULL default '0',
	  MemberID int(11) NOT NULL default '0',
	  IPAddress text NOT NULL
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%links (
	  LinkID int(11) NOT NULL auto_increment,
	  URL text NOT NULL,
	  LinkName text NOT NULL,
	  DateEntered int(11) NOT NULL default '0',
	  Status tinyint(4) NOT NULL default '0',
	  AdminID int(11) NOT NULL default '0',
	  PRIMARY KEY  (LinkID),
	  UNIQUE KEY LinkID (LinkID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%list_field_values (
	  FieldID int(11) NOT NULL default '0',
	  ListID int(11) NOT NULL default '0',
	  UserID int(11) NOT NULL default '0',
	  Value text NOT NULL
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%list_fields (
	  FieldID int(11) NOT NULL auto_increment,
	  FieldName text NOT NULL,
	  FieldType tinytext NOT NULL,
	  DefaultValue text NOT NULL,
	  AllValues text NOT NULL,
	  Required tinyint(4) NOT NULL default '0',
	  AdminID int(11) NOT NULL default '0',
	  PRIMARY KEY  (FieldID),
	  UNIQUE KEY FieldID (FieldID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%lists (
	  ListID int(11) NOT NULL auto_increment,
	  ListName text NOT NULL,
	  CreatedOn int(11) NOT NULL default '0',
	  Status tinyint(4) NOT NULL default '0',
	  CanSubscribe tinyint(4) NOT NULL default '0',
	  CanUnSubscribe tinyint(4) NOT NULL default '0',
	  Formats tinyint(4) NOT NULL default '0',
	  WebmasterName varchar(250) NOT NULL default '',
	  WebmasterEmail varchar(250) NOT NULL default '',
	  PRIMARY KEY  (ListID),
	  UNIQUE KEY ListID (ListID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%members (
	  MemberID int(11) NOT NULL auto_increment,
	  ListID int(11) NOT NULL default '0',
	  Email text NOT NULL,
	  SubscribeDate int(11) NOT NULL default '0',
	  Format tinyint(4) NOT NULL default '0',
	  Status tinyint(4) NOT NULL default '0',
	  Confirmed tinyint(4) NOT NULL default '0',
	  AdminNotes text NOT NULL,
	  ImportID int(11) NOT NULL default '0',
	  LastConfirmationDate int(11) NOT NULL default '0',
	  ConfirmCode text NOT NULL,
	  FormID int(11) NOT NULL default '0',
	  LastResponderID int(11) NOT NULL default '0',
	  PRIMARY KEY  (MemberID),
	  UNIQUE KEY MemberID (MemberID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%send_recipients (
	  SendID int(11) NOT NULL default '0',
	  MemberID int(11) NOT NULL default '0',
	  Problems tinyint(4) NOT NULL default '0',
	  Format tinyint(4) NOT NULL default '0'
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%sends (
	  SendID int(11) NOT NULL auto_increment,
	  ListID int(11) NOT NULL default '0',
	  DateStarted int(11) NOT NULL default '0',
	  DateEnded int(11) NOT NULL default '0',
	  ComposedID int(11) NOT NULL default '0',
	  Completed tinyint(4) NOT NULL default '0',
	  SendFrom text NOT NULL,
	  ReplyTo text NOT NULL,
	  ReturnPath text NOT NULL,
	  EmailsSent int(11) NOT NULL default '0',
	  HTMLRecipients int(11) NOT NULL default '0',
	  TextRecipients int(11) NOT NULL default '0',
	  TotalRecipients bigint(20) NOT NULL default '0',
	  PRIMARY KEY  (SendID),
	  UNIQUE KEY SendID (SendID)
	) TYPE=MyISAM";

	$tableSchema[] = "CREATE TABLE IF NOT EXISTS %%TABLEPREFIX%%templates (
	  TemplateID int(11) NOT NULL auto_increment,
	  TemplateName text NOT NULL,
	  Format tinyint(4) NOT NULL default '0',
	  DateCreated int(11) NOT NULL default '0',
	  TextContent longtext NOT NULL,
	  HTMLContent longtext NOT NULL,
	  AdminID int(11) NOT NULL default '0',
	  PRIMARY KEY  (TemplateID),
	  UNIQUE KEY TemplateID (TemplateID)
	) TYPE=MyISAM";

?>