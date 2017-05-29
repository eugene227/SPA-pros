
function openAccordions(id) {
    var element = document.getElementById(id);
    //if class exists then remove it and return false, if not, then add it and return true.
	element.classList.toggle("w3-show") ? element.classList.toggle("w3-hide") : element.classList.toggle("w3-hide");
} //end of function




function openTab(evt, tabName) {
    var i, x, tablinks;
    //display no content of any tab
    x = document.getElementsByClassName("homeTabs");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    //don't have any red bars under the tabs
    tablinks = document.getElementsByClassName("tablink");

    for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
    }
  
    //show the content of the clicked tab
    document.getElementById(tabName).style.display = "block";
    //add the class "w3-border-red" to make the tab bar a red color
    evt.currentTarget.firstElementChild.className += " w3-border-red";
} //end of function





function openReviewTab(evt, tabName) {
    var i, x;
    //display no content of any tab
    x = document.getElementsByClassName("reviewTabs");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    } //end of loop
    //show the content of the clicked tab
    document.getElementById(tabName).style.display = "block";
} //end of function




function openSurveyItems(evt, tabName) {
    var i, x;
    //display no content of any tab
    x = document.getElementsByClassName("surveyItems");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    } //end of loop
    //show the content of the clicked tab
    document.getElementById(tabName).style.display = "block";
} //end of function




function w3_open(id) {
    document.getElementById(id).style.display = "block";
} //end of function



function w3_close(id) {
    document.getElementById(id).style.display = "none";
} //end of function
