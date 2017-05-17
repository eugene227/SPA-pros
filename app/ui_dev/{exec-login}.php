<?php
require "app.php";
sentry(__FILE__);

// assume $_REQUEST is populated with unvalidated data

$_REQUEST["email"] = trim($_REQUEST["email"]);

$_REQUEST["*VALIDATION*"] = [
    "email"    => [],
    "password" => [],
];

if ($_REQUEST["email"]) {
    // verify email esists
    $email  = $db->lexify("'" . $_REQUEST["email"]); //FIXME ugly
    $result = $db->table_select("user", "password", "email = {$email}");
    if (count($result) != 1) {
        $_REQUEST["*VALIDATION*"]["email"][] = "Email Address not registered.";
        route("{login}");
    }
    if ($result[0]["password"] != $_REQUEST["password"]) {
        $_REQUEST["*VALIDATION*"]["password"][] = "Incorrect password.";
        route("{login}");
    }
} else {
    $_REQUEST["*VALIDATION*"]["email"][] = "Please enter email address.";
    route("{login}");
}

$_SESSION["user"] = $_REQUEST["email"];
$_REQUEST = [];
route();
