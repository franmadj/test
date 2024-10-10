import { formatQuery, isMatch, isObject } from './Utilities'

const _doc = document,
    _html = document.documentElement

/**
 * Get closest matching ancestor of element
 *
 * @private
 * @param {HTMLElement} el
 * @param {string} ancestor
 * @returns {Array}
 */
function closest(el, ancestor) {
    if (el === null || el === _html) {
        return []
    }

    if (isMatch(el, ancestor)) {
        return [el]
    }

    return closest(el.parentNode, ancestor)
}

/**
 * Parse CSS properties
 *
 * @param {HTMLElement} el
 * @param {Object|string} property
 * @param {string} [value]
 */
function css(el, property, value) {
    if (! isObject(property)) {
        el.style[property] = value

        return
    }

    el.style = Object.assign(el.style, property)
}

/**
 * Parse selection query
 *
 * @param {Array|Object|string} query
 * @returns {Array}
 */
function query(query) {
    let els = []

    if (Array.isArray(query)) {
        els = query
    } else if (typeof query == 'string') {
        els = _parseQueryString(query)
    } else if (query instanceof Element) {
        els.push(query)
    }

    return els
}

/**
 * Handle string selections
 *
 * @private
 * @param {string} query
 * @return {Array}
 */
function _parseQueryString(query) {
    let formatted = formatQuery(query),
        result = _doc.querySelectorAll(formatted)

    return [...result]
}

export default { closest, css, query }
