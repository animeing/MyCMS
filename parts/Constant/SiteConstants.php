<?php

/**
 * データが展開されている絶対Path
 */
define("INCLUDE_PATH", dirname(dirname(dirname(__FILE__))));

define("PARTS_DIRECTORY", INCLUDE_PATH.'/parts/');

define("PAGES_DIRECOTRY", PARTS_DIRECTORY."Pages/");

/**
 * テーマのデータがあるディレクトリ
 */
define("THEME_DIRECTORY", PARTS_DIRECTORY.'Theme/');

/**
 * Contentがあるディレクトリ
 */
define("CONTENT_DIRECTORY", PARTS_DIRECTORY.'Content/');

/**
 * 投稿データのあるディレクトリ(設定データなど)
 */
define("POST_DIRECTORY", CONTENT_DIRECTORY.'Post/');

/**
 * ジャンルファイルがあるディレクトリ
 */
define("GENRE_DIRECTORY", POST_DIRECTORY.'Genre/');

/**
 * 投稿されたContentファイルがあるディレクトリ(htmlファイル群)
 */
define("POST_CONTENT_DIRECTORY", POST_DIRECTORY.'Content/');

/**
 * 投稿されたContentファイルの設定ファイルディレクトリ
 */
define("POST_CONTENT_SETTING_DIRECTORY", POST_DIRECTORY.'ContentSetting/');

/**
 * ストレージディレクトリ
 */
define("STORAGE_DIRECTORY", PARTS_DIRECTORY.'Content/Storage/');

/**
 * 拡張機能が格納されているディレクトリ
 */
define("EXTENSION_PATH", PARTS_DIRECTORY.'Extension/');

/**
 * キャッシュデータが格納されているディレクトリ
 */
define("CACHE_DIRECTORY", PARTS_DIRECTORY.'Cache/');

define("CVV_PATH_NAME",$_SERVER['REQUEST_URI']);

/**
 * Getパラメータ
 */
define("CVV_QUERY", $_SERVER['QUERY_STRING']);

if ( isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on' )
{
    /**
     * ページのhttpアクセスかhttps
     */
	define("CVV_PORTS", 'https://');
}
else
{
    /**
     * ページのhttpアクセスかhttps
     */
	define("CVV_PORTS", 'http://');
}
/**
 * 現在のURL(Getパラメータも保持しています。)
 */
define("CVV_VIEW_URL", CVV_PORTS.$_SERVER['HTTP_HOST'].CVV_PATH_NAME);

/**
 * 現在のURL(Getパラメータは含みません。)
 */
define("CVV_PAGE_VIEW_URL", str_replace('?'.CVV_QUERY, '', CVV_VIEW_URL));

/**
 * ドメイン
 */
define("CVV_DOMAIN", CVV_PORTS.$_SERVER['HTTP_HOST']);

define("CVV_POST_URL", CVV_TOP_URL.'post/');