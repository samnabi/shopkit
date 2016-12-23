(function($) {
  var Tiers = function(element) {

    // Click button to add a new tier
    $(element).on('click', '.add-tier', function(e){
      var tiers = $(element).find('.tiers');
      var newTiersItemHtml = $(element).find('.tiers-item-template').html();
      tiers.append(newTiersItemHtml);
      var newTiersItem = tiers.find('.tiers-item').last();
      var newInput = newTiersItem.find('input').first();
      newInput.focus();
    })

    // Delete tier on backspace when both fields in the tier are empty
    $(element).on('keydown', '.tiers .input', function(e){
      var closestInput = ($(e.target).prev().length > 0) ? $(e.target).prev() : $(e.target).next();
      if($(e.target).val() == '' && closestInput.val() == '' && e.keyCode == 8){
        e.preventDefault();
        var tiersItem = $(e.target).parent();
        var prevTier = tiersItem.prev();
        prevTier.find('input').last().focus();
        tiersItem.remove();

        // Update upper limits
        var nextTier = prevTier.next();
        if (nextTier.length > 0) {
          upperLimitValue = +nextTier.find('.input:first-child').val() - 0.1;
          upperLimitValue = '—&nbsp;&nbsp;' + upperLimitValue;
        } else {
          upperLimitValue = '+';
        };
        prevTier.find('.tier-upper-limit').html(upperLimitValue);
      }
    })

    // Update upper limits on tier change
    $(element).on('blur', '.tiers .input:first-child', function(e){
      var upperLimit = $(e.target).parent().prev().find('.tier-upper-limit');
      var upperLimitValue = +$(e.target).val() - 0.1;
      upperLimit.html('—&nbsp;&nbsp;' + upperLimitValue);
    })

  };

  $.fn.tiers = function() {
    return this.each(function() {
      if($(this).data('tiers')) {
        return $(this).data('tiers');
      } else {
        var tiers = new Tiers(this);
        $(this).data('tiers', tiers);
        return tiers;
      }
    });
  };
})(jQuery);