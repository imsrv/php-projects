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
