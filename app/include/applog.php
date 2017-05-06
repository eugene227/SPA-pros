<?php

function new_logtime()
{
    usleep(1);
    $part = explode(" ", microtime());
    $w3c  = date(DATE_W3C, $part[1]);
    return substr($w3c, 0, -6) . substr($part[0], 1);
}

function applog($entry)
{
    $logtime = new_logtime();

    $_SESSION["applog"][$logtime] = $entry;

    show_log_entry($logtime); // DEBUG
}

function show_log_entry($logtime)
{
    $entry = $_SESSION["applog"][$logtime];
    show("[$logtime] $entry");
}

function show_log()
{
    foreach ($_SESSION['applog'] as $key => $_) {show_log_entry($key);}
}
