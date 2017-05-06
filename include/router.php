<?php

define('USER_ROUTE', '{home}.php');
define('GUEST_ROUTE', '{splash}.php');

function sentry($__FILE__)
{
    $__FILE__ = basename($__FILE__);

    applog("Sentry check by $__FILE__");
    
    if ($__FILE__ == $_SESSION['route']) {
        applog("   (permitted)");
        $_SESSION['route'] = false;
        return; // permit program flow
    }
    
    applog("   (rerouted)");
    
    route($_SESSION['user'] ? USER_ROUTE : GUEST_ROUTE);
    exit;
}

function route($route)
{
    applog("Routed to $route");
    if (".php" != substr($route, -4)) {$route .= ".php";}
    $_SESSION['route'] = $route;
    require $route;
    exit;
}
