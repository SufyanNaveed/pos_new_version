<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
$php_version_success = false;
$mysql_success = false;
$curl_success = false;
$gd_success = false;
$allow_url_fopen_success = false;
$timezone_success = true;
$mbstring = false;
$php_version_required = "7.3";
$current_php_version = PHP_VERSION;

//check required php version
if (version_compare($current_php_version, $php_version_required) >= 0) {
    $php_version_success = true;
}

//check mySql
if (function_exists("mysqli_connect")) {
    $mysql_success = true;
}

//check curl
if (function_exists("curl_version")) {
    $curl_success = true;
}

//check gd
if (extension_loaded('gd') && function_exists('gd_info')) {
    $gd_success = true;
}


//check allow_url_fopen
if (ini_get('allow_url_fopen')) {
    $allow_url_fopen_success = true;
}
//check allow_url_fopen
$timezone_settings = ini_get('date.timezone');
if ($timezone_settings) {
    $timezone_success = true;
}
//check gd
if (extension_loaded('mbstring')) {
    $mbstring = true;
}
$all_requirement_success = false;
$writeable_directories = array(
    'routes' => '/index.php',
    'routes_crm' => '/crm/index.php',
    'config_cache' => '/application/cache',
    'config_1' => '/application/config/config.php',
    'db' => '/application/config/database.php',
    'db_1' => '/application/config/lic.php',
    'config_crm' => '/crm/application/cache',
    'config' => '/crm/application/config/config.php',
    'db_c' => '/crm/application/config/database.php',
    'config_data' => '/userfiles/',
    'config_pdf' => '/userfiles/temp/pdf/'
);
$dashboard_url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$dashboard_url = preg_replace('/install.*/', '', $dashboard_url); //remove everything after index.php
if (!empty($_SERVER['HTTPS'])) {
    $dashboard_url = 'https://' . $dashboard_url;
} else {
    $dashboard_url = 'http://' . $dashboard_url;
}
include "version.php";
include "view/index.php";

?>
