function jout(_json, _collapsed = true) {
    element = document.createElement('div');
    $(element).JSONView(_json, {
        collapsed: _collapsed
    });
    $("body").prepend(element);
}

function aout(_array) {
    // jout(JSON.parse(JSON.stringify(_array)));
    jout(JSON.stringify(_array), false);
}

function pout(_string) {
    var body = document.body;
    var element = document.createElement('p');
    element.appendChild(document.createTextNode(_string));
    body.insertBefore(element, body.firstChild);
}

function cout(_string) {
    var body = document.body;
    var element = document.createElement('pre');
    element.appendChild(document.createTextNode(_string));
    body.insertBefore(element, body.firstChild);
}
//=================================================================
//   routing
//=================================================================
var STATE = {};
STATE["hint"] = "program state information should be kept here";

function ROUTER(hashlist) {
    aout(hashlist);
}
//=================================================================
//   test buttons
//=================================================================
$("#button_A").click(function(event) {
    event.stopPropagation();

    function _success(result) {
        jout(result);
    }

    function _error(xhr, desc, err) {
        pout(xhr);
        pout("Details: " + desc);
        pout("Error:" + err);
    }
    event.stopPropagation();
    $.ajax({
        url: "backend.php",
        type: 'post',
        data: {
            'action': 'test'
        },
        success: _success,
        error: _error
    })
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