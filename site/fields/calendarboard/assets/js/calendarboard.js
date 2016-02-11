var Today = new Date();

function builtCalendar(F,M,Y){
    var M = M || Today.getMonth()+1;
    var Y = Y || Today.getFullYear();
    
    var field_name = "";

    if(typeof F == "string"){
      field_name = F;
    }else{
      field_name = $(F).siblings("label.label").attr("for").replace("form-field-", "");
    }
    
    var _url = window.location.href;
    _url = _url.replace("/edit", "/field");
    _url += "/" + field_name;
    _url += "/calendarboard/get-month-board/" + M + "/" + Y;
    
    $.ajax({
        url: _url,
        type: 'GET',
        success: function(board) {
          $("div.calendarboard[data-field-name='" + field_name + "']").html(board);
        }
    });    
}

$.fn.createCalendar = function() {
  builtCalendar(this);
}
