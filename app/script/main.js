var STATE = {};
STATE["purpose"] = "SPA state should be kept in STATE object";
//=================================================================
//  LANDING
//=================================================================
PAGE["landing"] = "#landing";
CLICK("#landing .X_login", function(json, status) { // CHECK
    hashUpdate("login");
});
CLICK("#landing .X_register", function(json, status) {
    hashUpdate("registration");
});
//=================================================================
//  LOGIN
//=================================================================
PAGE["login"] = "#login";
CLICK("#login .X_login", function(json, status) {
    // pout("#login .X_login");
    switch (status) {
        case "exec":
            // pout("exec");
            json["email"] = IVAL("#login .I_email");
            json["password"] = IVAL("#login .I_password");
            SEND(json);
            break;
        case "success":
            pout(json["email"] + " Logged In");
            pout("GO HOME");
            // GO("home");
            break;
        case "failure":
            for (message of json["MESSAGE"]) {
                pout(message);
            }
            pout("Registration Failed");
            break;
    }
});
//=================================================================
//  REGISTRATION
//=================================================================
PAGE["registration"] = "#registration";
CLICK("#registration .X_register", function(json, status) {
    // pout("#registration .X_register");
    switch (status) {
        case "exec":
            json["email"] = IVAL("#registration .I_email");
            json["password"] = IVAL("#registration .I_password");
            json["password2"] = IVAL("#registration .I_password2");
            json["first_name"] = IVAL("#registration .I_first_name");
            json["last_name"] = IVAL("#registration .I_last_name");
            SEND(json);
            break;
        case "success":
            pout(json["email"] + " Registered");
            jout(json);
            GO("landing|login");
            break;
        case "failure":
            for (message of json["MESSAGE"]) {
                pout(message);
            }
            pout("Registration Failed");
            break;
    }
});
//=================================================================
//  REVIEW
//=================================================================
PAGE["reviews"] = "#reviews";
CLICK("#reviews .X_____", function(json, status) {
    // pout("#registration .X_register");
    switch (status) {
        case "exec":
            json["email"] = IVAL("#registration .I_email");
            json["password"] = IVAL("#registration .I_password");
            json["password2"] = IVAL("#registration .I_password2");
            json["first_name"] = IVAL("#registration .I_first_name");
            json["last_name"] = IVAL("#registration .I_last_name");
            SEND(json);
            break;
        case "success":
            pout(json["email"] + " Registered");
            jout(json);
            GO("landing|login");
            break;
        case "failure":
            for (message of json["MESSAGE"]) {
                pout(message);
            }
            pout("Registration Failed");
            break;
    }
});
//=================================================================
//  mySurveys - home/dashboard
//=================================================================
PAGE["mySurveys"] = "#mySurveys";
CLICK("#mySurveys .X_mySurveys", function(json, status) { // CHECK
    hashUpdate("mySurveys");
});
CLICK("#mySurveys .X_reviews", function(json, status) {
    hashUpdate("reviews");
});    
CLICK("#mySurveys .X_logout", function(json, status) {
    hashUpdate("landing");
});
CLICK("#mySurveys .X_create-survey", function(json, status) {
    hashUpdate("create-survey");
});
CLICK("#mySurveys .X_edit-survey", function(json, status) {
    hashUpdate("edit-survey");
});
//=================================================================
//  create-survey
//=================================================================
PAGE["create-survey"] = "#create-survey";
CLICK("#create-survey .X_mySurveys", function(json, status) { // CHECK
    hashUpdate("mySurveys");
});
CLICK("#create-survey .X_reviews", function(json, status) {
    hashUpdate("reviews");
});    
CLICK("#create-survey .X_logout", function(json, status) {
    hashUpdate("landing");
});
CLICK("#create-survey .X_cancle", function(json, status) {
    hashUpdate("mySurveys");
});
CLICK("#create-survey .X_create-preview", function(json, status) {
    // pout("#login .X_login");
    switch (status) {
        case "exec":
            // pout("exec");
            
            json["title"] = IVAL("#create-survey .I_title");
            json["description"] = IVAL("#create-survey .I_description");           
            
            //FIXME what if one of the survey items are styled as "display:none" in the DOM, will they also be included in the loop?
            
            //select all elements with classes I_question1 and I_choiceList1
            //create a json property for each question and choice list, name them properlly
            var questions = document.querySelector("#create-survey .question");
            var choiceList = document.querySelector("#create-survey .choiceList");
            var statusPublic = document.querySelector("#create-survey .statusPublic");
            
            //loop through each question and choiceList to add proper class names
            for (var i = 0; i < questions.length; i++) {
            	
            	//adding I_question[i] class to each question
            	questions[i].classList.add("I_question" + i);	
            	//adding question to json
				json["question"+i] = IVAL("#create-survey .I_question" + i);
            	
            	//adding I_statusPublic[i] class to each checkbox
            	statusPublic[i].classList.add("I_statusPublic" + i);	
            	//adding statusPublic to json
				json["statusPublic"+i] = IVAL("#create-survey .I_statusPublic" + i);

            	
             	//adding I_choiceList[i] class to each question
            	choiceList[i].classList.add("I_choiceList" + i);	
            	//adding choiceList to json
				json["choiceList"+i] = IVAL("#create-survey .I_choiceList" + i);
           	
            }//end of for loop
            
            SEND(json);
            break;
        case "success":
            pout("Survey Created");
            pout("GO HOME");
            // GO("home");
            break;
        case "failure":
            for (message of json["MESSAGE"]) {
                pout(message);
            }
            pout("Failed to delete survey");
            break;
    }
});
//=================================================================
//  edit-survey
//=================================================================
PAGE["edit-survey"] = "#edit-survey";
CLICK("#edit-survey .X_mySurveys", function(json, status) { // CHECK
    hashUpdate("mySurveys");
});
CLICK("#edit-survey .X_reviews", function(json, status) {
    hashUpdate("reviews");
});    
CLICK("#edit-survey .X_logout", function(json, status) {
    hashUpdate("landing");
});
CLICK("#edit-survey .X_cancle", function(json, status) {
    hashUpdate("mySurveys");
});
CLICK("#edit-survey .X_save-changes", function(json, status) {
    // pout("#login .X_login");
    switch (status) {
        case "exec":
            // pout("exec");
            
            json["title"] = IVAL("#edit-survey .I_title");
            json["description"] = IVAL("#edit-survey .I_description");           
            
            //FIXME what if one of the survey items are styled as "display:none" in the DOM, will they also be included in the loop?
            
            //select all elements with classes I_question1 and I_choiceList1
            //create a json property for each question and choice list, name them properlly
            var questions = document.querySelector("#edit-survey .question");
            var choiceList = document.querySelector("#edit-survey .choiceList");
            var statusPublic = document.querySelector("#edit-survey .statusPublic");
            
            //loop through each question and choiceList to add proper class names
            for (var i = 0; i < questions.length; i++) {
            	
            	//adding I_question[i] class to each question
            	questions[i].classList.add("I_question" + i);	
            	//adding question to json
				json["question"+i] = IVAL("#edit-survey .I_question" + i);
            	
            	//adding I_statusPublic[i] class to each checkbox
            	statusPublic[i].classList.add("I_statusPublic" + i);	
            	//adding statusPublic to json
				json["statusPublic"+i] = IVAL("#edit-survey .I_statusPublic" + i);

            	
             	//adding I_choiceList[i] class to each question
            	choiceList[i].classList.add("I_choiceList" + i);	
            	//adding choiceList to json
				json["choiceList"+i] = IVAL("#edit-survey .I_choiceList" + i);
           	
            }//end of for loop
            
            SEND(json);
            break;
        case "success":
            pout("Survey Created");
            pout("GO HOME");
            // GO("home");
            break;
        case "failure":
            for (message of json["MESSAGE"]) {
                pout(message);
            }
            pout("Failed to delete survey");
            break;
    }
});

//=================================================================
// test buttons
//=================================================================
$("#button_A").click(function(event) {
    event.stopPropagation();
    data = {
        "action": "test"
    };
    SEND(data)
});
$("#button_B").click(function(event) {
    event.stopPropagation();
    pout("Button B");
});
$("#button_C").click(function(event) {
    event.stopPropagation();
    pout("Button C");
});
$("#button_D").click(function(event) {
    pout("Button D");
});
//=================================================================
GO("landing");
//=================================================================
