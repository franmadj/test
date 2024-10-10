import { isObject } from './Utilities'

/**
 * Handle event binding
 *
 * @param {HTMLElement} el
 * @param {Object|string} events
 * @param {function} [handler]
 */
function on(el, events, handler) {
    if (! isObject(events)) {
        _addEvent(el, events, handler)

        return
    }

    for (let event in events) {
        _addEvent(el, event, events[event])
    }
}

/**
 * Bind event to element
 *
 * @private
 * @param {HTMLElement} el
 * @param {string} event
 * @param {function} handler
 */
function _addEvent(el, event, handler) {
    el.addEventListener(event, e => handler.apply(el, [e, el]))

    _storeHandler(el, event, handler)
}

/**
 * Store a reference of the handler on the element
 *
 * @param {HTMLElement} el
 * @param {string} event
 * @param {function} handler
 */
function _storeHandler(el, event, handler) {
    el._e = el._e || {};
    el._e[event] = el._e[event] || [];
    el._e[event].push(handler)
}

/**
 * Handle event unbinding
 *
 * @param {HTMLElement} el
 * @param {string} event
 */
function off(el, event) {
    let handlers = el._e ?
        el._e[event] :
        [];

    handlers.forEach(handler => el.removeEventListener(event, handler))
}

export default { on, off }
