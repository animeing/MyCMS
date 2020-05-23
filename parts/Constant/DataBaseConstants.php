<?php

$siteSettings = parse_ini_file(PARTS_DIRECTORY."Setting/dataBase.ini");

define("DB_DSN", $siteSettings['dsn']);

define("DB_USER", $siteSettings['user']);

define("DB_PASSWORD", $siteSettings['password']);

$siteSettings = null;
