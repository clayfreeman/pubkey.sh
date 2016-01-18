$('input:password').keydown(function() {
  // Generate a list of words for zxcvbn to use as user-generated data to
  // increase security
  var values = ['pubkey', 'pub', 'key', 'public', 'key'];
  $(this).closest('form').find('input:text').each(function() {
    $.each($(this).val().split(" "), function(i, item) {
      values.push(item);
    });
  });
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
    $(this).removeClass('uk-form-success');
    $(this).addClass('uk-form-danger');
    // Disable form submission
    $(this).closest('form').find('button').prop('disabled', true);
  }
});
