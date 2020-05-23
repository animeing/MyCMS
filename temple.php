<?php

ini_set('display_errors', "On");

define("CVV_TOP_URL", (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER['HTTP_HOST'] . ((dirname($_SERVER["SCRIPT_NAME"]) === '/')? "" : dirname($_SERVER["SCRIPT_NAME"]))."/");
define("CVV_ADMIN_PAGE", FALSE);

require_once(dirname(__FILE__)."/parts/ProjectLoader.php");

projectLoader(__DIR__.'/parts/loader.xml');


start();

require(THEME_PATH.'index.php');

ob_end_flush();
