<?php

require "app.php";
sentry(__FILE__);

// assume $_REQUEST is populated with unvalidated data

$_REQUEST["first_name"] = trim($_REQUEST["first_name"]);
$_REQUEST["last_name"]  = trim($_REQUEST["last_name"]);
$_REQUEST["email"]      = trim($_REQUEST["email"]);

$_REQUEST["*VALIDATION*"] = [
    "first_name" => [],
    "last_name"  => [],
    "email"      => [],
    "password"   => [],
];

$V = &$_REQUEST["*VALIDATION*"];

if (!$_REQUEST["first_name"]) {$V["first_name"][] = "Please enter first name.";}
if (!$_REQUEST["last_name"]) {$V["last_name"][] = "Please enter last name.";}
if (!$_REQUEST["email"]) {$V["email"][] = "Please enter email address.";}

    if ((bool) $_REQUEST["email"]) {
        // prevent duplicate email address
        $email  = $db->lexify("'" . $_REQUEST["email"]); //FIXME ugly
        $result = $db->table_select("user", "*", "email = {$email}");
        if (count($result) > 0) {
            $V["email"][] = "Email Address already in use.";
        }
    }

    foreach ($_REQUEST["*VALIDATION*"] as $_ => $problems) {
        if ($problems) {route("{register}");}
    }

    $data = [
        "id"         => " NULL",
        "first_name" => "'" . $_REQUEST["first_name"],
        "last_name"  => "'" . $_REQUEST["last_name"],
        "email"      => "'" . $_REQUEST["email"],
        "password"   => "'" . $_REQUEST["password"],
    ];

    $db->table_insert("user", $data);

    $_REQUEST = ["email" => $_REQUEST["email"]];
    route("{login}");
