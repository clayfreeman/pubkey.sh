$('input:password').on('input', function() {
  // Generate a list of words for zxcvbn to use as user-generated data to
  // increase security
  var form   = $(this).closest('form');
  var values = ['pubkey', 'pub', 'key', 'public', 'key'];
  form.find('input:text').each(function() {
    $.each($(this).val().split(" "), function(i, item) {
      values.push(item);
    });
  });
  // Fetch the information from zxcvbn regarding the password
  var info  = zxcvbn($(this).val(), values);
  // If the score is sufficient, enable submission of the form
  var score = $('#password-score');
  score.text(info.score < 4 ? info.score : 3);
  if (info.score > 2) {
    // Change the state of the password field to show success
    score.closest('.uk-alert').removeClass('uk-alert-danger');
    score.closest('.uk-alert').addClass('uk-alert-success');
    $(this).removeClass('uk-form-danger');
    $(this).addClass('uk-form-success');
    $(this).prop('verified', 'true');
    // Enable form submission if appropriate
    if (form.find('input[verified=false]').length == 0)
      form.find('button').prop('disabled', false);
  }
  else {
    // Change the state of the password field to show failure
    score.closest('.uk-alert').removeClass('uk-alert-success');
    score.closest('.uk-alert').addClass('uk-alert-danger');
    $(this).removeClass('uk-form-success');
    $(this).addClass('uk-form-danger');
    $(this).prop('verified', 'false');
    // Disable form submission
    form.find('button').prop('disabled', true);
  }
});
