#
# A mysql script for updating the statistics in the database
# for storing ADSL transfer statistics 
# 
# Peter van Es, 06 June 2002
# version 1.0
#
#
# Execute this program as follows
#
# mysql  --user=username --password=password adsl <adslstats.sql
#

# first update the adsl_day table, start with a clean slate

DELETE FROM adsl_day;

# this complicated query lets MySQL do all the hard work
# the select gets a day summary of data from adsl_log and
# inserts it into the adsl_day table as kilobytes (i.e. 
# divided by 1024
INSERT INTO adsl_day 
   SELECT year, month, day, round(sum(rx)/1024) AS rx, 
          round(sum(tx)/1024) AS tx
          FROM adsl_log 
          GROUP BY year, month, day;

# now update the adsl_month table
# note that this table now contains megabytes...

DELETE FROM adsl_month;

INSERT INTO adsl_month 
   SELECT year, month, round(sum(rx)/1024) AS rx, 
          round(sum(tx)/1024) AS tx
          FROM adsl_day 
          GROUP BY year, month;

# now update the hourly statistics

DELETE FROM adsl_hour;

INSERT INTO adsl_hour 
   SELECT hour, round(sum(rx)/(1024*COUNT(*))) AS rx, 
          round(sum(tx)/(1024*COUNT(*))) AS tx
          FROM adsl_log 
          GROUP BY hour;

# done

