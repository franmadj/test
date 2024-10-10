import $ from '../framework/$'

let otherSubject = null

function init() {
    bindEvents()
}

function bindEvents() {
    window.addEventListener('resize', () => {
        manageSocialIcons(parseInt(window.innerWidth))
    })
    manageSocialIcons(parseInt(window.innerWidth))

    hideConditionalFields()

    otherSubject = $(':otherSubject')[0]

    $(':otherSubject')[0].remove()

    $(':contactForm').on('submit', (e, el) => {
        let subject = $(':subject').els[0].value

        e.target.querySelector('button').disabled = true

        e.preventDefault()

        $(':formError').remove()

        if (! subject || subject == 'Subject') {
            let div = document.createElement('div')

            div.innerText = 'Subject is required.'
            div.className = 'c-form-error'
            div.setAttribute('data-ref', 'formError')

            div.style.textAlign = 'center'
            div.style.color = '#FFFFFF'

            $(el.querySelector('.c-box')).append(div)

            e.preventDefault()

            e.target.querySelector('button').disabled = false
        } else if (subject == 'Other' && ! $(':otherSubject').els[0].querySelector('input').value) {
            let div = document.createElement('div')

            div.innerText = 'Subject is required.'
            div.className = 'c-form-error'
            div.setAttribute('data-ref', 'formError')

            div.style.textAlign = 'center'
            div.style.color = '#FFFFFF'

            $(el.querySelector('.c-box')).append(div)

            e.preventDefault()

            e.target.querySelector('button').disabled = false
        } else {
            let fields = el.querySelectorAll('input[required], select[required]'),
                disallowedValues = [
                    'Location Visited',
                ],
                blankFields = Array.prototype.filter.call(fields, (el) => {
                    return ! el.value || disallowedValues.indexOf(el.value) > -1
                })

            if (blankFields.length == 0) {
                el.submit()
            } else {
                Array.prototype.forEach.call(blankFields, (field) => {
                    let div = document.createElement('div')

                    div.innerText = field.getAttribute('data-error')
                    div.className = 'c-form-error'
                    div.setAttribute('data-ref', 'formError')

                    div.style.textAlign = 'center'
                    div.style.color = '#FFFFFF'

                    $(el.querySelector('.c-box')).append(div)
                })

                e.target.querySelector('button').disabled = false
            }
        }
    })

    $(':subject').on('change', (e, el) => {
        hideConditionalFields()

        setTimeout(function() {
            switch (el.value) {
                case 'Guest Feedback':
                    reveal($('select[name*="locationVisited"]'))
                    reveal($('input[name*="dateVisited"]'))
                    break;
                case 'Gift Card Support':
                    break;
                case 'Media Inquiry':
                    break;
                case 'Other':
                    $(':body')[0].parentNode.insertBefore(otherSubject, $(':body')[0])

                    reveal($(otherSubject.querySelector('input')))
                    break;
            }
        }, 250)
    })
}

function hideConditionalFields() {
    $(':conditionalField').each((el) => {
        $(el).addClass('js-is-hidden')

        el.required = false

        if (el.nodeName == 'SELECT') {
            el.parentNode.style.display = 'none'
        }
    })
}

function reveal(el) {
    el.removeClass('js-is-hidden')

    el[0].required = true

    if (el[0].nodeName == 'SELECT') {
        el[0].parentNode.style.display = 'block'
    }
}

function manageSocialIcons(screenSize) {
    let socialIcons = $(':socialIcons').els[0],
        contactContent = $(':contactContent').els[0],
        contactForm = $(':contactForm').els[0]

    if (screenSize >= 768) {
        contactContent.parentNode.insertBefore(socialIcons, contactContent.nextSibling)
    } else {
        contactForm.parentNode.appendChild(socialIcons)
    }
}

export default Object.assign(init, {})
