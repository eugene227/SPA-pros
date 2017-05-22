var DISPATCH = {};
//=================================================================
// executeFunctionByName
// executeFunctionByName("My.Namespace.functionName", window, ...);
// You can pass in whatever context you want,
// so this would do the same as above:
// executeFunctionByName("Namespace.functionName", My, ...);
//=================================================================
function executeFunctionByName(functionName, context /*, arguments */ ) {
    var args = [].slice.call(arguments).splice(2);
    var namespaces = functionName.split(".");
    var func = namespaces.pop();
    for (var i = 0; i < namespaces.length; i++) {
        context = context[namespaces[i]];
    }
    return context[func].apply(context, args);
}

function SEND(json) {
    function _success(json) {
        // jout(json);
        switch (json["STATUS"]) {
            case "guest":
                // pout(json["$MESSAGE"]);
                GO("landing");
                break;
            case "success":
                DISPATCH[json["action"]](json, "success");
                break;
            case "failure":
                DISPATCH[json["action"]](json, "failure");
                break;
        }
    }

    function _error(jqXHR, textStatus, errorThrown) {
        let json = {
            // "jqXHR": jqXHR,
            "textStatus": textStatus,
            "errorThrown": errorThrown
        };
        debugger;
        jout(json);
    }
    $.ajax({
        "url": "backend.php",
        "type": "post",
        "data": json,
        "success": _success,
        "error": _error
    })
};

function EXEC(event) {
    event.stopPropagation();
    selector = event["data"];
    var json = {
        "action": selector
    };
    DISPATCH[selector](json, "exec");
}

function ACTIVATE(selector) {
    $(selector).click(selector, EXEC);
}

function DEACTIVATE(selector) {
    $(selector).click(function(event) {});
}

function CLICK(selector, fn) {
    DISPATCH[selector] = fn;
    ACTIVATE(selector);
}

function IVAL(selector) {
    return $(selector).eq(0).val();
}