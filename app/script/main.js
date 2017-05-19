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
//=================================================================
//   url hash routing
//=================================================================
$(window).bind("hashchange", function(event) {
    hash = window.location.hash;
    pout(hash);
});

function hashCompile(_array) {
    return Object.getOwnPropertyNames(_array).map(function(name) {
        value = _array[name];
        if (false === value) return "";
        return (true === value) ? name : (name + "=" + value);
    }).join("_");
}

function hashParse() {
    var result = {};
    hash = window.location.hash.slice(1);
    items = hash.split("_");
    for (item of items) {
        item = item.split('=');
        result[item[0]] = ((1 === item.length) ? true : item[1])
    }
    return result;
}

function hashUpdate(_string) {
    window.location.hash = _string
}

function hashSet(name, value = true) {
    hash = hashParse();
    hash[name] = value;
    hash = hashCompile(hash);
    hashUpdate(hash);
}

function hashUnset(name) {
    hash = hashParse();
    hash[name] = false;
    delete hash[name];
    hash = hashCompile(hash);
    hashUpdate(hash);
}

function hashToggle(name, value = true) {
    hash = hashParse();
    if (name in hash) {
        delete hash[name];
    } else {
        hash[name] = value;
    }
    hash = hashCompile(hash);
    hashUpdate(hash);
}

function hashHide() {
    history.pushState("", document.title, window.location.pathname + window.location.search);
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