<?php
require "app.php";
sentry(__FILE__);
$title = "DEVELOPMENT Login";
require "compose/HTML_head.php";
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

<div class="w3-row">
    
        <!--extra space on the LEFT side (only for medium and large screens)--> 
      <div class="w3-col w3-container w3-hide-small" style="width:20%"></div>
      
      
    
      
    <div class="w3-col w3-container w3-mobile" style="width:60%">
      
                              
                    <!--BLUE HEADER STARTS HERE-->    
                              
            <header class="w3-blue w3-card-4">

                <h3 class="w3-xlarge w3-padding">Log into Account</h3>

            </header>
    
                    <!--BLUE HEADER ENDS HERE-->
            
            
            
            
            <!--START of card container-->
      
          <form class="w3-container w3-card-4" method="post" action="event.php"> 

            <p class="w3-large">Email</p>
            <input class="w3-input w3-animate-input" autofocus required autocomplete="on" type="email" style="width:60%" tabindex="1" name="email" value="<?php echo htmlentities($email); ?>">

            <p class="w3-large">Enter Password</p>
            <input class="w3-input w3-animate-input" autocomplete="off" type="password" style="width:60%" tabindex="2" required name="password" value="<?php echo htmlentities($password); ?>">

            <button type="submit" class="w3-btn w3-right w3-padding w3-margin w3-green" tabindex="3" name="{exec-login}">Log In</button>
            
        
         </form><!--END of card container-->
      
      
      </div><!--end of 60% width container-->
      
      
      <!--extra space on the RIGHT side (only for medium and large screens)-->  
      <div class="w3-col w3-container w3-hide-small" style="width:20%"></div>
      
</div>

<?php
require "compose/HTML_foot.php";