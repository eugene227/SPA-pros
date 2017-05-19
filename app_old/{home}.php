<?php
require "app.php";
sentry(__FILE__);

$title = "DEVELOPMENT Home2";
require "compose/HTML_head.php";
?>

<!--CONTAINER OF ALL-->
<div class="w3-row w3-mobile" style="width:100%">

    <!--BAR-BLOCK columns-->
    <div class="w3-col w3-hide-medium w3-hide-small" style="width:7%">

         <div class="w3-bar-block w3-light-blue w3-center">
         
         
             <div class="tooltip">
                <button class="w3-button w3-bar-item w3-hover-light-blue" >
                    <i style="font-size:350%" class=" w3-margin-bottom w3-margin-top fa fa-file-text-o" tabindex="1"></i>
                    <span class="tooltiptext">My Surveys</span>
                </button>
            </div>  
            
        
             <div class="tooltip">
                <button class="w3-button w3-bar-item w3-hover-light-blue" >
                    <i style="font-size:350%" class=" w3-margin-bottom w3-margin-top fa fa-pencil-square-o" tabindex="1"></i>
                    <span class="tooltiptext">Evaluations</span>
                </button>
            </div>  
            
             <div class="tooltip">
                <button class="w3-button w3-bar-item w3-hover-light-blue" >
                    <i style="font-size:350%" class=" w3-margin-bottom w3-margin-top fa fa-calendar" tabindex="1"></i>
                    <span class="tooltiptext">Calender</span>
                </button>
            </div>  
            
             <div class="tooltip">
                <button class="w3-button w3-bar-item w3-hover-light-blue" >
                    <i style="font-size:350%" class=" w3-margin-bottom w3-margin-top    fa fa-sign-out" tabindex="1"></i>
                    <span class="tooltiptext">Log out</span>
                </button>
                
            </div>  
            
            
                        
            
            
                        
        </div> 
                
    <!--END OF >>>> BAR-BLOCK columns-->
    </div>
    
    
