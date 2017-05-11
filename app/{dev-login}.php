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

<div class="w3-container w3-teal">
    <h3>Login Form</h3>
</div>

<?php

// echo dump($_REQUEST); // DEBUG

$validation = (array_key_exists("*VALID*", $_REQUEST));

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

<form class="w3-container" method="post" action="event.php">
    <label class="w3-text-teal"><b>Email</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="email"
        value="<?php echo htmlentities($email); ?>">
    <label class="w3-text-teal"><b>Password</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="password"
        value="<?php echo htmlentities($password); ?>">
    <button class="w3-btn w3-blue-grey w3-right" name="{exec-login}">Login</button>
</form>

<?php

require "compose/HTML_foot.php";
