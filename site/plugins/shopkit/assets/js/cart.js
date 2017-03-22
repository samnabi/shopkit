(function () { // Enclose in an anonymous function to limit scope

    // Cut the mustard
    var mustard = !!document.querySelector && !!document.querySelectorAll && !!window.addEventListener && !!document.documentElement.classList;
    if (!mustard) return;

    // Hide submit buttons
    function hideButtons() {
     document.querySelector('select[name="country"] + button').className += ' hide';
     document.querySelector('.shipping button').className += ' hide';   
    }

    // Attach listeners to <main> because its child elements may be replaced by new DOM
    document.querySelector('main').addEventListener('change', function(event){
        // Only continue if it's shipping/country dropdown
        if (!['country','shipping'].includes(event.target.name)) return true;

        // Submit the form
        event.target.form.submit();
    });
    hideButtons();

    // Attach listeners to <main> because its child elements may be replaced by new DOM
    document.querySelector('main').addEventListener('submit', function(event){
        
        // Only continue if it's an add/remove action
        if (!['add','remove'].includes(event.target.action.value)) return true;

        // Stop standard submit action
        event.preventDefault();

        // Submit the form
        postAjax('', serialize(event.target), function(data){

            // Update partial DOM
            var oldTable = document.querySelector('.table-overflow');
            var newTable = document.createElement('div');
            newTable.classList.add('table-overflow');
            var d = data.slice(data.indexOf("<table dir"));
            var d = d.slice(0, d.indexOf("</table>")+8);
            newTable.innerHTML = d;
            oldTable.parentNode.replaceChild(newTable, oldTable);

            // Hide shipping/country buttons
            hideButtons();
        });
    });
    
})(); // Close up the function