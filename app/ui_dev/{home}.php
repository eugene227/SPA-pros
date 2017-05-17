<?php
require "app.php";
sentry(__FILE__);

$title = "DEVELOPMENT Home";
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
</div>

<div class="w3-bar w3-black">
    <button class="w3-bar-item w3-button tablink w3-teal"
     onclick="openHomeTab(event,'ToPeers')">To Peers</button>
    <button class="w3-bar-item w3-button tablink"
     onclick="openHomeTab(event,'FromPeers')">From Peers</button>
    <button class="w3-bar-item w3-button tablink"
     onclick="openHomeTab(event,'AsOverseer')">As Overseer</button>
    <button class="w3-bar-item w3-button tablink"
     onclick="openHomeTab(event,'MyAssets')">My Assets</button>
</div>

<div id="ToPeers" class="tab" style="display:block">
    <div class="w3-container w3-teal">
        <h3>Evaluations</h3>
        <p>[List of pending evaluations to complete.]</p>
    </div>
</div>

<div id="FromPeers" class="tab" style="display:none">
    <div class="w3-container w3-teal">
        <h3>Feedback</h3>
        <p>[Evaluations I've received from peers.]</p>
    </div>
</div>

<div id="AsOverseer" class="tab" style="display:none">
    <div class="w3-container w3-teal">
        <h3>Surveys In Progress</h3>
        <p>[List of surveys overseen by user.]</p>
    </div>
    <div class="w3-container w3-teal">
        <h3>Text Analysis Warnings</h3>
        <p>[List of text analysis warnings.]</p>
    </div>
</div>

<div id="MyAssets" class="tab" style="display:none">
    <div class="w3-container w3-teal">
        <h3>Surveys</h3>
        <p>[List of available surveys.]</p>
    </div>
    <div class="w3-container w3-teal">
        <h3>Questions</h3>
        <p>[List of available questions.]</p>
    </div>
    <div class="w3-container w3-teal">
        <h3>Choice Lists</h3>
        <p>[List of available choice lists.]</p>
    </div>
</div>

<script>

function openHomeTab(evt, tabName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("tab");
  for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-teal", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " w3-teal";
}

</script>

  



<?php
require "compose/HTML_foot.php";
