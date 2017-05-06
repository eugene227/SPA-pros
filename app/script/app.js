function post(path, params) {
    // alert(path);
    // alert(params);
    // return;
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", path);
    for(var key in params) {
        if(params.hasOwnProperty(key)) {
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

function exec(name) {
    alert(name);
    post('http://deck.local:8888/PRS/event.php', {name : null});
}

function exectest(x,y) {
    alert(x);
alert(y);
}
