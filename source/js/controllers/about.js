import $ from '../framework/$'
import axios from '../plugins/axios'
import serialize from '../plugins/serialize'
import Modal from '../plugins/modal'

let Popup = null,
    $body

const noScrollClass = 'no-scroll'

function init() {
    Popup = new Modal(document.querySelector('.about-modal'))
    $body = $('body')

    bindEvents()
}

function bindEvents() {
    $(':openDonationModal').on('click', (e, el) => {
        if (el.getAttribute('href').indexOf('#') > -1) {
            e.preventDefault()

            openModal(el.getAttribute('href').match(/#(.*)$/)[1])
        }
    })

    $(':eventModalExitButton').on('click', () => closeModal())

    $('.u-file-input').on('change', (e, el) => {
        if (e.target.files) {
            $('.u-file-label').els[0].innerText = e.target.files[0].name
        }
    })

    $('.chef-popup').on('click', (e, el) => {
        Popup.show()

        e.preventDefault()
    })

    $(':openVideo').on('click', (e, el) => {
        window.player.playVideo()
    })

    $(':modalClose').on('click', (e, el) => {
        window.player.stopVideo()
    })

    $(':donationForm').on('submit', (e, el) => {
        let files = $('.u-file-input').els[0].files

        e.preventDefault()

        $(':formError').remove()

        if (! files.length) {
            let div = document.createElement('div')

            div.innerText = 'Request document is required.'
            div.className = 'c-form-error'
            div.setAttribute('data-ref', 'formError')

            div.style.textAlign = 'center'
            div.style.color = '#FFFFFF'
            div.style.marginBottom = '2.4rem'
            div.style.width = '100%'

            $(el.querySelector('.event-form__fieldset')).append(div)
        } else {
            el.submit()
        }
    })

    if (window.location.hash && jQuery(window.location.hash).length) {
        jQuery('html, body').animate({scrollTop: jQuery(window.location.hash).offset().top }, 2000);
    }
}

function openModal(type) {
    $body.addClass(noScrollClass)
    $('[data-type="' + type + '"]').enable()
}

function closeModal() {
    $body.removeClass(noScrollClass)
    $(':eventModal').disable()
}

export default Object.assign(init, {})
