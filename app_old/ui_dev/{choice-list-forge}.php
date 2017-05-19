<?php
require "app.php";
// sentry(__FILE__);

$title = "DEVELOPMENT Choice List Forge";
require "compose/HTML_head.php";
?>

<div class="w3-bar w3-border w3-light-blue w3-xlarge">
    <span class="w3-bar-item w3-left">
        <?php echo basename(__FILE__); ?>
    </span>
    <span class="w3-bar-item"><?php echo "[{$_SESSION["user"]}]"; ?></span>
    <span class="w3-bar-item w3-button w3-hover-blue w3-right"
        <?php onclick("{exec-logout}");?> >
        Logout
    </span>
    <span class="w3-bar-item w3-button w3-hover-blue w3-right"
        <?php onclick("{home}");?> >
        Home
    </span>
</div>

<?php
$id      = "126";
$version = "a timestamp";
$list    = "A,B,C,D,F";
?>

<form class="w3-container" method="post" action="event.php">
    <label class="w3-text-teal"><b>ID</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="id"
        readonly
        value="<?php echo htmlentities($id); ?>">
    <label class="w3-text-teal"><b>Version</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="version"
        readonly
        value="<?php echo htmlentities($version); ?>">
    <label class="w3-text-teal"><b>Choice List (CSV)</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="list"
        value="<?php echo htmlentities($list); ?>">

    <div class="w3-bar w3-white w3-large">
        <span class="w3-bar-item w3-button w3-light-blue w3-hover-blue w3-right"
            <?php onclick("{exec-choice-list-delete}");?> >
            Delete
        </span>
        <span class="w3-bar-item w3-button w3-light-blue w3-hover-blue w3-right"
            <?php onclick("{exec-choice-list-save}");?> >
            Save
        </span>
    </div>
</form>


<?php
require "compose/HTML_foot.php";
