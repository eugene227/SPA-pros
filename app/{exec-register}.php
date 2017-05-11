<?php

error_reporting(-1); // Report all PHP errors (E_ALL)
ini_set("display_errors", true);
ini_set("log_errors", false);

require "app.php";
// sentry(__FILE__);

// echo dump("running {er}"); // DEBUG

// $_REQUEST["first_name"] = " ";
// $_REQUEST["last_name"]  = "User     ";
// $_REQUEST["email"]      = "au@gold.net";
// $_REQUEST["password"]   = " topsecret ";

$_REQUEST["first_name"] = trim($_REQUEST["first_name"]);
$_REQUEST["last_name"]  = trim($_REQUEST["last_name"]);
$_REQUEST["email"]      = trim($_REQUEST["email"]);
// $_REQUEST["password"]   = $_REQUEST["password"];

$_REQUEST["*LABEL*"] = [
    "first_name" => "First Name",
    "last_name"  => "Last Name",
    "email"      => "Email Address",
    "password"   => "Password",
];

$_REQUEST["*EMPTY_MSG*"] = [
    "first_name" => "Please enter your first name.",
    "last_name"  => "Please enter your last name.",
    "email"      => "Please enter your email address.",
    "password"   => "Please specify a password.",
];

$_REQUEST["*VALID*"] = [
    "first_name" => (!!$_REQUEST["first_name"]),
    "last_name"  => (!!$_REQUEST["last_name"]),
    "email"      => (!!$_REQUEST["email"]),
    "password"   => true,
];

// echo dump($_REQUEST); // DEBUG

$valid = true;

foreach ($_REQUEST["*VALID*"] as $_ => $valid) {
    if (!$valid) {
        route("{dev-register}");
    }
}

$_REQUEST = []; // FIXME (a better way to handle this?)

route("{dev-login}");
