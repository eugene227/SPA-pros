<?php
header("content-type:application/json");

ini_set("error_reporting", E_ALL); // report all PHP errors
ini_set("display_errors", false);
ini_set("log_errors", true);
ini_set("error_log", "error_log.txt");

if (PHP_SESSION_NONE == session_status()) {session_start();}

if (!array_key_exists("user", $_SESSION)) {$_SESSION["user"] = "";}

require_once "db/db.php";

// $PROS_PASSWORD = "wet71tech";
$PROS_PASSWORD = "team3password";
$db            = (new PROS($PROS_PASSWORD))->use_database("pros");

// $db->init_database("pros", false);

$_REQUEST["STATUS"]  = "";
$_REQUEST["MESSAGE"] = [];

function SUCCEED($message = "")
{
    $_REQUEST["STATUS"] = "success";
    if ($message) {$_REQUEST["MESSAGE"][] = $message;}
    FINALIZE();
}

function FAIL($message = "")
{
    $_REQUEST["STATUS"] = "failure";
    if ($message) {$_REQUEST["MESSAGE"][] = $message;}
    FINALIZE();
}

function VALIDATE()
{
    if ("" != $_REQUEST["STATUS"]) {FINALIZE();}
}

function FAULT($message = "")
{
    $_REQUEST["STATUS"] = "failure";
    if ($message) {$_REQUEST["MESSAGE"][] = $message;}
}

function FINALIZE()
{
    echo json_encode($_REQUEST);
    exit;
}

/*=============*\
|    LANDING    |
\*=============*/

$DISPATCH["#landing .X_login"]    = null;
$DISPATCH["#landing .X_register"] = null;

/*==========*\
|    LOGIN   |
\*==========*/

$DISPATCH["#login .X_login"] = function ($db) {
    // $_REQUEST["email"] = trim($_REQUEST["email"]);

    if (!$_REQUEST["email"]) {
        FAIL("Please enter email address.");}

    $email  = $db->lexify("'" . $_REQUEST["email"]); //FIXME ugly
    $result = $db->table_select("user", "password", "email = {$email}");

    if (count($result) != 1) {
        FAIL("Email Address not registered.");}

    if ($result[0]["password"] != $_REQUEST["password"]) {
        FAIL("Incorrect password.");}

    $_SESSION["user"] = $_REQUEST["email"];
    SUCCEED();
};

/*=================*\
|    REGISTRATION   |
\*=================*/

$DISPATCH["#registration .X_register"] = function ($db) {
    if (!$_REQUEST["email"]) {
        FAULT("Please enter email address.");}
    if (!$_REQUEST["first_name"]) {
        FAULT("Please enter first name.");}
    if (!$_REQUEST["last_name"]) {
        FAULT("Please enter last name.");}
    if (!$_REQUEST["password"]) {
        FAULT("Please enter a password.");}
    if (!$_REQUEST["password2"]) {
        FAULT("Please enter a matching password.");}
    VALIDATE();

    if ($_REQUEST["password"] != $_REQUEST["password2"]) {
        FAIL("Passwords do not match.");}

    $email  = $db->lexify("'" . $_REQUEST["email"]); //FIXME ugly
    $result = $db->table_select("user", "password", "email = {$email}");

    if (count($result) == 1) {
        FAIL("Email Address already registered.");}

    $data = [
        "email"      => $_REQUEST["email"],
        "first_name" => $_REQUEST["first_name"],
        "last_name"  => $_REQUEST["last_name"],
        "password"   => $_REQUEST["password"],
    ];

    $_REQUEST["id"] = $db->table_insert("user", $data);

    SUCCEED();
};
/*============*\
|    REVIEWS   |
\*============*/

$DISPATCH["#reviews .X______"] = function ($db) {

    SUCCEED();
};

/*====================*\
|    D I S P A T C H   |
\*====================*/

$DISPATCH[$_REQUEST["action"]]($db);

SUCCEED();
