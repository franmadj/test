import $ from '../framework/$'
import Modal from '../plugins/modal'

let Popup = null

function init() {
    Popup = new Modal(document.querySelector('.c-modal'))

    bindEvents()
}

function bindEvents() {
    $(':reserveButton').on('click', (e, el) => {
        Popup.show()

        e.preventDefault()
    })
}

export default Object.assign(init, {})
