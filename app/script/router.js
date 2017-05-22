var PAGE = {};
//=================================================================
// routing
//=================================================================
function ROUTER(json) {
    keys = Object.keys(PAGE);
    // pout("router");
    for (page of keys) {
        if (!(json.hasOwnProperty(page))) {
            HIDE(page);
        }
    }
    for (page of keys) {
        if (json.hasOwnProperty(page)) {
            SHOW(page);
        }
    }
}
var GO = hashUpdate;

function HIDE(page) {
    $(PAGE[page]).addClass("hidden_");
}

function SHOW(page) {
    $(PAGE[page]).removeClass("hidden_");
}//=================================================================
//   url hash routing
//=================================================================
function hashParse() {
    let result = {};
    hash = window.location.hash.slice(1);
    items = hash.split("|").filter(function(item) {
        return (item != "");
    });
    for (item of items) {
        item = item.split('=');
        result[item[0]] = ((1 === item.length) ? true : item[1])
    }
    return result;
}

function hashCompile(_array) {
    return Object.getOwnPropertyNames(_array).map(function(name) {
        value = _array[name];
        if (false === value) return "";
        return (true === value) ? name : (name + "=" + value);
    }).join("|");
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

function hashInit() {
    // pout("hashInit");
    hash = hashParse(); // save existing hashstate, possibly from bookmark
    hashUpdate(""); // clear current hashstate
    hash = hashCompile(hash);
    $(window).bind("hashchange", function(event) {
        ROUTER(hashParse());
    });
    hashUpdate(hash); // should trigger hashchange
    // ROUTER(hashParse());
}

hashInit();

//=================================================================
// Trigger initial routing.
//=================================================================