#Php Jobsite 1.12
ALTER TABLE `cctransactions` RENAME `phpjob_cctransactions`;
ALTER TABLE `companies` RENAME `phpjob_companies`;
ALTER TABLE `companycredits` RENAME `phpjob_companycredits`;
ALTER TABLE `delcompanies` RENAME `delphpjob_companies`;
ALTER TABLE `delinvoices` RENAME `delphpjob_invoices`;
ALTER TABLE `deljobs` RENAME `delphpjob_jobs`;
ALTER TABLE `delmembership` RENAME `delphpjob_membership`;
ALTER TABLE `delpersons` RENAME `delphpjob_persons`;
ALTER TABLE `delresumes` RENAME `delphpjob_resumes`;
ALTER TABLE `invoices` RENAME `phpjob_invoices`;
ALTER TABLE `jobcategories_en` RENAME `phpjob_jobcategories_en`;
ALTER TABLE `jobmail` RENAME `phpjob_jobmail`;
ALTER TABLE `jobs` RENAME `phpjob_jobs`;
ALTER TABLE `jobtypes_en` RENAME `phpjob_jobtypes_en`;
ALTER TABLE `jobview` RENAME `phpjob_jobview`;
ALTER TABLE `locations` RENAME `phpjob_locations_en`;
ALTER TABLE `membership` RENAME `phpjob_membership`;
ALTER TABLE `persons` RENAME `phpjob_persons`;
ALTER TABLE `pricing` RENAME `phpjob_pricing`;
ALTER TABLE `resumemail` RENAME `phpjob_resumemail`;
ALTER TABLE `resumes` RENAME `phpjob_resumes`;
ALTER TABLE `sendmail` RENAME `phpjob_sendmail`;

ALTER TABLE `phpjob_companies` ADD `hide_address` CHAR( 3 ) NOT NULL AFTER `url` ,
ADD `hide_location` CHAR( 3 ) NOT NULL AFTER `hide_address` ,
ADD `hide_phone` CHAR( 3 ) NOT NULL AFTER `hide_location` ,
ADD `hide_fax` CHAR( 3 ) NOT NULL AFTER `hide_phone` ,
ADD `hide_email` CHAR( 3 ) NOT NULL AFTER `hide_fax` ;

ALTER TABLE `delphpjob_companies` ADD `hide_address` CHAR( 3 ) NOT NULL AFTER `url` ,
ADD `hide_location` CHAR( 3 ) NOT NULL AFTER `hide_address` ,
ADD `hide_phone` CHAR( 3 ) NOT NULL AFTER `hide_location` ,
ADD `hide_fax` CHAR( 3 ) NOT NULL AFTER `hide_phone` ,
ADD `hide_email` CHAR( 3 ) NOT NULL AFTER `hide_fax` ;

ALTER TABLE `delphpjob_jobs` ADD `contact_name` VARCHAR( 100 ) NOT NULL AFTER `experience` ,
ADD `hide_contactname` CHAR( 3 ) NOT NULL AFTER `contact_name` ,
ADD `contact_email` VARCHAR( 100 ) NOT NULL AFTER `hide_contactname` ,
ADD `hide_contactemail` CHAR( 3 ) NOT NULL AFTER `contact_email` ,
ADD `contact_phone` VARCHAR( 32 ) NOT NULL AFTER `hide_contactemail` ,
ADD `hide_contactphone` CHAR( 3 ) NOT NULL AFTER `contact_phone` ,
ADD `contact_fax` VARCHAR( 32 ) NOT NULL AFTER `hide_contactphone` ,
ADD `hide_contactfax` CHAR( 3 ) NOT NULL AFTER `contact_fax` ;

ALTER TABLE `phpjob_jobs` ADD `contact_name` VARCHAR( 100 ) NOT NULL AFTER `experience` ,
ADD `hide_contactname` CHAR( 3 ) NOT NULL AFTER `contact_name` ,
ADD `contact_email` VARCHAR( 100 ) NOT NULL AFTER `hide_contactname` ,
ADD `hide_contactemail` CHAR( 3 ) NOT NULL AFTER `contact_email` ,
ADD `contact_phone` VARCHAR( 32 ) NOT NULL AFTER `hide_contactemail` ,
ADD `hide_contactphone` CHAR( 3 ) NOT NULL AFTER `contact_phone` ,
ADD `contact_fax` VARCHAR( 32 ) NOT NULL AFTER `hide_contactphone` ,
ADD `hide_contactfax` CHAR( 3 ) NOT NULL AFTER `contact_fax` ;

