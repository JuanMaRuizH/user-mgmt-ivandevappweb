//Add the novalidate when the JS loads

// Listen to all blur events

// Validate the field
var hasError = function (field) {
    var error = "";
    // Don't validate submits, buttons, file and reset inputs, and disabled fields
    if (field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') return;
    // Get validity
    var validity = field.validity;
    // If valid, return null
    if (validity.valid) {
        field.classList.remove('is-invalid');
        return;
    }
    // If field is required and empty

    if (validity.valueMissing) { $error = 'Debe rellenar este campo'; }
    // If not the right type
    else if (validity.typeMismatch) {
        // Email
        if (field.type === 'email') $error = 'El email es obligatorio y/o no tiene el formato correcto';
        // URL
        else if (field.type === 'url') $error = 'Please enter a URL.';
    }
    // If too short
    else if (validity.tooShort) $error = 'Please lengthen this text to ' + field.getAttribute('minLength') + ' characters or more. You are currently using ' + field.value.length + ' characters.';
    // If too long
    else if (validity.tooLong) $error = 'Please shorten this text to no more than ' + field.getAttribute('maxLength') + ' characters. You are currently using ' + field.value.length + ' characters.';
    // If number input isn't a number
    else if (validity.badInput) $error = 'Please enter a number.';
    // If a number value doesn't match the step interval
    else if (validity.stepMismatch) $error = 'Please select a valid value.';
    // If a number field is over the max
    else if (validity.rangeOverflow) $error = 'Please select a value that is no more than ' + field.getAttribute('max') + '.';
    // If a number field is below the min
    else if (validity.rangeUnderflow) $error = 'Please select a value that is no less than ' + field.getAttribute('min') + '.';
    // If pattern doesn't match
    else if (validity.patternMismatch) {
        // If pattern info is included, return custom error
        $error = field.getAttribute('title') || 'Please match the requested format.';
    }
    // If all else fails, return a generic catchall error
    else {
        $error = 'The value you entered for this field is invalid.';
    }
    return $error;
};
var showError = function (field, error) {
    // Add error class to field
    // field.classList.add('error');
    field.classList.add('is-invalid');
    // Get field id or name
    var id = field.id || field.name;
    if (!id) return;
    // Check if error message field already exists
    // If not, create one
    var message = field.form.querySelector('.invalid-feedback#error-for-' + id);
    if (message) message.innerHTML = error;
};
(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = [].slice.call(document.querySelectorAll('.validate'));
        forms.map(form => form.setAttribute('novalidate', true));
        forms.map(form => {
            form.addEventListener('blur', function (event) {
                // Only run if the field is in a form to be validated
                if (!event.target.form.classList.contains('validate')) return;
                // Validate the field
                var error = hasError(event.target);
                // If there's an error, show it
                if (error) {
                    showError(event.target, error);
                }
            }, true)
        });
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        forms.map(form => {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();