<?php

require 'app.php';

sentry(__FILE__);

$_SESSION['user'] = '';

route('_login.php');
