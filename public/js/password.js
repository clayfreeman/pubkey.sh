$('input:password').on('input', function() {
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
  $('#password-status').val(info.level+' / 4');
  if (info.score > 2) {
    // Change the state of the password field to show success
    $('#password-status').removeClass('uk-text-danger');
    $('#password-status').addClass('uk-text-success');
    $(this).removeClass('uk-form-danger');
    $(this).addClass('uk-form-success');
    // Enable form submission
    $(this).closest('form').find('button').prop('disabled', false);
  }
  else {
    // Change the state of the password field to show failure
    $('#password-status').removeClass('uk-text-success');
    $('#password-status').addClass('uk-text-danger');
    $(this).removeClass('uk-form-success');
    $(this).addClass('uk-form-danger');
    // Disable form submission
    $(this).closest('form').find('button').prop('disabled', true);
  }
});
