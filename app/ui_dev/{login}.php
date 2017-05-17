<?php
require "app.php";
sentry(__FILE__);

$title = "DEVELOPMENT Login";
require "compose/HTML_head.php";
?>

<div class="w3-bar w3-border w3-light-blue w3-xlarge">
    <span class="w3-bar-item w3-left">
        <?php echo basename(__FILE__); ?>
    </span>
</div>

<?php
//==============================================================================
$validation = array_key_exists("*VALIDATION*", $_REQUEST);
$problem_list = $validation ? flatten_values($_REQUEST["*VALIDATION*"]) : [];

if ($problem_list) {
    echo "<div class=\"w3-container w3-red\">";
    foreach ($problem_list as $_ => $problem) {
        echo "<h4>{$problem}</h4>";
    }
    echo "</div>";
}

$email      = &$_REQUEST["email"];
$password   = &$_REQUEST["password"];
//==============================================================================
?>

<form class="w3-container" method="post" action="event.php">
    <label class="w3-text-teal"><b>Email</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="email"
        value="<?php echo htmlentities($email); ?>">
    <label class="w3-text-teal"><b>Password</b></label>
    <input class="w3-input w3-border w3-light-grey" type="password" name="password"
        value="<?php echo htmlentities($password); ?>">
    <button class="w3-btn w3-blue-grey w3-right" name="{exec-login}">Login</button>
</form>

<?php

require "compose/HTML_foot.php";
