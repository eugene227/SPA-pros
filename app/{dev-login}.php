<?php
require "app.php";
sentry(__FILE__);
$title = "DEVELOPMENT Login";
require "compose/HTML_head.php";
?>
<div class="w3-bar w3-border w3-light-blue w3-xlarge">
    <span class="w3-bar-item w3-left">[Login]</span>
</div>
<div class="w3-container w3-teal">
    <h3>Login Form</h3>
</div>
<form class="w3-container" method="post" action="event.php">
    <label class="w3-text-teal"><b>Email</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="email">
    <label class="w3-text-teal"><b>Password</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="password">
    <button class="w3-btn w3-blue-grey" name="{exec-login}">Login</button>
</form>

<?php
require "compose/HTML_foot.php";