// Get references to form/input fields
const form = document.getElementById('sign_up_form')
const fullname_input = document.getElementById('fullname-input')
const email_input = document.getElementById('email-input')
const password_input = document.getElementById('password-input')
const confirm_password_input = document.getElementById('confirm-password-input')

// Event listener added for form being submitted
form.addEventListener('submit', (e) => {
    let errors = []

     // If statement, where if the "full name" input exists, it's a sign-up form, as the login form does not require this field to be input
    if(fullname_input){
        errors = getSignupErrors(fullname_input.value, email_input.value, password_input.value, confirm_password_input.value)
    }

    // When "full name" input does NOT exist, it is a login form
    else{
        errors = getLoginErrors(email_input.value, password_input.value)
    }

    // If the length of errors is more than 0, there are errors, and the form submission is prevented. 
    // This means fields can not be left empty, etc.
    if(errors.length > 0){
        e.preventDefault()
    }
})

// Function to validate sign-up form inputs
function getSignupErrors(fullname, email, password, confirmPassword){
    let errors = []

    // Clears previous errors before validating
    clearPreviousErrors([fullname_input, email_input, password_input, confirm_password_input])

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

    // Checks if password field is empty
    if(password === '' || password == null){
        errors.push('This field can not be left empty.')
        setInputError(password_input, 'Password is required.')
    }

    // Checks if confirmPassword field is empty
    if(confirmPassword === '' || confirmPassword == null){
        errors.push('This field can not be left empty.')
        setInputError(confirm_password_input, 'Confirm your password.')
    }

    // Checks if both the password and confirmPassword fields are equal
    if(password !== confirmPassword){
        errors.push('Password fields must be the same.')
        setInputError(password_input, 'Passwords do not match.')
        setInputError(confirm_password_input, 'Passwords do not match.')
    }

    // Check password length is above 6 characters, forcing a more secure password by the user
    if(password.length < 6){
        errors.push('Password must be longer than 6 characters.')
        setInputError(password_input, 'Password must be > 6 characters.')
    }

    // Checks password length is under 32 characters, as this is excessively long
    if(password.length > 32){
        errors.push('Password can not be longer than 32 characters.')
        setInputError(password_input, 'Password must be < 32 characters.')
    }

    return errors
}

// Function to validate login form inputs
function getLoginErrors(email, password){
    let errors = []

    // Clears previous errors before validating
    clearPreviousErrors([email_input, password_input])

    // Checks if email field is empty
    if(email === '' || email == null){
        errors.push('This field can not be left empty.')
        setInputError(email_input, 'Email is required.')
    }

    // Checks if password field is empty
    if(password === '' || password == null){
        errors.push('This field can not be left empty.')
        setInputError(password_input, 'Password is required.')
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