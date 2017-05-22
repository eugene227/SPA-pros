var STATE = {};
STATE["purpose"] = "SPA state should be kept in STATE object";
//=================================================================
//  LANDING
//=================================================================
PAGE["landing"] = "#landing";
CLICK("#landing .X_login", function(json, status) {
    hashUnset("registration");
    hashSet("login");
});
CLICK("#landing .X_register", function(json, status) {
    hashUnset("login");
    hashSet("registration");
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