<?php
/**
 * DATABASE
 */
// define("DATA_LAYER_CONFIG", [
//     "driver" => "mysql",
//     "host" => "92.249.45.92",
//     "port" => "3306",
//     "dbname" => "sistem80_cred_hml",
//     "username" => "sistem80",
//     "passwd" => "consult1810",
//     "options" => [
//         PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
//         PDO::ATTR_CASE => PDO::CASE_NATURAL
//     ]
// ]);

define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "127.0.0.1",
    "port" => "3306",
    "dbname" => "sistemacred_dev",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);


/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "http://dev.sistemacred.com");
define("CONF_URL", "http://dev.sistemacred.com");

/**
 * SITE
 */
define("CONF_SITE_NAME", "Sistema Cred");
define("CONF_SITE_TITLE", "Sistema de Crédito");
define("CONF_SITE_DESC", "Sistema_cred");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "sistema_cred.com");
define("CONF_SITE_ADDR_STREET", "");
define("CONF_SITE_ADDR_NUMBER", "");
define("CONF_SITE_ADDR_COMPLEMENT", "");
define("CONF_SITE_ADDR_CITY", "");
define("CONF_SITE_ADDR_STATE", "");
define("CONF_SITE_ADDR_ZIPCODE", "");

/**
 * SOCIAL
 */
define("CONF_SOCIAL_TWITTER_CREATOR", "");
define("CONF_SOCIAL_TWITTER_PUBLISHER", "");
define("CONF_SOCIAL_FACEBOOK_APP", "626590460695980");
define("CONF_SOCIAL_FACEBOOK_PAGE", "");
define("CONF_SOCIAL_FACEBOOK_AUTHOR", "");
define("CONF_SOCIAL_GOOGLE_PAGE", "");
define("CONF_SOCIAL_GOOGLE_AUTHOR", "");
define("CONF_SOCIAL_INSTAGRAM_PAGE", "");
define("CONF_SOCIAL_TWITTER_PAGE", "");

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_BR2", "d/m/Y");
define("CONF_DATE_APP", "Y-m-d H:i:s");
define("CONF_DATE_MY", "m/Y");
/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 6);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);


/**
 * VIEW
 */
define("CONF_VIEW_PATH", __DIR__ . "/../../shared/views");
define("CONF_VIEW_ADMIN", __DIR__ . "/../../themes/admin");
define("CONF_VIEW_THEME_ADMIN", "admin");
define("CONF_VIEW_EXT", "php");


/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * MAIL
 */

define("CONF_MAIL_HOST", "smtp-relay.sendinblue.com");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_USER", "sistema@okotech.com.br");
define("CONF_MAIL_PASS", "3NXDGEbVq4aShx2y");
define("CONF_MAIL_SENDER", ["name" => "Sistema Cred", "address" => "sistema@okotech.com.br"]);
define("CONF_MAIL_SUPPORT", "sistema@okotech.com.br");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

/**
 * Data Sources
 */
define("CREDILINK_API_HOST", "https://consulta.confirmeonline.com.br/Integracao/Consulta?wsdl");
define("CREDILINK_API_USER", "INTACINE");
define("CREDILINK_API_PASS", "9rbOlBJn");
define("CREDILINK_API_SECRET", "HUQNQ");