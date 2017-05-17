function post(path, params) {
    // alert(path);
    // alert(params);
    // return;
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", path);
    for (var key in params) {
        if (params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
    }
    document.body.appendChild(form);
    form.submit();
}

function openAccordions(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
} //end of function

function openTab(evt, tabName) {
    var i, x, tablinks;
    //display no content of any tab
    x = document.getElementsByClassName("city");
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

function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
} //end of function

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
} //end of function