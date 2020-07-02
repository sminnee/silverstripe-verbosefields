/**
 * Code for VerboseOptionsetField within the admin
 */
(function($) {
	$.entwine("ss", function($) {
    // Change values
    $(".verboseoptionsetfield input").entwine({
      onmatch: function(deferred) {
        if ($(this).is(':checked')) {
          $(this).showDescription();
        }
      },
			onchange: function(deferred) {
        $(this).showDescription();
      },
			showDescription: function(deferred) {
        // TODO: less brittle way of finding this element
        var descriptionEl = $(this).parent().parent().parent().parent().find('.verbose-description');
        descriptionEl.css('height', '');
        descriptionEl.html($(this).data('description'));
        descriptionEl.css('height', descriptionEl.height());
        descriptionEl.css('overflow', 'hidden');
        descriptionEl.css('opacity', '');
      },
    });

    // Hover to temporarily show the description, 50% faded
    $(".verboseoptionsetfield label.form-check-label").entwine({
      onmouseover: function(deferred) {
        // No need to do this for the currenlty selected item
        if ($(this).find('input').is(':checked')) {
          return;
        }

        var descriptionEl = $(this).parent().parent().parent().find('.verbose-description');

        // Show this element's description temporarily
        console.log($(this).html())
        descriptionEl.css('opacity', '0.5');
        descriptionEl.html($(this).find('input').data('description'));
      },

      onmouseout: function(deferred) {
        // No need to do this for the currenlty selected item
        if ($(this).find('input').is(':checked')) {
          return;
        }

        var descriptionEl = $(this).parent().parent().parent().find('.verbose-description');

        // Restore
        descriptionEl.css('opacity', '');
        descriptionEl.html(descriptionEl.parent().find('input:checked').data('description'));
      },
    });
  });
})(jQuery);
