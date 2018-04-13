var hasError = function (field) {
    var error = "";
    // Don't validate submits, buttons, file and reset inputs, and disabled fields
    if (field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') return;
    // Get validity
    var validity = field.validity;
    // If valid, return null
    if (validity.valid) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        return;
    }
    // If field is required and empty

    if (validity.valueMissing) { $error = 'Debe rellenar este campo'; }
    // If not the right type
    else if (validity.typeMismatch) {
        // Email
        if (field.type === 'email') $error = 'El email es obligatorio y/o no tiene el formato correcto';
        // URL
        else if (field.type === 'url') $error = 'Por favor introduce una URL correcta';
    }
    // If too short
    else if (validity.tooShort) $error = 'Por favor alarga este texto a ' + field.getAttribute('minLength') + ' caracteres o mas. Estás usando ' + field.value.length + ' caracteres.';
    // If too long
    else if (validity.tooLong) $error = 'Por favor ajusta este texto a ' + field.getAttribute('maxLength') + ' caracteres. Estás usando ' + field.value.length + ' caracteres.';
    // If number input isn't a number
    else if (validity.badInput) $error = 'Por favor introduce un número.';
    // If a number value doesn't match the step interval
    else if (validity.stepMismatch) $error = 'Por favor introduce un valor válido.';
    // If a number field is over the max
    else if (validity.rangeOverflow) $error = 'Por favor selecciona un valor no mayor de ' + field.getAttribute('max') + '.';
    // If a number field is below the min
    else if (validity.rangeUnderflow) $error = 'Por favor selecciona un valor no menor de' + field.getAttribute('min') + '.';
    // If pattern doesn't match
    else if (validity.patternMismatch) {
        // If pattern info is included, return custom error
        $error = field.getAttribute('title') || 'Por favor usa el siguiente formato.';
    }
    // If all else fails, return a generic catchall error
    else {
        $error = 'El valor introducido en este campo no es válido.';
    }
    return $error;
};
var showError = function (field, error) {
    field.classList.add('is-invalid');
    var id = field.id || field.name;
    if (!id) return;
    var message = field.form.querySelector('.invalid-feedback#error-for-' + id);
    if (message) message.innerHTML = error;
};

(function (modoVal) {
    'use strict';
    if ((modoVal === "cliente") || (modoVal === "servidor")) {
        window.addEventListener('load', function () {
            var form = document.querySelector('.validate');
            form.setAttribute('novalidate', true);
            if (modoVal === "cliente") {
                form.addEventListener('blur', function (event) {
                    if (!event.target.form.classList.contains('validate')) return;
                    var error = hasError(event.target);
                    if (error) {
                        showError(event.target, error);
                    }
                }, true);
                form.addEventListener('invalid', function (event) {
                    if (!event.target.form.classList.contains('validate')) return;
                    var error = hasError(event.target);
                    if (error) {
                        showError(event.target, error);
                    }
                }, true);

                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            }
        });
    }
})(modoVal);