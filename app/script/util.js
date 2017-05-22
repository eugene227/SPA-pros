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
