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

<div class="w3-container w3-teal">
    <h3>Registration Form</h3>
</div>

<?php

// echo dump($_REQUEST); // DEBUG

$validation = (array_key_exists("*VALID*", $_REQUEST));

$first_name = ($validation) ? $_REQUEST["first_name"] : "";
$last_name  = ($validation) ? $_REQUEST["last_name"] : "";
$email      = ($validation) ? $_REQUEST["email"] : "";
$password   = ($validation) ? $_REQUEST["password"] : "";

if ($validation) {
    echo "<div class=\"w3-container w3-red\">";
    foreach ($_REQUEST["*VALID*"] as $input => $valid) {
        if ($valid) {continue;}
        echo "<h4>";
        echo $_REQUEST["*EMPTY_MSG*"][$input];
        echo "</h4>";
    }
    echo "</div>";
}
?>

<form class="w3-container">
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
    <input class="w3-input w3-border w3-light-grey" type="text" name="password"
        value="<?php echo htmlentities($password); ?>">
    <button class="w3-btn w3-blue-grey" name="{exec-register}">Register</button>
</form>

<?php

unset($_SESSION["exec_register"]);

require "compose/HTML_foot.php";
