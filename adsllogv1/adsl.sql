#
# A mysql database definition to create a logging table
# for storing ADSL transfer statistics 
# 
# Peter van Es, 06 June 2002
# version 1.0
#
#
# Create the database with:
# 
# mysqladmin --user=username -p create adsl
#
# then add the definition with
#
# mysql  --user=username -p adsl <adsl.sql 

# table for storing hourly rates
create table adsl_log (
   year integer DEFAULT '0' NOT NULL,
   month integer DEFAULT '0' NOT NULL,
   day integer DEFAULT '0' NOT NULL,
   hour integer DEFAULT '0' NOT NULL,
   rx   bigint UNSIGNED DEFAULT '0',
   tx   bigint UNSIGNED DEFAULT '0',
   KEY year (year),
   KEY month (month),
   KEY day (day)
);

# tables for statistics and creating graphs
create table adsl_hour (
   hour integer DEFAULT '0' NOT NULL,
   rx   bigint UNSIGNED DEFAULT '0',
   tx   bigint UNSIGNED DEFAULT '0'
);

create table adsl_day (
   year integer DEFAULT '0' NOT NULL,
   month integer DEFAULT '0' NOT NULL,
   day  integer DEFAULT '0' NOT NULL,
   rx   bigint UNSIGNED DEFAULT '0',
   tx   bigint UNSIGNED DEFAULT '0',
   KEY year (year),
   KEY month (month)
);

create table adsl_month (
   year integer DEFAULT '0' NOT NULL,
   month  integer DEFAULT '0' NOT NULL,
   rx   bigint UNSIGNED DEFAULT '0',
   tx   bigint UNSIGNED DEFAULT '0',
   KEY year (year),
   KEY month (month),
);

# table for storing the last record
create table lastrec (
   year integer DEFAULT '0' NOT NULL,
   month integer DEFAULT '0' NOT NULL,
   day integer DEFAULT '0' NOT NULL,
   hour integer DEFAULT '0' NOT NULL,
   rx   bigint UNSIGNED DEFAULT '0',
   tx   bigint UNSIGNED DEFAULT '0'
);
