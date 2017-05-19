<?php

ini_set("error_reporting", E_ALL); // report all PHP errors
ini_set("display_errors", true);
ini_set("log_errors", false);

require_once "include/extend.php";
require_once "include/applog.php";

if (PHP_SESSION_NONE == session_status()) {
    session_start();
    applog("=== SESSION START ===");
}

if (!array_key_exists("user", $_SESSION)) {$_SESSION["user"] = "";}
if (!array_key_exists("route", $_SESSION)) {$_SESSION["route"] = "";}

require_once "include/router.php";
require_once "include/events.php";

require_once "db/db.php";

$PROS_PASSWORD ="wet71tech";
$PROS_PASSWORD ="team3password";
if (!isset($db)) {$db = (new PROS($PROS_PASSWORD))->use_database("pros");}
