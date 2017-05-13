(function () { // Enclose in an anonymous function to limit scope

  // Cut the mustard
  var mustard = !!document.querySelector && !!window.addEventListener;
  if (!mustard) return;

  // Helper function for checking decendant of arbitrary depth
  function isDescendant(parent, child) {
    var node = child.parentNode;
    while (node != null) {
      if (node == parent) return true;
      node = node.parentNode;
    }
    return false;
  }

  document.querySelector('.wrapper-main').addEventListener('click', function(event){

    // Is the target a prev/next button, or a descendant of a prev/next button?
    // (e.g. <svg>, <path>, <span>)
    var next = document.querySelector('.button.next');
    var prev = document.querySelector('.button.prev');
    if (next === event.target || isDescendant(next, event.target)) var link = next;
    if (prev === event.target || isDescendant(prev, event.target)) var link = prev;

    // Only continue if link exists and has a href attribute
    if (!link || !link.href) return true;

    // Stop standard click action
    event.preventDefault();

    // Update partial DOM
    getAjax(link.href, function(data){
      var oldMain = document.querySelector('main');
      var newMain = document.createElement('main');
      var d = data.slice(data.indexOf("<main>"));
      var d = d.slice(0, d.indexOf("</main>")+7);
      newMain.innerHTML = d;
      oldMain.parentNode.replaceChild(newMain, oldMain);
    });
  });

  // Keybindings for left, right, escape
  document.onkeydown = function(e) {

    if(!(/INPUT|TEXTAREA/i.test(e.target))) {
      e = e || window.event;
      switch(e.which || e.keyCode) {
        case 37: // left
        document.querySelector('a.prev').click();
        break;

        case 39: // right
        document.querySelector('a.next').click();
        break;

        case 27: // esc
        document.querySelector('a.grid').click();
        break;

        default: return; // exit this handler for other keys
      }
      e.preventDefault(); // prevent the default action (scroll / move caret)
    }
  };

})(); // Close up the function