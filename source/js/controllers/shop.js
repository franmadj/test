import $ from '../framework/$'

function init() {
    bindEvents()
}

function bindEvents() {
    // ...
}

function findAncestor(el, dataRef) {
    while (el.parentNode) {
        if (! el.getAttribute('data-ref')) {
            el = el.parentNode

            continue
        }

        if (el.getAttribute('data-ref').indexOf(dataRef) > -1) {
            return el
        }

        if (! el.parentNode) {
            return false
        }

        el = el.parentNode
    }
}

export default Object.assign(init, {})
