<?php
$siteSettings = parse_ini_file(PARTS_DIRECTORY."Setting/siteSetting.ini");
/**
 * 動作モード
 */
define("RUNNING_MODE", $siteSettings['runningMode']);

/**
 * エラーログファイルPath
 */
define("ERROR_LOG_PATH", $siteSettings['error_log_path']);
/**
 * サイト名
 */
define("SITE_NAME", $siteSettings['site_title']);
/**
 * サイトタイトルフォーマット
 */
define("SITE_TITLE_FORMAT", $siteSettings['site_title_format']);
/**
 * サイトコピーライト
 */
define("SITE_COPYRIGHT" ,$siteSettings['site_copyright']);
/**
 * サイトTheme
 */
define("THEME_NAME", $siteSettings['theme_name']);
/**
 * サイトのメールアドレス
 */
define("POST_MAIL", $siteSettings['mail']);
/**
 * サイトThemeのPath
 */
define("THEME_PATH", THEME_DIRECTORY.THEME_NAME.'/');

/**
 * サイトのcss,JavaScriptを圧縮フラグ
 */
define("DATA_COMPLESS", $siteSettings['data_compless']);

$siteSettings = null;