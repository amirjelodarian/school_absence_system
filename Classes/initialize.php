<?php
date_default_timezone_set('Asia/Tehran');
    ob_start();

    // Database Configuration
    defined('DB_HOST') ? null : define('DB_HOST','localhost');
    defined('DB_USER') ? null : define('DB_USER','root');
    defined('DB_PASS') ? null : define('DB_PASS','');
    defined('DB_NAME') ? null : define('DB_NAME','ahrar_school');
    defined('USERNAME') ? null : define('USERNAME','@ahrar@');
    defined('PASSWORD') ? null : define('PASSWORD','1400ahrar1400');
    defined('ANOTHER') ? null : define('ANOTHER','&copy; All Right Reversed By Sepehr Niki & Shahram Taghipour & Amir Jelodarian');
    ///////////////////////////


    require_once "Database.php";
    require_once "Validate.php";
    require_once "Sessions.php";
    require_once "Functions.php";
    require_once "Students.php";
    require_once "Sms.php";
    require_once "jdf.php";


?>
