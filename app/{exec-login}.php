<?php

require 'app.php';
sentry(__FILE__);

$_SESSION['user'] = $_REQUEST['email'];

route();
