<?php
require "app.php";
sentry(__FILE__);

$title = "DEVELOPMENT Register";
require "compose/HTML_head.php";
?>

<div class="w3-bar w3-border w3-light-blue w3-xlarge">
    <span class="w3-bar-item w3-left">
        <?php echo basename(__FILE__); ?>
    </span>
</div>


<?php
//==============================================================================
$validation   = array_key_exists("*VALIDATION*", $_REQUEST);
$problem_list = $validation ? flatten_values($_REQUEST["*VALIDATION*"]) : [];

if ($problem_list) {
    echo "<div class=\"w3-container w3-red\">";
    foreach ($problem_list as $_ => $problem) {
        echo "<h4>{$problem}</h4>";
    }
    echo "</div>";
}

$first_name = &$_REQUEST["first_name"];
$last_name  = &$_REQUEST["last_name"];
$email      = &$_REQUEST["email"];
$password   = &$_REQUEST["password"];
//==============================================================================
?>

<form class="w3-container" method="post" action="event.php">
    <label class="w3-text-teal"><b>First Name</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="first_name"
        value="<?php echo htmlentities($first_name); ?>">
    <label class="w3-text-teal"><b>Last Name</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="last_name"
        value="<?php echo htmlentities($last_name); ?>">
    <label class="w3-text-teal"><b>Email</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="email"
        value="<?php echo htmlentities($email); ?>">
    <label class="w3-text-teal"><b>Password</b></label>
    <input class="w3-input w3-border w3-light-grey" type="password" name="password"
        value="<?php echo htmlentities($password); ?>">
    <button class="w3-btn w3-blue-grey w3-right" name="{exec-register}">Register</button>
</form>

<?php

require "compose/HTML_foot.php";
