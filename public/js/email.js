function verifyEmail(selector) {
  // Add the unverified property to the password field
  $('input[name=' + selector + ']').attr('unverified', true);
  // Register an event handler on input to verify the username is available
  $('input[name=' + selector + ']').change(function() {
    // Select the icon and form from the field
    var field  = $(this);
    var icon   = field.siblings('i');
    var form   = field.closest('form');
    // Verify constraints of the username field
    if (field.val().length > 5 && /^.+@.+\.[a-z]{2,}$/i.test(field.val())) {
      // Disable the form field
      fieldMutateState(field, false, false);
      // Fetch the query result from the API
      icon.addClass('uk-icon-refresh');
      $.post('/email/available', {'mail': field.val()}, function(data) {
        available = $.parseJSON(data)['available'];
        if (available === true)
          // Enable the form field
          fieldMutateState(field, true, true);
        else
          // Disable the form field
          fieldMutateState(field, false, true);
      });
    }
    else {
      // Disable the form field
      fieldMutateState(field, false, true);
    }
  });
}
