const form = document.getElementById('sign_up_form')
const fullname_input = document.getElementById('fullname-input')
const email_input = document.getElementById('email-input')
const password_input = document.getElementById('password-input')
const confirm_password_input = document.getElementById('confirm-password-input')

form.addEventListener('submit', (e) => {
    let errors = []

    if(fullname_input){
        errors = getSignupErrors(fullname_input.value, email_input.value, password_input.value, confirm_password_input.value)
    }

    else{
        errors = getLoginErrors(email_input.value, password_input.value)
    }

    if(errors.length > 0){
        e.preventDefault()
    }
})

function getSignupErrors(fullname, email, password, confirmPassword){
    let errors = []

    clearPreviousErrors([fullname_input, email_input, password_input, confirm_password_input])

    if(fullname === '' || fullname == null){
        errors.push('This field can not be left empty.')
        setInputError(fullname_input, 'Full name is required.')
    }

    if(email === '' || email == null){
        errors.push('This field can not be left empty.')
        setInputError(email_input, 'Email is required.')
    }

    if(password === '' || password == null){
        errors.push('This field can not be left empty.')
        setInputError(password_input, 'Password is required.')
    }

    if(confirmPassword === '' || confirmPassword == null){
        errors.push('This field can not be left empty.')
        setInputError(confirm_password_input, 'Confirm your password.')
    }

    if(password !== confirmPassword){
        errors.push('Password fields must be the same.')
        setInputError(password_input, 'Passwords do not match.')
        setInputError(confirm_password_input, 'Passwords do not match.')
    }

    if(password.length < 6){
        errors.push('Password must be longer than 6 characters.')
        setInputError(password_input, 'Password must be > 6 characters.')
    }

    return errors
}

function getLoginErrors(email, password){
    let errors = []

    clearPreviousErrors([email_input, password_input])

    if(email === '' || email == null){
        errors.push('This field can not be left empty.')
        setInputError(email_input, 'Email is required.')
    }

    if(password === '' || password == null){
        errors.push('This field can not be left empty.')
        setInputError(password_input, 'Password is required.')
    }

    return errors
}

function setInputError(input, message) {
    input.value = ''
    input.placeholder = message
    input.parentElement.classList.add('incorrect')

    input.addEventListener('input', () => {
        input.placeholder = ''
        input.parentElement.classList.remove('incorrect')
    }, { once: true }
    )
}

function clearPreviousErrors(inputs) {
    inputs.forEach((input) => {
        input.parentElement.classList.remove('incorrect')
        input.placeholder = ''
    })
}