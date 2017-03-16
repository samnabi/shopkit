(function () { // Enclose in an anonymous function to limit scope

  // Cut the mustard
  var mustard = !!document.querySelector && !!window.addEventListener;
  if (!mustard) return;

  document.querySelector('.wrapper-main').addEventListener('click', function(event){
    // Only continue if it's an add/remove action
    if (!['button prev','button next'].includes(event.target.className)) return true;

    // Only continue if there's a valid href
    if (!event.target.href) return true;

    // Stop standard click action
    event.preventDefault();

    // Update partial DOM
    getAjax(event.target.href, function(data){
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