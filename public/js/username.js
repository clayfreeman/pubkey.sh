function usernameMutateState(field, enabled, indicateState) {
  // Select the icon and form from the field
  var icon = field.siblings('i');
  var form = field.closest('form');
  // Remove the icon's classes
  icon.removeClass(function(index, css) {
    return (css.match(/(^|\s)uk-icon-\S+/g) || []).join(' ');
  });
  // Change the state of the password field to show failure
  if (enabled) {
    field.removeAttr('unverified');
    field.removeClass('uk-form-danger');
    field.addClass('uk-form-success');
    icon.addClass('uk-icon-check');
    // Enable form submission if appropriate
    if (form.find('input[unverified]').length == 0)
      form.find('button').prop('disabled', false);
  }
  else {
    field.attr('unverified', true);
    field.removeClass('uk-form-success');
    if (indicateState) {
      field.addClass('uk-form-danger');
      icon.addClass('uk-icon-close');
    }
    else {
      field.removeClass('uk-form-danger');
    }
    // Disable form submission
    form.find('button').prop('disabled', true);
  }
}

function verifyUsername(selector) {
  // Add the unverified property to the password field
  $("input[name=" + selector + "]").attr('unverified', true);
  // Register an event handler on input to verify the username is available
  $("input[name=" + selector + "]").change(function() {
    // Select the icon for the form field
    var field  = $(this);
    var icon   = $(this).siblings('i');
    var form   = $(this).closest('form');
    // Verify constraints of the username field
    if (field.val().length > 2 && /^[a-z][a-z0-9]{2,}$/i.test(field.val())) {
      // Disable the form field
      usernameMutateState(field, false, false);
      // Fetch the query result from the API
      icon.addClass('uk-icon-refresh');
      $.post('/user/available', {"username": $(this).val()}, function(data) {
        available = $.parseJSON(data)['available'];
        if (available === true)
          // Enable the form field
          usernameMutateState(field, false, false);
        else
          // Disable the form field
          usernameMutateState(field, false, true);
      });
    }
    else {
      // Disable the form field
      usernameMutateState(field, false, true);
    }
  });
}
