<?php

error_reporting(-1); // Report all PHP errors (E_ALL)
ini_set("display_errors", true);
ini_set("log_errors", false);

require "app.php";
sentry(__FILE__);

$_REQUEST["email"] = trim($_REQUEST["email"]);
// $_REQUEST["password"]   = $_REQUEST["password"];

$_REQUEST["*LABEL*"] = [
    "email"    => "Email Address",
    "password" => "Password",
];

$_REQUEST["*EMPTY_MSG*"] = [
    "email"    => "Please enter your email address.",
    "password" => "Incorrect email or password.",
];

$_REQUEST["*VALID*"] = [
    "email"    => (!!$_REQUEST["email"]),
    "password" => true,
];

$valid = true;

foreach ($_REQUEST["*VALID*"] as $_ => $valid) {
    if (!$valid) {
        route("{dev-login}");
    }
}

// FIXME
// BETTER PASSWORD CHECKING LOGIC HERE!

if ("bad" == $_REQUEST["password"]) {
    $_REQUEST["*VALID*"] = [
        "email"    => true,
        "password" => false,
    ];
    route("{dev-login}");
}

$_SESSION["user"] = $_REQUEST["email"];
    
route("{dev-home}");
