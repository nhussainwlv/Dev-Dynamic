const form = document.getElementById('help_form')
const fullname_input = document.getElementById('fullname-input')
const email_input = document.getElementById('email-input')
const feedback_input = document.getElementById('feedback-input')

if (form) {
    form.addEventListener('submit', (e) => {
        let errors = getHelpErrors(fullname_input.value, email_input.value, feedback_input.value);

        if (errors.length > 0) {
            e.preventDefault();
        }
    });
}

function getHelpErrors(fullname, email, feedback){
    let errors = []

    clearPreviousErrors([fullname_input, email_input, feedback_input])

    if(fullname === '' || fullname == null){
        errors.push('This field can not be left empty.')
        setInputError(fullname_input, 'Full name is required.')
    }

    if(email === '' || email == null){
        errors.push('This field can not be left empty.')
        setInputError(email_input, 'Email is required.')
    }

    if(feedback === '' || feedback == null){
        errors.push('This field can not be left empty.')
        setInputError(feedback_input, 'Message is required.')
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