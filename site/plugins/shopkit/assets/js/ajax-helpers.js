// Turns a form node into a URL query string
function serialize(form) {
  var field, l, s = [];
  if (typeof form == 'object' && form.nodeName == "FORM") {
    var len = form.elements.length;
    for (var i=0; i<len; i++) {
      field = form.elements[i];
      if (field.name && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
        if (field.type == 'select-multiple') {
          l = form.elements[i].options.length; 
          for (var j=0; j<l; j++) {
            if(field.options[j].selected) {
                s[s.length] = encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[j].value);
            }
          }
        } else if ((field.type != 'checkbox' && field.type != 'radio') || field.checked) {
              s[s.length] = encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value);
        }
      }
    }
  }
  return s.join('&').replace(/%20/g, '+');
}

// Post via AJAX
function postAjax(url, data, success) {
  var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
  xhr.open('POST', url);
  xhr.onreadystatechange = function() {
    if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); }
  };
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(data);
  return xhr;
}

// Get via AJAX
function getAjax(url, success) {
  var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  xhr.open('GET', url);
  xhr.onreadystatechange = function() {
    if (xhr.readyState>3 && xhr.status==200) success(xhr.responseText);
  };
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.send();
  return xhr;
}