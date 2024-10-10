import $ from '../framework/$'
import axios from '../plugins/axios'
import serialize from '../plugins/serialize'

const noScrollClass = 'no-scroll'

let $body,
    $modal

function init() {
    $body = $('body')
    $modal = $(':eventModal')

    if (window.location.hash && window.location.hash == '#modal') {
        openModal('hosting')
    }

    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8;'

    axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest'

    initEvents()
}

function initEvents() {

    $('a').on('click', (e, el) => {
        if (el.getAttribute('href').indexOf('#') > -1) {
            e.preventDefault()

            openModal(el.getAttribute('href').match(/#(.*)$/)[1])
        }
    })

    $('form').on('submit', (e, el) => {
        let form = el

        form.querySelector('button').disabled = true

        e.preventDefault()

        $('.u-form-response').remove()

        if (! validateForm(el)) {
            let div = document.createElement('div')

            div.innerText = 'Please complete all fields marked required (*) before submitting.'
            div.className = 'u-form-response'

            $(form).append(div)

            form.querySelector('button').disabled = false

            return
        }

        el.submit()
    })

    $(':eventModalExitButton').on('click', () => closeModal())
}

function validateForm(form) {
    // let inputs = form.querySelectorAll('input[required], textarea[required], select[required]'),
    //     blankInputs = Array.prototype.filter.call(inputs, (el) => {
    //         let pattern = el.getAttribute('data-pattern')

    //         if (pattern) {
    //             let regex = null

    //             if (pattern == '#card#') {
    //                 return ! validateCardNumber(el.value)
    //             }

    //             regex = new RegExp(pattern, 'g')

    //             return ! regex.test(el.value)
    //         }

    //         if (el.nodeName !== 'SELECT') {
    //             return ! el.value
    //         }

    //         return el.value && disallowedSelectValues.indexOf(el.value) > -1
    //     })

    // if (! blankInputs.length) {
    //     return true
    // }

    let selects = form.querySelectorAll('select'),
        disallowedSelectValues = [
            'Select a location*',
            'State*',
            'Country*',
            'Start Time*',
            'End Time*'
        ],
        blankSelects = Array.prototype.filter.call(selects, (el) => {
            return ! el.value || disallowedSelectValues.indexOf(el.value) > -1
        }),
        dates = form.querySelectorAll('input.datepicker'),
        blankDates = Array.prototype.filter.call(dates, (el) => {
            return ! el.value
        })

    return blankSelects.length == 0 && blankDates.length == 0
}

function openModal(type) {
    $body.addClass(noScrollClass)
    $('[data-type="' + type + '"]').enable()
}

function closeModal() {
    $body.removeClass(noScrollClass)
    $modal.disable()
}

export default init