ALTER TABLE `phpjob_cctransactions` ADD `cc_name` VARCHAR( 255 ) NOT NULL ,
ADD `cc_type` VARCHAR( 255 ) NOT NULL ,
ADD `cc_num` VARCHAR( 255 ) NOT NULL ,
ADD `cc_exp` VARCHAR( 255 ) NOT NULL ,
ADD `cc_street` VARCHAR( 255 ) NOT NULL ,
ADD `cc_city` VARCHAR( 255 ) NOT NULL ,
ADD `cc_state` VARCHAR( 255 ) NOT NULL ,
ADD `cc_zip` VARCHAR( 255 ) NOT NULL ,
ADD `cc_country` VARCHAR( 255 ) NOT NULL ,
ADD `cc_phone` VARCHAR( 255 ) NOT NULL ,
ADD `cc_email` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE `phpjob_cctransactions` ADD INDEX ( `opid` );
ALTER TABLE `phpjob_locations_en` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( locationid, `locationid` );
ALTER TABLE `phpjob_locations_en` CHANGE `locationid` `locationid` INT( 3 ) DEFAULT '0' NOT NULL AUTO_INCREMENT;

#Php Jobsite 1.22
ALTER TABLE `phpjob_companies` ADD `hide_address` CHAR( 3 ) NOT NULL AFTER `url` ,
ADD `hide_location` CHAR( 3 ) NOT NULL AFTER `hide_address` ,
ADD `hide_phone` CHAR( 3 ) NOT NULL AFTER `hide_location` ,
ADD `hide_fax` CHAR( 3 ) NOT NULL AFTER `hide_phone` ,
ADD `hide_email` CHAR( 3 ) NOT NULL AFTER `hide_fax` ;
ALTER TABLE `delphpjob_companies` ADD `hide_address` CHAR( 3 ) NOT NULL AFTER `url` ,
ADD `hide_location` CHAR( 3 ) NOT NULL AFTER `hide_address` ,
ADD `hide_phone` CHAR( 3 ) NOT NULL AFTER `hide_location` ,
ADD `hide_fax` CHAR( 3 ) NOT NULL AFTER `hide_phone` ,
ADD `hide_email` CHAR( 3 ) NOT NULL AFTER `hide_fax` ;
ALTER TABLE `phpjob_pricing` CHANGE `pricing_price` `pricing_price` FLOAT( 10, 2 ) DEFAULT '0' NOT NULL;

ALTER TABLE `phpjob_jobmail` ADD `jmail_lang` VARCHAR( 40 ) NOT NULL AFTER `jobmail_type` ;
UPDATE phpjob_jobmail set jmail_lang='english' where jmail_lang='';
ALTER TABLE `phpjob_resumemail` ADD `rmail_lang` VARCHAR( 40 ) NOT NULL AFTER `resumemail_type` ;
UPDATE phpjob_resumemail set rmail_lang='english' where rmail_lang='';
ALTER TABLE `phpjob_resumes` CHANGE `salary` `salary` VARCHAR( 20 ) DEFAULT '0' NOT NULL;
ALTER TABLE `phpjob_sendmail` ADD `sendmail_header` TEXT NOT NULL AFTER `sendmail_email` ;
ALTER TABLE `phpjob_sendmail` ADD `sendmail_footer` TEXT NOT NULL , ADD `sendmail_subject` TEXT NOT NULL ;

ALTER TABLE `phpjob_jobs` ADD `hide_compname` CHAR( 3 ) NOT NULL AFTER `experience`;
ALTER TABLE `delphpjob_jobs` ADD `hide_compname` CHAR( 3 ) NOT NULL AFTER `experience`;

ALTER TABLE `phpjob_cctransactions` ADD `cc_cvc` VARCHAR( 255 ) NOT NULL AFTER `cc_num` ;

