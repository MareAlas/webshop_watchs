<?php 
// Marko Markovic markovicm.1403@gmail.com 

// webshop_watches

ob_start();

session_start();
// session_destroy();

define("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

define("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__.DS."templates/front");
define("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__.DS."templates/back");

define("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__.DS."uploads");

/*
define("DB_HOST") ? null : define("DB_HOST", "localhost");
define("DB_USER") ? null : define("DB_USER", "zoranp"); // root
define("DB_PASS") ? null : define("DB_PASS", "");
define("DB_NAME") ? null : define("DB_NAME", "stete ");  // ecom_db // stete
*/
define("DB_HOST", "localhost");
define("DB_USER", "zoranp");
define("DB_PASS", "");
define("DB_NAME", "amso");

// $connection = pg_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// radi conn_amso
$conn_amso = pg_connect("host=localhost dbname=amso user=zoranp");

require_once("functions.php");
require_once("cart.php");

?>