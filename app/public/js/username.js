/**
 * @file      username.js
 * @copyright Copyright 2016 Clay Freeman. All rights reserved
 * @license   GNU General Public License v3 (GPL-3.0)
 *
 * Responsible for verifying the validity and availability of a username
 */

function verifyUsername(selector) {
  // Add the unverified property to the password field
  $('input[name=' + selector + ']').attr('unverified', true);
  // Register an event handler on input to verify the username is available
  $('input[name=' + selector + ']').change(function() {
    // Select the icon and form from the field
    var field  = $(this);
    var icon   = field.siblings('i');
    var form   = field.closest('form');
    // Verify constraints of the username field
    if (field.val().length > 2 && /^[a-z][a-z0-9]{2,}$/i.test(field.val())) {
      // Disable the form field
      fieldMutateState(field, false, false);
      // Fetch the query result from the API
      icon.addClass('uk-icon-refresh');
      $.post('/user/available', {'username': field.val()}, function(data) {
        if (data['available'] === true)
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
