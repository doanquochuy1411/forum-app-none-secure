<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_name("forum-app-none-secure");
session_start();
require_once "./mvc/Bridge.php";
$myApp = new App();
?>