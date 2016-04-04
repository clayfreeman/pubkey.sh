/**
 * @file      password.js
 * @copyright Copyright 2016 Clay Freeman. All rights reserved
 * @license   GNU General Public License v3 (GPL-3.0)
 *
 * Responsible for verifying the validity of a password
 */

function verifyPassword(selector) {
  // Add the unverified property to the password field
  $('input[name=' + selector + ']').attr('unverified', true);
  // Register an event handler on input to verify the password complexity
  $('input[name=' + selector + ']').on('input', function() {
    // Select the icon and form from the field
    var field  = $(this);
    var icon   = field.siblings('i');
    var form   = field.closest('form');
    // Generate a list of words for zxcvbn to use as user-generated data to
    // increase security
    var values = ['pubkey.sh', 'pubkey', 'pub', 'key', 'public'];
    form.find('input:text').find('[name!='+ selector +']').each(function() {
      $.each($(this).val().split(' '), function(i, item) {
        values.push(item);
      });
    });
    // Fetch the information from zxcvbn regarding the password
    var info  = zxcvbn(field.val(), values);
    // If the score is sufficient, enable submission of the form
    var score = $('#password-score');
    var scoreNum = info.score <= 4 ? info.score : 4;
    var scorePercent = Math.round(scoreNum / 4.0 * 100);
    score.css('width', scorePercent + '%');
    score.value(scorePercent + '%');
    if (info.score > 2) {
      // Change the state of the password field to show success
      score.closest('.uk-progress').removeClass('uk-progress-danger');
      score.closest('.uk-progress').removeClass('uk-progress-striped');
      score.closest('.uk-progress').addClass('uk-progress-success');
      fieldMutateState(field, true, true);
    }
    else {
      // Change the state of the password field to show failure
      score.closest('.uk-progress').removeClass('uk-progress-success');
      score.closest('.uk-progress').addClass('uk-progress-danger');
      score.closest('.uk-progress').addClass('uk-progress-striped');
      fieldMutateState(field, false, true);
    }
  });
}
