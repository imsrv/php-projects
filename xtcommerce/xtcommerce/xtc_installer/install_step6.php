<?php
  /* --------------------------------------------------------------
   $Id: install_step6.php,v 1.1 2003/09/06 21:42:56 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   Released under the GNU General Public License 
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (install_step6.php,v 1.29 2003/08/20); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('../includes/configure.php');
  
  require('includes/application.php');
  
  require_once(DIR_FS_INC . 'xtc_rand.inc.php');
  require_once(DIR_FS_INC . 'xtc_encrypt_password.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_query.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_fetch_array.inc.php');
  require_once(DIR_FS_INC .'xtc_validate_email.inc.php');
  require_once(DIR_FS_INC .'xtc_db_input.inc.php');
  require_once(DIR_FS_INC .'xtc_db_num_rows.inc.php');
  require_once(DIR_FS_INC .'xtc_redirect.inc.php');
  require_once(DIR_FS_INC .'xtc_href_link.inc.php');
  require_once(DIR_FS_INC . 'xtc_get_countries.inc.php');
  require_once(DIR_FS_INC . 'xtc_draw_pull_down_menu.inc.php');
  require_once(DIR_FS_INC . 'xtc_draw_input_field.inc.php');
  require_once(DIR_FS_INC . 'xtc_get_country_list.inc.php');

    include('language/'.$_SESSION['language'].'.php');
  
  // connect do database
  xtc_db_connect() or die('Unable to connect to database server!'); 
    

  
  // get configuration data
  $configuration_query = xtc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
  while ($configuration = xtc_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

   $messageStack = new messageStack();
  
    $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $process = true;


    $firstname = xtc_db_prepare_input($_POST['FIRST_NAME']);
    $lastname = xtc_db_prepare_input($_POST['LAST_NAME']);
	$email_address = xtc_db_prepare_input($_POST['EMAIL_ADRESS']);
	$street_address = xtc_db_prepare_input($_POST['STREET_ADRESS']);
	$postcode = xtc_db_prepare_input($_POST['POST_CODE']);
    $city = xtc_db_prepare_input($_POST['CITY']);
    $zone_id = xtc_db_prepare_input($_POST['zone_id']);
    $state = xtc_db_prepare_input($_POST['STATE']);
	$country = xtc_db_prepare_input($_POST['COUNTRY']);
    $telephone = xtc_db_prepare_input($_POST['TELEPHONE']);
    $password = xtc_db_prepare_input($_POST['PASSWORD']);
    $confirmation = xtc_db_prepare_input($_POST['PASSWORD_CONFIRMATION']);
    $store_name = xtc_db_prepare_input($_POST['STORE_NAME']);
	$email_from = xtc_db_prepare_input($_POST['EMAIL_ADRESS_FROM']);
	$zone_setup = xtc_db_prepare_input($_POST['ZONE_SETUP']);
	$company = xtc_db_prepare_input($_POST['COMPANY']);
		
    $error = false;


    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_LAST_NAME_ERROR);
    }
	
    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_ERROR);
    } elseif (xtc_validate_email($email_address) == false) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    } 
    


 if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_CITY_ERROR);
    }

    if (is_numeric($country) == false) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_COUNTRY_ERROR);
    }

    if (ACCOUNT_STATE == 'true') {
      $zone_id = 0;
      $check_query = xtc_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
      $check = xtc_db_fetch_array($check_query);
      $entry_state_has_zones = ($check['total'] > 0);
      if ($entry_state_has_zones == true) {
        $zone_query = xtc_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and (zone_name like '" . xtc_db_input($state) . "%' or zone_code like '%" . xtc_db_input($state) . "%')");
        if (xtc_db_num_rows($zone_query) > 0) {
          $zone = xtc_db_fetch_array($zone_query);
          $zone_id = $zone['zone_id'];
        } else {
          $error = true;

          $messageStack->add('install_step6', ENTRY_STATE_ERROR_SELECT);
        }
      } else {
        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          $error = true;

          $messageStack->add('install_step6', ENTRY_STATE_ERROR);
        }
      }
    }

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_TELEPHONE_NUMBER_ERROR);
    }


    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_PASSWORD_ERROR);
    } elseif ($password != $confirmation) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }
	
	    if (strlen($store_name) < '3') {
      $error = true;

      $messageStack->add('install_step6', ENTRY_STORE_NAME_ERROR);
    }
	if (strlen($company) < '2') {
      $error = true;

      $messageStack->add('install_step6', ENTRY_COMPANY_NAME_ERROR);
    }
	
    if (strlen($email_from) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_FROM_ERROR);
    } elseif (xtc_validate_email($email_from) == false) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR);
    } 
	if ( ($zone_setup != 'yes') && ($zone_setup != 'no') ) {
        $error = true;

        $messageStack->add('install_step6', SELECT_ZONE_SETUP_ERROR);
	}
    
	
	    if ($error == false) {
		
xtc_db_query("insert into " . TABLE_CUSTOMERS . " (
										customers_id,
										customers_status,
										customers_firstname,
										customers_lastname,
										customers_email_address,
										customers_default_address_id,
										customers_telephone,
										customers_password,
										delete_user) VALUES
										('1',
										'0',
										'".$firstname."',
										'".$lastname."',
										'".$email_address."',
										'1',
										'".$telephone."',
										'".xtc_encrypt_password($password)."',
										'0')");

xtc_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (
										customers_info_id,
										customers_info_date_of_last_logon, 
										customers_info_number_of_logons, 
										customers_info_date_account_created,
										customers_info_date_account_last_modified,
										global_product_notifications) VALUES
										('1','','','','','')");
xtc_db_query("insert into " .TABLE_ADDRESS_BOOK . " (
										customers_id,
										entry_company,
   										entry_firstname,
   										entry_lastname,
   										entry_street_address,
   										entry_postcode,
   										entry_city,
   										entry_state,
   										entry_country_id,
   										entry_zone_id) VALUES
										('1',
										'".($company)."',
										'".($firstname)."',
										'".($lastname)."',
										'".($street_address)."',
										'".($postcode)."',
										'".($city)."',
										'".($state)."',
										'".($country)."',
										'".($zone_id)."'
										)");
										
										 
 
										
		$email_from = $store_name . ' <'.$email_from.'>';
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_address). "' WHERE configuration_key = 'STORE_OWNER_EMAIL_ADDRESS'");									
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($store_name). "' WHERE configuration_key = 'STORE_NAME'"); 
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_FROM'"); 
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($country). "' WHERE configuration_key = 'SHIPPING_ORIGIN_COUNTRY'");									
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($postcode). "' WHERE configuration_key = 'SHIPPING_ORIGIN_ZIP'");									
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($company). "' WHERE configuration_key = 'STORE_OWNER'");									


if ($zone_setup == 'yes') {

// Steuers�tze des jewiligen landes einstellen!
$tax_normal='';
$tax_normal_text='';
$tax_special='';
$tax_special_text='';
switch ($country) {

	case '14':
	// Austria
		$tax_normal='20.0000';
		$tax_normal_text='UST 20%';
		$tax_special='10.0000';
		$tax_special_text='UST 10%';
		 break;
	case '21':
	// Belgien
		$tax_normal='21.0000';
		$tax_normal_text='UST 21%';
		$tax_special='6.0000';
		$tax_special_text='UST 6%';
		 break;	
	case '57':
	// D�nemark
		$tax_normal='25.0000';
		$tax_normal_text='UST 25%';
		$tax_special='25.0000';
		$tax_special_text='UST 25%';
		 break;	
	case '72':
	// Finnland
		$tax_normal='22.0000';
		$tax_normal_text='UST 22%';
		$tax_special='8.0000';
		$tax_special_text='UST 8%';
		 break;	
	case '73':
	// Frankreich
		$tax_normal='19.6000';
		$tax_normal_text='UST 19.6%';
		$tax_special='2.1000';
		$tax_special_text='UST 2.1%';
		 break;	
	case '81':
	// Deutschland
		$tax_normal='16.0000';
		$tax_normal_text='UST 16%';
		$tax_special='7.0000';
		$tax_special_text='UST 7%';
		 break;	
	case '84':
	// Griechenland
		$tax_normal='18.0000';
		$tax_normal_text='UST 18%';
		$tax_special='4.0000';
		$tax_special_text='UST 4%';
		 break;	
	case '103':
	// Irland
		$tax_normal='21.0000';
		$tax_normal_text='UST 21%';
		$tax_special='4.2000';
		$tax_special_text='UST 4.2%';
		 break;	
	case '105':
	// Italien
		$tax_normal='20.0000';
		$tax_normal_text='UST 20%';
		$tax_special='4.0000';
		$tax_special_text='UST 4%';
		 break;	
	case '124':
	// Luxemburg
		$tax_normal='15.0000';
		$tax_normal_text='UST 15%';
		$tax_special='3.0000';
		$tax_special_text='UST 3%';
		 break;	
	case '150':
	// Niederlande
		$tax_normal='19.0000';
		$tax_normal_text='UST 19%';
		$tax_special='6.0000';
		$tax_special_text='UST 6%';
		 break;	
	case '171':
	// Portugal
		$tax_normal='17.0000';
		$tax_normal_text='UST 17%';
		$tax_special='5.0000';
		$tax_special_text='UST 5%';
		 break;	
	case '195':
	// Spain
		$tax_normal='16.0000';
		$tax_normal_text='UST 16%';
		$tax_special='4.0000';
		$tax_special_text='UST 4%';
		 break;	
	case '203':
	// Schweden
		$tax_normal='25.0000';
		$tax_normal_text='UST 25%';
		$tax_special='6.0000';
		$tax_special_text='UST 6%';
		 break;	
	case '222':
	// UK
		$tax_normal='17.5000';
		$tax_normal_text='UST 17.5%';
		$tax_special='5.0000';
		$tax_special_text='UST 5%';
		 break;	
}
	

// Steuers�tze / tax_rates

xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (1, 5, 1, 1, '".$tax_normal."', '".$tax_normal_text."', '', '')");
xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (2, 5, 2, 1, '".$tax_special."', '".$tax_special_text."', '', '')");
xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (3, 6, 1, 1, '0.0000', 'EU-AUS-UST 0%', '', '')");
xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (4, 6, 2, 1, '0.0000', 'EU-AUS-UST 0%', '', '')");


// Steuerklassen

xtc_db_query("INSERT INTO tax_class (tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (1, 'Standartsatz', '', '', now())");
xtc_db_query("INSERT INTO tax_class (tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (2, 'erm��igter Steuersatz', '', NULL, now())");

// Steuers�tze

xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (6, 'Steuerzone EU-Ausland', '', '', now())");
xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (5, 'Steuerzone EU', 'Steuerzone f�r die EU', '', now())");
xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (7, 'Steuerzone B2B', '', NULL, now())");

// EU-Steuerzonen 

xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (5, 57, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (4, 21, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (6, 72, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (7, 73, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (8, 84, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (9, 103, 0, 5, NULL,now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (10, 105, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (11, 124, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (12, 150, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (13, 14, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (14, 171, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (15, 195, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (16, 222, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (17, 203, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (18, 81, 0, 5, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (19, 1, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (20, 2, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (21, 3, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (22, 4, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (23, 5, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (24, 6, NULL, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (25, 7, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (26, 8, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (27, 9, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (28, 10, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (29, 11, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (30, 13, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (31, 15, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (32, 16, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (33, 17, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (34, 19, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (35, 20, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (36, 22, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (37, 23, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (38, 24, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (39, 25, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (40, 27, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (41, 26, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (42, 28, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (43, 29, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (44, 30, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (45, 31, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (46, 32, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (47, 33, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (48, 34, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (49, 35, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (50, 36, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (51, 37, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (52, 39, NULL, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (53, 38, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (54, 40, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (55, 41, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (56, 42, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (57, 43, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (58, 44, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (59, 45, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (60, 47, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (61, 48, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (62, 49, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (63, 50, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (64, 51, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (65, 52, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (66, 53, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (67, 54, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (68, 55, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (69, 56, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (70, 58, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (71, 59, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (72, 60, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (73, 61, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (74, 62, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (75, 63, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (76, 64, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (77, 65, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (78, 66, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (79, 67, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (80, 68, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (81, 69, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (82, 70, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (83, 71, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (84, 74, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (85, 75, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (86, 76, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (87, 77, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (88, 78, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (89, 79, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (90, 82, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (91, 83, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (92, 86, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (93, 87, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (94, 88, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (95, 89, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (96, 90, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (97, 91, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (98, 92, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (99, 93, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (100, 94, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (101, 95, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (102, 96, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (103, 97, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (104, 99, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (105, 100, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (106, 101, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (107, 102, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (108, 104, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (109, 106, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (110, 107, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (111, 109, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (112, 110, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (113, 111, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (114, 112, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (115, 113, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (116, 114, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (117, 115, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (118, 116, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (119, 117, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (120, 118, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (121, 119, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (122, 120, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (123, 121, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (124, 122, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (125, 125, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (126, 126, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (127, 127, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (128, 128, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (129, 129, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (130, 130, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (131, 131, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (132, 132, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (133, 133, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (134, 134, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (135, 135, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (136, 136, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (137, 137, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (138, 138, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (139, 139, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (140, 140, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (141, 141, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (142, 142, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (143, 143, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (144, 144, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (145, 145, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (146, 146, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (147, 147, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (148, 148, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (149, 149, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (150, 151, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (151, 152, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (152, 153, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (153, 154, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (154, 155, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (155, 156, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (156, 157, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (157, 158, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (158, 159, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (159, 160, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (160, 161, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (161, 162, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (162, 164, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (163, 165, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (164, 166, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (165, 167, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (166, 168, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (167, 169, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (168, 170, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (169, 172, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (170, 173, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (171, 174, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (172, 176, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (173, 177, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (174, 178, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (175, 179, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (176, 180, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (177, 181, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (178, 182, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (179, 183, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (180, 184, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (181, 185, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (182, 186, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (183, 187, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (184, 188, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (185, 189, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (186, 190, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (187, 191, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (188, 193, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (189, 194, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (190, 192, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (191, 196, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (192, 197, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (193, 198, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (194, 199, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (195, 200, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (196, 201, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (197, 202, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (198, 204, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (199, 205, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (200, 206, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (201, 207, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (202, 208, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (203, 209, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (204, 210, 0, 6, NULL,  now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (205, 211, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (206, 212, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (207, 213, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (208, 214, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (209, 215, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (210, 216, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (211, 217, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (212, 218, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (213, 219, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (214, 221, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (215, 223, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (216, 224, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (217, 225, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (218, 226, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (219, 227, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (220, 228, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (221, 229, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (222, 230, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (223, 231, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (224, 232, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (225, 233, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (226, 234, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (227, 235, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (228, 236, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (229, 237, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (230, 238, 0, 6, NULL, now())");
xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (231, 239, 0, 6, NULL, now())");





}																			
	      xtc_redirect(xtc_href_link('xtc_installer/install_step7.php', '', 'NONSSL'));
		}
			
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>XT-Commerce Installer - STEP 6 / Create Superuser</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php require('includes/form_check.js.php'); ?>
<style type="text/css">
<!--
.messageBox {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 1;
}
.messageStackError, .messageStackWarning { font-family: Verdana, Arial, sans-serif; font-weight: bold; font-size: 10px; background-color: #; }
-->
</style>
</head>

<body>
<table width="800" height="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="95" colspan="2" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="1"><img src="images/logo.gif"></td>
          <td background="images/bg_top.jpg">&nbsp;</td>
        </tr>
      </table>
  </tr>
  <tr> 
    <td width="180" valign="top" bgcolor="F3F3F3" style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid; border-color: #6D6D6D;"> 
      <table width="180" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="17" background="images/bg_left_blocktitle.gif">
<div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="FFAF00">xtc:</font><font color="#999999">Install</font></b></font></div></td>
        </tr>
        <tr> 
          <td bgcolor="F3F3F3" ><br> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="10">&nbsp;</td>
                <td width="135"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_LANGUAGE; ?></font></td>
                <td width="35"><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_DB_CONNECTION; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_DB_CONNECTION; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WEBSERVER_SETTINGS; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WRITE_CONFIG; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_ADMIN_CONFIG; ?></font></td>
                <td>&nbsp;</td>
              </tr>
			              <?php
  if ($messageStack->size('install_step6') > 0) {
?>
<tr><td style="border-bottom: 1px solid; border-color: #cccccc;" colspan="3">&nbsp;</td>
<tr><td colspan="3">
             <table border="0" cellpadding="0" cellspacing="0" bgcolor="f3f3f3">
              <tr> 
                <td><?php echo $messageStack->output('install_step6'); ?></td>
              </tr>
            </table>
</td></tr>
            <?php
  }
?>
            </table>
            <br></td>
        </tr>
      </table>
    </td>
    <td align="right" valign="top" style="border-top: 1px solid; border-bottom: 1px solid; border-right: 1px solid; border-color: #6D6D6D;"> 
      <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> <img src="images/title_index.gif" width="586" height="100" border="0"><br>
            <br>
            <br>
            <?php echo TEXT_WELCOME_STEP6; ?></font></td>
        </tr>
      </table> 
      <br>
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td>
             

             <form name="install" action="install_step6.php" method="post" onSubmit="return check_form(install_step6);">
              <input name="action" type="hidden" value="process">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    <?php echo TITLE_ADMIN_CONFIG; ?> </b></font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                    <b><?php echo TEXT_REQU_INFORMATION; ?></b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
			  <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TITLE_SHOP_CONFIG_NOTE; ?></font>
              <table width="100%" border="0">
                <tr> 
                  <td width="26%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo TEXT_FIRSTNAME; ?></strong></font></td>
                  <td width="74%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('FIRST_NAME'); ?> 
                    <font color="#FF0000">*</font> </font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_LASTNAME; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('LAST_NAME'); ?> 
                    <font color="#FF0000">*</font> </font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_EMAIL; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('EMAIL_ADRESS'); ?> 
                    <font color="#FF0000">*<font color="#000000"> </font><strong><?php echo TEXT_EMAIL_LONG; ?></strong></font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_STREET; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('STREET_ADRESS'); ?> 
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_POSTCODE; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('POST_CODE'); ?> 
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_CITY; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('CITY'); ?> 
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_STATE; ?></font></strong></font></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_query = xtc_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = xtc_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo xtc_draw_pull_down_menu('STATE', $zones_array);
      } else {
        echo xtc_draw_input_field('STATE');
      }
    } else {
      echo xtc_draw_input_field('STATE');
    }


?>
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_COUNTRY; ?></font></strong></td>
                  <td><?php echo xtc_get_country_list('COUNTRY'); ?><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
                    </font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">*<strong> 
                    <?php echo TEXT_COUNTRY_LONG; ?></strong></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_TEL; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('TELEPHONE'); ?> 
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_PASSWORD; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_password_field_installer('PASSWORD'); ?>
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_PASSWORD_CONF; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_password_field_installer('PASSWORD_CONFIRMATION'); ?>
                    <font color="#FF0000">*</font></font></td>
                </tr>
              </table>
              <p>&nbsp;</p>
			  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                  <?php echo TITLE_SHOP_CONFIG; ?> </b></font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <b><?php echo TEXT_REQU_INFORMATION; ?></b></font></td>
                <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
              </tr>
            </table>
              <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TITLE_SHOP_CONFIG_NOTE; ?></font><br>
              <table width="100%" border="0">
                <tr> 
                  <td width="26%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_STORE; ?></strong></font></td>
                  <td width="74%"><?php echo xtc_draw_input_field_installer('STORE_NAME'); ?><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    *<font color="#000000"> </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_STORE_LONG; ?></strong></font></font></td>
                </tr>
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_COMPANY; ?></strong></font></td>
                  <td><?php echo xtc_draw_input_field_installer('COMPANY'); ?><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    *<font color="#000000"> </font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></font></td>
                </tr>
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_EMAIL_FROM; ?></strong></font></td>
                  <td><?php echo xtc_draw_input_field_installer('EMAIL_ADRESS_FROM'); ?><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    *<font color="#000000"> </font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_EMAIL_FROM_LONG; ?></strong></font></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo TEXT_STATE; ?></strong></font></font></td>
                </tr>
              </table>
			  <p>&nbsp;</p>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    <?php echo TITLE_ZONE_CONFIG; ?> </b></font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <b><?php echo TEXT_REQU_INFORMATION; ?></b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
              <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TITLE_ZONE_CONFIG_NOTE; ?></font><br>
              <table width="100%" border="0">
                <tr> 
                  <td width="26%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_ZONE; ?></strong></font></td>
                  <td width="74%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_YES; ?> 
                    </font><?php echo xtc_draw_radio_field_installer('ZONE_SETUP', 'yes', 'true'); ?>
                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font> 
                    <?php echo xtc_draw_radio_field_installer('ZONE_SETUP', 'no'); ?></td>
                </tr>
              </table>
              <p><br>
              </p>
              <center>
                <input name="image" type="image" src="images/button_continue.gif" alt="Continue" align="middle" border="0">
                <br>
              </center>
            </form></td>
        </tr>
      </table> 
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>

      <p>&nbsp;</p>
    </td>
  </tr>
</table>



<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_FOOTER; ?><br>
  </font></p>
<p align="center">&nbsp;</p>
</body>
</html>

</body>
</html>
