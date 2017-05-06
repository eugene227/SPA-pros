<?php

function event_handler()
{
    return "http://"
    . $_SERVER["HTTP_HOST"]
    . dirname($_SERVER["SCRIPT_NAME"])
        . "/event.php";
}

function event_encoding($event)
{
    return "{&quot;{$event}&quot;:null}";
}

function onclick_attribute($event) {
    return sprintf(
        "onclick='post(\"%s\",%s)'",
        event_handler(),
        event_encoding($event));
}

function onclick($event)
{
    echo onclick_attribute($event);
}
