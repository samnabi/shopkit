(function () { // Enclose in an anonymous function to limit scope

  // Cut the mustard
  var mustard = !!document.querySelectorAll && !!window.addEventListener && !!document.documentElement.classList && !!document.documentElement.getAttribute && !!document.documentElement.setAttribute;
  if (!mustard) return;

  // Find toggle buttons and loop through them
  var toggles = document.querySelectorAll('button[aria-expanded]');

  for (var i = toggles.length - 1; i >= 0; i--) {
    var element = toggles[i];

    // Set max-height (for smoother transitions)
    function setMaxHeight(element) { element.style.maxHeight = element.offsetHeight + 'px'; }
    var sibling = element.nextElementSibling;
    setMaxHeight(sibling);
    window.addEventListener("resize", setMaxHeight(sibling)); // Reset max-height on window resize

    // Show button and collapse its related content
    element.style.display = 'inline-block';
    console.log(window.location.hash);
    if (window.location.hash == '#login' && element.getAttribute('aria-controls') == 'loginform') {
      // Focus on the form and don't collapse it
      document.getElementById('email').focus();
    } else {
      // Collapse it
      element.setAttribute('aria-expanded','false');
    }

    // Attach click events
    element.addEventListener('click',function(){
      if (this.getAttribute('aria-expanded') == 'false') {
        this.setAttribute('aria-expanded','true');

        // Autofocus on the login form
        if (this.getAttribute('aria-controls') == 'loginform') {
          document.getElementById('email').focus();
        }
      } else {
        this.setAttribute('aria-expanded','false');
      }
    });
  };

  // Enable CSS animations
  setTimeout(function(){
    document.documentElement.className += " animate";
  }, 500);

})(); // Close up the function