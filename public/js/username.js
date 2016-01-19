function verifyUsername(selector) {
  // Add the unverified property to the password field
  $("input[name=" + selector + "]").attr('unverified', true);
  // Register an event handler on input to verify the username is available
  $("input[name=" + selector + "]").on('input', function() {
    // Select the icon for the form field
    var icon   = $(this).siblings('i');
    // Remove the icon's classes
    icon.removeClass(function(index, css) {
      return (css.match(/(^|\s)uk-icon-\S+/g) || []).join(' ');
    });
    // Fetch the query result from the API
    $.postJSON('/user/available', $(this).val(), function(data) {
      console.log(JSON.stringify(data));
    });
  });
}