ALTER TABLE `phpjob_invoices` ADD `vat` FLOAT( 3, 2 ) NOT NULL AFTER `discount` ;
ALTER TABLE `delphpjob_invoices` ADD `vat` FLOAT( 3, 2 ) NOT NULL AFTER `discount` ;

ALTER TABLE `phpjob_invoices` CHANGE `discount` `discount` FLOAT( 3, 2 ) DEFAULT '0' NOT NULL;
ALTER TABLE `delphpjob_invoices` CHANGE `discount` `discount` FLOAT( 3, 2 ) DEFAULT '0' NOT NULL;

ALTER TABLE `phpjob_sendmail` ADD `sendmail_type` ENUM( 'jobmail', 'resumemail' ) NOT NULL default 'jobmail' AFTER `persid`;

ALTER TABLE `phpjob_companies` CHANGE `discount` `discount` FLOAT( 3, 2 ) DEFAULT '0' NOT NULL;
ALTER TABLE `delphpjob_companies` CHANGE `discount` `discount` FLOAT( 3, 2 ) DEFAULT '0' NOT NULL;

#Php Jobsite 1.20

#Php Jobsite 1.24
ALTER TABLE `phpjob_persons` ADD `lastip` VARCHAR( 50 ) NOT NULL ;
ALTER TABLE `delphpjob_persons` ADD `lastip` VARCHAR( 50 ) NOT NULL ;
ALTER TABLE `phpjob_companies` ADD `lastip` VARCHAR( 50 ) NOT NULL AFTER `lastlogin` ;
ALTER TABLE `delphpjob_companies` ADD `lastip` VARCHAR( 50 ) NOT NULL AFTER `lastlogin` ;
ALTER TABLE `phpjob_jobs` ADD `job_link` VARCHAR( 255 ) NOT NULL AFTER `hide_contactfax` ;
ALTER TABLE `delphpjob_jobs` ADD `job_link` VARCHAR( 255 ) NOT NULL AFTER `hide_contactfax` ;

CREATE TABLE phpjob_cronjobs (
  cron_type enum('jobmail','resumemail','expire') NOT NULL default 'jobmail',
  cron_date datetime NOT NULL default '0000-00-00 00:00:00',
  cron_start timestamp(14) NOT NULL,
  cron_status enum('done','running') NOT NULL default 'done',
  cron_priority tinyint(1) NOT NULL default '0'
);
INSERT INTO phpjob_cronjobs VALUES ('expire', DATE_ADD(NOW(), INTERVAL 10 HOUR), NOW(), 'done', 1);
INSERT INTO phpjob_cronjobs VALUES ('jobmail', DATE_ADD(NOW(), INTERVAL 10 HOUR), NOW(), 'done', 2);
INSERT INTO phpjob_cronjobs VALUES ('resumemail', DATE_ADD(NOW(), INTERVAL 10 HOUR), NOW(), 'done', 3);

#Php Jobsite 1.26

ALTER TABLE `phpjob_persons` ADD `hide_address` CHAR( 3 ) NOT NULL AFTER `url` ,
ADD `hide_location` CHAR( 3 ) NOT NULL AFTER `hide_address` ,
ADD `hide_phone` CHAR( 3 ) NOT NULL AFTER `hide_location` ,
ADD `hide_email` CHAR( 3 ) NOT NULL AFTER `hide_phone` ;
ALTER TABLE `delphpjob_persons` ADD `hide_address` CHAR( 3 ) NOT NULL AFTER `url` ,
ADD `hide_location` CHAR( 3 ) NOT NULL AFTER `hide_address` ,
ADD `hide_phone` CHAR( 3 ) NOT NULL AFTER `hide_location` ,
ADD `hide_email` CHAR( 3 ) NOT NULL AFTER `hide_phone` ;

ALTER TABLE `phpjob_persons` ADD `hide_name` CHAR( 3 ) NOT NULL AFTER `url` ;
ALTER TABLE `delphpjob_persons` ADD `hide_name` CHAR( 3 ) NOT NULL AFTER `url` ;
ALTER TABLE `phpjob_resumes` ADD `resume_cv` VARCHAR( 100 ) NOT NULL ;
ALTER TABLE `delphpjob_resumes` ADD `resume_cv` VARCHAR( 100 ) NOT NULL ;
