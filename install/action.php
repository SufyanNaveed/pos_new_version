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
include "version.php";
ini_set('max_execution_time', 900); //900 seconds 
if (isset($_POST)) {
    $host = $_POST["host"];
    $dbuser = $_POST["dbuser"];
    $dbpassword = $_POST["dbpassword"];
    $dbname = $_POST["dbname"];
    $app = $_POST["app_url"];
    $email = $_POST["email"];
    $number_decimal = $_POST["number_decimal"];
    $password = '123456';
    foreach (glob("assets/lib/*.php") as $filename) {
        include $filename;
    }
    //check required fields
    if (!($host && $dbuser && $dbname && $app && $email && $password)) {
        echo json_encode(array("success" => false, "message" => "Please input all fields correctly."));
        exit();
    }
    if (strlen($password) < 6) {
        echo json_encode(array("success" => false, "message" => "Password length should be at least 6 characters."));
        exit();
    }
    //check for valid database connection

    $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname);
    if (mysqli_connect_errno()) {
        echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
        exit();
    }
    $is_installsd = validate_value($app[1]);

    function sql_status($ok)
    {
        if (!$ok) {
            echo json_encode(array("success" => false, "message" => "Please input all fields correctly."));
            exit();
        }
    }

    $ok = $is_installsd;
    $db_file_path = "../application/config/database.php";
    $db_file = file_get_contents($db_file_path);
    $is_installed = strpos($db_file, "HOSTNAME");
    if (!$is_installed) {
        echo json_encode(array("success" => false, "message" => "Seems this app is already installed! You can't reinstall it again. Please delete all files and database to fresh install."));
        exit();
    }

    $url = 'http://provider.ultimatekode.com/geo/' . BUILD . '/verify.php';
    sql_status($ok);

    function create_user($id, $email, $pass)
    {
        $salt = md5($id);
        $password = hash('sha256', $salt . '' . $pass);
        $query = " INSERT INTO `geopos_users` (`id`, `email`, `pass`, `username`, `banned`, `last_login`, `last_activity`, `date_created`, `forgot_exp`, `remember_time`, `remember_exp`, `verification_code`, `totp_secret`, `ip_address`, `roleid`, `picture`, `loc`) VALUES
($id, '$email', '$password', 'admin', 0, '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d H:i:s") . "',  '" . date("Y-m-d H:i:s") . "', NULL, NULL, NULL, '', NULL, '::1', 5, 'example.png', 0);";
        return $query;
    }

    $uid = rand(5, 15);
    $user = create_user($uid, $email, $password);
    function file_get_contents_curl($url, $app, $id, $email, $action,$number_decimal='')
    {
        $file = file_get_contents('../install/db.txt');
        return $file;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "app=" . $app . "&id=" . $id . "&email=" . $email . "&action=" . $action."&decimal=" . $number_decimal);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    $core = file_get_contents_curl($url, $app[1], $uid, $email, $app[0],$number_decimal);
    if (!$core) {
        echo json_encode(array("success" => false, "message" => "Error Code e174."));
        exit();
    }
    $mysqli->multi_query($core . '' . $user);
    do {

    } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
    $validate = $mysqli->query("SELECT id FROM geopos_users WHERE id='$uid'");

    if (@$validate->num_rows > 0) {
        $mysqli->close();
        $db_file = str_replace('{HOSTNAME}', $host, $db_file);
        $db_file = str_replace('{USERNAME}', $dbuser, $db_file);
        $db_file = str_replace('{PASSWORD}', $dbpassword, $db_file);
        $db_file = str_replace('{DATABASE}', $dbname, $db_file);
        file_put_contents($db_file_path, $db_file);
        $db_file_path = "../crm/application/config/database.php";
        $db_file = file_get_contents($db_file_path);
        $db_file = str_replace('{HOSTNAME}', $host, $db_file);
        $db_file = str_replace('{USERNAME}', $dbuser, $db_file);
        $db_file = str_replace('{PASSWORD}', $dbpassword, $db_file);
        $db_file = str_replace('{DATABASE}', $dbname, $db_file);
        file_put_contents($db_file_path, $db_file);
        $ins_url = rtrim($app[0], "/") . '/';
        $config_file_path = "../application/config/config.php";
        $encryption_key = substr(md5(rand()), 0, 15);
        $config_file = file_get_contents($config_file_path);
        $config_file = str_replace('{APP_URL}', $ins_url, $config_file);
        $config_file = str_replace('enter_encryption_key', $encryption_key, $config_file);
        file_put_contents($config_file_path, $config_file);
        $config_file_path = "../crm/application/config/config.php";
        $config_file = file_get_contents($config_file_path);
        $config_file = str_replace('{APP_URL}', $ins_url . 'crm/', $config_file);
        $config_file = str_replace('enter_encryption_key', $encryption_key, $config_file);
        file_put_contents($config_file_path, $config_file);
        $index_file_path = "../index.php";
        $index_file = file_get_contents($index_file_path);
        $index_file = preg_replace('/pre_installation/', 'production', $index_file, 1);
        file_put_contents($index_file_path, $index_file);
        $index_file_path2 = "../crm/index.php";
        $index_file2 = file_get_contents($index_file_path2);
        $index_file2 = preg_replace('/pre_installation/', 'production', $index_file2, 1);
        file_put_contents($index_file_path2, $index_file2);
        echo json_encode(array("success" => true, "message" => "Installation successful."));
        exit();
    } else {
		$n='';
        $mysqli->query('SET foreign_key_checks = 0');
        if ($result = $mysqli->query("SHOW TABLES")) {
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
               // $mysqli->query('DROP TABLE IF EXISTS ' . $row[0]); 
			   $n=' Please clean up the database!';
            }
        }
        $mysqli->query('SET foreign_key_checks = 1');
        $mysqli->close();
        echo json_encode(array("success" => false, "message" => "Database import failed! Please make sure you are using MySQL 5.6+ OR MariaDB 10.0+  $n - dbname"));
        exit();
    }


}

function sql_status2($is_installsd)
{
    if ($is_installsd <= 0) {
        echo json_encode(array("success" => false, "message" => "Please input all fields."));
        exit();
    }
}