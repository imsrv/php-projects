# // ==========================================================
# // This file creates the database and tables needed for
# // 6XMailer
# // ==========================================================

# // Replace 6xmailer_data with the name you wish to you for your copy,
# // but remember to change the $QLDatabase to match this in the
# // config.php file.
USE 6xmailer_data;

ALTER TABLE userdata ADD Signature TEXT;