<!--    SIDE BAR MENU - ONLY IN MOBILE VIEW-->
    <div class="w3-sidebar w3-bar-block w3-white w3-animate-right" style="display:none;z-index:4;right:0" id="mySidebar">
      <button class="w3-bar-item w3-white" onclick="w3_close()"><span class="w3-red w3-xlarge w3-right w3-padding">&times;</span></button>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-file-text-o" style="font-size:100%"></i>   My Surveys</a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-pencil-square-o" style="font-size:100%"></i>   Evaluations</a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-calendar" style="font-size:100%"></i>   Calender</a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-sign-out" style="font-size:100%"></i>   Log out</a>
    </div>
    
    
    
    
    
    
    
    <!--MAIN CONTENT column-->
    <div class="w3-col w3-container w3-mobile" style="width:93%">
    
        <!--HEADER  +  BUTTON  +  FA-BARS ☰  +  SPACE-->
        <div class="w3-row w3-white" style="width:100%">
            <div class="w3-col w3-border-bottom w3-border-grey" style="width:100%">
            
                <!--new row for "Create New" button and screen title-->
                <div class="w3-row w3-white" style="width:100%">
                
                    <div class="w3-col" style="width:50%">
                        <p class="w3-xxlarge w3-margin-left">Lorem ipsum dor</p>
                    </div>
                    
                    <br><br>
                    
                    <div class="w3-col" style="width:50%">
                        
                        <button class="w3-btn  w3-circle w3-light-blue w3-xlarge w3-left">+</button>

                        
                        <!--HAMBURGER MENU - ONLY IN TABLET AND MOBILE VIEW-->
                        <i class="fa fa-bars w3-text-orange w3-right w3-xxlarge w3-hide-large" tabindex="1"  onclick="w3_open()"></i>
                        <!--END OF >>>> HAMBURGER MENU-->
                        
                        
                    </div>
                    
                    
                </div>
                <!--new row creating survey-->
                
                
                
            </div>

        </div>
        <!--END OF >>>> HEADER  +  BUTTON  +  FA-BARS ☰  +  SPACE-->






        <!--ACCORODIAN  +  TO DO  +  FEEDBACK-->
        <div class="w3-row w3-panel" style="width:100%">
        
        
        <!--ACCRODIAN CONTAINER-->
            <div class="w3-col w3-mobile" style= "width:57%">
            
                <!--ACCRODIAN #1-->
                <div class="w3-row w3-margin-top w3-border-top w3-border-bottom w3-padding" style="width:100%">
                
                    <!--SURVEY TITLE-->
                    <div class="w3-col" style="width:35%">
                        <p class="w3-large">Lorem ipsum dor</p>
                    </div>
                    
                    <!--SURVEY BUTTONS-->
                    <div class="w3-col w3-bar" style="width:45%">
                        <!--PREVIEW SURVEY BUTTON-->
                        <div class="w3-bar-item">
                            <i style="font-size:130%" class="fa fa-eye"></i>
                        </div>
                        <!--EDIT SURVEY BUTTON-->
                        <div class="w3-bar-item">
                            <i style="font-size:130%" class="fa fa-pencil"></i>
                        </div>
                        <!--DELETE SURVEY BUTTON-->
                        <div class="w3-bar-item">
                            <i style="font-size:130%" class="fa fa-trash-o"></i>
                        </div>
                        
                        
                    </div>
                    
                    <!--SEE MORE BUTTON-->
                    <div class="w3-col" style="width:20%">
                        <a onclick="openAccordions('Survey1')" class="w3-text-blue w3-large w3-center">SEE MORE  <i style="font-size:100%" class="w3-text-black fa  fa-sort-down"></i></a>
                    </div>
                
                
                </div>
                <!--END OF >>>> ACCRODIAN #1-->
            
                
                
                <!--CONTENT TO SHOW/HIDE-->
                <div id="Survey1" class="w3-container w3-hide w3-animate-opacity">

                    <ul class="w3-ul w3-padding">
                        <li><i style="font-size:100%" class="fa fa-tachometer"></i><strong>    Status:</strong> Lorem ipsum dor</li>
                        <li><i style="font-size:100%" class="fa fa-clock-o"></i><strong>   Acceptance Deadline:</strong> Lorem ipsum dor</li>
                        <li><i style="font-size:100%" class="fa fa-calendar"></i><strong>     Active Timeframe:</strong> Lorem ipsum dor</li>
                        <li><i style="font-size:100%"></i><strong>     Description:</strong><br> Lorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dor</li>
                    </ul>

                </div>
                
                
                
                
                
                <!--ACCRODIAN #1-->
                <div class="w3-row w3-margin-top w3-border-top w3-border-bottom w3-padding" style="width:100%">
                
                    <!--SURVEY TITLE-->
                    <div class="w3-col" style="width:35%">
                        <p class="w3-large">Lorem ipsum dor</p>
                    </div>
                    
                    <!--SURVEY BUTTONS-->
                    <div class="w3-col w3-bar" style="width:45%">
                        <!--PREVIEW SURVEY BUTTON-->
                        <div class="w3-bar-item">
                            <i style="font-size:130%" class="fa fa-eye"></i>
                        </div>
                        <!--EDIT SURVEY BUTTON-->
                        <div class="w3-bar-item">
                            <i style="font-size:130%" class="fa fa-pencil"></i>
                        </div>
                        <!--DELETE SURVEY BUTTON-->
                        <div class="w3-bar-item">
                            <i style="font-size:130%" class="fa fa-trash-o"></i>
                        </div>
                        
                        
                    </div>
                    
                    <!--SEE MORE BUTTON-->
                    <div class="w3-col" style="width:20%">
                        <a onclick="openAccordions('Survey2')" class="w3-text-blue w3-large w3-center">SEE MORE  <i style="font-size:100%" class="w3-text-black fa  fa-sort-down"></i></a>
                    </div>
                
                
                </div>
                <!--END OF >>>> ACCRODIAN #2-->
            
                
                
                <!--CONTENT TO SHOW/HIDE-->
                <div id="Survey2" class="w3-container w3-hide w3-animate-opacity">

                    <ul class="w3-ul w3-padding">
                        <li><i style="font-size:100%" class="fa fa-tachometer"></i><strong>    Status:</strong> Lorem ipsum dor</li>
                        <li><i style="font-size:100%" class="fa fa-clock-o"></i><strong>   Acceptance Deadline:</strong> Lorem ipsum dor</li>
                        <li><i style="font-size:100%" class="fa fa-calendar"></i><strong>     Active Timeframe:</strong> Lorem ipsum dor</li>
                        <li><i style="font-size:100%"></i><strong>     Description:</strong><br> Lorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dorLorem ipsum dor</li>
                    </ul>

                </div>
                
                
                
                
            
            
            </div>
            
            <!--END OF >>>> ACCRODIANS CONTAINER--> 
            
            
            
            
            
            <!--TO DO  +  FEEDBACK TABS CONTAINER-->
            <div class="w3-col w3-mobile" style="width:43%">
            
            <!--extra space in MOBILE VIEW-->
            <div class="w3-hide-medium w3-hide-large"><br><br></div>
            
            
              <div class="w3-container ">
             
                <!--TABS row-->
                  <div class="w3-row">
                  
                    <!--TO DO TAB LINK-->
                    <a href="javascript:void(0)" onclick="openTab(event, 'todo');">
                      <div class="w3-half tablink w3-bottombar w3-border-red w3-hover-light-grey w3-padding w3-large" >To do<span class="w3-badge w3-green w3-large w3-right">3</span></div>
                    </a>
                    <!--END OF >>>>> TO DO TAB LINK-->
                    
                    
                    
                    
                    <!--RECENT FEEDBACK TAB LINK-->
                    <a href="javascript:void(0)" onclick="openTab(event, 'feedback');">
                      <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-padding w3-large">Feedback<span class="w3-badge w3-green w3-large w3-right">1</span></div>
                    </a>
                    <!--END OF >>>>> RECENT FEEDBACK TAB LINK-->
                    
                    
                    
                  </div>
                <!--END OF >>>> TABS row-->
                
                
                
                <!--CONTENT FOR TO DO TAB -->
                  <div id="todo" class="w3-container city">
                    <ul class="w3-ul">
                        <li class="w3-padding-16">
                          <span onclick="this.parentElement.style.display='none'"
                          class="w3-button w3-white w3-xlarge w3-right">&times;</span>
                          <i style="font-size:150%" class="fa fa-calendar"></i>
                          <span class="w3-large">CONFIRM SURVEY PROPOSAL - title of survey</span><br>
                          <span>Overseerer: </span><span>16 peers • Deadline: June 23</span>
                        </li>
                        
                        <li class="w3-padding-16">
                          <span onclick="this.parentElement.style.display='none'"
                          class="w3-button w3-white w3-xlarge w3-right">&times;</span>
                          <i style="font-size:150%" class="fa fa-calendar"></i>
                          <span class="w3-large">CONFIRM SURVEY PROPOSAL - title of survey</span><br>
                          <span>Overseerer: </span><span>16 peers • Deadline: June 23</span>
                        </li>
                        
                        <li class="w3-padding-16">
                          <span onclick="this.parentElement.style.display='none'"
                          class="w3-button w3-white w3-xlarge w3-right">&times;</span>
                          <i style="font-size:150%" class="fa fa-calendar"></i>
                          <span class="w3-large">CONFIRM SURVEY PROPOSAL - title of survey</span><br>
                          <span>Overseerer: </span><span>16 peers • Deadline: June 23</span>
                        </li>


                    </ul>
                  </div>
                  <!--END OF >>>>> CONTENT FOR TO DO TAB -->
                  
                  
                  
                  
                  <!--CONTENT FOR RECENT FEEDBACK TAB -->
                  <div id="feedback" class="w3-container city" style="display:none">
                
                    <ul class="w3-ul">
                        <li class="w3-padding-16">
                          <span onclick="this.parentElement.style.display='none'"
                          class="w3-button w3-white w3-xlarge w3-right">&times;</span>
                          <i style="font-size:150%" class="fa fa-calendar"></i>
                          <span class="w3-large">CONFIRM SURVEY PROPOSAL - title of survey</span><br>
                          <span>Overseerer: </span><span>16 peers • Deadline: June 23</span>
                        </li>
                        
    


                    </ul>
                
                
                
                
                  </div>
                  <!--END OF >>>>> CONTENT FOR RECENT FEEDBACK TAB -->

                </div>
                <!--END OF >>>>> "w3-contaner"-->
            
            <div class="w3-center w3-border-top w3-padding w3-margin-top w3-container" style="width:100%">
                <a class=" w3-text-light-blue w3-large">SHOW MORE</a><br><i style="font-size:200%" class="fa fa-sort-down w3-text-blue"></i>
            </div>
            
            </div>
            <!--END OF >>>> TO DO  +  FEEDBACK TABS CONTAINER-->
            
        </div>
        <!--END OF >>>> ACCRODIAN  +  TO DO  +  FEEDBACK-->
    

    <!--END OF >>>> MAIN CONTENT column-->
    </div>
    
<!--END OF >>>> CONTAINER OF ALL--> 
</div>


<?php
require "compose/HTML_foot.php";

