/**
 * @file      fieldMutateState.js
 * @copyright Copyright 2016 Clay Freeman. All rights reserved
 * @license   This project is released under the GNU General Public License
 *            v3 (GPL-3.0)
 *
 * Responsible for form validation control and field status indicators
 */

function fieldMutateState(field, enabled, indicateState) {
  // Select the icon and form from the field
  var icon = field.siblings('i');
  var form = field.closest('form');
  // Remove the icon's classes
  icon.removeClass(function(index, css) {
    return (css.match(/(^|\s)uk-icon-\S+/g) || []).join(' ');
  });
  if (enabled) {
    // Update the state of the field to show success
    field.removeAttr('unverified');
    field.removeClass('uk-form-danger');
    field.addClass('uk-form-success');
    icon.addClass('uk-icon-check');
    // Enable form submission if appropriate
    if (form.find('input[unverified]').length == 0)
      form.find('button').prop('disabled', false);
  }
  else {
    // Update the state of the field to show failure
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
