// NIK and KK validation functions for Indonesian forms
function validateNIK(input) {
    const value = input.value.replace(/\D/g, ''); // Remove non-digits
    input.value = value; // Update input value

    const warningElement = input.parentNode.querySelector('.nik-warning');
    if (warningElement) {
        warningElement.remove();
    }

    if (value.length > 0 && value.length < 16) {
        showValidationWarning(input, 'NIK harus terdiri dari 16 digit angka', 'nik-warning');
    } else if (value.length === 16) {
        removeValidationWarning(input, 'nik-warning');
        input.classList.remove('border-red-300');
        input.classList.add('border-green-300');
    }
}

function validateKK(input) {
    const value = input.value.replace(/\D/g, ''); // Remove non-digits
    input.value = value; // Update input value

    const warningElement = input.parentNode.querySelector('.kk-warning');
    if (warningElement) {
        warningElement.remove();
    }

    if (value.length > 0 && value.length < 16) {
        showValidationWarning(input, 'Nomor KK harus terdiri dari 16 digit angka', 'kk-warning');
    } else if (value.length === 16) {
        removeValidationWarning(input, 'kk-warning');
        input.classList.remove('border-red-300');
        input.classList.add('border-green-300');
    }
}

function validateNIKAlmarhum(input) {
    const value = input.value.replace(/\D/g, ''); // Remove non-digits
    input.value = value; // Update input value

    const warningElement = input.parentNode.querySelector('.nik-almarhum-warning');
    if (warningElement) {
        warningElement.remove();
    }

    if (value.length > 0 && value.length < 16) {
        showValidationWarning(input, 'NIK Almarhum harus terdiri dari 16 digit angka', 'nik-almarhum-warning');
    } else if (value.length === 16) {
        removeValidationWarning(input, 'nik-almarhum-warning');
        input.classList.remove('border-red-300');
        input.classList.add('border-green-300');
    }
}

function showValidationWarning(input, message, className) {
    const warning = document.createElement('p');
    warning.className = `mt-1 text-sm text-orange-600 ${className}`;
    warning.textContent = message;
    input.parentNode.appendChild(warning);
    input.classList.add('border-red-300');
    input.classList.remove('border-green-300');
}

function removeValidationWarning(input, className) {
    const warning = input.parentNode.querySelector(`.${className}`);
    if (warning) {
        warning.remove();
    }
}

// Initialize validation on all NIK and KK inputs when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add validation to all NIK inputs
    const nikInputs = document.querySelectorAll('input[name="nik"], input[name="nik_almarhum"]');
    nikInputs.forEach(input => {
        if (input.name === 'nik') {
            input.addEventListener('input', () => validateNIK(input));
        } else if (input.name === 'nik_almarhum') {
            input.addEventListener('input', () => validateNIKAlmarhum(input));
        }
    });

    // Add validation to all KK inputs
    const kkInputs = document.querySelectorAll('input[name="nomor_kk"]');
    kkInputs.forEach(input => {
        input.addEventListener('input', () => validateKK(input));
    });
});
