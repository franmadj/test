import $ from '../framework/$'
import serialize from '../plugins/serialize'

function init() {

    $(':clubForm').on('submit', (e, el) => validateAndSubmitForm(e, el))

    bindEvents()

}

function bindEvents() {

    let eclubIconsFrame = document.querySelector('[data-ref="eclub-icons"]')

    if (window.innerWidth < 743) {
        document.querySelector('[data-el="target-o-col-first"]').prepend(eclubIconsFrame)
    }

    window.addEventListener('resize', () => {

        if (window.innerWidth < 743) {
            document.querySelector('[data-el="target-o-col-first"]').prepend(eclubIconsFrame)
        } else {
            document.querySelector('[data-el="target-o-col-second"]').append(eclubIconsFrame)
        }
    })

}

function validateAndSubmitForm(e, el) {
    let generalErrors = $(':generalErrors')[0]

    e.preventDefault()

    removeAllErrors()

    generalErrors.textContent = ''

    if (! $('[data-ref="conditionsChecked"]:checked').length) {
        generalErrors.textContent = 'Don\'t forget to accept the conditions above!'

        return
    }

    if (! validateForm(el)) {
        generalErrors.textContent = 'Please complete all fields marked required (*) before submitting.'

        return
    }

    el.submit()
}

function validateForm(form) {
    let blankInputs = Array.prototype.filter.call(form.querySelectorAll('input[required], select[required]'), (el) => {
            return ! el.value || el.value == 'Favorite Location*'
        })

    return blankInputs.length == 0
}

function addErrors(inputs, obj) {
    let titleIndex = inputs.indexOf('title'),
        errorClass = 'c-box__input--error',
        generalErrors = $(':generalErrors')[0]

    removeAllErrors()

    // DEV: Removes the title key from the array, since we're generating that server-side
    if (titleIndex > -1) {
        inputs.splice(titleIndex, 1)
    }

    $(inputs).each((name) => {
        let el = $('input[name*="' + name + '"]')

        el.addClass(errorClass)

        // DEV: If this is the first element, don't add a <br> tag
        generalErrors.innerHTML = generalErrors.innerHTML ? generalErrors.innerHTML + '<br>' + obj[name][0] : obj[name][0]
    })
}

function removeAllErrors() {
    let errorClass = 'c-box__input--error'

    $('.' + errorClass).removeClass(errorClass)
}

function _ajax(type, url, data = false, handler) {
    let request = new XMLHttpRequest()

    request.onreadystatechange = function() {
        if (request.readyState == XMLHttpRequest.DONE) {
            if (request.status == 200) {
                handler(request.responseText, 200)
            } else if (request.status == 400) {
                handler(request.responseText, 400)
            } else {
                handler(request.responseText, false)
            }
        }
    }

    request.open(type, url, true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8;')
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    request.send(data)
}

export default Object.assign(init, {})


