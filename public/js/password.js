$('input[type="password"]').change(function() {
  // Generate a list of words for zxcvbn to use as user-generated data to
  // increase security
  var values = ['pubkey', 'pub', 'key', 'public', 'key'];
  $(this).closest('form').find('input').each(function() {
    $.each($(this).split(" "), function(i, item) {
      values.push(item);
    });
  });
  // Log the restricted values to the console
  console.log("Restricted values:" + JSON.stringify(values));
  // Fetch the information from zxcvbn regarding the password
  var info = zxcvbn($(this).val(), values);
  // If the score is sufficient, enable submission of the form
  if (info.score > 2) {
    // Change the state of the password field to show success
    $(this).removeClass('uk-form-danger');
    $(this).addClass('uk-form-success');
    // Enable form submission
    $(this).closest('form').find('button').prop('disabled', false);
  }
  else {
    // Change the state of the password field to show failure
    $(this).removeClass('uk-form-danger');
    $(this).addClass('uk-form-success');
    // Disable form submission
    $(this).closest('form').find('button').prop('disabled', true);
  }
});
