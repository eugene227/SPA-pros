<?php

function flatten_values($array) {
    $collect = [];
    function walk($array, &$collect) {
        foreach ($array as $_ => $value) {
            if (is_array($value)) {
                walk($value, $collect);
            } else {
                $collect[] = $value;
            }
        }
    }
    walk($array, $collect);
    return $collect;
}

function out($value)
{
    print "<pre>";
    print_r($value);
    print "</pre>";
}

function getvalue($array, $key)
{
    return (array_key_exists($key, $array)) ? $array[$key] : null;
}

function show($value) {
    // echo $value . "<br>";
    out($value);
}

function dump($value)
{
    return "<pre>" . var_export($value, true) . "</pre>";
}

function tf($value)
{
    return ($value) ? 'true' : 'false';
}

function tag($tag, $inner, $props = '')
{
    $props = (($props) ? ' ' : '') . $props;
    return "<{$tag}{$props}>{$inner}</{$tag}>";
}

// src="https://dummyimage.com/400x400/000/fff.gif&text=square"

// function js_post_script()
// {
//     return <<<EOT
// <script>
// function post(path, params) {
//     var form = document.createElement("form");
//     form.setAttribute("method", "post");
//     form.setAttribute("action", path);
//     for(var key in params) {
//         if(params.hasOwnProperty(key)) {
//             var hiddenField = document.createElement("input");
//             hiddenField.setAttribute("type", "hidden");
//             hiddenField.setAttribute("name", key);
//             hiddenField.setAttribute("value", params[key]);
//             form.appendChild(hiddenField);
//          }
//     }
//     document.body.appendChild(form);
//     form.submit();
// }
// </script>
// EOT;
// }
