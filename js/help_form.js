// Get references to form/input fields
const form = document.getElementById('help_form')
const fullname_input = document.getElementById('fullname-input')
const email_input = document.getElementById('email-input')
const feedback_input = document.getElementById('feedback-input')

// Checks the form exists before adding event listener
if (form) {
    form.addEventListener('submit', (e) => {
        // Validates inputs and get errors
        let errors = getHelpErrors(fullname_input.value, email_input.value, feedback_input.value);

        // If the length of errors is more than 0, there are errors, and the form submission is prevented. 
        if (errors.length > 0) {
            e.preventDefault();
        }
    });
}

// Function to validate help form inputs
function getHelpErrors(fullname, email, feedback){
    let errors = []

    // Clears previous errors before validating
    clearPreviousErrors([fullname_input, email_input, feedback_input])

    // Checks if full name field is empty
    if(fullname === '' || fullname == null){
        errors.push('This field can not be left empty.')
        setInputError(fullname_input, 'Full name is required.')
    }

    // Checks if email field is empty
    if(email === '' || email == null){
        errors.push('This field can not be left empty.')
        setInputError(email_input, 'Email is required.')
    }

    // Checks if feedback field is empty
    if(feedback === '' || feedback == null){
        errors.push('This field can not be left empty.')
        setInputError(feedback_input, 'Message is required.')
    }

    return errors
}

// Function to display input validation errors
function setInputError(input, message) {
    input.value = '' // Field is first cleared
    input.placeholder = message // Error message is placed inn placeholder
    input.parentElement.classList.add('incorrect') // Error styling

    // Event listeners removes error when user starts typing
    input.addEventListener('input', () => {
        input.placeholder = '' // Placeholder is cleared
        input.parentElement.classList.remove('incorrect') // Error styling removed
    }, { once: true }
    )
}

// Function to clear previous errors
function clearPreviousErrors(inputs) {
    inputs.forEach((input) => {
        input.parentElement.classList.remove('incorrect') // Error styling removed
        input.placeholder = '' // Placeholder is cleared
    })
}