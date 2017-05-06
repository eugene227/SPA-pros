<?php

require "app.php";

// echo dump($_REQUEST); //DEBUG

$method = strtoupper($_SERVER["REQUEST_METHOD"]);
switch ($method) {
    case "GET":
        return dispatch($_GET);
    case "POST":
        return dispatch($_POST);
    case "PUT":
        return "PUT?";
    case "HEAD":
        return "HEAD?";
    default:
        return "Unknown \$_SERVER[\"REQUEST_METHOD\"]) = \"$method\"";
}

function dispatch($request)
{
    echo dump($request);
    $event = "{splash}";

    foreach ($request as $key => $_) {
        if ("{" != substr($key, 0, 1)) {continue;}
        // if ("}" != substr($key, -1)) {continue;}
        $event = $key;
        break;
    }
    route($event);
    exit;
}
