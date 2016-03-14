/**
 * @file      password.js
 * @copyright Copyright 2016 Clay Freeman. All rights reserved
 * @license   This project is released under the GNU General Public License
 *            v3 (GPL-3.0)
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
    var values = ['pubkey', 'pub', 'key', 'public'];
    form.find('input:text').find('[name!='+ selector +']').each(function() {
      $.each($(this).val().split(' '), function(i, item) {
        values.push(item);
      });
    });
    // Fetch the information from zxcvbn regarding the password
    var info  = zxcvbn(field.val(), values);
    // If the score is sufficient, enable submission of the form
    var score = $('#password-score');
    score.text(info.score < 4 ? info.score : 3);
    if (info.score > 2) {
      // Change the state of the password field to show success
      score.closest('.uk-alert').removeClass('uk-alert-danger');
      score.closest('.uk-alert').addClass('uk-alert-success');
      fieldMutateState(field, true, true);
    }
    else {
      // Change the state of the password field to show failure
      score.closest('.uk-alert').removeClass('uk-alert-success');
      score.closest('.uk-alert').addClass('uk-alert-danger');
      fieldMutateState(field, false, true);
    }
  });
}
